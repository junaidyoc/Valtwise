<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $perPage = $request->input('per_page', 20);

        $category = Category::where('slug', $slug)
            ->with(['parent', 'children'])
            ->firstOrFail();

        // If this is a parent category with subcategories, show subcategories
        $subcategories = $category->children()
            ->withCount(['activeStores'])
            ->orderBy('name')
            ->get();

        // Get stores - either from this category only (if subcategory)
        // or from all subcategories (if parent with no direct stores)
        $stores = $category->allActiveStores()
            ->withCount(['coupons' => fn($q) => $q->active()])
            ->orderByDesc('is_featured')
            ->paginate($perPage)
            ->appends($request->query());

        return view('categories.show', compact('category', 'stores', 'subcategories', 'perPage'));
    }
}
