<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');
        $categoryId = $request->input('category');
        $status = $request->input('status');

        $posts = BlogPost::with('category')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($status === 'published', fn($q) => $q->published())
            ->when($status === 'draft', fn($q) => $q->where(function ($q) {
                $q->where('is_published', false)
                    ->orWhereNull('published_at')
                    ->orWhere('published_at', '>', now());
            }))
            ->latest()
            ->paginate($perPage)
            ->appends($request->query());

        $categories = BlogCategory::orderBy('name')->get();

        return view('admin.blog-posts.index', compact('posts', 'categories', 'search', 'categoryId', 'status', 'perPage'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->orderBy('name')->get();
        return view('admin.blog-posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_posts,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|url',
            'category_id' => 'nullable|exists:blog_categories,id',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'focus_keyword' => 'nullable|string|max:50',
            'og_title' => 'nullable|string|max:90',
            'og_description' => 'nullable|string|max:200',
            'og_image' => 'nullable|url',
            'canonical_url' => 'nullable|url',
            'robots_index' => 'nullable|in:index,noindex',
            'robots_follow' => 'nullable|in:follow,nofollow',
        ]);

        BlogPost::create([
            'title' => $request->title,
            'slug' => $request->slug ?: Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'featured_image' => $request->featured_image,
            'category_id' => $request->category_id,

            // SEO
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'focus_keyword' => $request->focus_keyword,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $request->og_image,
            'canonical_url' => $request->canonical_url,
            'robots_index' => $request->robots_index ?? 'index',
            'robots_follow' => $request->robots_follow ?? 'follow',
            'sitemap_include' => $request->boolean('sitemap_include', true),

            // Publishing
            'is_published' => $request->boolean('is_published', false),
            'is_featured' => $request->boolean('is_featured', false),
            'published_at' => $request->boolean('is_published') ? ($request->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function edit(BlogPost $blog_post)
    {
        $categories = BlogCategory::active()->orderBy('name')->get();
        return view('admin.blog-posts.edit', ['post' => $blog_post, 'categories' => $categories]);
    }

    public function update(Request $request, BlogPost $blog_post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_posts,slug,' . $blog_post->id,
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|url',
            'category_id' => 'nullable|exists:blog_categories,id',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'focus_keyword' => 'nullable|string|max:50',
            'og_title' => 'nullable|string|max:90',
            'og_description' => 'nullable|string|max:200',
            'og_image' => 'nullable|url',
            'canonical_url' => 'nullable|url',
            'robots_index' => 'nullable|in:index,noindex',
            'robots_follow' => 'nullable|in:follow,nofollow',
        ]);

        // Handle published_at
        $publishedAt = $blog_post->published_at;
        if ($request->boolean('is_published') && !$blog_post->is_published) {
            $publishedAt = $request->published_at ?? now();
        } elseif (!$request->boolean('is_published')) {
            $publishedAt = null;
        }

        $blog_post->update([
            'title' => $request->title,
            'slug' => $request->slug ?: Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'featured_image' => $request->featured_image,
            'category_id' => $request->category_id,

            // SEO
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'focus_keyword' => $request->focus_keyword,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $request->og_image,
            'canonical_url' => $request->canonical_url,
            'robots_index' => $request->robots_index ?? 'index',
            'robots_follow' => $request->robots_follow ?? 'follow',
            'sitemap_include' => $request->boolean('sitemap_include', true),

            // Publishing
            'is_published' => $request->boolean('is_published', false),
            'is_featured' => $request->boolean('is_featured', false),
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(BlogPost $blog_post)
    {
        $blog_post->delete();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    public function toggle(BlogPost $blog_post)
    {
        $blog_post->update([
            'is_published' => !$blog_post->is_published,
            'published_at' => !$blog_post->is_published ? now() : null,
        ]);

        $status = $blog_post->is_published ? 'published' : 'unpublished';
        return back()->with('success', "Blog post {$status} successfully!");
    }
}
