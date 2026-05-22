<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('store')
            ->latest()
            ->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $stores = Store::active()->orderBy('name')->get();
        return view('admin.coupons.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'title'    => 'required|string|max:255',
            'type'     => 'required|in:code,deal,sale',
        ]);

        Coupon::create([
            'store_id'        => $request->store_id,
            'title'           => $request->title,
            'description'     => $request->description,
            'code'            => $request->code,
            'type'            => $request->type,
            'discount_value'  => $request->discount_value,
            'destination_url' => $request->destination_url,
            'is_verified'     => $request->boolean('is_verified'),
            'is_exclusive'    => $request->boolean('is_exclusive'),
            'is_active'       => $request->boolean('is_active', true),
            'expires_at'      => $request->expires_at ?: null,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon added!');
    }

    public function edit(Coupon $coupon)
    {
        $stores = Store::active()->orderBy('name')->get();
        return view('admin.coupons.edit', compact('coupon', 'stores'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update([
            'store_id'        => $request->store_id,
            'title'           => $request->title,
            'description'     => $request->description,
            'code'            => $request->code,
            'type'            => $request->type,
            'discount_value'  => $request->discount_value,
            'destination_url' => $request->destination_url,
            'is_verified'     => $request->boolean('is_verified'),
            'is_exclusive'    => $request->boolean('is_exclusive'),
            'is_active'       => $request->boolean('is_active'),
            'expires_at'      => $request->expires_at ?: null,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted!');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return back()->with('success', 'Coupon status updated!');
    }
}
