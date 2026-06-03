<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    /**
     * Display blog listing page
     */
    public function index()
    {
        $posts = BlogPost::with('category')
            ->published()
            ->latest('published_at')
            ->paginate(12);

        $categories = BlogCategory::active()
            ->withCount('publishedPosts')
            ->having('published_posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        $featuredPosts = BlogPost::with('category')
            ->published()
            ->featured()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('blog.index', compact('posts', 'categories', 'featuredPosts'));
    }

    /**
     * Display single blog post
     */
    public function show(string $slug)
    {
        $post = BlogPost::with('category')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $post->incrementViews();

        // Get related posts (same category or featured)
        $relatedPosts = BlogPost::with('category')
            ->published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, function ($q) use ($post) {
                $q->where('category_id', $post->category_id);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        // If not enough related, fill with recent posts
        if ($relatedPosts->count() < 3) {
            $moreIds = $relatedPosts->pluck('id')->push($post->id);
            $more = BlogPost::with('category')
                ->published()
                ->whereNotIn('id', $moreIds)
                ->latest('published_at')
                ->take(3 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->merge($more);
        }

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    /**
     * Display posts by category
     */
    public function category(string $slug)
    {
        $category = BlogCategory::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $posts = BlogPost::with('category')
            ->where('category_id', $category->id)
            ->published()
            ->latest('published_at')
            ->paginate(12);

        $categories = BlogCategory::active()
            ->withCount('publishedPosts')
            ->having('published_posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('blog.category', compact('posts', 'category', 'categories'));
    }
}
