<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::withCount(['coupons', 'clicks'])
            ->with('categories')
            ->latest()
            ->paginate(15);
        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.stores.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'website_url' => 'required|url',
        ]);

        $store = Store::create([
            'name'                   => $request->name,
            'slug'                   => Str::slug($request->name) . '-' . rand(100,999),
            'website_url'            => $request->website_url,
            'description'            => $request->description,
            'logo'                   => $request->logo,
            'cashback_rate'          => $request->cashback_rate ?? 0,
            'is_featured'            => $request->boolean('is_featured'),
            'is_active'              => $request->boolean('is_active', true),
            'affiliate_url_template' => $request->affiliate_url_template,
            'network'                => $request->network,
        ]);

        if ($request->category_ids) {
            $store->categories()->attach($request->category_ids);
        }

        return redirect()->route('admin.stores.index')
            ->with('success', "Store '{$store->name}' added successfully!");
    }

    public function edit(Store $store)
    {
        $categories = Category::all();
        return view('admin.stores.edit', compact('store', 'categories'));
    }

    public function update(Request $request, Store $store)
    {
        $store->update([
            'name'                   => $request->name,
            'website_url'            => $request->website_url,
            'description'            => $request->description,
            'logo'                   => $request->logo,
            'cashback_rate'          => $request->cashback_rate ?? 0,
            'is_featured'            => $request->boolean('is_featured'),
            'is_active'              => $request->boolean('is_active'),
            'affiliate_url_template' => $request->affiliate_url_template,
            'network'                => $request->network,
        ]);

        if ($request->category_ids) {
            $store->categories()->sync($request->category_ids);
        }

        return redirect()->route('admin.stores.index')
            ->with('success', "Store updated!");
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')
            ->with('success', "Store deleted!");
    }

    public function toggle(Store $store)
    {
        $store->update(['is_active' => !$store->is_active]);
        return back()->with('success', 'Store status updated!');
    }
}
