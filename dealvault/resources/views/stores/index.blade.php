@extends('layouts.app')
@section('title', 'All Stores — Valtwise')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <h1 class="section-title">All <span>Stores</span></h1>
            <span class="text-muted text-sm">{{ $stores->total() }} stores</span>
        </div>

        {{-- Search --}}
        <form action="{{ route('stores.index') }}" method="GET"
              style="display:flex;gap:10px;margin-bottom:28px;max-width:480px">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search stores…"
                   style="flex:1;border:1px solid var(--gray-2);border-radius:var(--radius-md);padding:10px 16px;font-size:14px;font-family:'DM Sans',sans-serif;outline:none">
            <button type="submit" class="btn btn-green">Search</button>
        </form>

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
            </a>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-4)">
                No stores found for "{{ request('search') }}"
            </div>
            @endforelse
        </div>

        <div style="margin-top:32px">{{ $stores->withQueryString()->links() }}</div>
    </div>
</section>
@endsection
