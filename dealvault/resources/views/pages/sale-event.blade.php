@extends('layouts.app')

@section('title', $event->seo_title)
@section('meta_description', $event->seo_description)
@section('meta_keywords', $event->seo_keywords)
@section('robots', $event->seo_robots)
@section('canonical', $event->seo_canonical)

@section('og_title', $event->seo_og_title ?: $event->seo_title)
@section('og_description', $event->seo_og_description ?: $event->seo_description)
@section('og_image', $event->seo_og_image ?? '')

@push('styles')
<style>
    /* Event Hero */
    .event-hero{background:var(--dark);padding:56px 0 48px;border-bottom:1px solid var(--dark-2)}
    .event-hero h1{color:var(--white);font-size:36px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:16px}
    .event-hero h1 .emoji{font-size:48px}
    .event-hero p{color:#a1a1aa;font-size:16px;max-width:700px;line-height:1.7}
    .breadcrumb{font-size:12px;color:#52525b;margin-bottom:14px}
    .breadcrumb a{color:#52525b;text-decoration:none}
    .breadcrumb a:hover{color:var(--green)}
    .breadcrumb span{margin:0 6px;color:#52525b}

    /* Event Meta */
    .event-meta{display:flex;flex-wrap:wrap;gap:20px;margin-top:24px}
    .event-meta-item{display:flex;flex-direction:column;gap:4px}
    .event-meta-label{font-size:11px;color:#71717a;text-transform:uppercase;letter-spacing:.03em}
    .event-meta-value{font-size:15px;color:var(--white);font-weight:600}

    /* Status Badge */
    .status-badge{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-md);font-size:13px;font-weight:600}
    .status-live{background:linear-gradient(90deg,#14532d,#166534);color:#86efac}
    .status-live .pulse{width:8px;height:8px;background:#86efac;border-radius:50%;animation:pulse 1.5s infinite}
    .status-upcoming{background:#422006;color:#fbbf24}
    .status-past{background:#27272a;color:#a1a1aa}
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.6;transform:scale(1.2)}}

    /* Region Badges */
    .region-badge{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:var(--radius-sm);font-size:12px;font-weight:600}
    .region-uk{background:#dcfce7;color:#166534}
    .region-pk{background:#fef3c7;color:#92400e}
    .region-global{background:#dbeafe;color:#1e40af}

    /* Section */
    .section{padding:48px 0}
    .section-gray{background:var(--gray-1)}
    .section-title{font-size:22px;font-weight:700;color:var(--dark);margin-bottom:8px}
    .section-subtitle{font-size:14px;color:#71717a;margin-bottom:24px}

    /* Description Card */
    .description-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:28px}
    .description-card p{font-size:15px;color:#52525b;line-height:1.8}

    /* Categories Grid */
    .categories-grid{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:24px}
    .category-tag{background:var(--green-light);color:var(--green);padding:8px 16px;border-radius:var(--radius-md);font-size:13px;font-weight:600}

    /* Checklist */
    .checklist-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:28px}
    .checklist{list-style:none;padding:0;margin:0}
    .checklist li{display:flex;align-items:flex-start;gap:12px;font-size:14px;color:#52525b;line-height:1.7;margin-bottom:12px;padding-bottom:12px;border-bottom:1px dashed var(--gray-2)}
    .checklist li:last-child{margin-bottom:0;padding-bottom:0;border-bottom:none}
    .checklist-icon{color:var(--green);font-size:16px;flex-shrink:0;margin-top:1px}

    /* Subtitle Tags */
    .subtitle-tags{display:flex;flex-wrap:wrap;gap:8px;margin-top:16px}
    .subtitle-tag{background:rgba(22,163,74,.15);color:#4ade80;padding:6px 12px;border-radius:var(--radius-sm);font-size:12px;font-weight:500}

    /* Density Bar */
    .density-section{display:flex;align-items:center;gap:16px;background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px 24px}
    .density-label{font-size:14px;color:var(--dark);font-weight:600;min-width:100px}
    .density-bar-wrap{flex:1;height:20px;background:var(--gray-1);border-radius:var(--radius-sm);overflow:hidden}
    .density-bar{height:100%;border-radius:var(--radius-sm);transition:width .5s ease}
    .density-bar.peak{background:var(--green)}
    .density-bar.high{background:#22c55e}
    .density-bar.medium{background:var(--green-light)}
    .density-bar.low{background:var(--gray-2)}
    .density-value{font-size:13px;font-weight:600;min-width:60px;text-align:right}
    .density-value.peak{color:var(--green)}
    .density-value.high{color:#22c55e}
    .density-value.medium{color:#71717a}
    .density-value.low{color:#a1a1aa}

    /* Suggested Stores */
    .stores-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
    .store-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px;text-align:center;transition:all .2s}
    .store-card:hover{border-color:var(--green);transform:translateY(-2px)}
    .store-logo{width:60px;height:60px;object-fit:contain;margin-bottom:12px}
    .store-name{font-size:14px;font-weight:600;color:var(--dark);margin-bottom:4px}
    .store-coupons{font-size:12px;color:var(--green)}

    /* Related Events */
    .related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
    .related-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px;text-align:center;transition:all .2s;text-decoration:none}
    .related-card:hover{border-color:var(--green);box-shadow:var(--shadow-md)}
    .related-emoji{font-size:32px;margin-bottom:10px}
    .related-name{font-size:15px;font-weight:600;color:var(--dark);margin-bottom:4px}
    .related-date{font-size:12px;color:#71717a}

    /* Navigation */
    .event-nav{display:flex;justify-content:space-between;align-items:center;padding:24px 0;border-top:1px solid var(--gray-2);margin-top:24px}
    .event-nav-item{display:flex;align-items:center;gap:12px;text-decoration:none;color:var(--dark);font-size:14px;padding:12px 16px;border-radius:var(--radius-md);transition:all .2s}
    .event-nav-item:hover{background:var(--gray-1)}
    .event-nav-item .emoji{font-size:24px}
    .event-nav-item .label{font-size:11px;color:#71717a;text-transform:uppercase}
    .event-nav-item .name{font-weight:600}
    .event-nav-item.prev{padding-left:0}
    .event-nav-item.next{text-align:right;padding-right:0}

    /* CTA Section */
    .cta-section{background:var(--dark);padding:60px 0;text-align:center}
    .cta-section h2{color:var(--white);font-size:26px;font-weight:700;margin-bottom:12px}
    .cta-section p{color:#a1a1aa;font-size:15px;margin-bottom:24px;max-width:500px;margin-left:auto;margin-right:auto}

    /* Responsive */
    @media(max-width:992px){
    .related-grid{grid-template-columns:repeat(2,1fr)}
    .stores-grid{grid-template-columns:repeat(2,1fr)}
    }
    @media(max-width:768px){
    .event-hero h1{font-size:28px;flex-direction:column;align-items:flex-start;gap:8px}
    .event-hero h1 .emoji{font-size:36px}
    .event-meta{flex-direction:column;gap:16px}
    .related-grid{grid-template-columns:1fr}
    .stores-grid{grid-template-columns:1fr}
    .event-nav{flex-direction:column;gap:16px}
    .event-nav-item{width:100%;justify-content:center}
    }
</style>
@endpush

{{-- JSON-LD Event Schema --}}
@push('scripts')
@php
$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Event',
    'name' => $event->name,
    'description' => strip_tags($event->description ?? $event->seo_description),
    'startDate' => $event->event_date->format('Y-m-d'),
    'eventAttendanceMode' => 'https://schema.org/OnlineEventAttendanceMode',
    'eventStatus' => 'https://schema.org/EventScheduled',
    'location' => [
        '@type' => 'VirtualLocation',
        'url' => route('sale-calendar.show', $event->slug)
    ],
    'organizer' => [
        '@type' => 'Organization',
        'name' => config('app.name', 'Valtwise'),
        'url' => config('app.url')
    ],
    'offers' => [
        '@type' => 'AggregateOffer',
        'priceCurrency' => 'GBP',
        'availability' => 'https://schema.org/InStock',
        'url' => route('stores.index')
    ]
];

if ($event->end_date) {
    $schema['endDate'] = $event->end_date->format('Y-m-d');
}

if ($event->seo_og_image) {
    $schema['image'] = $event->seo_og_image;
}
@endphp
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ route('home') }}"
        },
        {
            "@@type": "ListItem",
            "position": 2,
            "name": "Sale Calendar",
            "item": "{{ route('sale-calendar') }}"
        },
        {
            "@@type": "ListItem",
            "position": 3,
            "name": "{{ $event->name }}",
            "item": "{{ route('sale-calendar.show', $event->slug) }}"
        }
    ]
}
</script>
@endpush

@section('content')

{{-- HERO SECTION --}}
<div class="event-hero">
  <div class="container">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>></span>
      <a href="{{ route('sale-calendar') }}">Sale Calendar</a>
      <span>></span>
      <span style="color:#a1a1aa">{{ $event->name }}</span>
    </div>

    <h1>
      <span class="emoji">{{ $event->emoji ?? '🛒' }}</span>
      {{ $event->name }} {{ $event->event_date->format('Y') }}
    </h1>

    @if($event->description)
    <p>{{ $event->description }}</p>
    @else
    <p>Find the best {{ $event->name }} deals, discounts, and verified coupon codes. Plan your shopping with Valtwise.</p>
    @endif

    @if($event->subtitle_tags)
    <div class="subtitle-tags">
      @foreach($event->subtitle_tags_array as $tag)
        <span class="subtitle-tag">{{ $tag }}</span>
      @endforeach
    </div>
    @endif

    <div class="event-meta">
      <div class="event-meta-item">
        <span class="event-meta-label">Status</span>
        @if($event->isActive())
          <span class="status-badge status-live"><span class="pulse"></span> Live Now</span>
        @elseif($event->isUpcoming())
          <span class="status-badge status-upcoming">In {{ $event->daysUntil() }} days</span>
        @else
          <span class="status-badge status-past">Event Ended</span>
        @endif
      </div>

      <div class="event-meta-item">
        <span class="event-meta-label">Date</span>
        <span class="event-meta-value">{{ $event->date_range }}</span>
      </div>

      <div class="event-meta-item">
        <span class="event-meta-label">Region</span>
        <span class="event-meta-value">{!! $event->region_badge !!}</span>
      </div>

      <div class="event-meta-item">
        <span class="event-meta-label">Deal Density</span>
        <span class="event-meta-value" style="color:var(--green)">{{ $event->density_label }}</span>
      </div>

      @if($event->isActive())
      <div class="event-meta-item">
        <span class="event-meta-label">Ends In</span>
        <span class="event-meta-value" style="color:#fbbf24">{{ $event->daysRemaining() }} day{{ $event->daysRemaining() > 1 ? 's' : '' }}</span>
      </div>
      @endif
    </div>
  </div>
</div>

{{-- DEAL DENSITY --}}
<div class="section section-gray">
  <div class="container">
    <h2 class="section-title">Expected Deal Intensity</h2>
    <p class="section-subtitle">How much discount activity to expect during {{ $event->name }}</p>

    <div class="density-section">
      <div class="density-label">Deal Volume</div>
      <div class="density-bar-wrap">
        <div class="density-bar {{ $event->density }}" style="width: {{ $event->density_percent }}%"></div>
      </div>
      <div class="density-value {{ $event->density }}">{{ $event->density_label }}</div>
    </div>
  </div>
</div>

{{-- CATEGORIES --}}
@if($event->categories)
<div class="section">
  <div class="container">
    <h2 class="section-title">Top Categories During {{ $event->name }}</h2>
    <p class="section-subtitle">These categories typically see the best discounts</p>

    <div class="categories-grid">
      @foreach($event->categories_array as $category)
        <span class="category-tag">{{ $category }}</span>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- SHOPPING CHECKLIST --}}
@php
  $checklist = $event->checklist ?? [];
  if (is_string($checklist)) {
      $checklist = json_decode($checklist, true) ?? [];
  }
@endphp
@if(!empty($checklist) && is_array($checklist))
<div class="section section-gray">
  <div class="container">
    <h2 class="section-title">{{ $event->name }} Shopping Checklist</h2>
    <p class="section-subtitle">Pro tips to maximize your savings</p>

    <div class="checklist-card">
      <ul class="checklist">
        @foreach($checklist as $tip)
        <li>
          <span class="checklist-icon">✓</span>
          <span>{{ $tip }}</span>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endif

{{-- SUGGESTED STORES --}}
@if($suggestedStores && count($suggestedStores) > 0)
<div class="section">
  <div class="container">
    <h2 class="section-title">Stores With Active {{ $event->name }} Deals</h2>
    <p class="section-subtitle">Browse verified coupons from top retailers</p>

    <div class="stores-grid">
      @foreach($suggestedStores as $store)
      <a href="{{ route('stores.show', $store->slug) }}" class="store-card">
        @if($store->logo)
          <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="store-logo">
        @else
          <div class="store-logo" style="background:var(--gray-1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;color:var(--dark);font-weight:700">
            {{ substr($store->name, 0, 1) }}
          </div>
        @endif
        <div class="store-name">{{ $store->name }}</div>
        <div class="store-coupons">{{ $store->coupons_count ?? $store->coupons->count() }} active coupons</div>
      </a>
      @endforeach
    </div>

    <div style="text-align:center;margin-top:24px">
      <a href="{{ route('stores.index') }}" class="btn btn-outline" style="display:inline-block">
        View All Stores →
      </a>
    </div>
  </div>
</div>
@endif

{{-- RELATED EVENTS --}}
@if($relatedEvents && $relatedEvents->isNotEmpty())
<div class="section section-gray">
  <div class="container">
    <h2 class="section-title">Other Sale Events in {{ $year }}</h2>
    <p class="section-subtitle">More shopping opportunities this year</p>

    <div class="related-grid">
      @foreach($relatedEvents as $related)
      <a href="{{ route('sale-calendar.show', $related->slug) }}" class="related-card">
        <div class="related-emoji">{{ $related->emoji ?? '📅' }}</div>
        <div class="related-name">{{ $related->name }}</div>
        <div class="related-date">{{ $related->short_date_range }}</div>
      </a>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- EVENT NAVIGATION --}}
<div class="section">
  <div class="container">
    <div class="event-nav">
      @if($prevEvent)
      <a href="{{ route('sale-calendar.show', $prevEvent->slug) }}" class="event-nav-item prev">
        <span class="emoji">{{ $prevEvent->emoji ?? '📅' }}</span>
        <div>
          <div class="label">Previous Event</div>
          <div class="name">{{ $prevEvent->name }}</div>
        </div>
      </a>
      @else
      <div></div>
      @endif

      @if($nextEvent)
      <a href="{{ route('sale-calendar.show', $nextEvent->slug) }}" class="event-nav-item next">
        <div>
          <div class="label">Next Event</div>
          <div class="name">{{ $nextEvent->name }}</div>
        </div>
        <span class="emoji">{{ $nextEvent->emoji ?? '📅' }}</span>
      </a>
      @else
      <div></div>
      @endif
    </div>
  </div>
</div>

{{-- CTA SECTION --}}
<div class="cta-section">
  <div class="container">
    <h2>Find {{ $event->name }} Deals Now</h2>
    <p>Browse verified coupons and discount codes from 100+ UK & Pakistan stores</p>
    <a href="{{ route('stores.index') }}" class="btn btn-green" style="font-size:15px;padding:14px 36px">
      Browse All Stores →
    </a>
  </div>
</div>

@endsection
