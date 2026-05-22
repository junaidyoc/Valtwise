@extends('layouts.app')

@section('title', 'Terms & Conditions — Valtwise')
@section('meta_description', 'Read the Terms and Conditions for using Valtwise — your trusted coupon and deals platform.')

@section('content')

@push('styles')
<style>
.page-hero{background:var(--dark);padding:48px 0 40px;border-bottom:1px solid var(--dark-2)}
.page-hero h1{color:var(--white);font-size:32px;font-weight:700;margin-bottom:8px}
.page-hero p{color:#a1a1aa;font-size:15px}
.page-body{padding:56px 0 80px;max-width:820px}
.page-body h2{font-size:20px;font-weight:700;color:var(--dark);margin:36px 0 12px;padding-bottom:8px;border-bottom:2px solid var(--green-light)}
.page-body h3{font-size:16px;font-weight:600;color:var(--dark);margin:20px 0 8px}
.page-body p{font-size:14px;color:#52525b;line-height:1.8;margin-bottom:12px}
.page-body ul{padding-left:20px;margin-bottom:12px}
.page-body ul li{font-size:14px;color:#52525b;line-height:1.8;margin-bottom:6px}
.page-body strong{color:var(--dark)}
.last-updated{display:inline-flex;align-items:center;gap:6px;background:var(--green-light);color:#15803d;font-size:12px;font-weight:600;padding:4px 12px;border-radius:100px;margin-bottom:28px}
</style>
@endpush

<div class="page-hero">
  <div class="container">
    <div style="font-size:12px;color:#52525b;margin-bottom:14px">
      <a href="{{ route('home') }}" style="color:#52525b">Home</a>
      <span style="margin:0 6px">›</span>
      <span style="color:#a1a1aa">Terms & Conditions</span>
    </div>
    <h1>Terms & Conditions</h1>
    <p>Please read these terms carefully before using Valtwise.</p>
  </div>
</div>

<div class="container">
  <div class="page-body">
    <div class="last-updated">📅 Last updated: January 2026</div>

    <p>Welcome to <strong>Valtwise</strong> ("we", "our", or "us"). By accessing or using our website at valtwise.co, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, please do not use our services.</p>

    <h2>1. About Valtwise</h2>
    <p>Valtwise is a coupon aggregation and deals discovery platform. We help shoppers find verified discount codes, promotional offers, and cashback deals from a wide range of online retailers and brands. Valtwise acts as an intermediary — we do not sell any products directly, and all purchases are made on the respective merchant's website.</p>

    <h2>2. Use of Our Services</h2>
    <p>By using Valtwise, you agree to:</p>
    <ul>
      <li>Use the platform only for lawful personal shopping purposes</li>
      <li>Not attempt to manipulate, scrape, or exploit our affiliate links in any way</li>
      <li>Not use automated tools, bots, or scripts to access our content</li>
      <li>Not reproduce or redistribute our curated content without written permission</li>
      <li>Provide accurate information if you submit coupon codes or deals to us</li>
    </ul>

    <h2>3. Affiliate Disclosure</h2>
    <p>Valtwise participates in affiliate marketing programs. This means we may earn a commission when you click on links on our site and make a purchase on a partner merchant's website. This comes at <strong>no additional cost to you</strong> — the price you pay remains the same.</p>
    <p>Our affiliate relationships do not influence the deals we feature. We aim to list the most relevant and beneficial offers for our users.</p>

    <h2>4. Accuracy of Coupon Codes</h2>
    <p>We make every effort to verify that the coupon codes and deals listed on Valtwise are accurate and active. However, we cannot guarantee that every code will work at the time of use. Coupon codes may expire, be limited to specific products, or be subject to terms set by the merchant.</p>
    <p>Valtwise is not responsible for any failed transactions, expired coupons, or changes in merchant pricing or terms.</p>

    <h2>5. Third-Party Websites</h2>
    <p>Our site contains links to third-party merchant websites. Once you leave Valtwise and visit a merchant's site, their terms of service and privacy policy apply. Valtwise has no control over the content, availability, or policies of external websites.</p>
    <p>Any purchases you make on third-party sites are solely between you and the merchant.</p>

    <h2>6. Intellectual Property</h2>
    <p>All original content on Valtwise — including our logo, design, written descriptions, and code — is the intellectual property of Valtwise. You may not copy, reproduce, or use our content without prior written consent.</p>
    <p>Brand names, logos, and trademarks belonging to merchants or other companies remain the property of their respective owners.</p>

    <h2>7. Limitation of Liability</h2>
    <p>Valtwise provides its services on an "as is" basis. To the maximum extent permitted by law, we are not liable for:</p>
    <ul>
      <li>Any direct or indirect losses arising from use of our platform</li>
      <li>Issues with coupon codes that do not work as expected</li>
      <li>Any changes to pricing or terms made by third-party merchants</li>
      <li>Interruptions or errors in our service</li>
    </ul>

    <h2>8. Privacy</h2>
    <p>Your use of Valtwise is also governed by our Privacy Policy. We do not sell your personal data. We collect limited analytics data to improve our services. Please review our Privacy Policy for full details.</p>

    <h2>9. Modifications</h2>
    <p>We reserve the right to update these Terms and Conditions at any time. Changes will be posted on this page with an updated date. Continued use of Valtwise after changes are published constitutes acceptance of the updated terms.</p>

    <h2>10. Contact</h2>
    <p>If you have any questions about these terms, please <a href="{{ route('contact') }}" style="color:var(--green)">contact us</a>. We are happy to help.</p>

  </div>
</div>

@endsection
