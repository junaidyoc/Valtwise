@extends('admin.layouts.app')
@section('title', 'Edit Coupon')
@section('page-title', '✏️ Edit Coupon')

@section('content')
<div style="max-width:700px">
  <a href="{{ route('admin.coupons.index') }}" class="btn btn-gray btn-sm" style="margin-bottom:16px">← Back</a>

  <div class="card">
    <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
      @csrf @method('PUT')
      <div class="form-grid">

        <div class="form-group full">
          <label>Store</label>
          <select name="store_id" required>
            @foreach($stores as $store)
            <option value="{{ $store->id }}" {{ $coupon->store_id == $store->id ? 'selected' : '' }}>
              {{ $store->name }}
            </option>
            @endforeach
          </select>
        </div>

        <div class="form-group full">
          <label>Coupon Title</label>
          <input type="text" name="title" value="{{ $coupon->title }}" required>
        </div>

        <div class="form-group">
          <label>Type</label>
          <select name="type">
            <option value="code" {{ $coupon->type == 'code' ? 'selected' : '' }}>Code</option>
            <option value="deal" {{ $coupon->type == 'deal' ? 'selected' : '' }}>Deal</option>
            <option value="sale" {{ $coupon->type == 'sale' ? 'selected' : '' }}>Sale</option>
          </select>
        </div>

        <div class="form-group">
          <label>Discount Value</label>
          <input type="text" name="discount_value" value="{{ $coupon->discount_value }}">
        </div>

        <div class="form-group full">
          <label>Coupon Code</label>
          <input type="text" name="code" value="{{ $coupon->code }}"
                 style="font-family:monospace;text-transform:uppercase">
        </div>

        <div class="form-group full">
          <label>Destination URL</label>
          <input type="url" name="destination_url" value="{{ $coupon->destination_url }}">
        </div>

        <div class="form-group full">
          <label>Description</label>
          <textarea name="description" rows="2">{{ $coupon->description }}</textarea>
        </div>

        <div class="form-group">
          <label>Expiry Date</label>
          <input type="date" name="expires_at"
                 value="{{ $coupon->expires_at?->format('Y-m-d') }}">
        </div>

        <div class="form-group" style="display:flex;flex-direction:column;gap:10px;justify-content:flex-end">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_verified" value="1"
                   {{ $coupon->is_verified ? 'checked' : '' }}>
            ✓ Verified
          </label>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_exclusive" value="1"
                   {{ $coupon->is_exclusive ? 'checked' : '' }}>
            ⭐ Exclusive
          </label>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_active" value="1"
                   {{ $coupon->is_active ? 'checked' : '' }}>
            ✅ Active
          </label>
        </div>

      </div>

      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn btn-green">💾 Save Changes</button>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-gray">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
