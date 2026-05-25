@extends('layouts.app')

@section('title', 'FAQ — Frequently Asked Questions — Valtwise')
@section('meta_description', 'Got questions about Valtwise? Find answers to the most common questions about using coupon codes and deals.')

@section('content')

@push('styles')
<style>
.page-hero{background:var(--dark);padding:48px 0 40px;border-bottom:1px solid var(--dark-2)}
.page-hero h1{color:var(--white);font-size:32px;font-weight:700;margin-bottom:8px}
.page-hero p{color:#a1a1aa;font-size:15px}
.page-body{padding:56px 0 80px;max-width:820px}
.faq-section{margin-bottom:40px}
.faq-section h2{font-size:18px;font-weight:700;color:var(--dark);margin-bottom:16px;display:flex;align-items:center;gap:8px}
.faq-item{border:1px solid var(--gray-2);border-radius:var(--radius-lg);margin-bottom:10px;overflow:hidden}
.faq-q{padding:16px 20px;font-size:14px;font-weight:600;color:var(--dark);cursor:pointer;display:flex;justify-content:space-between;align-items:center;background:var(--white);transition:background .15s}
.faq-q:hover{background:var(--gray-1)}
.faq-a{padding:0 20px 16px;font-size:14px;color:#52525b;line-height:1.8;display:none}
.faq-a.open{display:block}
.faq-icon{font-size:18px;color:var(--green);transition:transform .2s;flex-shrink:0}
.faq-icon.open{transform:rotate(45deg)}
</style>
@endpush

<div class="page-hero">
  <div class="container">
    <div style="font-size:12px;color:#52525b;margin-bottom:14px">
      <a href="{{ route('home') }}" style="color:#52525b">Home</a>
      <span style="margin:0 6px">›</span>
      <span style="color:#a1a1aa">FAQ</span>
    </div>
    <h1>Frequently Asked Questions</h1>
    <p>Everything you need to know about using Valtwise to save money.</p>
  </div>
</div>

<div class="container">
  <div class="page-body">

    {{-- Section 1 --}}
    <div class="faq-section">
      <h2>🏷️ About Coupons & Deals</h2>

      <div class="faq-item">
        <div class="faq-q" onclick="toggle(this)">
          How do I find coupon codes on Valtwise?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">
          You can search for any store using the search bar at the top of the page, browse by category, or explore our featured stores on the homepage. Each store page shows all currently active coupon codes and deals for that brand.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggle(this)">
          How do I use a coupon code?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">
          Click the "Reveal Code" button on any coupon card. The code will be copied to your clipboard automatically, and you will be redirected to the merchant's website. At checkout, paste the code in the "Coupon Code" or "Promo Code" field to apply the discount.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggle(this)">
          What is the difference between a coupon code and a deal?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">
          A <strong>coupon code</strong> is a text code (like "SAVE20") that you enter at checkout. A <strong>deal</strong> requires no code — the discount is applied automatically when you click "Get Deal" and land on the merchant's page. Both save you money!
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggle(this)">
          Why isn't my coupon code working?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">
          Coupon codes can stop working for several reasons: the code may have expired, it may have a minimum order requirement, or it may be limited to first-time customers. We try to keep our listings updated, but we recommend checking the coupon's terms. If a code doesn't work, try another one from the same store page.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggle(this)">
          How do I know if a coupon is verified?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">
          Verified coupons are marked with a green "✓ Verified" badge. This means our team has tested and confirmed that the code works. Unverified coupons are community-submitted or sourced from brand websites and may or may not work.
        </div>
      </div>
    </div>

    {{-- Section 2 --}}
    <div class="faq-section">
      <h2>🌐 About Valtwise</h2>

      <div class="faq-item">
        <div class="faq-q" onclick="toggle(this)">
          Is Valtwise free to use?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">
          Absolutely — Valtwise is 100% free for shoppers. You never pay anything to use our platform. We earn a small commission from merchants when purchases are made through our links, and this keeps our service free for you.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggle(this)">
          How does Valtwise make money?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">
          Valtwise earns affiliate commissions from partner merchants when users make purchases through our links. This is standard practice in the deals and coupons industry. Our goal is always to show you the best deals — our revenue never influences which offers we feature.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggle(this)">
          How often are new coupons added?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">
          We update our deals and coupon codes regularly. New codes are added daily, and expired coupons are removed to keep our listings accurate and relevant.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggle(this)">
          How do I report a coupon that doesn't work?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">
          Please <a href="{{ route('contact') }}" style="color:var(--green)">contact us</a> with the coupon code and store name. Our team will verify and update it promptly. Your feedback helps us maintain the quality of our listings.
        </div>
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script>
function toggle(el) {
  const answer = el.nextElementSibling;
  const icon   = el.querySelector('.faq-icon');
  answer.classList.toggle('open');
  icon.classList.toggle('open');
}
</script>
@endpush

@endsection
