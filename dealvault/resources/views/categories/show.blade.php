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
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" loading="lazy"
                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($store->name) }}&background=f3f4f6&color=374151&size=80'">
                </div>
                <div class="store-name">{{ $store->name }}</div>
                <div class="store-meta">{{ $store->coupons_count }} coupons</div>
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

        {{-- Custom Pagination --}}
        @if($stores->hasPages())
        <div style="margin-top:32px;display:flex;justify-content:center;align-items:center;gap:8px;flex-wrap:wrap;">
            {{-- Previous --}}
            @if($stores->onFirstPage())
                <span style="padding:8px 14px;font-size:14px;color:var(--gray-3);background:var(--gray-1);border-radius:var(--radius-md);">← Prev</span>
            @else
                <a href="{{ $stores->previousPageUrl() }}" style="padding:8px 14px;font-size:14px;color:var(--dark);background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-md);text-decoration:none;">← Prev</a>
            @endif

            {{-- Page Numbers --}}
            @foreach($stores->getUrlRange(1, $stores->lastPage()) as $page => $url)
                @if($page == $stores->currentPage())
                    <span style="padding:8px 12px;font-size:14px;font-weight:600;color:#fff;background:var(--green);border-radius:var(--radius-md);">{{ $page }}</span>
                @elseif($page == 1 || $page == $stores->lastPage() || abs($page - $stores->currentPage()) <= 2)
                    <a href="{{ $url }}" style="padding:8px 12px;font-size:14px;color:var(--dark);background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-md);text-decoration:none;">{{ $page }}</a>
                @elseif(abs($page - $stores->currentPage()) == 3)
                    <span style="padding:8px 4px;font-size:14px;color:var(--gray-4);">...</span>
                @endif
            @endforeach

            {{-- Next --}}
            @if($stores->hasMorePages())
                <a href="{{ $stores->nextPageUrl() }}" style="padding:8px 14px;font-size:14px;color:var(--dark);background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-md);text-decoration:none;">Next →</a>
            @else
                <span style="padding:8px 14px;font-size:14px;color:var(--gray-3);background:var(--gray-1);border-radius:var(--radius-md);">Next →</span>
            @endif
        </div>
        <div style="text-align:center;margin-top:12px;font-size:13px;color:var(--gray-4);">
            Showing {{ $stores->firstItem() }} to {{ $stores->lastItem() }} of {{ $stores->total() }} stores
        </div>
        @endif
    </div>
</section>
@endsection
