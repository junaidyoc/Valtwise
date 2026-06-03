<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Store;

class HomeController extends Controller
{
    public function index()
    {
        // All active stores for the slider
        $sliderStores = Store::active()
            ->orderBy('name')
            ->get();

        $featuredStores = Store::active()
            ->featured()
            ->withCount(['coupons' => fn($q) => $q->active()])
            ->orderBy('name')
            ->take(8)
            ->get();

        $topCoupons = Coupon::active()
            ->with('store')
            ->orderByDesc('click_count')
            ->take(12)
            ->get();

        // Only show parent categories on homepage, with subcategory count
        $categories = Category::parents()
            ->withCount(['activeStores', 'children'])
            ->having('active_stores_count', '>', 0)
            ->orderByDesc('active_stores_count')
            ->take(12)
            ->get();

        return view('home', compact(
            'sliderStores',
            'featuredStores',
            'topCoupons',
            'categories',
        ));
    }
}
