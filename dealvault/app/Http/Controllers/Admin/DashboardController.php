<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Click;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Core Stats ────────────────────────────────────────────────────────
        $totalStores    = Store::count();
        $activeStores   = Store::where('is_active', true)->count();
        $totalCoupons   = Coupon::count();
        $activeCoupons  = Coupon::active()->count();
        $totalClicks    = Click::count();
        $totalCategories= Category::count();

        // ── Today Stats ───────────────────────────────────────────────────────
        $todayClicks    = Click::whereDate('created_at', today())->count();
        $weekClicks     = Click::where('created_at', '>=', now()->subDays(7))->count();
        $monthClicks    = Click::where('created_at', '>=', now()->subDays(30))->count();

        // ── Clicks Per Day (Last 14 days) ─────────────────────────────────────
        $clicksChart = Click::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(14))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ── Top Stores by Clicks ──────────────────────────────────────────────
        $topStores = Store::withCount('clicks')
            ->orderByDesc('clicks_count')
            ->take(5)
            ->get();

        // ── Top Coupons by Clicks ─────────────────────────────────────────────
        $topCoupons = Coupon::with('store')
            ->orderByDesc('click_count')
            ->take(5)
            ->get();

        // ── Recent Clicks ─────────────────────────────────────────────────────
        $recentClicks = Click::with(['coupon.store'])
            ->latest()
            ->take(10)
            ->get();

        // ── Expiring Soon ─────────────────────────────────────────────────────
        $expiringSoon = Coupon::with('store')
            ->where('is_active', true)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now()->addDays(7))
            ->where('expires_at', '>', now())
            ->orderBy('expires_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStores', 'activeStores', 'totalCoupons', 'activeCoupons',
            'totalClicks', 'totalCategories', 'todayClicks', 'weekClicks',
            'monthClicks', 'clicksChart', 'topStores', 'topCoupons',
            'recentClicks', 'expiringSoon'
        ));
    }
}
