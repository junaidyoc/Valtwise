@extends('layouts.app')

@section('title', "Sale Calendar {$year} — UK & Pakistan Shopping Events | Valtwise")
@section('meta_description', "Complete {$year} sale calendar for UK and Pakistan shoppers. Black Friday, Boxing Day, Eid sales and " . $stats['total_events'] . "+ more events — all dates in one place.")

@section('content')

@push('styles')
<style>
/* Hero Section */
.calendar-hero{background:var(--dark);padding:56px 0 48px;border-bottom:1px solid var(--dark-2)}
.calendar-hero h1{color:var(--white);font-size:36px;font-weight:700;margin-bottom:12px}
.calendar-hero p{color:#a1a1aa;font-size:16px;max-width:620px;line-height:1.7}
.breadcrumb{font-size:12px;color:#52525b;margin-bottom:14px}
.breadcrumb a{color:#52525b;text-decoration:none}
.breadcrumb a:hover{color:var(--green)}
.breadcrumb span{margin:0 6px;color:#52525b}

/* Stats Row */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-top:32px}
.stat-box{background:var(--dark-2);border-radius:var(--radius-md);padding:20px;text-align:center;border:1px solid #3f3f46}
.stat-num{font-size:28px;font-weight:700;color:var(--green);font-family:'Sora',sans-serif}
.stat-lbl{font-size:12px;color:#a1a1aa;margin-top:4px}

/* Active Banner */
.active-banner{background:linear-gradient(90deg,#14532d,#166534);padding:16px 24px;border-radius:var(--radius-lg);display:flex;align-items:center;justify-content:space-between;gap:16px;margin:24px 0}
.active-banner-content{display:flex;align-items:center;gap:12px}
.pulse-dot{width:10px;height:10px;background:var(--green);border-radius:50%;animation:pulse 1.5s infinite}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.6;transform:scale(1.2)}}
.active-banner-text{color:var(--white);font-size:15px;font-weight:600}
.active-banner-text span{color:#86efac;font-weight:400}
.active-banner .btn{white-space:nowrap}

/* Section Headers */
.section{padding:48px 0}
.section-gray{background:var(--gray-1)}
.section-title{font-size:24px;font-weight:700;color:var(--dark);margin-bottom:8px}
.section-subtitle{font-size:14px;color:#71717a;margin-bottom:24px}

/* Upcoming Cards */
.upcoming-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.upcoming-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:24px;text-align:center;transition:all .2s}
.upcoming-card:hover{border-color:var(--green);box-shadow:var(--shadow-md)}
.upcoming-card.featured{border-left:4px solid var(--green)}
.upcoming-emoji{font-size:40px;margin-bottom:12px}
.upcoming-name{font-size:18px;font-weight:700;color:var(--dark);margin-bottom:6px}
.upcoming-dates{font-size:14px;color:#71717a;margin-bottom:10px}
.upcoming-regions{display:flex;gap:6px;justify-content:center;margin-bottom:12px;flex-wrap:wrap}
.upcoming-countdown{font-size:13px;color:var(--green);font-weight:600;margin-bottom:10px}
.upcoming-categories{font-size:12px;color:#a1a1aa}

/* Region Badges */
.region-badge{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:var(--radius-sm);font-size:11px;font-weight:600}
.region-uk{background:#dcfce7;color:#166534}
.region-pk{background:#fef3c7;color:#92400e}
.region-global{background:#dbeafe;color:#1e40af}

/* Density Chart */
.density-chart{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:24px}
.density-row{display:flex;align-items:center;gap:16px;margin-bottom:12px}
.density-month{width:80px;font-size:13px;font-weight:500;color:var(--dark);flex-shrink:0}
.density-bar-wrap{flex:1;height:24px;background:var(--gray-1);border-radius:var(--radius-sm);overflow:hidden}
.density-bar{height:100%;border-radius:var(--radius-sm);transition:width .5s ease}
.density-bar.peak{background:var(--green)}
.density-bar.high{background:#22c55e}
.density-bar.medium{background:var(--green-light)}
.density-bar.low{background:var(--gray-2)}
.density-label{width:60px;font-size:12px;font-weight:500;text-align:right;flex-shrink:0}
.density-label.peak{color:var(--green)}
.density-label.high{color:#22c55e}
.density-label.medium{color:#52525b}
.density-label.low{color:#a1a1aa}

/* Events Table */
.events-table{width:100%;border-collapse:collapse;background:var(--white);border-radius:var(--radius-lg);overflow:hidden;border:1px solid var(--gray-2)}
.events-table th{background:var(--dark);color:var(--white);font-size:12px;font-weight:600;padding:14px 16px;text-align:left;letter-spacing:.02em}
.events-table td{padding:14px 16px;border-bottom:1px solid var(--gray-2);font-size:14px;color:var(--dark)}
.events-table tr:last-child td{border-bottom:none}
.events-table tr:hover td{background:#fafafa}
.events-table tr.featured td{background:#f0fdf4}
.events-table .event-name{display:flex;align-items:center;gap:8px;font-weight:600}
.events-table .event-emoji{font-size:18px}
.events-table .star{color:#eab308;margin-left:4px}

/* Month Guide Cards */
.month-card{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);overflow:hidden;margin-bottom:24px}
.month-header{background:var(--dark);padding:16px 20px;display:flex;align-items:center;justify-content:space-between}
.month-header h3{color:var(--white);font-size:18px;font-weight:700;margin:0}
.month-tags{display:flex;gap:6px;flex-wrap:wrap}
.month-tag{background:rgba(22,163,74,.2);color:#4ade80;padding:4px 10px;border-radius:var(--radius-sm);font-size:11px;font-weight:500}
.month-body{padding:20px}
.month-description{font-size:14px;color:#52525b;line-height:1.7;margin-bottom:16px}
.month-table{width:100%;border-collapse:collapse;margin-bottom:16px}
.month-table th{background:var(--gray-1);font-size:12px;font-weight:600;color:var(--dark);padding:10px 12px;text-align:left}
.month-table td{padding:10px 12px;border-bottom:1px solid var(--gray-2);font-size:13px;color:#52525b}
.month-table tr:last-child td{border-bottom:none}
.checklist{list-style:none;padding:0;margin:0}
.checklist li{display:flex;align-items:flex-start;gap:10px;font-size:13px;color:#52525b;line-height:1.6;margin-bottom:8px}
.checklist li:last-child{margin-bottom:0}
.checklist-icon{color:var(--green);font-size:14px;flex-shrink:0;margin-top:2px}

/* Best Time Table */
.best-table{width:100%;border-collapse:collapse;background:var(--white);border-radius:var(--radius-lg);overflow:hidden;border:1px solid var(--gray-2)}
.best-table th{background:var(--dark);color:var(--white);font-size:12px;font-weight:600;padding:14px 16px;text-align:left}
.best-table td{padding:14px 16px;border-bottom:1px solid var(--gray-2);font-size:14px}
.best-table tr:last-child td{border-bottom:none}
.best-table tr:hover td{background:#fafafa}
.best-table .category{font-weight:600;color:var(--dark)}
.best-table .month{color:var(--green);font-weight:600}
.best-table .why{color:#52525b;font-size:13px}

/* FAQ Accordion */
.faq-list{display:flex;flex-direction:column;gap:12px}
.faq-item{background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-md);overflow:hidden}
.faq-question{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;cursor:pointer;font-size:15px;font-weight:600;color:var(--dark)}
.faq-question:hover{background:#fafafa}
.faq-toggle{font-size:20px;color:var(--green);font-weight:400;transition:transform .2s}
.faq-item.open .faq-toggle{transform:rotate(45deg)}
.faq-answer{padding:0 20px 16px;font-size:14px;color:#52525b;line-height:1.7;display:none}
.faq-item.open .faq-answer{display:block}

/* CTA Section */
.cta-section{background:var(--dark);padding:60px 0;text-align:center}
.cta-section h2{color:var(--white);font-size:28px;font-weight:700;margin-bottom:12px}
.cta-section p{color:#a1a1aa;font-size:15px;margin-bottom:24px;max-width:500px;margin-left:auto;margin-right:auto}

/* Responsive */
@media(max-width:992px){
  .stats-row{grid-template-columns:repeat(2,1fr)}
  .upcoming-grid{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:768px){
  .stats-row{grid-template-columns:1fr 1fr}
  .upcoming-grid{grid-template-columns:1fr}
  .active-banner{flex-direction:column;text-align:center}
  .density-month{width:50px;font-size:11px}
  .density-label{width:50px;font-size:11px}
  .events-table{display:block;overflow-x:auto}
  .month-header{flex-direction:column;gap:12px;align-items:flex-start}
}
@media(max-width:480px){
  .stats-row{grid-template-columns:1fr}
  .calendar-hero h1{font-size:28px}
}
</style>
@endpush

{{-- JSON-LD Event Schema --}}
@push('scripts')
@php
$schemaEvents = $allEvents->map(function($event, $index) {
    $item = [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'item' => [
            '@type' => 'Event',
            'name' => $event->name,
            'startDate' => $event->event_date->format('Y-m-d'),
            'eventAttendanceMode' => 'https://schema.org/OnlineEventAttendanceMode',
            'eventStatus' => 'https://schema.org/EventScheduled',
            'location' => [
                '@type' => 'VirtualLocation',
                'url' => url('/sale-calendar')
            ],
            'description' => Str::limit(strip_tags($event->description ?? ''), 150)
        ]
    ];
    if ($event->end_date) {
        $item['item']['endDate'] = $event->end_date->format('Y-m-d');
    }
    return $item;
});

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => 'UK & Pakistan Sale Calendar ' . $year,
    'description' => 'Complete sale calendar for UK and Pakistan shoppers',
    'numberOfItems' => $allEvents->count(),
    'itemListElement' => $schemaEvents
];
@endphp
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

{{-- SECTION A: Hero --}}
<div class="calendar-hero">
  <div class="container">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>›</span>
      <span style="color:#a1a1aa">Sale Calendar</span>
    </div>
    <h1>Sale Calendar {{ $year }}</h1>
    <p>Plan your shopping around UK & Pakistan's biggest sales. Never miss a deal again.</p>

    <div class="stats-row">
      <div class="stat-box">
        <div class="stat-num">{{ $stats['total_events'] }}+</div>
        <div class="stat-lbl">Sale Events</div>
      </div>
      <div class="stat-box">
        <div class="stat-num">{{ $stats['months'] }}</div>
        <div class="stat-lbl">Active Months</div>
      </div>
      <div class="stat-box">
        <div class="stat-num">{{ $stats['countries'] }}</div>
        <div class="stat-lbl">Countries</div>
      </div>
      <div class="stat-box">
        <div class="stat-num">{{ $stats['categories'] }}+</div>
        <div class="stat-lbl">Categories</div>
      </div>
    </div>
  </div>
</div>

{{-- SECTION B: Active/Upcoming Banner --}}
@if($activeEvents->isNotEmpty())
<div class="container">
  @foreach($activeEvents as $activeEvent)
  <div class="active-banner">
    <a href="{{ route('sale-calendar.show', $activeEvent->slug) }}" class="active-banner-content" style="text-decoration:none">
      <div class="pulse-dot"></div>
      <div class="active-banner-text">
        LIVE NOW: {{ $activeEvent->emoji }} {{ $activeEvent->name }}
        <span>— Ends in {{ $activeEvent->daysRemaining() }} day{{ $activeEvent->daysRemaining() > 1 ? 's' : '' }}</span>
      </div>
    </a>
    <a href="{{ route('sale-calendar.show', $activeEvent->slug) }}" class="btn btn-green">View Details →</a>
  </div>
  @endforeach
</div>
@endif

{{-- SECTION C: Upcoming Sales Cards --}}
@if($upcomingEvents->isNotEmpty())
<div class="section section-gray">
  <div class="container">
    <h2 class="section-title">Coming Up Next</h2>
    <p class="section-subtitle">Mark your calendar for these upcoming sales</p>

    <div class="upcoming-grid">
      @foreach($upcomingEvents as $event)
      <a href="{{ route('sale-calendar.show', $event->slug) }}" class="upcoming-card {{ $event->is_featured ? 'featured' : '' }}" style="text-decoration:none">
        <div class="upcoming-emoji">{{ $event->emoji }}</div>
        <div class="upcoming-name">{{ $event->name }}</div>
        <div class="upcoming-dates">{{ $event->short_date_range }}</div>
        <div class="upcoming-regions">
          {!! $event->region_badge !!}
        </div>
        <div class="upcoming-countdown">
          @if($event->daysUntil() === 1)
            Tomorrow!
          @elseif($event->daysUntil() <= 7)
            In {{ $event->daysUntil() }} days
          @else
            In {{ $event->daysUntil() }} days
          @endif
        </div>
        <div class="upcoming-categories">{{ $event->categories }}</div>
      </a>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- SECTION D: Sale Density Chart --}}
<div class="section">
  <div class="container">
    <h2 class="section-title">Sale Density by Month</h2>
    <p class="section-subtitle">Not all months are equal — plan your budget accordingly</p>

    <div class="density-chart">
      @foreach($monthDensity as $month => $data)
      <div class="density-row">
        <div class="density-month">{{ substr($month, 0, 3) }}</div>
        <div class="density-bar-wrap">
          <div class="density-bar {{ $data['level'] }}" style="width: {{ $data['percent'] }}%"></div>
        </div>
        <div class="density-label {{ $data['level'] }}">
          {{ $data['label'] }}
          @if($data['events'] > 0)
            ({{ $data['events'] }})
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- SECTION E: Full Year Table --}}
<div class="section section-gray">
  <div class="container">
    <h2 class="section-title">UK & Pakistan Sale Calendar {{ $year }}</h2>
    <p class="section-subtitle">All {{ $stats['total_events'] }} sale events for the year</p>

    <table class="events-table">
      <thead>
        <tr>
          <th>Month</th>
          <th>Event</th>
          <th>Date</th>
          <th>Region</th>
          <th>Categories</th>
        </tr>
      </thead>
      <tbody>
        @foreach($allEvents as $event)
        <tr class="{{ $event->is_featured ? 'featured' : '' }}">
          <td>{{ $event->month_name }}</td>
          <td>
            <a href="{{ route('sale-calendar.show', $event->slug) }}" class="event-name" style="text-decoration:none">
              <span class="event-emoji">{{ $event->emoji }}</span>
              {{ $event->name }}
              @if($event->is_featured)
                <span class="star">⭐</span>
              @endif
            </a>
          </td>
          <td>{{ $event->short_date_range }}</td>
          <td>{!! $event->region_badge !!}</td>
          <td>{{ $event->categories }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- SECTION F: Month by Month Guide --}}
<div class="section">
  <div class="container">
    <h2 class="section-title">Month by Month Shopping Guide</h2>
    <p class="section-subtitle">Detailed breakdown with tips for each month</p>

    @foreach($eventsByMonth as $month => $events)
    <div class="month-card">
      <div class="month-header">
        <h3>{{ $month }} {{ $year }}</h3>
        <div class="month-tags">
          @foreach($events as $event)
            @if($event->subtitle_tags)
              @foreach($event->subtitle_tags_array as $tag)
                <span class="month-tag">{{ $tag }}</span>
              @endforeach
            @endif
          @endforeach
        </div>
      </div>
      <div class="month-body">
        @php
          $monthDescription = $events->first()->description ?? '';
        @endphp
        @if($monthDescription)
          <p class="month-description">{{ $monthDescription }}</p>
        @endif

        <table class="month-table">
          <thead>
            <tr>
              <th>Event</th>
              <th>Date</th>
              <th>Region</th>
              <th>Categories</th>
            </tr>
          </thead>
          <tbody>
            @foreach($events as $event)
            <tr>
              <td style="font-weight:600">
                <a href="{{ route('sale-calendar.show', $event->slug) }}" style="color:inherit;text-decoration:none">
                  {{ $event->emoji }} {{ $event->name }}
                </a>
              </td>
              <td>{{ $event->short_date_range }}</td>
              <td>{!! $event->region_badge !!}</td>
              <td>{{ $event->categories }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

        @php
          $checklist = $events->first()->checklist ?? [];
          // Handle case where checklist is double-encoded JSON string
          if (is_string($checklist)) {
              $checklist = json_decode($checklist, true) ?? [];
          }
        @endphp
        @if(!empty($checklist) && is_array($checklist))
        <ul class="checklist">
          @foreach($checklist as $tip)
          <li>
            <span class="checklist-icon">✅</span>
            <span>{{ $tip }}</span>
          </li>
          @endforeach
        </ul>
        @endif
      </div>
    </div>
    @endforeach
  </div>
</div>

{{-- SECTION G: Best Time to Buy Table --}}
<div class="section section-gray">
  <div class="container">
    <h2 class="section-title">Best Time to Buy — UK & Pakistan</h2>
    <p class="section-subtitle">Optimize your shopping by category</p>

    <table class="best-table">
      <thead>
        <tr>
          <th>Category</th>
          <th>Best Month</th>
          <th>Why</th>
        </tr>
      </thead>
      <tbody>
        @foreach($bestTimeToBuy as $item)
        <tr>
          <td class="category">{{ $item['category'] }}</td>
          <td class="month">{{ $item['best_month'] }}</td>
          <td class="why">{{ $item['why'] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- SECTION H: FAQ --}}
<div class="section">
  <div class="container">
    <h2 class="section-title">Frequently Asked Questions</h2>
    <p class="section-subtitle">Quick answers about UK & Pakistan sales</p>

    <div class="faq-list">
      @foreach($faqs as $faq)
      <div class="faq-item">
        <div class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          <span>{{ $faq['question'] }}</span>
          <span class="faq-toggle">+</span>
        </div>
        <div class="faq-answer">
          {{ $faq['answer'] }}
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- SECTION I: CTA Bottom --}}
<div class="cta-section">
  <div class="container">
    <h2>Ready to Find Deals?</h2>
    <p>Browse verified coupons from 100+ UK & Pakistan stores</p>
    <a href="{{ route('stores.index') }}" class="btn btn-green" style="font-size:15px;padding:14px 36px">
      Browse All Stores →
    </a>
  </div>
</div>

@endsection
