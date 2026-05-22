@extends('layouts.app')
@section('title', $category->name . ' Coupons & Deals — Valtwise')

@section('content')
<section class="section">
    <div class="container">
        <div style="font-size:12px;color:var(--gray-4);margin-bottom:20px">
            <a href="{{ route('home') }}" style="color:var(--gray-4)">Home</a>
            <span style="margin:0 6px">›</span>
            <span>{{ $category->name }}</span>
        </div>

        <div class="section-header">
            <h1 class="section-title">{{ $category->name }} <span>Coupons</span></h1>
            <span class="text-muted text-sm">{{ $stores->total() }} stores</span>
        </div>

        <div class="store-grid">
            @forelse($stores as $store)
            <a href="{{ route('stores.show', $store->slug) }}" class="store-card">
                <div class="store-logo-wrap">
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" loading="lazy">
                </div>
                <div class="store-name">{{ $store->name }}</div>
                <div class="store-meta">{{ $store->coupons_count }} coupons</div>
                @if($store->cashback_rate > 0)
                <div class="cashback-pill">{{ $store->cashback_rate }}% Back</div>
                @endif
                @if($store->is_featured)
                <span class="badge badge-amber">Featured</span>
                @endif
            </a>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-4)">
                No stores in this category yet.
            </div>
            @endforelse
        </div>

        <div style="margin-top:32px">{{ $stores->links() }}</div>
    </div>
</section>
@endsection
