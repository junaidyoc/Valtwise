@extends('admin.layouts.app')
@section('title', 'Add Store')
@section('page-title', '🏪 Add New Store')

@section('content')
<div style="max-width:700px">
  <a href="{{ route('admin.stores.index') }}" class="btn btn-gray btn-sm" style="margin-bottom:16px">← Back</a>

  <div class="card">
    <form method="POST" action="{{ route('admin.stores.store') }}">
      @csrf
      <div class="form-grid">

        <div class="form-group">
          <label>Store Name *</label>
          <input type="text" name="name" placeholder="e.g. AliExpress Fashion"
                 value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
          <label>Network</label>
          <select name="network">
            <option value="admitad">Admitad</option>
            <option value="commission_factory">Commission Factory</option>
            <option value="cj">CJ Affiliate</option>
            <option value="rakuten">Rakuten</option>
            <option value="shareasale">ShareASale</option>
            <option value="direct">Direct</option>
          </select>
        </div>

        <div class="form-group full">
          <label>Website URL *</label>
          <input type="url" name="website_url"
                 placeholder="https://www.aliexpress.com/category/..."
                 value="{{ old('website_url') }}" required>
        </div>

        <div class="form-group full">
          <label>Affiliate Link (Admitad Deep Link)</label>
          <input type="url" name="affiliate_url_template"
                 placeholder="https://ad.admitad.com/g/XXXXXXXX/?ulp={destination}"
                 value="{{ old('affiliate_url_template') }}">
          <div style="font-size:11px;color:#475569;margin-top:4px">
            {destination} will be replaced with product URL automatically
          </div>
        </div>

        <div class="form-group">
          <label>Logo URL</label>
          <input type="url" name="logo"
                 placeholder="https://logo.clearbit.com/aliexpress.com"
                 value="{{ old('logo') }}">
        </div>

        <div class="form-group">
          <label>Cashback Rate (%)</label>
          <input type="number" name="cashback_rate"
                 placeholder="5" step="0.5" min="0" max="100"
                 value="{{ old('cashback_rate', 0) }}">
        </div>

        <div class="form-group full">
          <label>Description</label>
          <textarea name="description" rows="3"
                    placeholder="Best deals and discounts from AliExpress...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group full">
          <label>Categories</label>
          <div style="display:flex;flex-wrap:wrap;gap:8px">
            @foreach($categories as $cat)
            <label style="display:flex;align-items:center;gap:6px;padding:6px 10px;background:#0f172a;border:1px solid #334155;border-radius:6px;cursor:pointer;font-size:13px;color:#94a3b8">
              <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                     {{ in_array($cat->id, old('category_ids', [])) ? 'checked' : '' }}>
              {{ $cat->icon ?? '🏷️' }} {{ $cat->name }}
            </label>
            @endforeach
          </div>
        </div>

        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_featured" value="1"
                   {{ old('is_featured') ? 'checked' : '' }}>
            <span>Featured Store (Show on Homepage)</span>
          </label>
        </div>

        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_active" value="1" checked>
            <span>Active</span>
          </label>
        </div>

      </div>

      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn btn-green">✅ Add Store</button>
        <a href="{{ route('admin.stores.index') }}" class="btn btn-gray">Cancel</a>
      </div>
    </form>
  </div>

  {{-- Quick Logo Tip --}}
  <div class="card" style="margin-top:12px;background:#0f172a">
    <div class="card-title">💡 Logo URL Tips</div>
    <div style="font-size:13px;color:#64748b;line-height:1.8">
      Free logo URLs:<br>
      • <code style="color:#4ade80">https://logo.clearbit.com/aliexpress.com</code><br>
      • <code style="color:#4ade80">https://logo.clearbit.com/booking.com</code><br>
      • <code style="color:#4ade80">https://logo.clearbit.com/shein.com</code><br>
      Just replace domain name!
    </div>
  </div>
</div>
@endsection
