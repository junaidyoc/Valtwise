<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo', 'website_url', 'description',
        'meta_title', 'meta_description', 'focus_keyword',
        // Enhanced SEO - Open Graph
        'og_title', 'og_description', 'og_image',
        // Enhanced SEO - Twitter
        'twitter_title', 'twitter_description', 'twitter_image',
        // Enhanced SEO - Technical
        'canonical_url', 'robots_index', 'robots_follow',
        'schema_type', 'sitemap_include', 'breadcrumb_enable',
        // Other fields
        'cashback_rate', 'is_featured', 'is_active',
        'affiliate_url_template', 'network',
        'commission_type', 'commission_rate', 'cpc_rate', 'cpa_rate',
    ];

    protected $casts = [
        'cashback_rate'     => 'decimal:2',
        'cpc_rate'          => 'decimal:4',
        'cpa_rate'          => 'decimal:2',
        'is_featured'       => 'boolean',
        'is_active'         => 'boolean',
        'sitemap_include'   => 'boolean',
        'breadcrumb_enable' => 'boolean',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function activeCoupons(): HasMany
    {
        return $this->hasMany(Coupon::class)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Build affiliate URL for a given destination URL.
     * Replaces {destination} in the template with the encoded URL.
     */
    public function buildAffiliateUrl(string $destination): string
    {
        if (! $this->affiliate_url_template) {
            return $destination;
        }

        return str_replace(
            '{destination}',
            urlencode($destination),
            $this->affiliate_url_template
        );
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }

        return $this->logo
            ? asset('storage/' . $this->logo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=f3f4f6&color=374151&size=80';
    }

    public function getActiveCouponCountAttribute(): int
    {
        return $this->activeCoupons()->count();
    }

    /**
     * Get formatted commission display string
     */
    public function getCommissionDisplayAttribute(): string
    {
        $parts = [];

        if ($this->commission_type === 'cpc' || $this->commission_type === 'both') {
            if ($this->cpc_rate) {
                $parts[] = '$' . number_format($this->cpc_rate, 2) . ' CPC';
            }
        }

        if ($this->commission_type === 'cpa' || $this->commission_type === 'both') {
            if ($this->cpa_rate) {
                $parts[] = $this->cpa_rate . '% CPA';
            }
        }

        return implode(' + ', $parts) ?: ($this->commission_rate ?? 'N/A');
    }

    /**
     * Check if store has CPC commission
     */
    public function hasCpc(): bool
    {
        return in_array($this->commission_type, ['cpc', 'both']);
    }

    /**
     * Check if store has CPA commission
     */
    public function hasCpa(): bool
    {
        return in_array($this->commission_type, ['cpa', 'both']);
    }

    // ─── SEO Helpers ─────────────────────────────────────────────────────────

    /**
     * Get SEO title (custom or auto-generated)
     */
    public function getSeoTitleAttribute(): string
    {
        if ($this->meta_title) {
            return $this->meta_title;
        }
        return $this->name . ' Coupons & Promo Codes ' . date('F Y') . ' — Valtwise';
    }

    /**
     * Get SEO description (custom or auto-generated)
     */
    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        $couponCount = $this->activeCoupons()->count();
        return "Find the latest {$this->name} coupon codes and deals. {$couponCount} active discounts verified today. Save money with exclusive {$this->name} promo codes.";
    }

    /**
     * Get SEO keywords
     */
    public function getSeoKeywordsAttribute(): string
    {
        if ($this->focus_keyword) {
            return "{$this->focus_keyword}, {$this->name} coupon codes, {$this->name} promo codes, {$this->name} deals";
        }
        return "{$this->name} coupon codes, {$this->name} promo codes, {$this->name} discount codes, {$this->name} deals, {$this->name} vouchers";
    }

    /**
     * Get OG title (custom or fallback to SEO title)
     */
    public function getSeoOgTitleAttribute(): string
    {
        return $this->og_title ?: $this->seo_title;
    }

    /**
     * Get OG description (custom or fallback to SEO description)
     */
    public function getSeoOgDescriptionAttribute(): string
    {
        return $this->og_description ?: $this->seo_description;
    }

    /**
     * Get OG image (custom or fallback to logo or default)
     */
    public function getSeoOgImageAttribute(): string
    {
        if ($this->og_image) {
            return $this->og_image;
        }
        if ($this->logo && str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }
        return SeoSetting::get('default_og_image', asset('images/og-default.jpg'));
    }

    /**
     * Get Twitter title (custom or fallback to OG title)
     */
    public function getSeoTwitterTitleAttribute(): string
    {
        return $this->twitter_title ?: $this->seo_og_title;
    }

    /**
     * Get Twitter description (custom or fallback to OG description)
     */
    public function getSeoTwitterDescriptionAttribute(): string
    {
        return $this->twitter_description ?: $this->seo_og_description;
    }

    /**
     * Get Twitter image (custom or fallback to OG image)
     */
    public function getSeoTwitterImageAttribute(): string
    {
        return $this->twitter_image ?: $this->seo_og_image;
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
     * Get canonical URL (custom or auto-generated)
     */
    public function getSeoCanonicalAttribute(): string
    {
        return $this->canonical_url ?: route('stores.show', $this->slug);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
