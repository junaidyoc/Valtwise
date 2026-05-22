<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $stores = $category->activeStores()
            ->withCount(['coupons' => fn($q) => $q->active()])
            ->orderByDesc('is_featured')
            ->orderByDesc('cashback_rate')
            ->paginate(20);

        return view('categories.show', compact('category', 'stores'));
    }
}
