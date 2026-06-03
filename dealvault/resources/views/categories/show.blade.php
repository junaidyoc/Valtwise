@extends('layouts.app')

{{-- SEO: Uses custom values from admin or auto-generated --}}
@section('title', $category->seo_title)
@section('meta_description', $category->seo_description)
@section('meta_keywords', $category->seo_keywords)

{{-- Robots & Canonical (from enhanced SEO) --}}
@section('robots', $category->seo_robots)
@section('canonical', $category->seo_canonical)

{{-- Pagination SEO --}}
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
@section('og_title', $category->seo_og_title ?: $category->name . ' Coupons & Deals — ' . $stores->total() . ' Stores')
@section('og_description', $category->seo_og_description ?: 'Find verified ' . $category->name . ' coupon codes from ' . $stores->total() . ' top stores.')
@section('og_image', $category->seo_og_image)

{{-- Schema Markup --}}
@push('schema')
{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ route('home') }}"
        }
        @if($category->parent)
        ,{
            "@@type": "ListItem",
            "position": 2,
            "name": "{{ $category->parent->name }}",
            "item": "{{ route('categories.show', $category->parent->slug) }}"
        },
        {
            "@@type": "ListItem",
            "position": 3,
            "name": "{{ $category->name }}",
            "item": "{{ route('categories.show', $category->slug) }}"
        }
        @else
        ,{
            "@@type": "ListItem",
            "position": 2,
            "name": "{{ $category->name }}",
            "item": "{{ route('categories.show', $category->slug) }}"
        }
        @endif
    ]
}
</script>

{{-- CollectionPage Schema --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "CollectionPage",
    "name": "{{ $category->name }} Coupons & Deals",
    "description": "Browse {{ $stores->total() }} stores with {{ $category->name }} coupons and deals",
    "url": "{{ route('categories.show', $category->slug) }}",
    "numberOfItems": {{ $stores->total() }},
    "mainEntity": {
        "@@type": "ItemList",
        "numberOfItems": {{ $stores->count() }},
        "itemListElement": [
            @foreach($stores->take(10) as $index => $store)
            {
                "@@type": "ListItem",
                "position": {{ $index + 1 }},
                "item": {
                    "@@type": "Store",
                    "name": "{{ $store->name }}",
                    "url": "{{ route('stores.show', $store->slug) }}"
                }
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
}
</script>
@endpush

@push('styles')
<style>
    .breadcrumb {
        font-size: 12px;
        color: var(--gray-4);
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
    }
    .breadcrumb a { color: var(--gray-4); }
    .breadcrumb a:hover { color: var(--green); }
    .subcategories-section { margin-bottom: 32px; }
    .subcategories-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-4);
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .subcategories-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .subcategory-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: var(--white);
        border: 1px solid var(--gray-2);
        border-radius: 100px;
        font-size: 13px;
        font-weight: 500;
        color: var(--dark);
        transition: all .15s;
    }
    .subcategory-chip:hover {
        border-color: var(--green);
        background: var(--green-light);
    }
    .subcategory-count {
        background: var(--gray-1);
        color: var(--gray-4);
        padding: 2px 8px;
        border-radius: 100px;
        font-size: 11px;
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
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-4);
    }
    @media (max-width: 767px) {
        .breadcrumb { font-size: 11px; margin-bottom: 16px; }
        .subcategories-section { margin-bottom: 24px; }
        .subcategories-title { font-size: 12px; margin-bottom: 10px; }
        .subcategories-list { gap: 8px; }
        .subcategory-chip { padding: 6px 12px; font-size: 12px; }
        .subcategory-count { font-size: 10px; padding: 2px 6px; }
        .pagination-wrap { gap: 4px; }
        .pagination-info { flex-direction: column; gap: 8px; }
        .page-link { padding: 6px 10px; font-size: 13px; }
        .empty-state { padding: 40px 16px; }
    }
    @media (max-width: 479px) {
        .subcategory-chip { padding: 5px 10px; font-size: 11px; }
        .page-link { padding: 5px 8px; font-size: 12px; }
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>›</span>
            @if($category->parent)
                <a href="{{ route('categories.show', $category->parent->slug) }}">{{ $category->parent->name }}</a>
                <span>›</span>
            @endif
            <span>{{ $category->name }}</span>
        </nav>

        <div class="section-header">
            <h1 class="section-title">{{ $category->name }} <span>Coupons</span></h1>
            <span class="text-muted text-sm">{{ $stores->total() }} stores</span>
        </div>

        {{-- Subcategories (if parent category) --}}
        @if($subcategories->count() > 0)
        <div class="subcategories-section">
            <h3 class="subcategories-title">Browse Subcategories</h3>
            <div class="subcategories-list">
                @foreach($subcategories as $sub)
                <a href="{{ route('categories.show', $sub->slug) }}" class="subcategory-chip">
                    {{ $sub->name }}
                    <span class="subcategory-count">{{ $sub->active_stores_count }}</span>
                </a>
                @endforeach
            </div>
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
                @if($store->is_featured)
                <span class="badge badge-green">Featured</span>
                @endif
            </a>
            @empty
            <div class="empty-state">No stores in this category yet.</div>
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
                    @foreach([12, 20, 40, 80] as $size)
                    <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" {{ ($perPage ?? 20) == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
                <span class="text-muted text-sm">per page</span>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
