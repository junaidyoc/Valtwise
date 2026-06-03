<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = BlogCategory::withCount('posts')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(20)
            ->appends($request->query());

        return view('admin.blog-categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug',
            'description' => 'nullable|string|max:500',
        ]);

        BlogCategory::create([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category created successfully!');
    }

    public function edit(BlogCategory $blog_category)
    {
        return view('admin.blog-categories.edit', ['category' => $blog_category]);
    }

    public function update(Request $request, BlogCategory $blog_category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug,' . $blog_category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $blog_category->update([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category updated successfully!');
    }

    public function destroy(BlogCategory $blog_category)
    {
        $blog_category->delete();

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category deleted successfully!');
    }
}
