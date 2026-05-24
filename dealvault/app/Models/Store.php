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
        'commission_type', 'commission_rate', 'cpc_rate', 'cpa_rate',
    ];

    protected $casts = [
        'cashback_rate' => 'decimal:2',
        'cpc_rate'      => 'decimal:4',
        'cpa_rate'      => 'decimal:2',
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
