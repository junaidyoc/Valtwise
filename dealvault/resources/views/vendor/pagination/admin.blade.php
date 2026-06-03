@if ($paginator->hasPages())
<nav class="admin-pagination">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="page-btn disabled">&larr; Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">&larr; Prev</a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="page-btn disabled">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="page-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">Next &rarr;</a>
    @else
        <span class="page-btn disabled">Next &rarr;</span>
    @endif
</nav>

<style>
.admin-pagination {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 16px;
    flex-wrap: wrap;
}
.admin-pagination .page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 12px;
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 6px;
    color: #94a3b8;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s ease;
}
.admin-pagination .page-btn:hover:not(.disabled):not(.active) {
    background: #334155;
    color: #f1f5f9;
    border-color: #475569;
}
.admin-pagination .page-btn.active {
    background: #16a34a;
    border-color: #16a34a;
    color: #fff;
    font-weight: 600;
}
.admin-pagination .page-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}
</style>
@endif
