# Sale Calendar Feature - Implementation Summary

## Overview
Complete Sale Calendar feature for Valtwise — a Laravel 11 + Blade coupon site targeting UK and Pakistan audiences. Reference: couponzania.com/sale-calendar

## Tech Stack
- Laravel 11, Blade templates, MySQL, Custom CSS
- CSS Variables: `--dark`, `--green`, `--green-light`, `--white`, `--gray-1`, `--gray-2`, `--radius-lg`, `--radius-md`

---

## Files Created/Modified

### 1. Migration
**File:** `dealvault/database/migrations/2024_01_03_000001_create_sale_events_table.php`

**Fields:**
- `id`, `name`, `slug` (unique), `emoji`, `subtitle_tags`
- `event_date` (date), `end_date` (date, nullable)
- `region` (enum: uk, pk, global)
- `description` (longtext), `categories` (string)
- `checklist` (JSON), `event_table` (JSON)
- `density` (enum: low, medium, high, peak)
- `is_featured`, `is_active` (boolean), `sort_order` (int)
- Indexes on: event_date, end_date, region, is_active, is_featured

### 2. Model
**File:** `dealvault/app/Models/SaleEvent.php`

**Casts:**
```php
'event_date' => 'date',
'end_date' => 'date',
'checklist' => 'array',
'event_table' => 'array',
'is_featured' => 'boolean',
'is_active' => 'boolean',
```

**Helper Methods:**
- `isActive()` - Check if event is currently running
- `isUpcoming()` - Check if event is in future
- `isPast()` - Check if event has ended
- `daysUntil()` - Days until event starts
- `daysRemaining()` - Days left for active event

**Accessors:**
- `status` - Returns 'active'/'upcoming'/'past'
- `region_badge` - HTML badge with flag emoji
- `region_emoji` - Just the emoji
- `density_percent` - For chart (25/50/75/100)
- `date_range`, `short_date_range` - Formatted dates
- `month_name`, `month_year`
- `categories_array`, `subtitle_tags_array`

**Scopes:**
- `scopeUpcoming()`, `scopeCurrentlyActive()`
- `scopeByRegion($region)`, `scopeUkOrGlobal()`, `scopePkOrGlobal()`
- `scopeFeatured()`, `scopeActive()`
- `scopeByYear($year)`, `scopeByMonth($month)`
- `scopeOrderByDate($direction)`

### 3. Controller
**File:** `dealvault/app/Http/Controllers/SaleCalendarController.php`

**`index()` method returns:**
- `$allEvents` - All active events for year, ordered by date
- `$eventsByMonth` - Grouped by month name
- `$activeEvents` - Currently running events
- `$upcomingEvents` - Next 3 upcoming
- `$featuredEvents` - Featured events
- `$monthDensity` - Density per month for chart
- `$stats` - total_events, months, countries, categories
- `$bestTimeToBuy` - Category recommendations
- `$faqs` - FAQ data array
- `$year` - Current year

### 4. Blade View
**File:** `dealvault/resources/views/pages/sale-calendar.blade.php`

**Sections:**
- **A: Hero** - Dark background, breadcrumb, H1, subtitle, 4 stat boxes
- **B: Active Banner** - Green pulsing "LIVE NOW" banner for active events
- **C: Upcoming Cards** - Next 3 events as cards with countdown
- **D: Density Chart** - CSS-only horizontal bar chart by month
- **E: Full Year Table** - All events with month, name, date, region, categories
- **F: Month Guide** - Expandable cards with description, event table, checklist
- **G: Best Time to Buy** - Category/month/why table
- **H: FAQ Accordion** - Expandable Q&A
- **I: CTA Bottom** - Dark section with "Browse All Stores" button

**SEO:**
- JSON-LD ItemList schema with Event items
- Meta title and description

**Important Fix:** Checklist handles double-encoded JSON:
```php
@php
  $checklist = $events->first()->checklist ?? [];
  if (is_string($checklist)) {
      $checklist = json_decode($checklist, true) ?? [];
  }
@endphp
```

### 5. Seeder
**File:** `dealvault/database/seeders/SaleEventSeeder.php`

**18 Events (2026):**
1. January Sales (UK) - High
2. Valentine's Day (Global) - Medium
3. Ramadan Sale (PK) - High
4. Women's Day (Global) - Medium
5. Eid ul Fitr (PK) - Peak ⭐
6. Easter Sale (UK) - Medium
7. Mother's Day (Global) - Medium
8. Eid ul Adha (PK) - High
9. Father's Day (Global) - Medium
10. Summer Sale (UK) - High
11. Amazon Prime Day (Global) - High
12. Back to School (UK) - Medium
13. Independence Day (PK) - Medium
14. Halloween (UK) - Medium
15. Black Friday (Global) - Peak ⭐
16. Cyber Monday (Global) - Peak
17. Christmas Sale (UK) - Peak
18. Boxing Day (UK) - Peak ⭐

**Important:** Do NOT use `json_encode()` in seeder - model casts handle it automatically.

### 6. Route
**File:** `dealvault/routes/web.php`

```php
use App\Http\Controllers\SaleCalendarController;

Route::get('/sale-calendar', [SaleCalendarController::class, 'index'])->name('sale-calendar');
```

### 7. Footer Link
**File:** `dealvault/resources/views/layouts/app.blade.php`

Added to Browse section:
```html
<a href="{{ route('sale-calendar') }}">Sale Calendar</a>
```

### 8. DatabaseSeeder
**File:** `dealvault/database/seeders/DatabaseSeeder.php`

Added at end of `run()`:
```php
$this->call(SaleEventSeeder::class);
```

---

## Deployment Commands

```bash
cd dealvault
php artisan migrate
php artisan db:seed --class=SaleEventSeeder
```

**To reset data (if needed):**
```bash
php artisan tinker
>>> DB::table('sale_events')->truncate();
>>> exit
php artisan db:seed --class=SaleEventSeeder
```

---

## Design System

**Region Badges:**
- UK: `background:#dcfce7; color:#166534` (green)
- PK: `background:#fef3c7; color:#92400e` (amber)
- Global: `background:#dbeafe; color:#1e40af` (blue)

**Density Colors:**
- Peak: `var(--green)` (100%)
- High: `#22c55e` (75%)
- Medium: `var(--green-light)` (50%)
- Low: `var(--gray-2)` (25%)

**Featured Events:** Green left border, highlighted rows

---

## URL
`/sale-calendar` → `sale-calendar` route name
