@extends('admin.layouts.app')
@section('title', 'Stores')
@section('page-title', '🏪 Stores')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:12px">
  <div style="display:flex;align-items:center;gap:12px">
    <form method="GET" action="{{ route('admin.stores.index') }}" style="display:flex;gap:8px">
      <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search stores..."
             style="padding:8px 12px;border:1px solid #334155;border-radius:6px;background:#0f172a;color:#f1f5f9;font-size:13px;width:200px">
      <button type="submit" class="btn btn-blue btn-sm">Search</button>
      @if($search)
      <a href="{{ route('admin.stores.index') }}" class="btn btn-gray btn-sm">Clear</a>
      @endif
    </form>
    <span style="font-size:13px;color:#64748b">{{ $stores->total() }} stores</span>
  </div>
  <a href="{{ route('admin.stores.create') }}" class="btn btn-green">+ Add Store</a>
</div>

<div class="card" style="padding:0;overflow:hidden">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Store</th>
          <th>Network</th>
          <th>Cashback</th>
          <th>Coupons</th>
          <th>Clicks</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($stores as $store)
        <tr>
          <td>
            <div style="font-weight:500;color:#f1f5f9">{{ $store->name }}</div>
            <div style="font-size:11px;color:#475569">{{ $store->slug }}</div>
          </td>
          <td><span class="badge badge-blue">{{ $store->network ?? 'N/A' }}</span></td>
          <td>
            @if($store->cashback_rate > 0)
            <span class="badge badge-green">{{ $store->cashback_rate }}%</span>
            @else
            <span style="color:#475569">—</span>
            @endif
          </td>
          <td><span class="badge badge-gray">{{ $store->coupons_count }}</span></td>
          <td><span class="badge badge-amber">{{ $store->clicks_count }}</span></td>
          <td>
            @if($store->is_active)
            <span class="badge badge-green">Active</span>
            @else
            <span class="badge badge-red">Inactive</span>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px">
              <a href="{{ route('admin.stores.edit', $store) }}"
                 class="btn btn-gray btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.stores.toggle', $store) }}">
                @csrf @method('PATCH')
                <button class="btn btn-sm {{ $store->is_active ? 'btn-red' : 'btn-green' }}">
                  {{ $store->is_active ? 'Disable' : 'Enable' }}
                </button>
              </form>
              <form method="POST" action="{{ route('admin.stores.destroy', $store) }}"
                    onsubmit="return confirm('Delete {{ $store->name }}?')">
                @csrf @method('DELETE')
                <button class="btn btn-red btn-sm">Del</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center;color:#475569;padding:40px">
            No stores yet — <a href="{{ route('admin.stores.create') }}" style="color:#4ade80">Add one!</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-top:20px">
  <div style="display:flex;align-items:center;gap:8px">
    <span style="font-size:13px;color:#64748b">Show</span>
    <select onchange="window.location.href=this.value" style="padding:6px 10px;border:1px solid #334155;border-radius:6px;background:#0f172a;color:#f1f5f9;font-size:13px">
      @foreach([10, 15, 25, 50, 100] as $size)
      <option value="{{ request()->fullUrlWithQuery(['per_page' => $size]) }}" {{ ($perPage ?? 15) == $size ? 'selected' : '' }}>{{ $size }}</option>
      @endforeach
    </select>
    <span style="font-size:13px;color:#64748b">per page</span>
  </div>
  <div class="pagination">{{ $stores->links() }}</div>
</div>
@endsection
