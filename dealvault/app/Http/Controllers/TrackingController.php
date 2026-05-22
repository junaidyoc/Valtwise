<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Log the click and redirect user through the affiliate link.
     *
     * Flow:
     *  1. Find the coupon
     *  2. Log the click (async-friendly — non-blocking)
     *  3. Increment click counter
     *  4. Build the affiliate URL via store template
     *  5. 302 redirect → affiliate network → brand site
     */
    public function redirect(Request $request, int $couponId): RedirectResponse
    {
        $coupon = Coupon::with('store')->findOrFail($couponId);

        // 1. Log the click
        Click::create([
            'coupon_id'  => $coupon->id,
            'store_id'   => $coupon->store_id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer'   => $request->headers->get('referer'),
        ]);

        // 2. Increment click counter (lightweight, no full reload)
        $coupon->increment('click_count');

        // 3. Build the target URL
        $destination = $coupon->destination_url ?? $coupon->store->website_url;
        $affiliateUrl = $coupon->store->buildAffiliateUrl($destination);

        return redirect()->away($affiliateUrl);
    }
}
