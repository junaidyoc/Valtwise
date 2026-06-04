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

        {{-- Commission Settings --}}
        <div class="form-group">
          <label>Commission Type</label>
          <select name="commission_type">
            <option value="cpa" {{ old('commission_type') === 'cpa' ? 'selected' : '' }}>CPA (Per Sale)</option>
            <option value="cpc" {{ old('commission_type') === 'cpc' ? 'selected' : '' }}>CPC (Per Click)</option>
            <option value="both" {{ old('commission_type') === 'both' ? 'selected' : '' }}>Both CPC + CPA</option>
          </select>
        </div>

        <div class="form-group">
          <label>Commission Info</label>
          <input type="text" name="commission_rate"
                 placeholder="e.g. $0.15 CPC or 5% CPA"
                 value="{{ old('commission_rate') }}">
          <div style="font-size:11px;color:#475569;margin-top:4px">
            Display text for reference
          </div>
        </div>

        <div class="form-group">
          <label>CPC Rate ($)</label>
          <input type="number" name="cpc_rate"
                 placeholder="0.15" step="0.01" min="0"
                 value="{{ old('cpc_rate') }}">
          <div style="font-size:11px;color:#475569;margin-top:4px">
            Amount earned per click (USD)
          </div>
        </div>

        <div class="form-group">
          <label>CPA Rate (%)</label>
          <input type="number" name="cpa_rate"
                 placeholder="5" step="0.1" min="0" max="100"
                 value="{{ old('cpa_rate') }}">
          <div style="font-size:11px;color:#475569;margin-top:4px">
            Commission percentage per sale
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

        {{-- Collapsible SEO Settings --}}
        <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
          <button type="button" onclick="toggleSeoSection()" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:8px;width:100%;padding:0;text-align:left">
            <span id="seoToggleIcon" style="transition:transform .2s;color:#10b981">&#9654;</span>
            <span style="font-size:14px;font-weight:600;color:#10b981">SEO Settings</span>
            <span style="font-size:11px;color:#64748b;margin-left:auto">Optional - Click to expand</span>
          </button>
        </div>

        <div id="seoSection" style="display:none">
          {{-- Basic Meta --}}
          <div class="form-group full" style="margin-top:12px">
            <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Basic SEO</div>
          </div>

          <div class="form-group full">
            <label>Meta Title <span style="color:#64748b;font-weight:400">(max 70 chars)</span></label>
            <input type="text" name="meta_title" value="{{ old('meta_title') }}" maxlength="70" id="metaTitle"
                   placeholder="Leave empty for auto-generated title">
            <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-top:4px">
              <span>Auto: [Store Name] Coupons & Promo Codes {{ date('F Y') }} — Valtwise</span>
              <span id="metaTitleCount">0/70</span>
            </div>
          </div>

          <div class="form-group full">
            <label>Meta Description <span style="color:#64748b;font-weight:400">(max 160 chars)</span></label>
            <textarea name="meta_description" rows="2" maxlength="160" id="metaDesc"
                      placeholder="Leave empty for auto-generated description">{{ old('meta_description') }}</textarea>
            <div style="text-align:right;font-size:11px;color:#64748b;margin-top:4px">
              <span id="metaDescCount">0/160</span>
            </div>
          </div>

          <div class="form-group">
            <label>Focus Keyword</label>
            <input type="text" name="focus_keyword" value="{{ old('focus_keyword') }}" maxlength="50"
                   placeholder="e.g. Amazon deals UK">
          </div>

          {{-- Open Graph --}}
          <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
            <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Open Graph (Facebook/LinkedIn)</div>
          </div>

          <div class="form-group full">
            <label>OG Title <span style="color:#64748b;font-weight:400">(leave empty for meta title)</span></label>
            <input type="text" name="og_title" value="{{ old('og_title') }}" maxlength="90">
          </div>

          <div class="form-group full">
            <label>OG Description</label>
            <textarea name="og_description" rows="2" maxlength="200">{{ old('og_description') }}</textarea>
          </div>

          <div class="form-group full">
            <label>OG Image URL</label>
            <input type="url" name="og_image" value="{{ old('og_image') }}" placeholder="Leave empty to use store logo">
          </div>

          {{-- Twitter --}}
          <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
            <div style="font-size:12px;font-weight:600;color:#38bdf8;margin-bottom:8px">Twitter Card</div>
          </div>

          <div class="form-group full">
            <label>Twitter Title <span style="color:#64748b;font-weight:400">(leave empty for OG title)</span></label>
            <input type="text" name="twitter_title" value="{{ old('twitter_title') }}" maxlength="90">
          </div>

          <div class="form-group full">
            <label>Twitter Description</label>
            <textarea name="twitter_description" rows="2" maxlength="200">{{ old('twitter_description') }}</textarea>
          </div>

          <div class="form-group full">
            <label>Twitter Image URL</label>
            <input type="url" name="twitter_image" value="{{ old('twitter_image') }}" placeholder="Leave empty for OG image">
          </div>

          {{-- Technical SEO --}}
          <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
            <div style="font-size:12px;font-weight:600;color:#a78bfa;margin-bottom:8px">Technical SEO</div>
          </div>

          <div class="form-group full">
            <label>Canonical URL <span style="color:#64748b;font-weight:400">(leave empty for auto)</span></label>
            <input type="url" name="canonical_url" value="{{ old('canonical_url') }}">
          </div>

          <div class="form-group">
            <label>Robots Index</label>
            <select name="robots_index">
              <option value="index" {{ old('robots_index', 'index') == 'index' ? 'selected' : '' }}>Index</option>
              <option value="noindex" {{ old('robots_index') == 'noindex' ? 'selected' : '' }}>NoIndex</option>
            </select>
          </div>

          <div class="form-group">
            <label>Robots Follow</label>
            <select name="robots_follow">
              <option value="follow" {{ old('robots_follow', 'follow') == 'follow' ? 'selected' : '' }}>Follow</option>
              <option value="nofollow" {{ old('robots_follow') == 'nofollow' ? 'selected' : '' }}>NoFollow</option>
            </select>
          </div>

          <div class="form-group">
            <label>Schema Type</label>
            <select name="schema_type">
              <option value="Store" {{ old('schema_type', 'Store') == 'Store' ? 'selected' : '' }}>Store</option>
              <option value="Organization" {{ old('schema_type') == 'Organization' ? 'selected' : '' }}>Organization</option>
              <option value="LocalBusiness" {{ old('schema_type') == 'LocalBusiness' ? 'selected' : '' }}>LocalBusiness</option>
            </select>
          </div>

          <div class="form-group">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:20px">
              <input type="checkbox" name="sitemap_include" value="1" {{ old('sitemap_include', true) ? 'checked' : '' }}>
              Include in Sitemap
            </label>
          </div>

          <div class="form-group">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:20px">
              <input type="checkbox" name="breadcrumb_enable" value="1" {{ old('breadcrumb_enable', true) ? 'checked' : '' }}>
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
                @if($parent->children->count() > 0)
                <button type="button" onclick="toggleSubcats('subcats-{{ $parent->id }}')"
                        style="padding:4px 10px;background:#1e3a5f;border:1px solid #334155;border-radius:4px;cursor:pointer;font-size:11px;color:#60a5fa;display:flex;align-items:center;gap:4px">
                  <span id="subcats-{{ $parent->id }}-icon" style="transition:transform .2s;font-size:8px">▶</span>
                  {{ $parent->children->count() }} subcats
                </button>
                @endif
                <label style="display:flex;align-items:center;gap:4px;margin-left:auto;padding:4px 8px;background:#0f172a;border:1px solid #334155;border-radius:4px;cursor:pointer;font-size:11px;color:#64748b">
                  <input type="checkbox" name="category_ids[]" value="{{ $parent->id }}"
                         {{ in_array($parent->id, old('category_ids', [])) ? 'checked' : '' }}>
                  Main
                </label>
              </div>
              {{-- Subcategories (hidden by default) --}}
              @if($parent->children->count() > 0)
              <div id="subcats-{{ $parent->id }}" style="display:none;flex-wrap:wrap;gap:6px;padding-left:8px;margin-top:8px">
                @foreach($parent->children as $sub)
                <label style="display:flex;align-items:center;gap:5px;padding:5px 10px;background:#0f172a;border:1px solid #334155;border-radius:6px;cursor:pointer;font-size:12px;color:#94a3b8;transition:all .15s">
                  <input type="checkbox" name="category_ids[]" value="{{ $sub->id }}"
                         {{ in_array($sub->id, old('category_ids', [])) ? 'checked' : '' }}>
                  {{ $sub->icon ?? '🏷️' }} {{ $sub->name }}
                </label>
                @endforeach
              </div>
              @endif
            </div>
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
    <div class="card-title">Logo URL Tips</div>
    <div style="font-size:13px;color:#64748b;line-height:1.8">
      Free logo URLs:<br>
      <code style="color:#4ade80">https://logo.clearbit.com/aliexpress.com</code><br>
      <code style="color:#4ade80">https://logo.clearbit.com/booking.com</code><br>
      Just replace domain name!
    </div>
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

function toggleSubcats(id) {
  const section = document.getElementById(id);
  const icon = document.getElementById(id + '-icon');
  if (section.style.display === 'none') {
    section.style.display = 'flex';
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
