@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', '📊 Dashboard')

@section('content')

{{-- Stats Grid --}}
<div class="stats-grid">
  <div class="stat-card green">
    <div class="stat-icon">🏪</div>
    <div class="stat-label">Total Stores</div>
    <div class="stat-value">{{ $totalStores }}</div>
    <div class="stat-sub">{{ $activeStores }} active</div>
  </div>
  <div class="stat-card blue">
    <div class="stat-icon">🏷️</div>
    <div class="stat-label">Total Coupons</div>
    <div class="stat-value">{{ $totalCoupons }}</div>
    <div class="stat-sub">{{ $activeCoupons }} active</div>
  </div>
  <div class="stat-card amber">
    <div class="stat-icon">👆</div>
    <div class="stat-label">Today Clicks</div>
    <div class="stat-value">{{ $todayClicks }}</div>
    <div class="stat-sub">{{ $weekClicks }} this week</div>
  </div>
  <div class="stat-card purple">
    <div class="stat-icon">📅</div>
    <div class="stat-label">Month Clicks</div>
    <div class="stat-value">{{ $monthClicks }}</div>
    <div class="stat-sub">{{ $totalClicks }} all time</div>
  </div>
  <div class="stat-card teal">
    <div class="stat-icon">📁</div>
    <div class="stat-label">Categories</div>
    <div class="stat-value">{{ $totalCategories }}</div>
    <div class="stat-sub">Active</div>
  </div>
  <div class="stat-card pink">
    <div class="stat-icon">💰</div>
    <div class="stat-label">Est. Earnings</div>
    <div class="stat-value">${{ number_format($monthClicks * 0.05, 0) }}</div>
    <div class="stat-sub">~$0.05 per click avg</div>
  </div>
</div>

{{-- Charts Row --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px">

  {{-- Clicks Chart --}}
  <div class="card">
    <div class="card-title">📈 Clicks — Last 14 Days</div>
    @php
      $maxClicks = $clicksChart->max('count') ?: 1;
    @endphp
    <div class="chart-bar-wrap">
      @forelse($clicksChart as $day)
      <div style="flex:1;display:flex;flex-direction:column;align-items:center">
        <div class="chart-bar"
             style="width:100%;height:{{ max(4, ($day->count / $maxClicks) * 80) }}px"
             title="{{ $day->date }}: {{ $day->count }} clicks">
        </div>
        <div class="chart-label">{{ \Carbon\Carbon::parse($day->date)->format('d/m') }}</div>
      </div>
      @empty
      <div style="color:#475569;font-size:13px;padding:20px">No clicks yet — share your site!</div>
      @endforelse
    </div>
  </div>

  {{-- Top Stores --}}
  <div class="card">
    <div class="card-title">🏆 Top Stores</div>
    @forelse($topStores as $store)
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #334155">
      <div style="font-size:13px;color:#cbd5e1">{{ Str::limit($store->name, 18) }}</div>
      <span class="badge badge-green">{{ $store->clicks_count }}</span>
    </div>
    @empty
    <div style="color:#475569;font-size:13px">No data yet</div>
    @endforelse
  </div>
</div>

{{-- Bottom Row --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

  {{-- Top Coupons --}}
  <div class="card">
    <div class="card-title">🔥 Top Coupons by Clicks</div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Coupon</th>
            <th>Store</th>
            <th>Clicks</th>
          </tr>
        </thead>
        <tbody>
          @forelse($topCoupons as $coupon)
          <tr>
            <td>{{ Str::limit($coupon->title, 25) }}</td>
            <td><span class="badge badge-blue">{{ $coupon->store->name ?? '-' }}</span></td>
            <td><span class="badge badge-green">{{ $coupon->click_count }}</span></td>
          </tr>
          @empty
          <tr><td colspan="3" style="color:#475569">No coupons yet</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Expiring Soon --}}
  <div class="card">
    <div class="card-title">⏰ Expiring Soon</div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Coupon</th>
            <th>Expires</th>
          </tr>
        </thead>
        <tbody>
          @forelse($expiringSoon as $coupon)
          <tr>
            <td>{{ Str::limit($coupon->title, 25) }}</td>
            <td>
              <span class="badge badge-amber">
                {{ $coupon->expires_at->diffForHumans() }}
              </span>
            </td>
          </tr>
          @empty
          <tr><td colspan="2" style="color:#475569">No coupons expiring soon</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Recent Clicks --}}
<div class="card" style="margin-top:16px">
  <div class="card-title">🕐 Recent Clicks</div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Time</th>
          <th>Coupon</th>
          <th>Store</th>
          <th>IP</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentClicks as $click)
        <tr>
          <td style="color:#64748b">{{ $click->created_at->diffForHumans() }}</td>
          <td>{{ Str::limit($click->coupon->title ?? 'N/A', 30) }}</td>
          <td><span class="badge badge-blue">{{ $click->store->name ?? '-' }}</span></td>
          <td style="color:#475569;font-size:12px">{{ $click->ip_address }}</td>
        </tr>
        @empty
        <tr><td colspan="4" style="color:#475569">No clicks yet</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Quick Actions --}}
<div style="display:flex;gap:10px;margin-top:16px;flex-wrap:wrap">
  <a href="{{ route('admin.stores.create') }}" class="btn btn-green">+ Add Store</a>
  <a href="{{ route('admin.coupons.create') }}" class="btn btn-green">+ Add Coupon</a>
  <a href="{{ route('admin.categories.index') }}" class="btn btn-gray">Manage Categories</a>
  <a href="{{ route('home') }}" target="_blank" class="btn btn-gray">🌐 View Site</a>
</div>

@endsection
