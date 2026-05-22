<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin') — Valtwise</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0f172a;color:#e2e8f0;display:flex;min-height:100vh}

/* Sidebar */
.sidebar{width:240px;background:#1e293b;border-right:1px solid #334155;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:100}
.sidebar-logo{padding:20px;border-bottom:1px solid #334155}
.sidebar-logo a{display:flex;align-items:center;gap:10px;text-decoration:none}
.logo-icon{width:32px;height:32px;background:#16a34a;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px}
.logo-text{font-size:16px;font-weight:700;color:#f1f5f9}
.logo-badge{font-size:10px;background:#334155;color:#94a3b8;padding:2px 6px;border-radius:4px;margin-left:4px}
.sidebar-nav{flex:1;padding:12px 0;overflow-y:auto}
.nav-section{padding:8px 16px 4px;font-size:10px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:#475569}
.nav-item{display:flex;align-items:center;gap:10px;padding:9px 16px;color:#94a3b8;text-decoration:none;font-size:13px;font-weight:500;transition:all .15s;border-left:3px solid transparent}
.nav-item:hover{background:#334155;color:#f1f5f9}
.nav-item.active{background:#166534;color:#4ade80;border-left-color:#16a34a}
.nav-item .icon{font-size:16px;width:20px;text-align:center}
.sidebar-footer{padding:16px;border-top:1px solid #334155}
.sidebar-footer a{display:flex;align-items:center;gap:8px;color:#ef4444;font-size:13px;text-decoration:none;padding:8px 12px;border-radius:6px;transition:background .15s}
.sidebar-footer a:hover{background:#450a0a}

/* Main */
.main{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh}
.topbar{background:#1e293b;border-bottom:1px solid #334155;padding:0 24px;height:56px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
.topbar-title{font-size:15px;font-weight:600;color:#f1f5f9}
.topbar-right{display:flex;align-items:center;gap:12px}
.status-dot{width:8px;height:8px;border-radius:50%;background:#4ade80;box-shadow:0 0 6px #16a34a}
.status-text{font-size:12px;color:#64748b}
.content{padding:24px;flex:1}

/* Cards */
.card{background:#1e293b;border:1px solid #334155;border-radius:12px;padding:20px;margin-bottom:16px}
.card-title{font-size:13px;font-weight:600;color:#f1f5f9;margin-bottom:16px;display:flex;align-items:center;gap:8px}

/* Stats Grid */
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-bottom:24px}
.stat-card{background:#1e293b;border:1px solid #334155;border-radius:12px;padding:16px 20px;position:relative;overflow:hidden}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px}
.stat-card.green::before{background:#16a34a}
.stat-card.blue::before{background:#3b82f6}
.stat-card.amber::before{background:#f59e0b}
.stat-card.purple::before{background:#8b5cf6}
.stat-card.pink::before{background:#ec4899}
.stat-card.teal::before{background:#14b8a6}
.stat-label{font-size:11px;color:#64748b;font-weight:500;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px}
.stat-value{font-size:28px;font-weight:700;color:#f1f5f9;line-height:1}
.stat-sub{font-size:11px;color:#475569;margin-top:6px}
.stat-icon{position:absolute;top:16px;right:16px;font-size:24px;opacity:.2}

/* Table */
.table-wrap{overflow-x:auto}
table{width:100%;border-collapse:collapse;font-size:13px}
thead tr{border-bottom:1px solid #334155}
thead th{padding:10px 12px;text-align:left;font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.06em}
tbody tr{border-bottom:1px solid #1e293b;transition:background .1s}
tbody tr:hover{background:#1e293b}
tbody td{padding:12px;color:#cbd5e1}

/* Badges */
.badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:100px;font-size:11px;font-weight:600}
.badge-green{background:#14532d;color:#4ade80}
.badge-red{background:#450a0a;color:#f87171}
.badge-amber{background:#451a03;color:#fbbf24}
.badge-blue{background:#1e3a5f;color:#60a5fa}
.badge-gray{background:#1e293b;color:#64748b;border:1px solid #334155}

/* Buttons */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:all .15s;font-family:inherit}
.btn-green{background:#16a34a;color:#fff}
.btn-green:hover{background:#15803d}
.btn-red{background:#dc2626;color:#fff}
.btn-red:hover{background:#b91c1c}
.btn-gray{background:#334155;color:#e2e8f0;border:1px solid #475569}
.btn-gray:hover{background:#475569}
.btn-sm{padding:5px 10px;font-size:12px}

/* Forms */
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.form-group{margin-bottom:16px}
.form-group.full{grid-column:1/-1}
label{display:block;font-size:12px;font-weight:500;color:#94a3b8;margin-bottom:6px}
input,select,textarea{width:100%;padding:9px 12px;background:#0f172a;border:1px solid #334155;border-radius:8px;color:#f1f5f9;font-size:13px;font-family:inherit;transition:border-color .15s;outline:none}
input:focus,select:focus,textarea:focus{border-color:#16a34a}
input[type=checkbox]{width:auto;margin-right:6px}
select option{background:#1e293b}

/* Alert */
.alert{padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;display:flex;align-items:center;gap:8px}
.alert-success{background:#14532d;border:1px solid #166534;color:#4ade80}
.alert-error{background:#450a0a;border:1px solid #7f1d1d;color:#f87171}

/* Chart */
.chart-bar-wrap{display:flex;align-items:flex-end;gap:4px;height:80px;padding-top:8px}
.chart-bar{flex:1;background:#16a34a;border-radius:3px 3px 0 0;min-height:4px;transition:height .3s;position:relative}
.chart-bar:hover{background:#4ade80}
.chart-label{font-size:9px;color:#475569;text-align:center;margin-top:4px}

/* Pagination */
.pagination{display:flex;gap:4px;margin-top:16px}
.pagination a,.pagination span{padding:6px 10px;border-radius:6px;font-size:12px;text-decoration:none;color:#94a3b8;border:1px solid #334155}
.pagination .active span{background:#16a34a;color:#fff;border-color:#16a34a}

@media(max-width:768px){
  .sidebar{transform:translateX(-100%)}
  .main{margin-left:0}
  .form-grid{grid-template-columns:1fr}
  .stats-grid{grid-template-columns:repeat(2,1fr)}
}
</style>
@stack('styles')
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <a href="{{ route('admin.dashboard') }}">
      <div class="logo-icon">✦</div>
      <span class="logo-text">Valtwise</span>
      <span class="logo-badge">Admin</span>
    </a>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section">Main</div>
    <a href="{{ route('admin.dashboard') }}"
       class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <span class="icon">📊</span> Dashboard
    </a>

    <div class="nav-section">Content</div>
    <a href="{{ route('admin.stores.index') }}"
       class="nav-item {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
      <span class="icon">🏪</span> Stores
    </a>
    <a href="{{ route('admin.coupons.index') }}"
       class="nav-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
      <span class="icon">🏷️</span> Coupons
    </a>
    <a href="{{ route('admin.categories.index') }}"
       class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
      <span class="icon">📁</span> Categories
    </a>

    <div class="nav-section">Links</div>
    <a href="{{ route('home') }}" target="_blank" class="nav-item">
      <span class="icon">🌐</span> View Site
    </a>
  </nav>
  <div class="sidebar-footer">
    <a href="{{ route('admin.logout') }}">
      <span>🚪</span> Logout
    </a>
  </div>
</aside>

<!-- Main Content -->
<div class="main">
  <div class="topbar">
    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    <div class="topbar-right">
      <div class="status-dot"></div>
      <span class="status-text">Site Live</span>
    </div>
  </div>

  <div class="content">
    @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    @yield('content')
  </div>
</div>

@stack('scripts')
</body>
</html>
