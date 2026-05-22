<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — Valtwise</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0f172a;color:#e2e8f0;min-height:100vh;display:flex;align-items:center;justify-content:center}
.login-card{background:#1e293b;border:1px solid #334155;border-radius:16px;padding:36px;width:100%;max-width:380px}
.logo{display:flex;align-items:center;gap:10px;justify-content:center;margin-bottom:28px}
.logo-icon{width:40px;height:40px;background:#16a34a;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px}
.logo-text{font-size:20px;font-weight:700;color:#f1f5f9}
h2{font-size:18px;font-weight:600;color:#f1f5f9;margin-bottom:4px;text-align:center}
p{font-size:13px;color:#64748b;text-align:center;margin-bottom:24px}
label{display:block;font-size:12px;font-weight:500;color:#94a3b8;margin-bottom:6px}
input{width:100%;padding:10px 14px;background:#0f172a;border:1px solid #334155;border-radius:8px;color:#f1f5f9;font-size:14px;font-family:inherit;outline:none;margin-bottom:16px;transition:border-color .15s}
input:focus{border-color:#16a34a}
button{width:100%;padding:11px;background:#16a34a;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;transition:background .15s}
button:hover{background:#15803d}
.error{background:#450a0a;border:1px solid #7f1d1d;color:#f87171;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px}
.hint{font-size:11px;color:#475569;text-align:center;margin-top:16px}
</style>
</head>
<body>
<div class="login-card">
  <div class="logo">
    <div class="logo-icon">✦</div>
    <span class="logo-text">Valtwise</span>
  </div>
  <h2>Admin Login</h2>
  <p>Enter password to access dashboard</p>

  @if($errors->any())
  <div class="error">❌ {{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('admin.login.post') }}">
    @csrf
    <label>Password</label>
    <input type="password" name="password" placeholder="Enter admin password" autofocus required>
    <button type="submit">Login →</button>
  </form>
  <div class="hint">Default: valtwise@admin123 — change in Railway Variables (ADMIN_PASSWORD)</div>
</div>
</body>
</html>
