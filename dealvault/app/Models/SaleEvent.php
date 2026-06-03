<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class SaleEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'emoji',
        'subtitle_tags',
        'event_date',
        'end_date',
        'region',
        'description',
        'categories',
        'checklist',
        'event_table',
        'density',
        'is_featured',
        'is_active',
        'sort_order',
        // SEO Fields
        'meta_title',
        'meta_description',
        'focus_keyword',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'robots_index',
        'robots_follow',
        'sitemap_include',
    ];

    protected $casts = [
        'event_date' => 'date',
        'end_date' => 'date',
        'checklist' => 'array',
        'event_table' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sitemap_include' => 'boolean',
    ];

    // ══════════════════════════════════════════════════════════════════════════
    // SEO ACCESSORS
    // ══════════════════════════════════════════════════════════════════════════

    /**
     * Get SEO title (custom or auto-generated)
     */
    public function getSeoTitleAttribute(): string
    {
        if ($this->meta_title) {
            return $this->meta_title;
        }

        $year = $this->event_date->format('Y');
        $region = $this->region === 'uk' ? 'UK' : ($this->region === 'pk' ? 'Pakistan' : '');

        return "{$this->name} {$year} {$region} — Best Deals & Sales | Valtwise";
    }

    /**
     * Get SEO description (custom or auto-generated)
     */
    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }

        $dateStr = $this->date_range;
        return "Don't miss {$this->name} {$dateStr}! Find the best deals, discounts, and verified coupon codes. Prepare your shopping list with Valtwise.";
    }

    /**
     * Get SEO keywords
     */
    public function getSeoKeywordsAttribute(): string
    {
        $keywords = [
            strtolower($this->name),
            strtolower($this->name) . ' deals',
            strtolower($this->name) . ' ' . $this->event_date->format('Y'),
            strtolower($this->name) . ' sales',
        ];

        if ($this->region === 'uk') {
            $keywords[] = strtolower($this->name) . ' uk';
        } elseif ($this->region === 'pk') {
            $keywords[] = strtolower($this->name) . ' pakistan';
        }

        if ($this->categories) {
            foreach ($this->categories_array as $cat) {
                $keywords[] = strtolower($this->name) . ' ' . strtolower($cat);
            }
        }

        return implode(', ', array_unique($keywords));
    }

    /**
     * Get OG title with fallback
     */
    public function getSeoOgTitleAttribute(): ?string
    {
        return $this->og_title ?: $this->meta_title;
    }

    /**
     * Get OG description with fallback
     */
    public function getSeoOgDescriptionAttribute(): ?string
    {
        return $this->og_description ?: $this->meta_description;
    }

    /**
     * Get OG image with fallback
     */
    public function getSeoOgImageAttribute(): ?string
    {
        return $this->og_image;
    }

    /**
     * Get robots directive
     */
    public function getSeoRobotsAttribute(): string
    {
        $index = $this->robots_index ?? 'index';
        $follow = $this->robots_follow ?? 'follow';
        return "{$index}, {$follow}";
    }

    /**
     * Get canonical URL
     */
    public function getSeoCanonicalAttribute(): string
    {
        return $this->canonical_url ?: route('sale-calendar.show', $this->slug);
    }

    /**
     * Check if event is currently active (running now)
     */
    public function isActive(): bool
    {
        $now = Carbon::now()->startOfDay();
        $start = $this->event_date;
        $end = $this->end_date ?? $this->event_date;

        return $now->between($start, $end->endOfDay());
    }

    /**
     * Check if event is upcoming
     */
    public function isUpcoming(): bool
    {
        return $this->event_date->isFuture();
    }

    /**
     * Check if event is past
     */
    public function isPast(): bool
    {
        $end = $this->end_date ?? $this->event_date;
        return $end->isPast();
    }

    /**
     * Get days until event starts
     */
    public function daysUntil(): int
    {
        if ($this->isActive()) {
            return 0;
        }

        if ($this->isPast()) {
            return -1;
        }

        return Carbon::now()->startOfDay()->diffInDays($this->event_date, false);
    }

    /**
     * Get days remaining for active event
     */
    public function daysRemaining(): int
    {
        if (!$this->isActive()) {
            return 0;
        }

        $end = $this->end_date ?? $this->event_date;
        return Carbon::now()->startOfDay()->diffInDays($end, false) + 1;
    }

    /**
     * Get event status
     */
    public function getStatusAttribute(): string
    {
        if ($this->isActive()) {
            return 'active';
        }

        if ($this->isUpcoming()) {
            return 'upcoming';
        }

        return 'past';
    }

    /**
     * Get region badge HTML
     */
    public function getRegionBadgeAttribute(): string
    {
        return match($this->region) {
            'uk' => '<span class="region-badge region-uk">🇬🇧 UK</span>',
            'pk' => '<span class="region-badge region-pk">🇵🇰 PK</span>',
            'global' => '<span class="region-badge region-global">🌍 Global</span>',
            default => '',
        };
    }

    /**
     * Get region emoji only
     */
    public function getRegionEmojiAttribute(): string
    {
        return match($this->region) {
            'uk' => '🇬🇧',
            'pk' => '🇵🇰',
            'global' => '🌍',
            default => '',
        };
    }

    /**
     * Get density percentage for chart
     */
    public function getDensityPercentAttribute(): int
    {
        return match($this->density) {
            'low' => 25,
            'medium' => 50,
            'high' => 75,
            'peak' => 100,
            default => 50,
        };
    }

    /**
     * Get density label
     */
    public function getDensityLabelAttribute(): string
    {
        return match($this->density) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'peak' => 'Peak',
            default => 'Medium',
        };
    }

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute(): string
    {
        if ($this->end_date && !$this->event_date->eq($this->end_date)) {
            if ($this->event_date->month === $this->end_date->month) {
                return $this->event_date->format('M j') . ' — ' . $this->end_date->format('j, Y');
            }
            return $this->event_date->format('M j') . ' — ' . $this->end_date->format('M j, Y');
        }

        return $this->event_date->format('M j, Y');
    }

    /**
     * Get short date range
     */
    public function getShortDateRangeAttribute(): string
    {
        if ($this->end_date && !$this->event_date->eq($this->end_date)) {
            if ($this->event_date->month === $this->end_date->month) {
                return $this->event_date->format('M j') . ' — ' . $this->end_date->format('j');
            }
            return $this->event_date->format('M j') . ' — ' . $this->end_date->format('M j');
        }

        return $this->event_date->format('M j');
    }

    /**
     * Get month name
     */
    public function getMonthNameAttribute(): string
    {
        return $this->event_date->format('F');
    }

    /**
     * Get month year
     */
    public function getMonthYearAttribute(): string
    {
        return $this->event_date->format('F Y');
    }

    /**
     * Get categories as array
     */
    public function getCategoriesArrayAttribute(): array
    {
        if (empty($this->categories)) {
            return [];
        }

        return array_map('trim', explode(',', $this->categories));
    }

    /**
     * Get subtitle tags as array
     */
    public function getSubtitleTagsArrayAttribute(): array
    {
        if (empty($this->subtitle_tags)) {
            return [];
        }

        return array_map('trim', explode(',', $this->subtitle_tags));
    }

    /**
     * Scope: Upcoming events
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('event_date', '>', Carbon::now()->startOfDay())
                     ->where('is_active', true)
                     ->orderBy('event_date', 'asc');
    }

    /**
     * Scope: Currently active events (running now)
     */
    public function scopeCurrentlyActive(Builder $query): Builder
    {
        $now = Carbon::now()->startOfDay();

        return $query->where('is_active', true)
                     ->where('event_date', '<=', $now)
                     ->where(function ($q) use ($now) {
                         $q->whereNull('end_date')
                           ->orWhere('end_date', '>=', $now);
                     });
    }

    /**
     * Scope: By region
     */
    public function scopeByRegion(Builder $query, string $region): Builder
    {
        return $query->where('region', $region);
    }

    /**
     * Scope: UK or Global events
     */
    public function scopeUkOrGlobal(Builder $query): Builder
    {
        return $query->whereIn('region', ['uk', 'global']);
    }

    /**
     * Scope: PK or Global events
     */
    public function scopePkOrGlobal(Builder $query): Builder
    {
        return $query->whereIn('region', ['pk', 'global']);
    }

    /**
     * Scope: Featured events
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Active (not disabled)
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: By year
     */
    public function scopeByYear(Builder $query, int $year): Builder
    {
        return $query->whereYear('event_date', $year);
    }

    /**
     * Scope: By month
     */
    public function scopeByMonth(Builder $query, int $month): Builder
    {
        return $query->whereMonth('event_date', $month);
    }

    /**
     * Scope: Order by date
     */
    public function scopeOrderByDate(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('event_date', $direction)
                     ->orderBy('sort_order', 'asc');
    }
}
