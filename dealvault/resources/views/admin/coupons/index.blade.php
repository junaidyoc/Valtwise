@extends('admin.layouts.app')
@section('title', 'Coupons')
@section('page-title', '🏷️ Coupons')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
  <div style="font-size:13px;color:#64748b">{{ $coupons->total() }} total coupons</div>
  <a href="{{ route('admin.coupons.create') }}" class="btn btn-green">+ Add Coupon</a>
</div>

<div class="card" style="padding:0;overflow:hidden">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Coupon</th>
          <th>Store</th>
          <th>Type</th>
          <th>Code</th>
          <th>Discount</th>
          <th>Clicks</th>
          <th>Expires</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($coupons as $coupon)
        <tr>
          <td>
            <div style="font-weight:500;color:#f1f5f9;max-width:200px">
              {{ Str::limit($coupon->title, 35) }}
            </div>
            @if($coupon->is_verified)
            <span class="badge badge-green" style="margin-top:4px;font-size:10px">✓ Verified</span>
            @endif
            @if($coupon->is_exclusive)
            <span class="badge badge-amber" style="margin-top:4px;font-size:10px">Exclusive</span>
            @endif
          </td>
          <td><span class="badge badge-blue">{{ $coupon->store->name ?? '-' }}</span></td>
          <td><span class="badge badge-gray">{{ ucfirst($coupon->type) }}</span></td>
          <td>
            @if($coupon->code)
            <code style="background:#0f172a;padding:2px 6px;border-radius:4px;font-size:12px;color:#4ade80">
              {{ $coupon->code }}
            </code>
            @else
            <span style="color:#475569">—</span>
            @endif
          </td>
          <td>
            @if($coupon->discount_value)
            <span style="color:#fbbf24;font-weight:600">{{ $coupon->discount_value }}</span>
            @else
            <span style="color:#475569">—</span>
            @endif
          </td>
          <td><span class="badge badge-amber">{{ $coupon->click_count }}</span></td>
          <td>
            @if($coupon->expires_at)
              @if($coupon->isExpired())
              <span class="badge badge-red">Expired</span>
              @else
              <span style="font-size:12px;color:#94a3b8">{{ $coupon->expires_at->format('d M Y') }}</span>
              @endif
            @else
            <span style="color:#475569">No expiry</span>
            @endif
          </td>
          <td>
            @if($coupon->is_active)
            <span class="badge badge-green">Active</span>
            @else
            <span class="badge badge-red">Off</span>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:4px">
              <a href="{{ route('admin.coupons.edit', $coupon) }}"
                 class="btn btn-gray btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.coupons.toggle', $coupon) }}">
                @csrf @method('PATCH')
                <button class="btn btn-sm {{ $coupon->is_active ? 'btn-red' : 'btn-green' }}">
                  {{ $coupon->is_active ? 'Off' : 'On' }}
                </button>
              </form>
              <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}"
                    onsubmit="return confirm('Delete this coupon?')">
                @csrf @method('DELETE')
                <button class="btn btn-red btn-sm">Del</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" style="text-align:center;color:#475569;padding:40px">
            No coupons yet — <a href="{{ route('admin.coupons.create') }}" style="color:#4ade80">Add one!</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="pagination">{{ $coupons->links() }}</div>
@endsection
