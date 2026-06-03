@extends('layouts.app')

@section('title', 'Valtwise — Best Coupon Codes & Deals for UK & Pakistan ' . date('Y'))
@section('meta_description', 'Find verified coupon codes, promo codes, and exclusive deals from ' . \App\Models\Store::active()->count() . '+ top brands. Save money on UK & Pakistan online shopping with Valtwise.')
@section('meta_keywords', 'coupon codes, promo codes, discount codes, deals UK, deals Pakistan, voucher codes, online shopping deals, verified coupons')

{{-- Open Graph --}}
@section('og_title', 'Valtwise — ' . \App\Models\Coupon::active()->count() . '+ Active Coupon Codes & Deals')
@section('og_description', 'Find verified coupon codes and exclusive deals from top UK & Pakistan brands. Save money every time you shop online.')

{{-- WebSite Schema for Sitelinks --}}
@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebSite",
    "name": "{{ $seoSettings['site_name'] ?? 'Valtwise' }}",
    "url": "{{ config('app.url') }}",
    "description": "Find verified coupon codes, promo codes, and exclusive deals for UK & Pakistan",
    "potentialAction": {
        "@@type": "SearchAction",
        "target": {
            "@@type": "EntryPoint",
            "urlTemplate": "{{ route('stores.index') }}?search={search_term_string}"
        },
        "query-input": "required name=search_term_string"
    }
}
</script>
@endpush

@section('content')

{{-- ── Hero ─────────────────────────────────────────────────────────────── --}}
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-eyebrow">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                {{ \App\Models\Coupon::active()->count() }}+ active deals today
            </div>
            <h1>Save more on everything<br>you <span>already buy</span></h1>
            <p>Verified coupon codes and exclusive deals from {{ \App\Models\Store::active()->count() }}+ top brands.</p>
            <form action="{{ route('stores.index') }}" method="GET" class="hero-search">
                <input type="text" name="search" placeholder="Search for a store or brand…">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</section>

{{-- ── Stores Slider ───────────────────────────────────────────────────── --}}
<section class="stores-slider-section">
    <div class="stores-slider-wrapper">
        <div class="stores-slider-track">
            @foreach($sliderStores as $store)
            <a href="{{ route('stores.show', $store->slug) }}" class="slider-store-item">
                <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" loading="lazy" width="54" height="54"
                     onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($store->name) }}&background=f3f4f6&color=374151&size=60'">
            </a>
            @endforeach
            {{-- Duplicate for seamless infinite scroll --}}
            @foreach($sliderStores as $store)
            <a href="{{ route('stores.show', $store->slug) }}" class="slider-store-item">
                <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" loading="lazy" width="54" height="54"
                     onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($store->name) }}&background=f3f4f6&color=374151&size=60'">
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Featured Stores ─────────────────────────────────────────────────── --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Popular <span>Stores</span></h2>
            <a href="{{ route('stores.index') }}" class="view-all">View all stores →</a>
        </div>
        <div class="store-grid">
            @foreach($featuredStores as $store)
            <a href="{{ route('stores.show', $store->slug) }}" class="store-card">
                <div class="store-logo-wrap">
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" loading="lazy" width="60" height="60"
                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($store->name) }}&background=f3f4f6&color=374151&size=80'">
                </div>
                <div class="store-name">{{ $store->name }}</div>
                <div class="store-meta">{{ $store->coupons_count }} coupons</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<div class="divider"></div>

{{-- ── Top Coupons ─────────────────────────────────────────────────────── --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Today's <span>Top Deals</span></h2>
        </div>
        <div class="coupon-grid">
            @foreach($topCoupons as $coupon)
            @include('partials.coupon-card', ['coupon' => $coupon])
            @endforeach
        </div>
    </div>
</section>

<div class="divider"></div>

{{-- ── Categories ──────────────────────────────────────────────────────── --}}
<section class="section" style="background: var(--gray-1);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Browse by <span>Category</span></h2>
        </div>
        <div class="category-grid">
            @php
            $icons = [
                'apparel-clothing' => '👗',
                'electronics' => '💻',
                'health-beauty' => '💄',
                'travel' => '✈️',
                'sports-outdoors' => '⚽',
                'food-drinks' => '🍔',
                'home-garden' => '🏡',
                'babies-kids' => '🍼',
                'pets' => '🐾',
                'automotive' => '🚗',
                'games-toys' => '🎮',
                'jewelry-watches' => '💍',
            ];
            @endphp
            @foreach($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="category-card">
                <span class="category-icon">{{ $icons[$category->slug] ?? '🏷️' }}</span>
                <div class="category-name">{{ $category->name }}</div>
                <div class="category-count">
                    {{ $category->active_stores_count }} stores
                    @if($category->children_count > 0)
                        · {{ $category->children_count }} subcategories
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
