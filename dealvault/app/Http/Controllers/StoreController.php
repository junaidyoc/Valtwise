<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::active()
            ->withCount(['coupons' => fn($q) => $q->active()])
            ->when($request->search, fn($q, $s) =>
                $q->where('name', 'like', "%{$s}%")
            )
            ->when($request->category, fn($q, $c) =>
                $q->whereHas('categories', fn($q2) => $q2->where('slug', $c))
            )
            ->when($request->letter, function($q, $letter) {
                if ($letter === '#') {
                    // Numbers and special characters
                    $q->whereRaw("name REGEXP '^[0-9]'");
                } else {
                    $q->where('name', 'like', "{$letter}%");
                }
            })
            ->orderBy('name')
            ->paginate(24);

        // Get available first letters for the filter
        $availableLetters = Store::active()
            ->selectRaw("UPPER(LEFT(name, 1)) as letter")
            ->groupBy('letter')
            ->pluck('letter')
            ->toArray();

        return view('stores.index', compact('stores', 'availableLetters'));
    }

    public function show(string $slug)
    {
        $store = Store::active()
            ->where('slug', $slug)
            ->with('categories')
            ->firstOrFail();

        $coupons = $store->activeCoupons()
            ->orderByDesc('is_verified')
            ->orderByDesc('is_exclusive')
            ->orderByDesc('click_count')
            ->get();

        $similarStores = Store::active()
            ->whereHas('categories', fn($q) =>
                $q->whereIn('categories.id', $store->categories->pluck('id'))
            )
            ->where('id', '!=', $store->id)
            ->withCount(['coupons' => fn($q) => $q->active()])
            ->take(4)
            ->get();

        return view('stores.show', compact('store', 'coupons', 'similarStores'));
    }
}
