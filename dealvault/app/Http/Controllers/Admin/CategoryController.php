<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // Get parent categories with their children
        $categories = Category::parents()
            ->withCount(['stores', 'children'])
            ->with(['children' => function ($query) {
                $query->withCount('stores')->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        // Get all parent categories for the dropdown
        $parentCategories = Category::parents()->orderBy('name')->get();

        return view('admin.categories.index', compact('categories', 'parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Generate slug and check for uniqueness
        $slug = Str::slug($request->name);

        // Check if category with same slug already exists
        $existing = Category::where('slug', $slug)->first();
        if ($existing) {
            return back()
                ->withInput()
                ->with('error', "A category with name '{$existing->name}' already exists. Please use a different name.");
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'icon' => $request->icon ?? '🏷️',
            'description' => $request->description,
            'parent_id' => $request->parent_id ?: null,
            // Basic SEO
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'focus_keyword' => $request->focus_keyword,
        ]);

        $type = $request->parent_id ? 'Subcategory' : 'Category';
        return back()->with('success', "{$type} added!");
    }

    public function edit(Category $category)
    {
        // Get all parent categories for the dropdown (exclude self and children)
        $parentCategories = Category::parents()
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update([
            'name' => $request->name,
            'icon' => $request->icon ?? $category->icon,
            'description' => $request->description,
            'parent_id' => $request->parent_id ?: null,
            // Basic SEO
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'focus_keyword' => $request->focus_keyword,
            // Open Graph
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $request->og_image,
            // Twitter
            'twitter_title' => $request->twitter_title,
            'twitter_description' => $request->twitter_description,
            'twitter_image' => $request->twitter_image,
            // Technical SEO
            'canonical_url' => $request->canonical_url,
            'robots_index' => $request->robots_index ?? 'index',
            'robots_follow' => $request->robots_follow ?? 'follow',
            'schema_type' => $request->schema_type ?? 'CollectionPage',
            'sitemap_include' => $request->boolean('sitemap_include', true),
            'breadcrumb_enable' => $request->boolean('breadcrumb_enable', true),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' updated!");
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        $hasChildren = $category->children()->count() > 0;

        if ($hasChildren) {
            return back()->with('error', "Cannot delete '{$name}' because it has subcategories. Delete subcategories first.");
        }

        $category->delete();
        return back()->with('success', "'{$name}' deleted!");
    }
}
