@extends('admin.layouts.app')
@section('title', 'Edit Store')
@section('page-title', '✏️ Edit Store')

@section('content')
<div style="max-width:700px">
  <a href="{{ route('admin.stores.index') }}" class="btn btn-gray btn-sm" style="margin-bottom:16px">← Back</a>

  <div class="card">
    <form method="POST" action="{{ route('admin.stores.update', $store) }}">
      @csrf @method('PUT')
      <div class="form-grid">

        <div class="form-group">
          <label>Store Name</label>
          <input type="text" name="name" value="{{ $store->name }}" required>
        </div>

        <div class="form-group">
          <label>Network</label>
          <select name="network">
            @foreach(['admitad','commission_factory','cj','rakuten','shareasale','direct'] as $n)
            <option value="{{ $n }}" {{ $store->network == $n ? 'selected' : '' }}>
              {{ ucfirst(str_replace('_',' ',$n)) }}
            </option>
            @endforeach
          </select>
        </div>

        <div class="form-group full">
          <label>Website URL</label>
          <input type="url" name="website_url" value="{{ $store->website_url }}" required>
        </div>

        <div class="form-group full">
          <label>Affiliate Link Template</label>
          <input type="url" name="affiliate_url_template"
                 value="{{ $store->affiliate_url_template }}"
                 placeholder="https://ad.admitad.com/g/XXXXX/?ulp={destination}">
        </div>

        {{-- Commission Settings --}}
        <div class="form-group">
          <label>Commission Type</label>
          <select name="commission_type">
            <option value="cpa" {{ $store->commission_type === 'cpa' ? 'selected' : '' }}>CPA (Per Sale)</option>
            <option value="cpc" {{ $store->commission_type === 'cpc' ? 'selected' : '' }}>CPC (Per Click)</option>
            <option value="both" {{ $store->commission_type === 'both' ? 'selected' : '' }}>Both CPC + CPA</option>
          </select>
        </div>

        <div class="form-group">
          <label>Commission Info</label>
          <input type="text" name="commission_rate"
                 placeholder="e.g. $0.15 CPC or 5% CPA"
                 value="{{ $store->commission_rate }}">
        </div>

        <div class="form-group">
          <label>CPC Rate ($)</label>
          <input type="number" name="cpc_rate"
                 placeholder="0.15" step="0.01" min="0"
                 value="{{ $store->cpc_rate }}">
        </div>

        <div class="form-group">
          <label>CPA Rate (%)</label>
          <input type="number" name="cpa_rate"
                 placeholder="5" step="0.1" min="0" max="100"
                 value="{{ $store->cpa_rate }}">
        </div>

        <div class="form-group">
          <label>Logo URL</label>
          <input type="url" name="logo" value="{{ $store->logo }}">
        </div>

        <div class="form-group">
          <label>Cashback Rate (%)</label>
          <input type="number" name="cashback_rate"
                 value="{{ $store->cashback_rate }}" step="0.5" min="0" max="100">
        </div>

        <div class="form-group full">
          <label>Description</label>
          <textarea name="description" rows="3">{{ $store->description }}</textarea>
        </div>

        <div class="form-group full">
          <label>Categories</label>
          <div style="display:flex;flex-wrap:wrap;gap:8px">
            @foreach($categories as $cat)
            <label style="display:flex;align-items:center;gap:6px;padding:6px 10px;background:#0f172a;border:1px solid #334155;border-radius:6px;cursor:pointer;font-size:13px;color:#94a3b8">
              <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                     {{ $store->categories->contains($cat->id) ? 'checked' : '' }}>
              {{ $cat->name }}
            </label>
            @endforeach
          </div>
        </div>

        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_featured" value="1"
                   {{ $store->is_featured ? 'checked' : '' }}>
            Featured Store
          </label>
        </div>

        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_active" value="1"
                   {{ $store->is_active ? 'checked' : '' }}>
            Active
          </label>
        </div>

      </div>

      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn btn-green">💾 Save Changes</button>
        <a href="{{ route('admin.stores.index') }}" class="btn btn-gray">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
