<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'icon', 'description', 'parent_id',
        'meta_title', 'meta_description', 'focus_keyword',
        // Enhanced SEO - Open Graph
        'og_title', 'og_description', 'og_image',
        // Enhanced SEO - Twitter
        'twitter_title', 'twitter_description', 'twitter_image',
        // Enhanced SEO - Technical
        'canonical_url', 'robots_index', 'robots_follow',
        'schema_type', 'sitemap_include', 'breadcrumb_enable',
    ];

    protected $casts = [
        'sitemap_include'   => 'boolean',
        'breadcrumb_enable' => 'boolean',
    ];

    /**
     * Parent category relationship
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Child categories (subcategories)
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all descendants (children, grandchildren, etc.)
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    /**
     * Check if this is a parent category (has no parent)
     */
    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if this is a subcategory (has a parent)
     */
    public function isChild(): bool
    {
        return !is_null($this->parent_id);
    }

    /**
     * Scope: Only parent categories
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope: Only subcategories
     */
    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class);
    }

    public function activeStores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class)->where('is_active', true);
    }

    /**
     * Get all stores from this category and its subcategories
     */
    public function allActiveStores()
    {
        $categoryIds = collect([$this->id]);

        // Add all child category IDs
        $children = $this->children()->pluck('id');
        $categoryIds = $categoryIds->merge($children);

        return Store::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })->where('is_active', true);
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
        return $this->name . ' Coupons & Deals ' . date('F Y') . ' — Valtwise';
    }

    /**
     * Get SEO description (custom or auto-generated)
     */
    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        $storeCount = $this->allActiveStores()->count();
        return "Browse {$storeCount} stores with {$this->name} coupons and deals. Find verified discount codes and save money on {$this->name} products.";
    }

    /**
     * Get SEO keywords
     */
    public function getSeoKeywordsAttribute(): string
    {
        if ($this->focus_keyword) {
            return "{$this->focus_keyword}, {$this->name} coupons, {$this->name} deals, {$this->name} discount codes";
        }
        return "{$this->name} coupons, {$this->name} deals, {$this->name} discount codes, {$this->name} promo codes";
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
     * Get OG image (custom or fallback to default)
     */
    public function getSeoOgImageAttribute(): string
    {
        return $this->og_image ?: SeoSetting::get('default_og_image', asset('images/og-default.jpg'));
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
        return $this->canonical_url ?: route('categories.show', $this->slug);
    }
}
