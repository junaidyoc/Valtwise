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

        {{-- Collapsible SEO Settings --}}
        <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
          <button type="button" onclick="toggleSeoSection()" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:8px;width:100%;padding:0;text-align:left">
            <span id="seoToggleIcon" style="transition:transform .2s;color:#10b981">&#9654;</span>
            <span style="font-size:14px;font-weight:600;color:#10b981">SEO Settings</span>
            <span style="font-size:11px;color:#64748b;margin-left:auto">Click to expand</span>
          </button>
        </div>

        <div id="seoSection" style="display:none">
          {{-- Basic Meta --}}
          <div class="form-group full" style="margin-top:12px">
            <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Basic SEO</div>
          </div>

          <div class="form-group full">
            <label>Meta Title <span style="color:#64748b;font-weight:400">(max 70 chars)</span></label>
            <input type="text" name="meta_title" value="{{ $store->meta_title }}" maxlength="70" id="metaTitle"
                   placeholder="Leave empty for auto-generated title">
            <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-top:4px">
              <span>Auto: {{ $store->name }} Coupons & Promo Codes {{ date('F Y') }} — Valtwise</span>
              <span id="metaTitleCount">{{ strlen($store->meta_title ?? '') }}/70</span>
            </div>
          </div>

          <div class="form-group full">
            <label>Meta Description <span style="color:#64748b;font-weight:400">(max 160 chars)</span></label>
            <textarea name="meta_description" rows="2" maxlength="160" id="metaDesc"
                      placeholder="Leave empty for auto-generated description">{{ $store->meta_description }}</textarea>
            <div style="text-align:right;font-size:11px;color:#64748b;margin-top:4px">
              <span id="metaDescCount">{{ strlen($store->meta_description ?? '') }}/160</span>
            </div>
          </div>

          <div class="form-group">
            <label>Focus Keyword</label>
            <input type="text" name="focus_keyword" value="{{ $store->focus_keyword }}" maxlength="50"
                   placeholder="e.g. Amazon deals UK">
          </div>

          {{-- Open Graph --}}
          <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
            <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Open Graph (Facebook/LinkedIn)</div>
          </div>

          <div class="form-group full">
            <label>OG Title <span style="color:#64748b;font-weight:400">(leave empty for meta title)</span></label>
            <input type="text" name="og_title" value="{{ $store->og_title }}" maxlength="90">
          </div>

          <div class="form-group full">
            <label>OG Description</label>
            <textarea name="og_description" rows="2" maxlength="200">{{ $store->og_description }}</textarea>
          </div>

          <div class="form-group full">
            <label>OG Image URL</label>
            <input type="url" name="og_image" value="{{ $store->og_image }}" placeholder="Leave empty to use store logo">
          </div>

          {{-- Twitter --}}
          <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
            <div style="font-size:12px;font-weight:600;color:#38bdf8;margin-bottom:8px">Twitter Card</div>
          </div>

          <div class="form-group full">
            <label>Twitter Title <span style="color:#64748b;font-weight:400">(leave empty for OG title)</span></label>
            <input type="text" name="twitter_title" value="{{ $store->twitter_title }}" maxlength="90">
          </div>

          <div class="form-group full">
            <label>Twitter Description</label>
            <textarea name="twitter_description" rows="2" maxlength="200">{{ $store->twitter_description }}</textarea>
          </div>

          <div class="form-group full">
            <label>Twitter Image URL</label>
            <input type="url" name="twitter_image" value="{{ $store->twitter_image }}" placeholder="Leave empty for OG image">
          </div>

          {{-- Technical SEO --}}
          <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
            <div style="font-size:12px;font-weight:600;color:#a78bfa;margin-bottom:8px">Technical SEO</div>
          </div>

          <div class="form-group full">
            <label>Canonical URL <span style="color:#64748b;font-weight:400">(leave empty for auto)</span></label>
            <input type="url" name="canonical_url" value="{{ $store->canonical_url }}">
          </div>

          <div class="form-group">
            <label>Robots Index</label>
            <select name="robots_index">
              <option value="index" {{ ($store->robots_index ?? 'index') == 'index' ? 'selected' : '' }}>Index</option>
              <option value="noindex" {{ ($store->robots_index ?? '') == 'noindex' ? 'selected' : '' }}>NoIndex</option>
            </select>
          </div>

          <div class="form-group">
            <label>Robots Follow</label>
            <select name="robots_follow">
              <option value="follow" {{ ($store->robots_follow ?? 'follow') == 'follow' ? 'selected' : '' }}>Follow</option>
              <option value="nofollow" {{ ($store->robots_follow ?? '') == 'nofollow' ? 'selected' : '' }}>NoFollow</option>
            </select>
          </div>

          <div class="form-group">
            <label>Schema Type</label>
            <select name="schema_type">
              <option value="Store" {{ ($store->schema_type ?? 'Store') == 'Store' ? 'selected' : '' }}>Store</option>
              <option value="Organization" {{ ($store->schema_type ?? '') == 'Organization' ? 'selected' : '' }}>Organization</option>
              <option value="LocalBusiness" {{ ($store->schema_type ?? '') == 'LocalBusiness' ? 'selected' : '' }}>LocalBusiness</option>
            </select>
          </div>

          <div class="form-group">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:20px">
              <input type="checkbox" name="sitemap_include" value="1" {{ ($store->sitemap_include ?? true) ? 'checked' : '' }}>
              Include in Sitemap
            </label>
          </div>

          <div class="form-group">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:20px">
              <input type="checkbox" name="breadcrumb_enable" value="1" {{ ($store->breadcrumb_enable ?? true) ? 'checked' : '' }}>
              Enable Breadcrumbs
            </label>
          </div>
        </div>

        <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
          <label>Categories</label>
          <div style="display:flex;flex-direction:column;gap:16px">
            @foreach($categories as $parent)
            <div>
              {{-- Parent Category Header --}}
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;padding-bottom:6px;border-bottom:1px solid #334155">
                <span style="font-size:18px">{{ $parent->icon ?? '🏷️' }}</span>
                <span style="font-size:13px;font-weight:600;color:#e2e8f0">{{ $parent->name }}</span>
                <label style="display:flex;align-items:center;gap:4px;margin-left:auto;padding:4px 8px;background:#0f172a;border:1px solid #334155;border-radius:4px;cursor:pointer;font-size:11px;color:#64748b">
                  <input type="checkbox" name="category_ids[]" value="{{ $parent->id }}"
                         {{ $store->categories->contains($parent->id) ? 'checked' : '' }}>
                  Main
                </label>
              </div>
              {{-- Subcategories --}}
              @if($parent->children->count() > 0)
              <div style="display:flex;flex-wrap:wrap;gap:6px;padding-left:8px">
                @foreach($parent->children as $sub)
                <label style="display:flex;align-items:center;gap:5px;padding:5px 10px;background:#0f172a;border:1px solid #334155;border-radius:6px;cursor:pointer;font-size:12px;color:#94a3b8;transition:all .15s">
                  <input type="checkbox" name="category_ids[]" value="{{ $sub->id }}"
                         {{ $store->categories->contains($sub->id) ? 'checked' : '' }}>
                  {{ $sub->icon ?? '🏷️' }} {{ $sub->name }}
                </label>
                @endforeach
              </div>
              @else
              <div style="font-size:11px;color:#475569;padding-left:8px">No subcategories</div>
              @endif
            </div>
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
        <button type="submit" class="btn btn-green">Save Changes</button>
        <a href="{{ route('admin.stores.index') }}" class="btn btn-gray">Cancel</a>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function toggleSeoSection() {
  const section = document.getElementById('seoSection');
  const icon = document.getElementById('seoToggleIcon');
  if (section.style.display === 'none') {
    section.style.display = 'contents';
    icon.style.transform = 'rotate(90deg)';
  } else {
    section.style.display = 'none';
    icon.style.transform = 'rotate(0deg)';
  }
}

// Character counters
document.getElementById('metaTitle')?.addEventListener('input', function() {
  document.getElementById('metaTitleCount').textContent = this.value.length + '/70';
});
document.getElementById('metaDesc')?.addEventListener('input', function() {
  document.getElementById('metaDescCount').textContent = this.value.length + '/160';
});
</script>
@endpush
@endsection
