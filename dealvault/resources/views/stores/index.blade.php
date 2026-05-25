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

        {{-- A-Z Alphabetical Filter --}}
        <div class="alpha-filter" style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:28px;">
            <a href="{{ route('stores.index', request()->except('letter', 'page')) }}"
               class="alpha-letter {{ !request('letter') ? 'active' : '' }}"
               style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:var(--radius-md);font-size:13px;font-weight:600;text-decoration:none;transition:all .15s ease;{{ !request('letter') ? 'background:var(--green);color:#fff;' : 'background:var(--gray-1);color:var(--gray-5);' }}">
                All
            </a>
            @foreach(range('A', 'Z') as $letter)
                @php $hasStores = in_array($letter, $availableLetters ?? []); @endphp
                <a href="{{ $hasStores ? route('stores.index', array_merge(request()->except('page'), ['letter' => $letter])) : '#' }}"
                   class="alpha-letter {{ request('letter') === $letter ? 'active' : '' }} {{ !$hasStores ? 'disabled' : '' }}"
                   style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:var(--radius-md);font-size:13px;font-weight:600;text-decoration:none;transition:all .15s ease;{{ request('letter') === $letter ? 'background:var(--green);color:#fff;' : ($hasStores ? 'background:var(--gray-1);color:var(--gray-5);' : 'background:var(--gray-1);color:var(--gray-3);cursor:not-allowed;opacity:0.5;') }}"
                   {{ !$hasStores ? 'onclick=return false;' : '' }}>
                    {{ $letter }}
                </a>
            @endforeach
            @php $hasNumbers = collect($availableLetters ?? [])->contains(fn($l) => is_numeric($l)); @endphp
            <a href="{{ $hasNumbers ? route('stores.index', array_merge(request()->except('page'), ['letter' => '#'])) : '#' }}"
               class="alpha-letter {{ request('letter') === '#' ? 'active' : '' }} {{ !$hasNumbers ? 'disabled' : '' }}"
               style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:var(--radius-md);font-size:13px;font-weight:600;text-decoration:none;transition:all .15s ease;{{ request('letter') === '#' ? 'background:var(--green);color:#fff;' : ($hasNumbers ? 'background:var(--gray-1);color:var(--gray-5);' : 'background:var(--gray-1);color:var(--gray-3);cursor:not-allowed;opacity:0.5;') }}"
               {{ !$hasNumbers ? 'onclick=return false;' : '' }}>
                #
            </a>
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
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" loading="lazy"
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
