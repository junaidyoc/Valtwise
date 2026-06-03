<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');

        $coupons = Coupon::with('store')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.coupons.index', compact('coupons', 'search', 'perPage'));
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
            // SEO fields
            'meta_title'      => $request->meta_title,
            'meta_description'=> $request->meta_description,
            'focus_keyword'   => $request->focus_keyword,
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
            // SEO fields
            'meta_title'      => $request->meta_title,
            'meta_description'=> $request->meta_description,
            'focus_keyword'   => $request->focus_keyword,
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
