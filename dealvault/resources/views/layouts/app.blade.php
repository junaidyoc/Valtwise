<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO: Robots directive --}}
    @if(config('app.env') === 'production')
    <meta name="robots" content="@yield('robots', $seoSettings['default_robots'] ?? 'index, follow')">
    @else
    <meta name="robots" content="noindex, nofollow">
    @endif

    {{-- Google Search Console Verification --}}
    @if(!empty($seoSettings['google_search_console_verification']))
    <meta name="google-site-verification" content="{{ $seoSettings['google_search_console_verification'] }}">
    @endif

    {{-- Primary Meta Tags --}}
    <title>@yield('title', ($seoSettings['site_name'] ?? 'Valtwise') . ' — Best Coupon Codes & Deals for UK & Pakistan')</title>
    <meta name="description" content="@yield('meta_description', 'Find verified coupon codes, promo codes, and exclusive deals for UK & Pakistan. Save money on top brands with ' . ($seoSettings['site_name'] ?? 'Valtwise') . '.')">
    <meta name="keywords" content="@yield('meta_keywords', 'coupon codes, promo codes, discount codes, deals, vouchers, UK deals, Pakistan deals, online shopping')">

    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Hreflang for Multi-Region --}}
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', ($seoSettings['site_name'] ?? 'Valtwise') . ' — Best Coupon Codes & Deals')">
    <meta property="og:description" content="@yield('og_description', 'Find verified coupon codes and exclusive deals for UK & Pakistan. Save money on top brands.')">
    <meta property="og:image" content="@yield('og_image', $seoSettings['default_og_image'] ?? asset('images/og-default.jpg'))">
    <meta property="og:site_name" content="{{ $seoSettings['site_name'] ?? 'Valtwise' }}">
    <meta property="og:locale" content="en_GB">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    @if(!empty($seoSettings['twitter_handle']))
    <meta name="twitter:site" content="{{ $seoSettings['twitter_handle'] }}">
    @endif
    <meta name="twitter:title" content="@yield('twitter_title', $__env->yieldContent('og_title', ($seoSettings['site_name'] ?? 'Valtwise') . ' — Best Coupon Codes & Deals'))">
    <meta name="twitter:description" content="@yield('twitter_description', $__env->yieldContent('og_description', 'Find verified coupon codes and exclusive deals for UK & Pakistan.'))">
    <meta name="twitter:image" content="@yield('twitter_image', $__env->yieldContent('og_image', $seoSettings['default_og_image'] ?? asset('images/og-default.jpg')))">

    {{-- Pagination SEO --}}
    @stack('pagination_meta')

    {{-- Favicon --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Admitad Verification --}}
    <meta name="verify-admitad" content="e560ada907" />
    
    {{-- Organization Schema (Global) --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "{{ $seoSettings['site_name'] ?? 'Valtwise' }}",
        "url": "{{ config('app.url') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "description": "Find verified coupon codes and exclusive deals for UK & Pakistan",
        "areaServed": [
            {"@@type": "Country", "name": "United Kingdom"},
            {"@@type": "Country", "name": "Pakistan"}
        ],
        "sameAs": []
    }
    </script>
    @stack('schema')

    {{-- Google Fonts with preconnect for faster loading --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    {{-- External CSS for better caching (loads non-blocking) --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ asset('css/app.css') }}"></noscript>

    {{-- Critical inline CSS for faster First Contentful Paint --}}
    <style>
        /* ── Reset & Base (CRITICAL) ─────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green:#16a34a;--green-light:#dcfce7;--green-dark:#14532d;
            --amber:#f59e0b;--amber-light:#fef3c7;
            --dark:#18181b;--dark-2:#27272a;
            --gray-1:#f4f4f5;--gray-2:#e4e4e7;--gray-3:#a1a1aa;--gray-4:#71717a;
            --white:#fff;--radius-sm:6px;--radius-md:10px;--radius-lg:16px;
            --shadow-sm:0 1px 3px rgba(0,0,0,.07),0 1px 2px rgba(0,0,0,.05);
            --shadow-md:0 4px 16px rgba(0,0,0,.08);--shadow-lg:0 12px 40px rgba(0,0,0,.12);
        }
        html{scroll-behavior:smooth}
        body{font-family:'DM Sans',sans-serif;background:#fafafa;color:var(--dark);line-height:1.6;font-size:15px}
        h1,h2,h3,h4,h5{font-family:'Sora',sans-serif;line-height:1.25}
        a{color:inherit;text-decoration:none}
        img{display:block;max-width:100%}
        .container{max-width:1200px;margin:0 auto;padding:0 20px}

        /* ── Navbar (CRITICAL - Above fold) ──────────────────────────────── */
        .navbar{background:var(--dark);position:sticky;top:0;z-index:100;border-bottom:1px solid var(--dark-2)}
        .navbar-inner{display:flex;align-items:center;gap:24px;height:60px}
        .logo{font-family:'Sora',sans-serif;font-weight:700;font-size:20px;color:var(--white);display:flex;align-items:center;gap:8px}
        .logo-icon{background:var(--green);color:#fff;width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px}
        .nav-links{display:flex;gap:4px;flex:1;align-items:center;min-width:0;overflow:visible}
        .nav-links-primary{display:flex;gap:4px;align-items:center;flex-shrink:1;min-width:0;overflow:visible}
        .nav-links>a,.nav-links-primary>a,.nav-dropdown>.nav-dropdown-trigger{color:#a1a1aa;font-size:14px;font-weight:500;padding:6px 12px;border-radius:var(--radius-sm);transition:color .15s,background .15s;cursor:pointer;display:flex;align-items:center;gap:4px;white-space:nowrap;flex-shrink:0}
        .nav-links>a:hover,.nav-links>a.active,.nav-links-primary>a:hover,.nav-links-primary>a.active,.nav-dropdown:hover>.nav-dropdown-trigger{color:var(--white);background:rgba(255,255,255,.07)}
        .nav-dropdown{position:relative}
        .nav-dropdown-trigger svg{width:12px;height:12px;transition:transform .2s}
        .nav-dropdown:hover .nav-dropdown-trigger svg{transform:rotate(180deg)}
        .nav-dropdown-menu{position:absolute;top:100%;left:0;min-width:220px;background:var(--dark-2);border:1px solid #3f3f46;border-radius:var(--radius-md);padding:8px 0;opacity:0;visibility:hidden;transform:translateY(10px);transition:all .2s;box-shadow:0 10px 40px rgba(0,0,0,.3);z-index:1000}
        .nav-dropdown:hover .nav-dropdown-menu{opacity:1;visibility:visible;transform:translateY(4px)}
        .nav-dropdown-menu a{display:flex;align-items:center;gap:10px;padding:10px 16px;color:#a1a1aa;font-size:13px;transition:all .15s}
        .nav-dropdown-menu a:hover{background:rgba(255,255,255,.05);color:var(--white)}
        .nav-dropdown-menu a .icon{font-size:16px;width:20px;text-align:center}
        .nav-dropdown-menu .divider{height:1px;background:#3f3f46;margin:8px 0}
        .nav-dropdown-menu .menu-header{padding:6px 16px;font-size:10px;font-weight:600;color:#71717a;text-transform:uppercase;letter-spacing:.05em}
        .nav-search{display:flex;align-items:center;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1);border-radius:var(--radius-md);padding:0 12px;gap:8px;height:36px;width:180px;flex-shrink:0;margin-left:auto;transition:border-color .2s,width .2s}
        .nav-search:focus-within{border-color:var(--green);width:200px}
        .nav-search input{background:none;border:none;outline:none;color:var(--white);font-size:13px;width:100%;font-family:'DM Sans',sans-serif}
        .nav-search input::placeholder{color:var(--gray-3)}
        .nav-search svg{color:var(--gray-3);flex-shrink:0}
        .nav-more-dropdown{position:relative;display:none}
        .nav-more-dropdown.has-items{display:block}
        .nav-more-trigger{color:#a1a1aa;font-size:14px;font-weight:500;padding:6px 12px;border-radius:var(--radius-sm);transition:color .15s,background .15s;cursor:pointer;display:flex;align-items:center;gap:4px;white-space:nowrap;background:none;border:none;font-family:inherit}
        .nav-more-trigger:hover,.nav-more-dropdown:hover .nav-more-trigger{color:var(--white);background:rgba(255,255,255,.07)}
        .nav-more-trigger svg{width:12px;height:12px;transition:transform .2s}
        .nav-more-dropdown:hover .nav-more-trigger svg{transform:rotate(180deg)}
        .nav-more-menu{position:absolute;top:100%;left:0;min-width:200px;background:var(--dark-2);border:1px solid #3f3f46;border-radius:var(--radius-md);padding:8px 0;opacity:0;visibility:hidden;transform:translateY(10px);transition:all .2s;box-shadow:0 10px 40px rgba(0,0,0,.3);z-index:1000;overflow:visible}
        .nav-more-dropdown:hover .nav-more-menu{opacity:1;visibility:visible;transform:translateY(4px)}
        .nav-more-menu .nav-dropdown{display:block;width:100%;position:relative}
        .nav-more-menu .nav-dropdown .nav-dropdown-trigger{padding:10px 16px;border-radius:0;width:100%;justify-content:space-between}
        .nav-more-menu .nav-dropdown .nav-dropdown-menu{position:absolute;left:100%;top:0;margin-left:0;min-width:220px;opacity:0;visibility:hidden;transform:translateY(0) translateX(10px);z-index:1001}
        .nav-more-menu .nav-dropdown:hover>.nav-dropdown-menu{opacity:1;visibility:visible;transform:translateY(0) translateX(0)}
        .nav-more-menu .nav-dropdown:hover .nav-dropdown-trigger{background:rgba(255,255,255,.05)}

        /* ── Buttons & Badges (CRITICAL) ─────────────────────────────────── */
        .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:var(--radius-md);font-weight:500;font-size:14px;cursor:pointer;border:none;transition:all .15s;font-family:'DM Sans',sans-serif;white-space:nowrap}
        .btn-green{background:var(--green);color:#fff}
        .btn-green:hover{background:#15803d;transform:translateY(-1px)}
        .btn-outline{background:transparent;color:var(--green);border:1.5px solid var(--green)}
        .btn-outline:hover{background:var(--green-light)}
        .btn-dark{background:var(--dark);color:#fff}
        .btn-dark:hover{background:var(--dark-2)}
        .badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:100px;font-size:11px;font-weight:600;letter-spacing:.03em;text-transform:uppercase}
        .badge-green{background:var(--green-light);color:#15803d}
        .badge-amber{background:var(--amber-light);color:#b45309}
        .badge-gray{background:var(--gray-1);color:var(--gray-4)}
        .badge-dark{background:var(--dark);color:#fff}

        /* ── Hero (CRITICAL - Above fold) ────────────────────────────────── */
        .hero{background:var(--dark);padding:64px 0 56px;position:relative;overflow:hidden}
        .hero::before{content:'';position:absolute;top:-80px;right:-80px;width:400px;height:400px;background:radial-gradient(circle,rgba(22,163,74,.15) 0%,transparent 70%);pointer-events:none}
        .hero-content{position:relative;max-width:620px}
        .hero-eyebrow{display:inline-flex;align-items:center;gap:6px;background:rgba(22,163,74,.15);border:1px solid rgba(22,163,74,.3);color:#4ade80;font-size:12px;font-weight:600;padding:4px 12px;border-radius:100px;margin-bottom:20px;letter-spacing:.04em}
        .hero h1{font-size:clamp(28px,5vw,44px);font-weight:700;color:var(--white);margin-bottom:16px;line-height:1.2}
        .hero h1 span{color:#4ade80}
        .hero p{color:#a1a1aa;font-size:16px;margin-bottom:32px}
        .hero-search{display:flex;background:var(--white);border-radius:var(--radius-md);overflow:hidden;box-shadow:var(--shadow-lg);max-width:480px}
        .hero-search input{flex:1;border:none;outline:none;padding:14px 18px;font-size:15px;font-family:'DM Sans',sans-serif}
        .hero-search button{background:var(--green);color:#fff;border:none;padding:0 24px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Sora',sans-serif;transition:background .15s}
        .hero-search button:hover{background:#15803d}

        /* ── Mobile Menu Button (CRITICAL) ───────────────────────────────── */
        .mobile-menu-btn{display:none;background:none;border:none;padding:8px;cursor:pointer;color:var(--gray-3);transition:color .2s}
        .mobile-menu-btn:hover{color:var(--white)}
        .mobile-menu-btn svg{width:24px;height:24px}

        /* ── Essential Responsive (CRITICAL) ─────────────────────────────── */
        @media(max-width:767px){
            .navbar-inner{gap:12px}
            .nav-links-primary,.nav-more-dropdown{display:none!important}
            .nav-links{flex:0;gap:0}
            .nav-links>a{display:none}
            .nav-search{width:auto;min-width:120px;flex:1;max-width:200px}
            .mobile-menu-btn{display:flex}
            .hero{padding:40px 0 32px}
            .hero h1{font-size:28px}
            .hero p{font-size:14px;margin-bottom:24px}
            .hero-search{flex-direction:column;border-radius:var(--radius-md)}
            .hero-search input{padding:14px 16px;border-bottom:1px solid var(--gray-2)}
            .hero-search button{padding:14px;border-radius:0 0 var(--radius-md) var(--radius-md)}
        }
        @media(max-width:599px){
            .container{padding:0 12px}
            .navbar-inner{height:56px;gap:8px}
            .logo{font-size:18px}
            .logo-icon{width:26px;height:26px;font-size:12px}
            .nav-search{height:34px;min-width:100px}
            .nav-search input{font-size:12px}
            .hero{padding:32px 0 24px}
            .hero-eyebrow{font-size:11px;padding:3px 10px}
            .hero h1{font-size:24px;margin-bottom:12px}
            .hero p{font-size:13px;margin-bottom:20px}
        }

        /* ── Mobile Menu (CRITICAL - Must be hidden by default) ──────────── */
        .mobile-menu-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:998;opacity:0;visibility:hidden;pointer-events:none}
        .mobile-menu-overlay.active{opacity:1;visibility:visible;pointer-events:auto}
        .mobile-menu{position:fixed;top:0;right:0;width:280px;max-width:85vw;height:100%;background:var(--dark);z-index:999;transform:translateX(100%);overflow-y:auto;visibility:hidden}
        .mobile-menu.active{transform:translateX(0);visibility:visible}
        .mobile-menu-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--dark-2)}
        .mobile-menu-close{background:none;border:none;color:var(--gray-3);padding:8px;cursor:pointer}
        .mobile-menu-body{padding:16px 0}
        .mobile-menu-item{display:block;padding:12px 20px;color:#a1a1aa;font-size:15px;font-weight:500}
        .mobile-menu-divider{height:1px;background:var(--dark-2);margin:12px 0}
        .mobile-menu-section{padding:8px 20px;font-size:11px;font-weight:600;color:var(--gray-4);text-transform:uppercase;letter-spacing:.05em}

        /* ── Cookie Consent (CRITICAL - Must be hidden by default) ───────── */
        .cookie-consent{position:fixed;bottom:0;left:0;right:0;background:var(--dark);border-top:1px solid var(--dark-2);padding:20px;z-index:9999;transform:translateY(100%)}
        .cookie-consent.show{transform:translateY(0)}
        .cookie-consent-inner{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap}
        .cookie-consent-text{flex:1;min-width:280px}
        .cookie-consent-text p{color:#e4e4e7;font-size:14px;margin:0;line-height:1.6}
        .cookie-consent-text a{color:var(--green);text-decoration:underline}
        .cookie-consent-buttons{display:flex;gap:12px;flex-shrink:0}
        .cookie-btn{padding:10px 24px;border-radius:var(--radius-md);font-size:14px;font-weight:600;cursor:pointer;border:none;font-family:'DM Sans',sans-serif}
        .cookie-btn-accept{background:var(--green);color:#fff}
        .cookie-btn-reject{background:transparent;color:#a1a1aa;border:1px solid var(--dark-2)}

        /* ── Section & Content (CRITICAL) ────────────────────────────────── */
        .section{padding:60px 0}
        .section-sm{padding:40px 0}
        .section-header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:28px;gap:16px}
        .section-title{font-size:22px;font-weight:700;color:var(--dark)}
        .section-title span{color:var(--green)}
        .view-all{font-size:13px;font-weight:500;color:var(--green);display:flex;align-items:center;gap:4px;white-space:nowrap}

        /* ── Store Grid (CRITICAL) ───────────────────────────────────────── */
        .store-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px}
        .store-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px;display:flex;flex-direction:column;align-items:center;gap:12px;text-align:center;transition:box-shadow .2s,transform .2s,border-color .2s}
        .store-logo-wrap{width:72px;height:72px;border-radius:var(--radius-md);border:1px solid var(--gray-2);overflow:hidden;display:flex;align-items:center;justify-content:center;background:#fafafa}
        .store-logo-wrap img{width:100%;height:100%;object-fit:contain;padding:6px}
        .store-name{font-family:'Sora',sans-serif;font-size:14px;font-weight:600}
        .store-meta{font-size:12px;color:var(--gray-4)}

        /* ── Category Grid (CRITICAL) ────────────────────────────────────── */
        .category-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:12px}
        .category-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-md);padding:16px 12px;text-align:center;cursor:pointer;transition:all .2s}
        .category-icon{font-size:28px;margin-bottom:8px;display:block}
        .category-name{font-size:13px;font-weight:600;margin-bottom:2px}
        .category-count{font-size:11px;color:var(--gray-4)}

        /* ── Footer (CRITICAL) ───────────────────────────────────────────── */
        footer{background:var(--dark);color:#a1a1aa;padding:48px 0 24px;margin-top:80px}
        .footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px;margin-bottom:40px}
        .footer-brand p{font-size:13px;line-height:1.7;margin-top:10px}
        .footer-col h4{font-family:'Sora',sans-serif;color:var(--white);font-size:13px;font-weight:600;margin-bottom:14px}
        .footer-col a{display:block;font-size:13px;color:#71717a;margin-bottom:8px}
        .footer-bottom{border-top:1px solid var(--dark-2);padding-top:20px;font-size:12px;color:#52525b;display:flex;justify-content:space-between}

        /* ── Utilities (CRITICAL) ────────────────────────────────────────── */
        .text-green{color:var(--green)}
        .text-muted{color:var(--gray-4)}
        .text-sm{font-size:13px}
        .fw-600{font-weight:600}
        .divider{height:1px;background:var(--gray-2);margin:0}

        /* ── More Responsive (CRITICAL) ──────────────────────────────────── */
        @media(max-width:767px){
            .section{padding:32px 0}
            .section-header{flex-direction:column;align-items:flex-start;gap:8px;margin-bottom:20px}
            .section-title{font-size:20px}
            .store-grid{grid-template-columns:repeat(2,1fr);gap:12px}
            .store-card{padding:16px}
            .store-logo-wrap{width:56px;height:56px}
            .store-name{font-size:13px}
            .category-grid{grid-template-columns:repeat(3,1fr);gap:8px}
            .category-card{padding:12px 8px}
            .category-icon{font-size:24px}
            .category-name{font-size:12px}
            .footer-grid{grid-template-columns:1fr 1fr;gap:24px}
            .footer-brand{grid-column:1/-1}
            footer{padding:32px 0 20px;margin-top:40px}
            .footer-bottom{flex-direction:column;gap:8px;text-align:center}
            .cookie-consent-inner{flex-direction:column;text-align:center}
            .cookie-consent-buttons{width:100%;justify-content:center}
        }
        @media(max-width:599px){
            .section{padding:24px 0}
            .section-title{font-size:18px}
            .store-grid{grid-template-columns:repeat(2,1fr);gap:10px}
            .store-card{padding:12px;gap:8px}
            .store-logo-wrap{width:48px;height:48px}
            .store-name{font-size:12px}
            .store-meta{font-size:11px}
            .category-grid{grid-template-columns:repeat(2,1fr);gap:8px}
            .footer-grid{grid-template-columns:1fr;gap:20px}
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
            Valtwise
        </a>
        <div class="nav-links" id="navLinks">
            <a href="{{ route('stores.index') }}" class="{{ request()->routeIs('stores.*') ? 'active' : '' }}">All Stores</a>
            <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>

            {{-- Primary Nav Items Container --}}
            <div class="nav-links-primary" id="navPrimary">
                {{-- Dynamic Category Dropdowns --}}
                @isset($navCategories)
                @foreach($navCategories as $navCat)
                <div class="nav-dropdown" data-nav-item>
                    <span class="nav-dropdown-trigger">
                        {{ $navCat->name }}
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </span>
                    <div class="nav-dropdown-menu">
                        <a href="{{ route('categories.show', $navCat->slug) }}">
                            <span class="icon">{{ $navCat->icon ?? '🏷️' }}</span>
                            All {{ $navCat->name }}
                        </a>
                        @if($navCat->children->count() > 0)
                        <div class="divider"></div>
                        <div class="menu-header">Subcategories</div>
                        @foreach($navCat->children as $subCat)
                        <a href="{{ route('categories.show', $subCat->slug) }}">
                            <span class="icon">{{ $subCat->icon ?? '📁' }}</span>
                            {{ $subCat->name }}
                        </a>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endforeach
                @endisset
            </div>

            {{-- More Dropdown (Priority+ Pattern) --}}
            <div class="nav-more-dropdown" id="navMore">
                <button type="button" class="nav-more-trigger">
                    More
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>
                <div class="nav-more-menu" id="navMoreMenu">
                    {{-- Overflow items will be moved here via JS --}}
                </div>
            </div>
        </div>
        <form action="{{ route('stores.index') }}" method="GET" class="nav-search">
            <input type="text" name="search" placeholder="Search stores…" value="{{ request('search') }}">
            <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
            </button>
        </form>
        {{-- Mobile Menu Button --}}
        <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 12h18M3 6h18M3 18h18"/>
            </svg>
        </button>
    </div>
</nav>

{{-- Mobile Menu Overlay --}}
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

{{-- Mobile Menu Panel --}}
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon">✦</div>
            Valtwise
        </a>
        <button type="button" class="mobile-menu-close" id="mobileMenuClose" aria-label="Close menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <div class="mobile-menu-body">
        <a href="{{ route('stores.index') }}" class="mobile-menu-item">All Stores</a>
        <div class="mobile-menu-divider"></div>
        <div class="mobile-menu-section">Categories</div>
        @isset($navCategories)
        @foreach($navCategories as $navCat)
        <a href="{{ route('categories.show', $navCat->slug) }}" class="mobile-menu-item">
            {{ $navCat->icon ?? '🏷️' }} {{ $navCat->name }}
        </a>
        @endforeach
        @endisset
        <div class="mobile-menu-divider"></div>
        <div class="mobile-menu-section">Quick Links</div>
        <a href="{{ route('blog.index') }}" class="mobile-menu-item">📝 Blog</a>
        <a href="{{ route('sale-calendar') }}" class="mobile-menu-item">📅 Sale Calendar</a>
        <a href="{{ route('about') }}" class="mobile-menu-item">ℹ️ About Us</a>
        <a href="{{ route('contact') }}" class="mobile-menu-item">📧 Contact</a>
        <a href="{{ route('faq') }}" class="mobile-menu-item">❓ FAQ</a>
    </div>
</div>

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
                    Valtwise
                </a>
                <p>Find verified coupon codes and exclusive deals from top brands. Save money every time you shop online.</p>
            </div>
            <div class="footer-col">
                <h4>Browse</h4>
                <a href="{{ route('stores.index') }}">All Stores</a>
                <a href="{{ route('sale-calendar') }}">Sale Calendar</a>
                <a href="{{ route('categories.show', 'electronics') }}">Electronics</a>
                <a href="{{ route('categories.show', 'apparel-clothing') }}">Fashion</a>
                <a href="{{ route('categories.show', 'travel') }}">Travel</a>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('contact') }}">Contact Us</a>
                <a href="{{ route('blog.index') }}">Blog</a>
            </div>
            <div class="footer-col">
                <h4>Legal</h4>
                <a href="{{ route('terms') }}">Terms & Conditions</a>
                <a href="{{ route('privacy') }}">Privacy Policy</a>
                <a href="{{ route('faq') }}">FAQ</a>
                <a href="{{ route('how-to-use') }}">How to Use</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} Valtwise. All rights reserved.</span>
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

{{-- ── Priority+ Navigation JS ─────────────────────────────────────────── --}}
<script>
(function() {
    const navPrimary = document.getElementById('navPrimary');
    const navMore = document.getElementById('navMore');
    const navMoreMenu = document.getElementById('navMoreMenu');
    const navLinks = document.getElementById('navLinks');

    if (!navPrimary || !navMore || !navMoreMenu) return;

    // Store original items and their order
    const originalItems = Array.from(navPrimary.querySelectorAll('[data-nav-item]'));

    function getAvailableWidth() {
        const navLinksRect = navLinks.getBoundingClientRect();
        const searchBox = document.querySelector('.nav-search');
        const searchWidth = searchBox ? searchBox.offsetWidth + 32 : 220;
        const moreWidth = 80; // Fixed estimate for "More" button
        const allStoresLink = navLinks.querySelector(':scope > a');
        const allStoresWidth = allStoresLink ? allStoresLink.offsetWidth + 8 : 0;

        return navLinksRect.width - searchWidth - moreWidth - allStoresWidth - 20;
    }

    function updateNavigation() {
        // First, restore all items to visible state
        originalItems.forEach(item => {
            item.style.display = '';
            item.style.visibility = '';
        });
        navMore.classList.remove('has-items');
        navMoreMenu.innerHTML = '';

        // Force reflow to get accurate measurements
        void navPrimary.offsetWidth;

        // Calculate available width
        const availableWidth = getAvailableWidth();
        let currentWidth = 0;
        let overflowStartIndex = -1;

        // Measure each item and find where overflow starts
        for (let i = 0; i < originalItems.length; i++) {
            const item = originalItems[i];
            const itemWidth = item.offsetWidth + 4;

            if (currentWidth + itemWidth > availableWidth && overflowStartIndex === -1) {
                overflowStartIndex = i;
            }
            currentWidth += itemWidth;
        }

        // If we have overflow, hide items and add to More menu
        if (overflowStartIndex !== -1 && overflowStartIndex < originalItems.length) {
            for (let i = overflowStartIndex; i < originalItems.length; i++) {
                const item = originalItems[i];

                // Hide the original item
                item.style.display = 'none';

                // Clone for More menu
                const clone = item.cloneNode(true);
                clone.style.display = '';
                navMoreMenu.appendChild(clone);
            }
            navMore.classList.add('has-items');
        }
    }

    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    const debouncedUpdate = debounce(updateNavigation, 150);

    // Initial update after DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(updateNavigation, 50);
        });
    } else {
        setTimeout(updateNavigation, 50);
    }

    // Update on window load (ensures fonts are loaded)
    window.addEventListener('load', function() {
        setTimeout(updateNavigation, 100);
    });

    // Update on resize
    window.addEventListener('resize', debouncedUpdate);
})();
</script>

{{-- ── Mobile Menu JS ──────────────────────────────────────────────────── --}}
<script>
(function() {
    const menuBtn = document.getElementById('mobileMenuBtn');
    const menuClose = document.getElementById('mobileMenuClose');
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileMenuOverlay');

    if (!menuBtn || !menu || !overlay) return;

    function openMenu() {
        menu.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        menu.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    menuBtn.addEventListener('click', openMenu);
    if (menuClose) menuClose.addEventListener('click', closeMenu);
    overlay.addEventListener('click', closeMenu);

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && menu.classList.contains('active')) {
            closeMenu();
        }
    });

    // Close menu on window resize to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 767 && menu.classList.contains('active')) {
            closeMenu();
        }
    });
})();
</script>
@stack('scripts')

{{-- ── Cookie Consent Banner ───────────────────────────────────────────── --}}
<div id="cookieConsent" class="cookie-consent">
    <div class="cookie-consent-inner">
        <div class="cookie-consent-text">
            <p>
                We use cookies to enhance your browsing experience and analyse site traffic.
                By clicking "Accept All", you consent to our use of cookies.
                <a href="{{ route('privacy') }}">Learn more</a>
            </p>
        </div>
        <div class="cookie-consent-buttons">
            <button type="button" class="cookie-btn cookie-btn-reject" id="cookieReject">
                Reject All
            </button>
            <button type="button" class="cookie-btn cookie-btn-accept" id="cookieAccept">
                Accept All
            </button>
        </div>
    </div>
</div>

{{-- ── Cookie Consent & Analytics JS ───────────────────────────────────── --}}
<script>
(function() {
    const CONSENT_KEY = 'valtwise_cookie_consent';
    const consentBanner = document.getElementById('cookieConsent');
    const acceptBtn = document.getElementById('cookieAccept');
    const rejectBtn = document.getElementById('cookieReject');

    // Check existing consent
    function getConsent() {
        return localStorage.getItem(CONSENT_KEY);
    }

    // Set consent
    function setConsent(value) {
        localStorage.setItem(CONSENT_KEY, value);
        hideBanner();
        if (value === 'accepted') {
            loadAnalytics();
        }
    }

    // Show banner
    function showBanner() {
        setTimeout(function() {
            consentBanner.classList.add('show');
        }, 500);
    }

    // Hide banner
    function hideBanner() {
        consentBanner.classList.remove('show');
    }

    // Load Google Analytics
    function loadAnalytics() {
        // Only load if not already loaded
        if (window.gaLoaded) return;
        window.gaLoaded = true;

        // Google Analytics 4 - ID from admin SEO settings
        const GA_ID = '{{ $seoSettings['google_analytics_id'] ?? '' }}';

        // Skip if no GA ID configured
        if (!GA_ID) return;

        // Load gtag.js
        const script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=' + GA_ID;
        document.head.appendChild(script);

        // Initialize gtag
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        window.gtag = gtag;
        gtag('js', new Date());
        gtag('config', GA_ID, { 'anonymize_ip': true });
    }

    // Event listeners
    acceptBtn.addEventListener('click', function() {
        setConsent('accepted');
    });

    rejectBtn.addEventListener('click', function() {
        setConsent('rejected');
    });

    // Initialize
    const consent = getConsent();
    if (!consent) {
        showBanner();
    } else if (consent === 'accepted') {
        loadAnalytics();
    }
})();
</script>

{{-- ── Service Worker Registration ─────────────────────────────────────── --}}
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('SW registered:', registration.scope);
            })
            .catch(function(error) {
                console.log('SW registration failed:', error);
            });
    });
}
</script>
</body>
</html>
