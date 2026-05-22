@extends('layouts.app')

@section('title', 'Contact Us — Valtwise')
@section('meta_description', 'Get in touch with Valtwise. Report broken coupons, suggest stores, or ask any question.')

@section('content')

@push('styles')
<style>
.page-hero{background:var(--dark);padding:48px 0 40px;border-bottom:1px solid var(--dark-2)}
.page-hero h1{color:var(--white);font-size:32px;font-weight:700;margin-bottom:8px}
.page-hero p{color:#a1a1aa;font-size:15px}
.contact-grid{display:grid;grid-template-columns:1fr 1.5fr;gap:40px;padding:56px 0 80px;align-items:start}
.contact-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px;display:flex;gap:14px;align-items:flex-start;margin-bottom:12px}
.contact-icon{width:40px;height:40px;background:var(--green-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.contact-label{font-size:12px;font-weight:600;color:#71717a;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px}
.contact-value{font-size:14px;font-weight:500;color:var(--dark)}
.contact-sub{font-size:12px;color:#a1a1aa;margin-top:2px}
.form-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:28px}
.form-card h3{font-size:18px;font-weight:700;color:var(--dark);margin-bottom:4px}
.form-card p{font-size:13px;color:#71717a;margin-bottom:20px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-grp{margin-bottom:14px}
.form-grp label{display:block;font-size:12px;font-weight:600;color:#52525b;margin-bottom:5px}
.form-grp input,.form-grp select,.form-grp textarea{width:100%;padding:10px 14px;border:1px solid var(--gray-2);border-radius:var(--radius-md);font-size:14px;font-family:'DM Sans',sans-serif;color:var(--dark);outline:none;transition:border-color .15s;background:var(--white)}
.form-grp input:focus,.form-grp select:focus,.form-grp textarea:focus{border-color:var(--green)}
</style>
@endpush

<div class="page-hero">
  <div class="container">
    <div style="font-size:12px;color:#52525b;margin-bottom:14px">
      <a href="{{ route('home') }}" style="color:#52525b">Home</a>
      <span style="margin:0 6px">›</span>
      <span style="color:#a1a1aa">Contact Us</span>
    </div>
    <h1>Contact Us</h1>
    <p>Have a question, found a broken coupon, or want to suggest a store? We'd love to hear from you.</p>
  </div>
</div>

<div class="container">
  <div class="contact-grid">

    {{-- Left: Info --}}
    <div>
      <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:20px">Get In Touch</h2>

      <div class="contact-card">
        <div class="contact-icon">📧</div>
        <div>
          <div class="contact-label">Email</div>
          <div class="contact-value">info@valtwise.co</div>
          <div class="contact-sub">We respond within 24 hours</div>
        </div>
      </div>

      <div class="contact-card">
        <div class="contact-icon">🕐</div>
        <div>
          <div class="contact-label">Response Time</div>
          <div class="contact-value">Within 24 hours</div>
          <div class="contact-sub">Monday to Saturday</div>
        </div>
      </div>

      <div class="contact-card">
        <div class="contact-icon">🏷️</div>
        <div>
          <div class="contact-label">Report a Coupon</div>
          <div class="contact-value">Broken or expired code?</div>
          <div class="contact-sub">Use the form to report it — we'll fix it fast</div>
        </div>
      </div>

      <div class="contact-card">
        <div class="contact-icon">🏪</div>
        <div>
          <div class="contact-label">Suggest a Store</div>
          <div class="contact-value">Don't see your favourite brand?</div>
          <div class="contact-sub">Tell us and we'll add it!</div>
        </div>
      </div>

      <div style="margin-top:20px">
        <div style="font-size:13px;font-weight:600;color:var(--dark);margin-bottom:10px">Follow Us</div>
        <div style="display:flex;gap:10px">
          @foreach([['Facebook','#','📘'],['Instagram','#','📸'],['Pinterest','#','📌']] as [$name,$url,$icon])
          <a href="{{ $url }}"
             style="display:flex;align-items:center;gap:6px;padding:8px 14px;background:var(--gray-1);border-radius:var(--radius-md);font-size:13px;font-weight:500;color:var(--dark);text-decoration:none;transition:background .15s"
             onmouseover="this.style.background='var(--green-light)'"
             onmouseout="this.style.background='var(--gray-1)'">
            {{ $icon }} {{ $name }}
          </a>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Right: Form --}}
    <div class="form-card">
      <h3>Send Us a Message</h3>
      <p>Fill in the form below and our team will get back to you shortly.</p>

      @if(session('contact_success'))
      <div style="background:var(--green-light);border:1px solid #86efac;border-radius:var(--radius-md);padding:12px 16px;font-size:13px;color:#15803d;margin-bottom:16px">
        ✅ Message sent! We'll reply within 24 hours.
      </div>
      @endif

      <form method="POST" action="{{ route('contact') }}">
        @csrf
        <div class="form-row">
          <div class="form-grp">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="John" required>
          </div>
          <div class="form-grp">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Doe">
          </div>
        </div>

        <div class="form-grp">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="john@example.com" required>
        </div>

        <div class="form-grp">
          <label>Subject</label>
          <select name="subject">
            <option value="broken_coupon">Report a broken coupon</option>
            <option value="suggest_store">Suggest a store</option>
            <option value="general">General question</option>
            <option value="partnership">Partnership inquiry</option>
            <option value="other">Other</option>
          </select>
        </div>

        <div class="form-grp">
          <label>Message</label>
          <textarea name="message" rows="5"
                    placeholder="Tell us how we can help you..."
                    required></textarea>
        </div>

        <button type="submit" class="btn btn-green" style="width:100%;justify-content:center;padding:12px">
          Send Message →
        </button>
      </form>
    </div>

  </div>
</div>

@endsection
