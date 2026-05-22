@extends('admin.layouts.app')
@section('title', 'Stores')
@section('page-title', '🏪 Stores')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
  <div style="font-size:13px;color:#64748b">{{ $stores->total() }} total stores</div>
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

<div class="pagination">{{ $stores->links() }}</div>
@endsection
