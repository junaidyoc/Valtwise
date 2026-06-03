@extends('admin.layouts.app')
@section('title', 'Sale Events')
@section('page-title', 'Sale Calendar Events')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        {{-- Year Filter --}}
        <select onchange="applyFilter('year', this.value)" style="padding:8px 12px;background:#1e293b;border:1px solid #334155;border-radius:6px;color:#f1f5f9;font-size:13px">
            @foreach($years as $y)
            <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>

        {{-- Region Filter --}}
        <select onchange="applyFilter('region', this.value)" style="padding:8px 12px;background:#1e293b;border:1px solid #334155;border-radius:6px;color:#f1f5f9;font-size:13px">
            <option value="">All Regions</option>
            <option value="uk" {{ request('region') === 'uk' ? 'selected' : '' }}>UK</option>
            <option value="pk" {{ request('region') === 'pk' ? 'selected' : '' }}>Pakistan</option>
            <option value="global" {{ request('region') === 'global' ? 'selected' : '' }}>Global</option>
        </select>

        {{-- Status Filter --}}
        <select onchange="applyFilter('status', this.value)" style="padding:8px 12px;background:#1e293b;border:1px solid #334155;border-radius:6px;color:#f1f5f9;font-size:13px">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <a href="{{ route('admin.sale-events.create') }}" class="btn btn-green">+ Add Event</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Event</th>
                <th>Date</th>
                <th>Region</th>
                <th>Density</th>
                <th>Status</th>
                <th style="width:140px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:24px">{{ $event->emoji ?? '📅' }}</span>
                        <div>
                            <div style="font-weight:600;color:#f1f5f9">{{ $event->name }}</div>
                            @if($event->subtitle_tags)
                            <div style="font-size:11px;color:#64748b">{{ $event->subtitle_tags }}</div>
                            @endif
                        </div>
                        @if($event->is_featured)
                        <span class="badge badge-amber" style="font-size:10px">Featured</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div style="font-size:13px;color:#e2e8f0">{{ $event->date_range }}</div>
                    @if($event->isActive())
                    <span style="display:inline-flex;align-items:center;gap:4px;font-size:11px;color:#22c55e">
                        <span style="width:6px;height:6px;background:#22c55e;border-radius:50%;animation:pulse 1.5s infinite"></span>
                        Live Now
                    </span>
                    @elseif($event->isUpcoming())
                    <span style="font-size:11px;color:#64748b">In {{ $event->daysUntil() }} days</span>
                    @else
                    <span style="font-size:11px;color:#475569">Ended</span>
                    @endif
                </td>
                <td>
                    @if($event->region === 'uk')
                    <span style="font-size:12px">🇬🇧 UK</span>
                    @elseif($event->region === 'pk')
                    <span style="font-size:12px">🇵🇰 PK</span>
                    @else
                    <span style="font-size:12px">🌍 Global</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $event->density === 'peak' ? 'badge-green' : ($event->density === 'high' ? 'badge-amber' : 'badge-gray') }}">
                        {{ ucfirst($event->density) }}
                    </span>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.sale-events.toggle', $event) }}" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="badge {{ $event->is_active ? 'badge-green' : 'badge-gray' }}" style="cursor:pointer;border:none">
                            {{ $event->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <a href="{{ route('sale-calendar.show', $event->slug) }}" class="btn btn-gray btn-sm" target="_blank" title="View public page">👁</a>
                        <a href="{{ route('admin.sale-events.edit', $event) }}" class="btn btn-blue btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.sale-events.destroy', $event) }}"
                              onsubmit="return confirm('Delete {{ $event->name }}?')" style="margin:0">
                            @csrf @method('DELETE')
                            <button class="btn btn-red btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:40px;color:#64748b">
                    No sale events found. <a href="{{ route('admin.sale-events.create') }}" style="color:#10b981">Add one?</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($events->hasPages())
    <div style="padding:16px;border-top:1px solid #334155">
        {{ $events->withQueryString()->links('vendor.pagination.admin') }}
    </div>
    @endif
</div>

@push('scripts')
<script>
function applyFilter(key, value) {
    const url = new URL(window.location.href);
    if (value) {
        url.searchParams.set(key, value);
    } else {
        url.searchParams.delete(key);
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>
@endpush
@endsection
