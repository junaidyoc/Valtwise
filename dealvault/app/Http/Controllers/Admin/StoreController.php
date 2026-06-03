<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search');

        $stores = Store::withCount(['coupons', 'clicks'])
            ->with('categories')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.stores.index', compact('stores', 'search', 'perPage'));
    }

    public function create()
    {
        // Get parent categories with their children for grouped display
        $categories = Category::parents()
            ->with(['children' => fn($q) => $q->orderBy('name')])
            ->orderBy('name')
            ->get();
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
            // Commission fields
            'commission_type'        => $request->commission_type,
            'commission_rate'        => $request->commission_rate,
            'cpc_rate'               => $request->cpc_rate,
            'cpa_rate'               => $request->cpa_rate,
            // Basic SEO
            'meta_title'             => $request->meta_title,
            'meta_description'       => $request->meta_description,
            'focus_keyword'          => $request->focus_keyword,
            // Open Graph
            'og_title'               => $request->og_title,
            'og_description'         => $request->og_description,
            'og_image'               => $request->og_image,
            // Twitter
            'twitter_title'          => $request->twitter_title,
            'twitter_description'    => $request->twitter_description,
            'twitter_image'          => $request->twitter_image,
            // Technical SEO
            'canonical_url'          => $request->canonical_url,
            'robots_index'           => $request->robots_index ?? 'index',
            'robots_follow'          => $request->robots_follow ?? 'follow',
            'schema_type'            => $request->schema_type ?? 'Store',
            'sitemap_include'        => $request->boolean('sitemap_include', true),
            'breadcrumb_enable'      => $request->boolean('breadcrumb_enable', true),
        ]);

        if ($request->category_ids) {
            $store->categories()->attach($request->category_ids);
        }

        return redirect()->route('admin.stores.index')
            ->with('success', "Store '{$store->name}' added successfully!");
    }

    public function edit(Store $store)
    {
        // Get parent categories with their children for grouped display
        $categories = Category::parents()
            ->with(['children' => fn($q) => $q->orderBy('name')])
            ->orderBy('name')
            ->get();
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
            // Commission fields
            'commission_type'        => $request->commission_type,
            'commission_rate'        => $request->commission_rate,
            'cpc_rate'               => $request->cpc_rate,
            'cpa_rate'               => $request->cpa_rate,
            // Basic SEO
            'meta_title'             => $request->meta_title,
            'meta_description'       => $request->meta_description,
            'focus_keyword'          => $request->focus_keyword,
            // Open Graph
            'og_title'               => $request->og_title,
            'og_description'         => $request->og_description,
            'og_image'               => $request->og_image,
            // Twitter
            'twitter_title'          => $request->twitter_title,
            'twitter_description'    => $request->twitter_description,
            'twitter_image'          => $request->twitter_image,
            // Technical SEO
            'canonical_url'          => $request->canonical_url,
            'robots_index'           => $request->robots_index ?? 'index',
            'robots_follow'          => $request->robots_follow ?? 'follow',
            'schema_type'            => $request->schema_type ?? 'Store',
            'sitemap_include'        => $request->boolean('sitemap_include', true),
            'breadcrumb_enable'      => $request->boolean('breadcrumb_enable', true),
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
