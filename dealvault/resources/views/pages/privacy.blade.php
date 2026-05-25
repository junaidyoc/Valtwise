@extends('layouts.app')

@section('title', 'Privacy Policy — Valtwise')
@section('meta_description', 'Read the Valtwise Privacy Policy. Learn how we collect, use, and protect your personal information.')

@section('content')

@push('styles')
<style>
.page-hero{background:var(--dark);padding:48px 0 40px;border-bottom:1px solid var(--dark-2)}
.page-hero h1{color:var(--white);font-size:32px;font-weight:700;margin-bottom:8px}
.page-hero p{color:#a1a1aa;font-size:15px}
.page-body{padding:56px 0 80px;max-width:820px}
.page-body h2{font-size:20px;font-weight:700;color:var(--dark);margin:36px 0 12px;padding-bottom:8px;border-bottom:2px solid var(--green-light)}
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
            <span style="color:#a1a1aa">Privacy Policy</span>
        </div>
        <h1>Privacy Policy</h1>
        <p>How we collect, use, and protect your information.</p>
    </div>
</div>

<div class="container">
    <div class="page-body">

        <div class="last-updated">📅 Last updated: {{ date('F Y') }}</div>

        <p>
            Welcome to <strong>Valtwise</strong> ("we", "our", "us").
            This Privacy Policy explains how we handle information
            when you use our website. By using Valtwise, you agree
            to the practices described below.
        </p>

        {{-- 1 --}}
        <h2>1. Who We Are</h2>
        <p>
            Valtwise is a free coupon and deals aggregation platform.
            We help users find verified discount codes and promotional
            offers from online retailers worldwide. We do not sell
            products directly. We earn revenue through affiliate
            partnerships.
        </p>
        <p>
            For privacy questions, contact us at:
            <a href="mailto:contactvaltwise@gmail.com"
               style="color:var(--green)">
               contactvaltwise@gmail.com
            </a>
        </p>

        {{-- 2 --}}
        <h2>2. Information We Collect</h2>
        <p>
            Valtwise does not require registration or account
            creation to browse deals and coupons.
        </p>
        <p>We may collect the following:</p>
        <ul>
            <li>
                <strong>Email address</strong> — only if you
                voluntarily subscribe to our newsletter or
                contact us via our contact form.
            </li>
            <li>
                <strong>Name and message</strong> — if submitted
                via our contact form.
            </li>
            <li>
                <strong>Usage data</strong> — pages visited,
                time on site, browser type, device type, and
                referring website. This data is aggregated and
                anonymised.
            </li>
            <li>
                <strong>IP address</strong> — collected
                automatically when you visit our site or
                click affiliate links, used for security
                and fraud prevention.
            </li>
        </ul>
        <p>
            We do <strong>not</strong> collect payment information,
            government identification, or sensitive personal data.
        </p>

        {{-- 3 --}}
        <h2>3. How We Use Your Information</h2>
        <ul>
            <li>To operate and improve the Valtwise platform</li>
            <li>
                To send deal newsletters — only if you opt in
            </li>
            <li>To respond to your enquiries and support requests</li>
            <li>To detect and prevent fraudulent activity</li>
            <li>
                To analyse traffic using anonymised analytics data
            </li>
        </ul>

        {{-- 4 --}}
        <h2>4. Information Sharing</h2>
        <p>
            We do <strong>not sell, rent, or trade</strong>
            your personal information to any third party.
        </p>
        <p>We may share limited data with:</p>
        <ul>
            <li>
                <strong>Analytics providers</strong> (e.g. Google
                Analytics) — anonymised traffic data only
            </li>
            <li>
                <strong>Affiliate networks</strong> (e.g. Admitad)
                — click tracking when you use our deal links
            </li>
            <li>
                <strong>Email providers</strong> (e.g. Resend)
                — to send newsletters if you subscribe
            </li>
            <li>
                <strong>Law enforcement</strong> — if required
                by applicable law
            </li>
        </ul>

        {{-- 5 --}}
        <h2>5. Cookies</h2>
        <p>
            We use cookies to enable site functionality and
            understand how visitors use our platform. You may
            disable cookies in your browser settings, though
            some features may not function correctly.
        </p>
        <ul>
            <li>
                <strong>Functional cookies</strong> — required
                for basic site operation
            </li>
            <li>
                <strong>Analytics cookies</strong> — Google
                Analytics (anonymised data)
            </li>
            <li>
                <strong>Affiliate cookies</strong> — set by
                affiliate networks when you click deal links
            </li>
        </ul>

        {{-- 6 --}}
        <h2>6. Affiliate Links</h2>
        <p>
            Valtwise contains affiliate links to third-party
            merchant websites. When you click these links:
        </p>
        <ul>
            <li>
                You will be redirected to the merchant's website
            </li>
            <li>
                A tracking cookie may be set by the affiliate
                network
            </li>
            <li>
                We may earn a commission if you make a purchase
                — at <strong>no additional cost to you</strong>
            </li>
        </ul>
        <p>
            We are not responsible for the privacy practices
            of third-party merchant sites.
        </p>

        {{-- 7 --}}
        <h2>7. Coupon Accuracy</h2>
        <p>
            While we make reasonable efforts to keep coupon
            codes and deals accurate and up to date, we cannot
            guarantee that every offer will be valid at the
            time of use. Offers may expire or be withdrawn by
            merchants without notice. Valtwise accepts no
            liability for failed or expired coupons.
        </p>

        {{-- 8 --}}
        <h2>8. Your Rights</h2>
        <p>
            Regardless of your location, you may contact us
            at any time to:
        </p>
        <ul>
            <li>Request access to the data we hold about you</li>
            <li>Request correction of inaccurate data</li>
            <li>Request deletion of your personal data</li>
            <li>Unsubscribe from our newsletter at any time</li>
        </ul>
        <p>
            We will respond to all data requests within
            <strong>30 days</strong>.
            Contact us at
            <a href="{{ route('contact') }}"
               style="color:var(--green)">
               our contact page
            </a>.
        </p>

        {{-- 9 --}}
        <h2>9. Data Retention</h2>
        <ul>
            <li>
                <strong>Contact form data</strong> —
                retained up to 12 months
            </li>
            <li>
                <strong>Newsletter email</strong> —
                until you unsubscribe, then deleted
                within 90 days
            </li>
            <li>
                <strong>Click logs</strong> —
                up to 90 days for fraud prevention
            </li>
            <li>
                <strong>Analytics data</strong> —
                per Google Analytics retention settings
            </li>
        </ul>

        {{-- 10 --}}
        <h2>10. Children's Privacy</h2>
        <p>
            Valtwise is not directed at children under the
            age of 13. We do not knowingly collect personal
            data from children. If you believe a child has
            submitted data via our site, contact us
            immediately and we will delete it.
        </p>

        {{-- 11 --}}
        <h2>11. Security</h2>
        <p>
            We take reasonable technical measures to protect
            your information from unauthorised access or
            disclosure. However, no internet transmission
            is 100% secure. We cannot guarantee absolute
            security.
        </p>

        {{-- 12 --}}
        <h2>12. Third-Party Services</h2>
        <p>
            We use the following third-party services.
            Each has its own privacy policy:
        </p>
        <ul>
            <li>
                <strong>Google Analytics</strong> —
                website traffic analysis
            </li>
            <li>
                <strong>Admitad</strong> —
                affiliate link tracking
            </li>
            <li>
                <strong>Resend</strong> —
                email delivery
            </li>
            <li>
                <strong>Cloudflare</strong> —
                security and performance
            </li>
        </ul>

        {{-- 13 --}}
        <h2>13. User Conduct</h2>
        <p>
            You may not scrape, crawl, reproduce, or
            commercially exploit any content from Valtwise
            without prior written permission. Automated
            access via bots or scripts is strictly
            prohibited.
        </p>

        {{-- 14 --}}
        <h2>14. Changes to This Policy</h2>
        <p>
            We may update this Privacy Policy from time
            to time. Changes will be posted on this page
            with an updated date. Continued use of
            Valtwise after changes are posted constitutes
            acceptance of the updated policy.
        </p>

        {{-- 15 --}}
        <h2>15. Contact</h2>
        <p>
            For any privacy questions or data requests:
        </p>
        <ul>
            <li>
                Email:
                <a href="mailto:contactvaltwise@gmail.com"
                   style="color:var(--green)">
                   contactvaltwise@gmail.com
                </a>
            </li>
            <li>
                Form:
                <a href="{{ route('contact') }}"
                   style="color:var(--green)">
                   Contact Us
                </a>
            </li>
        </ul>

        <div style="margin-top:48px;padding-top:24px;
                    border-top:1px solid var(--gray-2);
                    font-size:13px;color:#a1a1aa">
            © {{ date('Y') }} Valtwise. All rights reserved.
        </div>

    </div>
</div>

@endsection