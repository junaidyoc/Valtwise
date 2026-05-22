@extends('layouts.app')

@section('title', $store->name . ' Coupons & Promo Codes — Valtwise')
@section('meta_description', 'Find the latest ' . $store->name . ' coupon codes and deals. ' . $coupons->count() . ' active discounts verified today.')

@push('styles')
<style>
.store-header {
    background: var(--dark);
    padding: 40px 0;
    border-bottom: 1px solid var(--dark-2);
}
.store-header-inner {
    display: flex;
    align-items: center;
    gap: 24px;
}
.store-header-logo {
    width: 88px;
    height: 88px;
    border-radius: var(--radius-lg);
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.1);
    flex-shrink: 0;
}
.store-header-logo img { width: 100%; height: 100%; object-fit: contain; padding: 8px; }
.store-header-info h1 { color: var(--white); font-size: 26px; margin-bottom: 6px; }
.store-header-info p  { color: #a1a1aa; font-size: 14px; max-width: 500px; }
.store-stats {
    display: flex;
    gap: 24px;
    margin-top: 16px;
}
.store-stat { text-align: center; }
.store-stat-num { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 700; color: #4ade80; }
.store-stat-lbl { font-size: 11px; color: #71717a; margin-top: 2px; }

.filter-bar {
    background: var(--white);
    border-bottom: 1px solid var(--gray-2);
    padding: 12px 0;
    position: sticky;
    top: 60px;
    z-index: 50;
}
.filter-inner {
    display: flex;
    gap: 8px;
    align-items: center;
}
.filter-btn {
    padding: 6px 14px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid var(--gray-2);
    background: transparent;
    cursor: pointer;
    color: var(--gray-4);
    transition: all .15s;
    font-family: 'DM Sans', sans-serif;
}
.filter-btn:hover, .filter-btn.active {
    background: var(--dark);
    color: var(--white);
    border-color: var(--dark);
}

.coupon-list { display: flex; flex-direction: column; gap: 16px; }
.coupon-list-item {
    background: var(--white);
    border: 1px solid var(--gray-2);
    border-radius: var(--radius-lg);
    display: flex;
    gap: 0;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.coupon-list-item:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-1px);
}
.coupon-discount-strip {
    width: 110px;
    flex-shrink: 0;
    background: var(--green-light);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 16px 8px;
    border-right: 1.5px dashed #86efac;
}
.discount-value {
    font-family: 'Sora', sans-serif;
    font-size: 26px;
    font-weight: 700;
    color: var(--green);
    line-height: 1;
}
.discount-type { font-size: 10px; color: #15803d; font-weight: 600; text-transform: uppercase; margin-top: 4px; }
.coupon-list-body { flex: 1; padding: 16px 20px; }
.coupon-list-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 600; margin-bottom: 4px; }
.coupon-list-desc { font-size: 13px; color: var(--gray-4); margin-bottom: 10px; }
.coupon-list-action {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    padding: 16px;
    border-left: 1px solid var(--gray-1);
    background: var(--gray-1);
    min-width: 160px;
    justify-content: center;
}

.json-ld { display: none; }
</style>
@endpush

@section('content')

{{-- ── Store Header ─────────────────────────────────────────────────────── --}}
<div class="store-header">
    <div class="container">
        <div style="font-size:12px;color:#52525b;margin-bottom:16px">
            <a href="{{ route('home') }}" style="color:#52525b;">Home</a>
            <span style="margin:0 6px">›</span>
            <a href="{{ route('stores.index') }}" style="color:#52525b;">Stores</a>
            <span style="margin:0 6px">›</span>
            <span style="color:#a1a1aa">{{ $store->name }}</span>
        </div>
        <div class="store-header-inner">
            <div class="store-header-logo">
                <img src="{{ $store->logo_url }}" alt="{{ $store->name }}">
            </div>
            <div class="store-header-info">
                <h1>{{ $store->name }} Coupons</h1>
                @if($store->description)
                <p>{{ $store->description }}</p>
                @endif
                <div class="store-stats">
                    <div class="store-stat">
                        <div class="store-stat-num">{{ $coupons->count() }}</div>
                        <div class="store-stat-lbl">Active coupons</div>
                    </div>
                    @if($store->cashback_rate > 0)
                    <div class="store-stat">
                        <div class="store-stat-num">{{ $store->cashback_rate }}%</div>
                        <div class="store-stat-lbl">Cash back</div>
                    </div>
                    @endif
                    <div class="store-stat">
                        <div class="store-stat-num">{{ $coupons->where('is_verified', true)->count() }}</div>
                        <div class="store-stat-lbl">Verified</div>
                    </div>
                </div>
            </div>
            <div style="margin-left:auto">
                <a href="{{ route('coupon.go', $coupons->first()?->id ?? 0) }}"
                   target="_blank"
                   rel="noopener"
                   class="btn btn-green"
                   style="font-size:15px;padding:12px 28px">
                    Visit {{ $store->name }}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── Filter Bar ───────────────────────────────────────────────────────── --}}
<div class="filter-bar">
    <div class="container filter-inner">
        <button class="filter-btn active" onclick="filterCoupons('all', this)">All ({{ $coupons->count() }})</button>
        <button class="filter-btn" onclick="filterCoupons('code', this)">Coupon Codes ({{ $coupons->where('type','code')->count() }})</button>
        <button class="filter-btn" onclick="filterCoupons('deal', this)">Deals ({{ $coupons->where('type','deal')->count() }})</button>
        <button class="filter-btn" onclick="filterCoupons('verified', this)">✓ Verified ({{ $coupons->where('is_verified',true)->count() }})</button>
    </div>
