@extends('layouts.app')

@section('title', 'How to Use Coupon Codes — Valtwise')
@section('meta_description', 'Learn how to use coupon codes and deals on Valtwise. Simple step-by-step guide to saving money on your online shopping.')

@section('content')

@push('styles')
<style>
.page-hero{background:var(--dark);padding:48px 0 40px;border-bottom:1px solid var(--dark-2)}
.page-hero h1{color:var(--white);font-size:32px;font-weight:700;margin-bottom:8px}
.page-hero p{color:#a1a1aa;font-size:15px}
.htu-wrap{padding:56px 0 80px}
.step-list{max-width:720px;margin:0 auto 60px}
.step{display:flex;gap:20px;margin-bottom:32px;align-items:flex-start}
.step-num{width:48px;height:48px;background:var(--green);border-radius:12px;display:flex;align-items:center;justify-content:center;font-family:'Sora',sans-serif;font-size:20px;font-weight:700;color:#fff;flex-shrink:0}
.step-body h3{font-size:17px;font-weight:700;color:var(--dark);margin-bottom:6px}
.step-body p{font-size:14px;color:#52525b;line-height:1.7}
.step-connector{width:2px;height:24px;background:var(--green-light);margin:0 23px -8px}
.tip-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;max-width:720px;margin:0 auto 60px}
.tip-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px}
.tip-icon{font-size:28px;margin-bottom:10px}
.tip-title{font-size:14px;font-weight:600;color:var(--dark);margin-bottom:6px}
.tip-text{font-size:13px;color:#71717a;line-height:1.6}
.type-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;max-width:720px;margin:0 auto}
.type-card{border-radius:var(--radius-lg);padding:20px;text-align:center}
.type-card.code{background:#dbeafe;border:1px solid #bfdbfe}
.type-card.deal{background:var(--green-light);border:1px solid #86efac}
.type-card.sale{background:var(--amber-light);border:1px solid #fcd34d}
.type-icon{font-size:32px;margin-bottom:10px}
.type-name{font-size:15px;font-weight:700;margin-bottom:6px}
.type-desc{font-size:12px;line-height:1.6}
.type-card.code .type-name{color:#1d4ed8}
.type-card.code .type-desc{color:#3b82f6}
.type-card.deal .type-name{color:#15803d}
.type-card.deal .type-desc{color:#16a34a}
.type-card.sale .type-name{color:#b45309}
.type-card.sale .type-desc{color:#f59e0b}
.section-head{text-align:center;margin-bottom:32px}
.section-head h2{font-size:24px;font-weight:700;color:var(--dark);margin-bottom:8px}
.section-head p{font-size:14px;color:#71717a}
</style>
@endpush

<div class="page-hero">
  <div class="container">
    <div style="font-size:12px;color:#52525b;margin-bottom:14px">
      <a href="{{ route('home') }}" style="color:#52525b">Home</a>
      <span style="margin:0 6px">›</span>
      <span style="color:#a1a1aa">How to Use Coupons</span>
    </div>
    <h1>How to Use Coupon Codes</h1>
    <p>Start saving in 3 simple steps. No account needed.</p>
  </div>
</div>

<div class="htu-wrap">
  <div class="container">

    {{-- Types of deals --}}
    <div class="section-head">
      <h2>Types of Deals on Valtwise</h2>
      <p>We have three types of savings for you</p>
    </div>

    <div class="type-grid">
      <div class="type-card code">
        <div class="type-icon">🏷️</div>
        <div class="type-name">Coupon Code</div>
        <div class="type-desc">A text code like "SAVE20" that you enter at checkout to get a discount</div>
      </div>
      <div class="type-card deal">
        <div class="type-icon">⚡</div>
        <div class="type-name">Deal / Offer</div>
        <div class="type-desc">No code needed — discount applies automatically when you click "Get Deal"</div>
      </div>
      <div class="type-card sale">
        <div class="type-icon">🔥</div>
        <div class="type-name">Sale</div>
        <div class="type-desc">A store-wide or category-wide discount during a special event or season</div>
      </div>
    </div>

    <div style="height:56px"></div>

    {{-- Steps --}}
    <div class="section-head">
      <h2>Step-by-Step Guide</h2>
      <p>Using a coupon on Valtwise takes less than 60 seconds</p>
    </div>

    <div class="step-list">

      <div class="step">
        <div class="step-num">1</div>
        <div class="step-body">
          <h3>Find Your Store or Deal</h3>
          <p>Use the search bar to look up a store by name, or browse by category — Fashion, Shoes, Perfume, Furniture, and more. You can also check the homepage for today's featured deals.</p>
        </div>
      </div>
      <div class="step-connector"></div>

      <div class="step">
        <div class="step-num">2</div>
        <div class="step-body">
          <h3>Click "Reveal Code" or "Get Deal"</h3>
          <p>For coupon codes — click the <strong>Reveal Code</strong> button. The code will be copied to your clipboard automatically. For deals — simply click the <strong>Get Deal</strong> button to be taken directly to the offer.</p>
        </div>
      </div>
      <div class="step-connector"></div>

      <div class="step">
        <div class="step-num">3</div>
        <div class="step-body">
          <h3>Shop on the Merchant's Website</h3>
          <p>You will be redirected to the merchant's website. Add your items to the cart and proceed to checkout. Paste your coupon code in the "Promo Code" or "Discount Code" field and click Apply.</p>
        </div>
      </div>
      <div class="step-connector"></div>

      <div class="step">
        <div class="step-num">4</div>
        <div class="step-body">
          <h3>Save Money & Enjoy!</h3>
          <p>Your discount should be applied automatically. Complete your purchase and enjoy your savings. That's it — no account needed on Valtwise!</p>
        </div>
      </div>

    </div>

    {{-- Tips --}}
    <div class="section-head">
      <h2>Pro Tips for Saving More</h2>
      <p>Get the most out of every coupon</p>
    </div>

    <div class="tip-grid">
      <div class="tip-card">
        <div class="tip-icon">🔍</div>
        <div class="tip-title">Check expiry dates</div>
        <div class="tip-text">Every coupon shows an expiry date. Always use codes before they expire for guaranteed savings.</div>
      </div>
      <div class="tip-card">
        <div class="tip-icon">✅</div>
        <div class="tip-title">Look for "Verified" badges</div>
        <div class="tip-text">Verified coupons are tested by our team. Start with these for the highest success rate.</div>
      </div>
      <div class="tip-card">
        <div class="tip-icon">💰</div>
        <div class="tip-title">Stack deals with cashback</div>
        <div class="tip-text">Many stores let you use a coupon code AND earn cashback at the same time. Double savings!</div>
      </div>
      <div class="tip-card">
        <div class="tip-icon">📱</div>
        <div class="tip-title">Try multiple codes</div>
        <div class="tip-text">If one code doesn't work, try the next one on the list. Different codes may have different conditions.</div>
      </div>
    </div>

    {{-- CTA --}}
    <div style="text-align:center;margin-top:48px;padding:40px;background:var(--dark);border-radius:20px;max-width:720px;margin:48px auto 0">
      <div style="font-size:32px;margin-bottom:12px">🛍️</div>
      <h3 style="color:var(--white);font-size:22px;font-weight:700;margin-bottom:8px">Ready to Start Saving?</h3>
      <p style="color:#a1a1aa;font-size:14px;margin-bottom:24px">Browse hundreds of deals from your favourite stores right now.</p>
      <a href="{{ route('stores.index') }}" class="btn btn-green" style="font-size:15px;padding:12px 32px">
        Browse All Stores →
      </a>
    </div>

  </div>
</div>

@endsection
