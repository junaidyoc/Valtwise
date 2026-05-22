@extends('layouts.app')

@section('title', 'DealVault — Best Coupon Codes & Promo Deals')

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
            <p>Verified coupon codes, exclusive deals, and cashback offers from {{ \App\Models\Store::active()->count() }}+ top brands.</p>
            <form action="{{ route('stores.index') }}" method="GET" class="hero-search">
                <input type="text" name="search" placeholder="Search for a store or brand…">
                <button type="submit">Search</button>
            </form>
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
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" loading="lazy">
                </div>
                <div class="store-name">{{ $store->name }}</div>
                <div class="store-meta">{{ $store->coupons_count }} coupons</div>
                @if($store->cashback_rate > 0)
                    <div class="cashback-pill">{{ $store->cashback_rate }}% Cashback</div>
                @endif
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
                <div class="category-count">{{ $category->active_stores_count }} stores</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Cashback ─────────────────────────────────────────────────────────── --}}
@if($cashbackStores->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Top <span>Cashback</span> Stores</h2>
        </div>
        <div class="store-grid">
            @foreach($cashbackStores as $store)
            <a href="{{ route('stores.show', $store->slug) }}" class="store-card">
                <div class="store-logo-wrap">
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" loading="lazy">
                </div>
                <div class="store-name">{{ $store->name }}</div>
                <div class="cashback-pill">{{ $store->cashback_rate }}% Cash Back</div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