</div>

{{-- ── Coupon List ──────────────────────────────────────────────────────── --}}
<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 300px;gap:32px;align-items:start">
            <div>
                <div class="coupon-list" id="coupon-list">
                    @forelse($coupons as $coupon)
                    <div class="coupon-list-item"
                         data-type="{{ $coupon->type }}"
                         data-verified="{{ $coupon->is_verified ? '1' : '0' }}">
                        {{-- Discount strip --}}
                        <div class="coupon-discount-strip">
                            @if($coupon->discount_value)
                            <div class="discount-value">{{ $coupon->discount_value }}</div>
                            <div class="discount-type">{{ $coupon->type === 'deal' ? 'Deal' : 'Off' }}</div>
                            @else
                            <div class="discount-value" style="font-size:18px">SALE</div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="coupon-list-body">
                            <div class="coupon-badges" style="margin-bottom:6px">
                                @if($coupon->is_verified)
                                <span class="badge badge-green">
                                    <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                                    Verified
                                </span>
                                @endif
                                @if($coupon->is_exclusive)
                                <span class="badge badge-amber">Exclusive</span>
                                @endif
                            </div>
                            <div class="coupon-list-title">{{ $coupon->title }}</div>
                            @if($coupon->description)
                            <div class="coupon-list-desc">{{ $coupon->description }}</div>
                            @endif
                            <div style="font-size:12px;color:var(--gray-3)">{{ $coupon->expiry_label }}</div>
                        </div>

                        {{-- Action --}}
                        <div class="coupon-list-action">
                            @if($coupon->type === 'code' && $coupon->code)
                            <div style="text-align:center">
                                <div class="code-reveal"
                                     data-code="{{ $coupon->code }}"
                                     onclick="revealCode(this, {{ $coupon->id }})"
                                     style="margin-bottom:6px">
                                    {{ $coupon->code }}
                                    <div class="blur-overlay">Click to reveal</div>
                                </div>
                                <div style="font-size:11px;color:var(--gray-3)">Click to copy & go</div>
                            </div>
                            @else
                            <a href="{{ route('coupon.go', $coupon->id) }}"
                               target="_blank"
                               rel="noopener"
                               class="btn btn-green"
                               style="width:100%;justify-content:center">
                                Get Deal →
                            </a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center;padding:60px 20px;color:var(--gray-4)">
                        <div style="font-size:40px;margin-bottom:12px">🏷️</div>
                        <p>No active coupons right now. Check back soon!</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="position:sticky;top:108px">
                @if($store->cashback_rate > 0)
                <div style="background:var(--green-light);border:1px solid #86efac;border-radius:var(--radius-lg);padding:20px;margin-bottom:20px;text-align:center">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#15803d;margin-bottom:6px">Cash Back Available</div>
                    <div style="font-size:36px;font-weight:700;font-family:'Sora',sans-serif;color:var(--green)">{{ $store->cashback_rate }}%</div>
                    <div style="font-size:13px;color:#15803d;margin-top:4px">on all purchases</div>
                </div>
                @endif

                @if($similarStores->isNotEmpty())
                <div style="background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px">
                    <h4 style="font-size:14px;font-weight:600;margin-bottom:14px">Similar Stores</h4>
                    @foreach($similarStores as $s)
                    <a href="{{ route('stores.show', $s->slug) }}"
                       style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--gray-1)">
                        <img src="{{ $s->logo_url }}"
                             style="width:36px;height:36px;border-radius:8px;border:1px solid var(--gray-2);object-fit:contain;padding:3px;background:#fafafa"
                             alt="{{ $s->name }}">
                        <div>
                            <div style="font-size:13px;font-weight:600">{{ $s->name }}</div>
                            <div style="font-size:11px;color:var(--gray-4)">{{ $s->coupons_count }} coupons</div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- JSON-LD structured data for Google rich results --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "{{ $store->name }} Coupons",
  "description": "Best coupon codes and deals for {{ $store->name }}",
  "numberOfItems": {{ $coupons->count() }},
  "itemListElement": [
    @foreach($coupons->take(10) as $i => $coupon)
    {
      "@type": "Offer",
      "position": {{ $i + 1 }},
      "name": "{{ addslashes($coupon->title) }}",
      "description": "{{ addslashes($coupon->description ?? '') }}",
      "url": "{{ route('coupon.go', $coupon->id) }}",
      "validThrough": "{{ $coupon->expires_at?->toIso8601String() ?? '2099-12-31T00:00:00Z' }}"
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>

@endsection

@push('scripts')
<script>
function filterCoupons(type, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.coupon-list-item').forEach(item => {
        if (type === 'all') {
            item.style.display = '';
        } else if (type === 'verified') {
            item.style.display = item.dataset.verified === '1' ? '' : 'none';
        } else {
            item.style.display = item.dataset.type === type ? '' : 'none';
        }
    });
}

function revealCode(el, couponId) {
    el.classList.add('revealed');
    const code = el.dataset.code;
    if (navigator.clipboard) navigator.clipboard.writeText(code);
    setTimeout(() => window.open('/go/' + couponId, '_blank'), 300);
}
</script>
@endpush
