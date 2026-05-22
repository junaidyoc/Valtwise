<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DealVault — Save More Every Day')</title>
    <meta name="description" content="@yield('meta_description', 'Find the best coupon codes, promo codes, and exclusive deals. Save big with verified discounts from top brands.')">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>
        /* ── Reset & Base ─────────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:      #16a34a;
            --green-light:#dcfce7;
            --green-dark: #14532d;
            --amber:      #f59e0b;
            --amber-light:#fef3c7;
            --dark:       #18181b;
            --dark-2:     #27272a;
            --gray-1:     #f4f4f5;
            --gray-2:     #e4e4e7;
            --gray-3:     #a1a1aa;
            --gray-4:     #71717a;
            --white:      #ffffff;
            --radius-sm:  6px;
            --radius-md:  10px;
            --radius-lg:  16px;
            --shadow-sm:  0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.05);
            --shadow-md:  0 4px 16px rgba(0,0,0,.08);
            --shadow-lg:  0 12px 40px rgba(0,0,0,.12);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #fafafa;
            color: var(--dark);
            line-height: 1.6;
            font-size: 15px;
        }

        h1,h2,h3,h4,h5 { font-family: 'Sora', sans-serif; line-height: 1.25; }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }

        /* ── Container ────────────────────────────────────────────────────── */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* ── Navbar ───────────────────────────────────────────────────────── */
        .navbar {
            background: var(--dark);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--dark-2);
        }
        .navbar-inner {
            display: flex;
            align-items: center;
            gap: 32px;
            height: 60px;
        }
        .logo {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 20px;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo-icon {
            background: var(--green);
            color: #fff;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        .nav-links {
            display: flex;
            gap: 4px;
            flex: 1;
        }
        .nav-links a {
            color: #a1a1aa;
            font-size: 14px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            transition: color .15s, background .15s;
        }
        .nav-links a:hover, .nav-links a.active {
            color: var(--white);
            background: rgba(255,255,255,.07);
        }
        .nav-search {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: var(--radius-md);
            padding: 0 12px;
            gap: 8px;
            height: 36px;
            width: 220px;
            transition: border-color .2s;
        }
        .nav-search:focus-within { border-color: var(--green); }
        .nav-search input {
            background: none;
            border: none;
            outline: none;
            color: var(--white);
            font-size: 13px;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
        }
        .nav-search input::placeholder { color: var(--gray-3); }
        .nav-search svg { color: var(--gray-3); flex-shrink: 0; }

        /* ── Buttons ──────────────────────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: var(--radius-md);
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            border: none;
            transition: all .15s;
            font-family: 'DM Sans', sans-serif;
            white-space: nowrap;
        }
        .btn-green {
            background: var(--green);
            color: #fff;
        }
        .btn-green:hover { background: #15803d; transform: translateY(-1px); }

        .btn-outline {
            background: transparent;
            color: var(--green);
            border: 1.5px solid var(--green);
        }
        .btn-outline:hover { background: var(--green-light); }

        .btn-dark {
            background: var(--dark);
            color: #fff;
        }
        .btn-dark:hover { background: var(--dark-2); }

        /* ── Badges ───────────────────────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .03em;
            text-transform: uppercase;
        }
        .badge-green  { background: var(--green-light); color: #15803d; }
        .badge-amber  { background: var(--amber-light); color: #b45309; }
        .badge-gray   { background: var(--gray-1); color: var(--gray-4); }
        .badge-dark   { background: var(--dark); color: #fff; }

        /* ── Section ──────────────────────────────────────────────────────── */
        .section { padding: 60px 0; }
        .section-sm { padding: 40px 0; }
        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 16px;
        }
        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
        }
        .section-title span { color: var(--green); }
        .view-all {
            font-size: 13px;
            font-weight: 500;
            color: var(--green);
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }
        .view-all:hover { text-decoration: underline; }

        /* ── Store Card ───────────────────────────────────────────────────── */
        .store-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }
        .store-card {
            background: var(--white);
            border: 1px solid var(--gray-2);
            border-radius: var(--radius-lg);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            text-align: center;
            transition: box-shadow .2s, transform .2s, border-color .2s;
        }
        .store-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
            border-color: var(--green);
        }
        .store-logo-wrap {
            width: 72px;
            height: 72px;
            border-radius: var(--radius-md);
            border: 1px solid var(--gray-2);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafafa;
        }
        .store-logo-wrap img { width: 100%; height: 100%; object-fit: contain; padding: 6px; }
        .store-name { font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 600; }
        .store-meta { font-size: 12px; color: var(--gray-4); }
        .cashback-pill {
            background: var(--green-light);
            color: #15803d;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 100px;
        }

        /* ── Coupon Card ──────────────────────────────────────────────────── */
        .coupon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }
        .coupon-card {
            background: var(--white);
            border: 1px solid var(--gray-2);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow .2s, transform .2s;
        }
        .coupon-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .coupon-card-body { padding: 16px 18px; flex: 1; }
        .coupon-store-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }
        .coupon-store-logo {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid var(--gray-2);
            object-fit: contain;
            padding: 2px;
            background: #fafafa;
        }
        .coupon-store-name { font-size: 12px; font-weight: 600; color: var(--gray-4); }
        .coupon-title { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 600; margin-bottom: 6px; }
        .coupon-desc { font-size: 13px; color: var(--gray-4); margin-bottom: 10px; }
        .coupon-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 10px; }
        .coupon-expiry { font-size: 11px; color: var(--gray-3); margin-top: auto; }
        .coupon-card-footer {
            padding: 12px 18px;
            border-top: 1px solid var(--gray-1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* code reveal box */
        .code-reveal {
            flex: 1;
            border: 1.5px dashed var(--green);
            border-radius: var(--radius-sm);
            padding: 7px 12px;
            font-family: monospace;
            font-size: 14px;
            font-weight: 700;
            color: var(--green);
            background: var(--green-light);
            text-align: center;
            letter-spacing: .08em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: background .2s;
        }
        .code-reveal:hover { background: #bbf7d0; }
        .code-reveal .blur-overlay {
            position: absolute;
            inset: 0;
            backdrop-filter: blur(4px);
            background: rgba(220,252,231,.85);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: #15803d;
            letter-spacing: 0;
            font-family: 'DM Sans', sans-serif;
            transition: opacity .2s;
        }
        .code-reveal.revealed .blur-overlay { opacity: 0; pointer-events: none; }

        /* ── Category Cards ───────────────────────────────────────────────── */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 12px;
        }
        .category-card {
            background: var(--white);
            border: 1px solid var(--gray-2);
            border-radius: var(--radius-md);
            padding: 16px 12px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
        }
        .category-card:hover {
            border-color: var(--green);
            background: var(--green-light);
            transform: translateY(-2px);
        }
        .category-icon {
            font-size: 28px;
            margin-bottom: 8px;
            display: block;
        }
        .category-name { font-size: 13px; font-weight: 600; margin-bottom: 2px; }
        .category-count { font-size: 11px; color: var(--gray-4); }

        /* ── Hero Banner ──────────────────────────────────────────────────── */
        .hero {
            background: var(--dark);
            padding: 64px 0 56px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(22,163,74,.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-content { position: relative; max-width: 620px; }
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(22,163,74,.15);
            border: 1px solid rgba(22,163,74,.3);
            color: #4ade80;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 100px;
            margin-bottom: 20px;
            letter-spacing: .04em;
        }
        .hero h1 {
            font-size: clamp(28px, 5vw, 44px);
            font-weight: 700;
            color: var(--white);
            margin-bottom: 16px;
            line-height: 1.2;
        }
        .hero h1 span { color: #4ade80; }
        .hero p { color: #a1a1aa; font-size: 16px; margin-bottom: 32px; }
        .hero-search {
            display: flex;
            background: var(--white);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            max-width: 480px;
        }
        .hero-search input {
            flex: 1;
            border: none;
            outline: none;
            padding: 14px 18px;
            font-size: 15px;
            font-family: 'DM Sans', sans-serif;
        }
        .hero-search button {
            background: var(--green);
            color: #fff;
            border: none;
            padding: 0 24px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            font-family: 'Sora', sans-serif;
            transition: background .15s;
        }
        .hero-search button:hover { background: #15803d; }

        /* ── Divider ──────────────────────────────────────────────────────── */
        .divider { height: 1px; background: var(--gray-2); margin: 0; }

        /* ── Footer ───────────────────────────────────────────────────────── */
        footer {
            background: var(--dark);
            color: #a1a1aa;
            padding: 48px 0 24px;
            margin-top: 80px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-brand p { font-size: 13px; line-height: 1.7; margin-top: 10px; }
        .footer-col h4 {
            font-family: 'Sora', sans-serif;
            color: var(--white);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 14px;
        }
        .footer-col a {
            display: block;
            font-size: 13px;
            color: #71717a;
            margin-bottom: 8px;
            transition: color .15s;
        }
        .footer-col a:hover { color: var(--white); }
        .footer-bottom {
            border-top: 1px solid var(--dark-2);
            padding-top: 20px;
            font-size: 12px;
            color: #52525b;
            display: flex;
            justify-content: space-between;
        }

        /* ── Utilities ────────────────────────────────────────────────────── */
        .text-green { color: var(--green); }
        .text-muted { color: var(--gray-4); }
        .text-sm { font-size: 13px; }
        .fw-600 { font-weight: 600; }
        .mt-8 { margin-top: 8px; }
        .mt-16 { margin-top: 16px; }

        /* ── Responsive ───────────────────────────────────────────────────── */
        @media (max-width: 768px) {
            .nav-links, .nav-search { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .store-grid  { grid-template-columns: repeat(2, 1fr); }
            .coupon-grid { grid-template-columns: 1fr; }
            .section { padding: 40px 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── Navbar ──────────────────────────────────────────────────────────── --}}
<nav class="navbar">
    <div class="container navbar-inner">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon">✦</div>
            DealVault
        </a>
        <div class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('stores.index') }}" class="{{ request()->routeIs('stores.*') ? 'active' : '' }}">All Stores</a>
            <a href="{{ route('categories.show', 'apparel-clothing') }}">Fashion</a>
            <a href="{{ route('categories.show', 'electronics') }}">Electronics</a>
            <a href="{{ route('categories.show', 'travel') }}">Travel</a>
        </div>
        <form action="{{ route('stores.index') }}" method="GET" class="nav-search" style="margin-left:auto">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" name="search" placeholder="Search stores…" value="{{ request('search') }}">
        </form>
    </div>
</nav>

{{-- ── Main Content ─────────────────────────────────────────────────────── --}}
<main>
    @yield('content')
</main>

{{-- ── Footer ───────────────────────────────────────────────────────────── --}}
<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="logo">
                    <div class="logo-icon">✦</div>
                    DealVault
                </a>
                <p>Find verified coupon codes and exclusive deals from top brands. Save money every time you shop online.</p>
            </div>
            <div class="footer-col">
                <h4>Browse</h4>
                <a href="{{ route('stores.index') }}">All Stores</a>
                <a href="{{ route('categories.show', 'electronics') }}">Electronics</a>
                <a href="{{ route('categories.show', 'apparel-clothing') }}">Fashion</a>
                <a href="{{ route('categories.show', 'travel') }}">Travel</a>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <a href="#">About Us</a>
                <a href="#">Blog</a>
                <a href="#">Contact</a>
                <a href="#">Advertise</a>
            </div>
            <div class="footer-col">
                <h4>Legal</h4>
                <a href="#">Terms of Use</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Cookie Policy</a>
                <a href="#">FAQ</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} DealVault. All rights reserved.</span>
            <span>Affiliate disclosure: We earn commissions from qualifying purchases.</span>
        </div>
    </div>
</footer>

{{-- ── Code Reveal JS ───────────────────────────────────────────────────── --}}
<script>
document.querySelectorAll('.code-reveal').forEach(el => {
    el.addEventListener('click', function () {
        this.classList.add('revealed');
        // Copy to clipboard
        const code = this.dataset.code;
        if (code && navigator.clipboard) {
            navigator.clipboard.writeText(code).then(() => {
                const overlay = this.querySelector('.blur-overlay');
                if (overlay) overlay.textContent = 'Copied!';
            });
        }
    });
});
</script>
@stack('scripts')
</body>
</html>
