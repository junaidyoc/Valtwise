@extends('layouts.app')
@section('title', 'All Stores with Coupon Codes & Deals ' . date('Y') . ' — Valtwise')
@section('meta_description', 'Browse all ' . $stores->total() . ' stores with verified coupon codes and deals. Find discounts from top UK & Pakistan brands A-Z.')
@section('meta_keywords', 'all stores, coupon stores, discount stores, store coupons, brand deals, A-Z stores')

@push('pagination_meta')
@if(isset($stores) && $stores->hasPages())
    @if($stores->previousPageUrl())
    <link rel="prev" href="{{ $stores->previousPageUrl() }}">
    @endif
    @if($stores->nextPageUrl())
    <link rel="next" href="{{ $stores->nextPageUrl() }}">
    @endif
@endif
@endpush

{{-- Open Graph --}}
@section('og_title', 'All ' . $stores->total() . ' Stores with Coupon Codes — Valtwise')
@section('og_description', 'Browse verified coupon codes from ' . $stores->total() . ' top stores. Find deals A-Z.')

{{-- Schema Markup --}}
@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "CollectionPage",
    "name": "All Stores with Coupon Codes",
    "description": "Browse all {{ $stores->total() }} stores with verified coupon codes and deals",
    "url": "{{ route('stores.index') }}",
    "numberOfItems": {{ $stores->total() }}
}
</script>
@endpush

@push('styles')
<style>
    .page-search-form {
        display: flex;
        gap: 10px;
        margin-bottom: 28px;
        max-width: 480px;
    }
    .page-search-form input {
        flex: 1;
        border: 1px solid var(--gray-2);
        border-radius: var(--radius-md);
        padding: 10px 16px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        min-width: 0;
    }
    .page-search-form input:focus {
        border-color: var(--green);
    }
    .alpha-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 28px;
    }
    .alpha-letter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: var(--radius-md);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all .15s ease;
        background: var(--gray-1);
        color: var(--gray-4);
    }
    .alpha-letter:hover:not(.disabled) {
        background: var(--green);
        color: #fff;
    }
    .alpha-letter.active {
        background: var(--green);
        color: #fff;
    }
    .alpha-letter.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .pagination-wrap {
        margin-top: 32px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .pagination-info {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
        margin-top: 12px;
        flex-wrap: wrap;
    }
    .page-link {
        padding: 8px 12px;
        font-size: 14px;
        color: var(--dark);
        background: var(--white);
        border: 1px solid var(--gray-2);
        border-radius: var(--radius-md);
        text-decoration: none;
    }
    .page-link.active {
        font-weight: 600;
        color: #fff;
        background: var(--green);
        border-color: var(--green);
    }
    .page-link.disabled {
        color: var(--gray-3);
        background: var(--gray-1);
        border-color: var(--gray-1);
    }
    @media (max-width: 767px) {
        .page-search-form { max-width: 100%; }
        .alpha-filter { gap: 4px; }
        .alpha-letter { min-width: 32px; height: 32px; font-size: 12px; }
        .pagination-wrap { gap: 4px; }
        .pagination-info { flex-direction: column; gap: 8px; }
        .page-link { padding: 6px 10px; font-size: 13px; }
    }
    @media (max-width: 479px) {
        .alpha-letter { min-width: 28px; height: 28px; font-size: 11px; padding: 0 6px; }
        .page-link { padding: 5px 8px; font-size: 12px; }
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <h1 class="section-title">All <span>Stores</span></h1>
            <span class="text-muted text-sm">{{ $stores->total() }} stores</span>
        </div>

        {{-- Search --}}
        <form action="{{ route('stores.index') }}" method="GET" class="page-search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search stores…">
            <button type="submit" class="btn btn-green">Search</button>
        </form>

        {{-- A-Z Alphabetical Filter --}}
        <div class="alpha-filter">
            <a href="{{ route('stores.index', request()->except('letter', 'page')) }}"
               class="alpha-letter {{ !request('letter') ? 'active' : '' }}">All</a>
            @foreach(range('A', 'Z') as $letter)
                @php $hasStores = in_array($letter, $availableLetters ?? []); @endphp
                <a href="{{ $hasStores ? route('stores.index', array_merge(request()->except('page'), ['letter' => $letter])) : '#' }}"
                   class="alpha-letter {{ request('letter') === $letter ? 'active' : '' }} {{ !$hasStores ? 'disabled' : '' }}"
                   {{ !$hasStores ? 'onclick=return false;' : '' }}>{{ $letter }}</a>
            @endforeach
            @php $hasNumbers = collect($availableLetters ?? [])->contains(fn($l) => is_numeric($l)); @endphp
            <a href="{{ $hasNumbers ? route('stores.index', array_merge(request()->except('page'), ['letter' => '#'])) : '#' }}"
               class="alpha-letter {{ request('letter') === '#' ? 'active' : '' }} {{ !$hasNumbers ? 'disabled' : '' }}"
               {{ !$hasNumbers ? 'onclick=return false;' : '' }}>#</a>
        </div>

        @if(request('letter'))
        <div style="margin-bottom:20px;">
            <span style="font-size:14px;color:var(--gray-4);">
                Showing stores starting with "{{ request('letter') }}"
                <a href="{{ route('stores.index', request()->except('letter')) }}" style="color:var(--green);margin-left:8px;">Clear filter</a>
            </span>
        </div>
        @endif

        <div class="store-grid">
            @forelse($stores as $store)
            <a href="{{ route('stores.show', $store->slug) }}" class="store-card">
                <div class="store-logo-wrap">
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" loading="lazy" width="60" height="60"
                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($store->name) }}&background=f3f4f6&color=374151&size=80'">
                </div>
                <div class="store-name">{{ $store->name }}</div>
                <div class="store-meta">{{ $store->coupons_count }} coupons</div>
            </a>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-4)">
                No stores found for "{{ request('search') }}"
            </div>
            @endforelse
        </div>

        {{-- Custom Pagination --}}
        @if($stores->hasPages())
        <div class="pagination-wrap">
            @if($stores->onFirstPage())
                <span class="page-link disabled">← Prev</span>
            @else
                <a href="{{ $stores->previousPageUrl() }}" class="page-link">← Prev</a>
            @endif

            @foreach($stores->getUrlRange(1, $stores->lastPage()) as $page => $url)
                @if($page == $stores->currentPage())
                    <span class="page-link active">{{ $page }}</span>
                @elseif($page == 1 || $page == $stores->lastPage() || abs($page - $stores->currentPage()) <= 2)
                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                @elseif(abs($page - $stores->currentPage()) == 3)
                    <span class="text-muted">...</span>
                @endif
            @endforeach

            @if($stores->hasMorePages())
                <a href="{{ $stores->nextPageUrl() }}" class="page-link">Next →</a>
            @else
                <span class="page-link disabled">Next →</span>
            @endif
        </div>
        <div class="pagination-info">
            <span class="text-muted text-sm">
                Showing {{ $stores->firstItem() }} to {{ $stores->lastItem() }} of {{ $stores->total() }} stores
            </span>
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="text-muted text-sm">Show</span>
                <select onchange="window.location.href=this.value" style="padding:6px 10px;border:1px solid var(--gray-2);border-radius:var(--radius-md);background:var(--white);font-size:13px;font-family:'DM Sans',sans-serif;">
                    @foreach([12, 24, 48, 96] as $size)
                    <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" {{ ($perPage ?? 24) == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
                <span class="text-muted text-sm">per page</span>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
