{{-- partials/coupon-card.blade.php --}}
<div class="coupon-card">
    <div class="coupon-card-body">
        <div class="coupon-store-row">
            <img class="coupon-store-logo"
                 src="{{ $coupon->store->logo_url }}"
                 alt="{{ $coupon->store->name }}">
            <span class="coupon-store-name">{{ $coupon->store->name }}</span>
        </div>

        @if($coupon->discount_value)
        <div style="font-size:28px;font-family:'Sora',sans-serif;font-weight:700;color:var(--green);margin-bottom:6px;">
            {{ $coupon->discount_value }} <span style="font-size:16px;color:var(--gray-3);font-weight:400;">OFF</span>
        </div>
        @endif

        <div class="coupon-title">{{ $coupon->title }}</div>

        @if($coupon->description)
        <div class="coupon-desc">{{ Str::limit($coupon->description, 80) }}</div>
        @endif

        <div class="coupon-badges">
            @if($coupon->is_verified)
            <span class="badge badge-green">
                <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                Verified
            </span>
            @endif
            @if($coupon->is_exclusive)
            <span class="badge badge-amber">Exclusive</span>
            @endif
            @if($coupon->type === 'deal')
            <span class="badge badge-gray">No code needed</span>
            @endif
        </div>

        <div class="coupon-expiry">{{ $coupon->expiry_label }}</div>
    </div>

    <div class="coupon-card-footer">
        @if($coupon->type === 'code' && $coupon->code)
            {{-- Blurred code that reveals on click --}}
            <div class="code-reveal"
                 data-code="{{ $coupon->code }}"
                 onclick="revealCode(this, {{ $coupon->id }})">
                {{ $coupon->code }}
                <div class="blur-overlay">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    Click to reveal
                </div>
            </div>
        @else
            <a href="{{ route('coupon.go', $coupon->id) }}"
               target="_blank"
               rel="noopener"
               class="btn btn-green"
               style="flex:1;justify-content:center">
                Get Deal
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        @endif
    </div>
</div>

@once
@push('scripts')
<script>
function revealCode(el, couponId) {
    el.classList.add('revealed');
    const code = el.dataset.code;
    // copy to clipboard
    if (navigator.clipboard) navigator.clipboard.writeText(code);
    // open store in new tab via tracking
    const goUrl = '/go/' + couponId;
    setTimeout(() => window.open(goUrl, '_blank'), 300);
}
</script>
@endpush
@endonce
