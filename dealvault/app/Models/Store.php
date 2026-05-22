<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo', 'website_url', 'description',
        'cashback_rate', 'is_featured', 'is_active',
        'affiliate_url_template', 'network',
    ];

    protected $casts = [
        'cashback_rate' => 'decimal:2',
        'is_featured'   => 'boolean',
        'is_active'     => 'boolean',
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
