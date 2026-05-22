@extends('layouts.app')

@section('title', 'About Us — Valtwise')
@section('meta_description', 'Learn about Valtwise — our mission to help shoppers save money on fashion, perfume, shoes, furniture and more with verified coupon codes and deals.')

@section('content')

@push('styles')
<style>
.page-hero{background:var(--dark);padding:56px 0 48px;border-bottom:1px solid var(--dark-2)}
.page-hero h1{color:var(--white);font-size:36px;font-weight:700;margin-bottom:12px}
.page-hero p{color:#a1a1aa;font-size:16px;max-width:560px;line-height:1.7}
.about-section{padding:60px 0}
.about-grid{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
.about-text h2{font-size:26px;font-weight:700;color:var(--dark);margin-bottom:16px}
.about-text p{font-size:14px;color:#52525b;line-height:1.8;margin-bottom:12px}
.stat-row{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin:48px 0}
.stat-box{background:var(--dark);border-radius:var(--radius-lg);padding:24px;text-align:center}
.stat-num{font-size:36px;font-weight:700;color:var(--green);font-family:'Sora',sans-serif}
.stat-lbl{font-size:13px;color:#a1a1aa;margin-top:4px}
.value-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-top:16px}
.value-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px}
.value-icon{font-size:28px;margin-bottom:10px}
.value-title{font-size:14px;font-weight:600;color:var(--dark);margin-bottom:6px}
.value-desc{font-size:13px;color:#71717a;line-height:1.6}
.team-note{background:var(--green-light);border:1px solid #86efac;border-radius:var(--radius-lg);padding:24px;margin-top:40px}
.team-note p{font-size:14px;color:#15803d;line-height:1.7;margin:0}
</style>
@endpush

<div class="page-hero">
  <div class="container">
    <div style="font-size:12px;color:#52525b;margin-bottom:14px">
      <a href="{{ route('home') }}" style="color:#52525b">Home</a>
      <span style="margin:0 6px">›</span>
      <span style="color:#a1a1aa">About Us</span>
    </div>
    <h1>About Valtwise</h1>
    <p>We believe everyone deserves to shop smarter. Valtwise was built to make saving money simple, transparent, and effortless.</p>
  </div>
</div>

{{-- Mission --}}
<div class="about-section" style="background:#fafafa">
  <div class="container">
    <div class="about-grid">
      <div class="about-text">
        <h2>Our Mission</h2>
        <p>Valtwise was founded with a single goal: to help everyday shoppers discover the best deals on the things they actually buy — fashion, shoes, perfume, furniture, and much more.</p>
        <p>We spend hours every day finding, verifying, and updating coupon codes and deals from hundreds of top brands. So you don't have to. Whether you're looking for a discount on the latest trends or a cashback offer on home furniture, Valtwise has you covered.</p>
        <p>Our platform is completely <strong>free for shoppers</strong>. No hidden charges, no subscriptions, no nonsense.</p>
      </div>
      <div style="background:var(--dark);border-radius:20px;padding:32px">
        <div style="font-size:13px;color:#4ade80;font-weight:600;margin-bottom:12px;letter-spacing:.06em;text-transform:uppercase">What We Do</div>
        @foreach([
          ['🔍', 'Find', 'We discover deals from 500+ stores daily'],
          ['✅', 'Verify', 'Our team tests every coupon code before listing'],
          ['🔄', 'Update', 'Expired codes are removed — only fresh deals shown'],
          ['💸', 'Save', 'You save money on every purchase'],
        ] as [$icon, $title, $desc])
        <div style="display:flex;gap:12px;margin-bottom:16px">
          <div style="width:36px;height:36px;background:rgba(22,163,74,.15);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">{{ $icon }}</div>
          <div>
            <div style="font-size:13px;font-weight:600;color:#f1f5f9">{{ $title }}</div>
            <div style="font-size:12px;color:#71717a;margin-top:2px">{{ $desc }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="stat-row">
      <div class="stat-box">
        <div class="stat-num">500+</div>
        <div class="stat-lbl">Partner Stores</div>
      </div>
      <div class="stat-box">
        <div class="stat-num">Daily</div>
        <div class="stat-lbl">New Deals Added</div>
      </div>
      <div class="stat-box">
        <div class="stat-num">Free</div>
        <div class="stat-lbl">Always Free for Shoppers</div>
      </div>
    </div>
  </div>
</div>

{{-- Values --}}
<div class="about-section">
  <div class="container">
    <h2 style="font-size:26px;font-weight:700;color:var(--dark);margin-bottom:8px;text-align:center">What We Stand For</h2>
    <p style="text-align:center;color:#71717a;font-size:14px;margin-bottom:0">Our values guide everything we do at Valtwise.</p>

    <div class="value-grid">
      <div class="value-card">
        <div class="value-icon">🎯</div>
        <div class="value-title">Honesty</div>
        <div class="value-desc">We only list deals that actually work. We clearly mark verified codes and never fake discounts to drive clicks.</div>
      </div>
      <div class="value-card">
        <div class="value-icon">⚡</div>
        <div class="value-title">Speed</div>
        <div class="value-desc">New deals are added daily. We move fast so you never miss a limited-time offer or flash sale.</div>
      </div>
      <div class="value-card">
        <div class="value-icon">🔒</div>
        <div class="value-title">Privacy</div>
        <div class="value-desc">We do not sell your data. Your shopping habits and personal information stay private.</div>
      </div>
      <div class="value-card">
        <div class="value-icon">💚</div>
        <div class="value-title">Value</div>
        <div class="value-desc">Every deal we feature is chosen because it genuinely helps shoppers save money — not because it earns us more.</div>
      </div>
    </div>

    <div class="team-note">
      <p>💬 <strong>A note from our team:</strong> Valtwise started as a small project to help people shop smarter. We are a passionate team of developers and deal hunters who believe saving money should not require hours of searching. Thank you for being part of our community — every visit and every click helps us grow and improve the platform for you.</p>
    </div>
  </div>
</div>

@endsection
