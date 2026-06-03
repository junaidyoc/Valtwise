@extends('admin.layouts.app')
@section('title', 'Add Coupon')
@section('page-title', '🏷️ Add New Coupon')

@section('content')
<div style="max-width:700px">
  <a href="{{ route('admin.coupons.index') }}" class="btn btn-gray btn-sm" style="margin-bottom:16px">← Back</a>

  <div class="card">
    <form method="POST" action="{{ route('admin.coupons.store') }}">
      @csrf
      <div class="form-grid">

        <div class="form-group full">
          <label>Store *</label>
          <select name="store_id" required>
            <option value="">Select Store...</option>
            @foreach($stores as $store)
            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
              {{ $store->name }}
            </option>
            @endforeach
          </select>
        </div>

        <div class="form-group full">
          <label>Coupon Title *</label>
          <input type="text" name="title"
                 placeholder="e.g. 20% Off Sitewide — AliExpress"
                 value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
          <label>Type *</label>
          <select name="type" required>
            <option value="code" {{ old('type') == 'code' ? 'selected' : '' }}>
              Code (user needs to copy code)
            </option>
            <option value="deal" {{ old('type') == 'deal' ? 'selected' : '' }}>
              Deal (no code needed)
            </option>
            <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>
              Sale
            </option>
          </select>
        </div>

        <div class="form-group">
          <label>Discount Value</label>
          <input type="text" name="discount_value"
                 placeholder="e.g. 20% or $10 or BOGO"
                 value="{{ old('discount_value') }}">
        </div>

        <div class="form-group full">
          <label>Coupon Code</label>
          <input type="text" name="code"
                 placeholder="e.g. SAVE20 (leave empty for deals)"
                 value="{{ old('code') }}"
                 style="font-family:monospace;letter-spacing:.05em;text-transform:uppercase">
        </div>

        <div class="form-group full">
          <label>Destination URL (Product/Landing Page)</label>
          <input type="url" name="destination_url"
                 placeholder="https://www.aliexpress.com/category/..."
                 value="{{ old('destination_url') }}">
        </div>

        <div class="form-group full">
          <label>Description</label>
          <textarea name="description" rows="2"
                    placeholder="Get 20% off on all fashion items...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
          <label>Expiry Date</label>
          <input type="date" name="expires_at" value="{{ old('expires_at') }}">
        </div>

        <div class="form-group" style="display:flex;flex-direction:column;gap:10px;justify-content:flex-end">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_verified" value="1"
                   {{ old('is_verified') ? 'checked' : '' }}>
            Verified Coupon
          </label>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_exclusive" value="1"
                   {{ old('is_exclusive') ? 'checked' : '' }}>
            Exclusive
          </label>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_active" value="1" checked>
            Active
          </label>
        </div>

        {{-- SEO Settings --}}
        <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
          <div style="font-size:14px;font-weight:600;color:#10b981;margin-bottom:12px">SEO Settings <span style="font-weight:400;color:#64748b">(Optional)</span></div>
        </div>

        <div class="form-group full">
          <label>Meta Title <span style="color:#64748b;font-weight:400">(max 70 chars)</span></label>
          <input type="text" name="meta_title" value="{{ old('meta_title') }}" maxlength="70"
                 placeholder="Leave empty for auto-generated title">
        </div>

        <div class="form-group full">
          <label>Meta Description <span style="color:#64748b;font-weight:400">(max 160 chars)</span></label>
          <textarea name="meta_description" rows="2" maxlength="160"
                    placeholder="Leave empty for auto-generated description">{{ old('meta_description') }}</textarea>
        </div>

        <div class="form-group">
          <label>Focus Keyword</label>
          <input type="text" name="focus_keyword" value="{{ old('focus_keyword') }}" maxlength="50"
                 placeholder="e.g. discount code">
        </div>

      </div>

      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn btn-green">✅ Add Coupon</button>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-gray">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
