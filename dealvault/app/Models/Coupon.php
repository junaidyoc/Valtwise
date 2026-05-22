<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'store_id', 'title', 'description', 'code', 'type',
        'discount_value', 'destination_url', 'is_verified',
        'is_exclusive', 'is_active', 'click_count', 'expires_at',
    ];

    protected $casts = [
        'is_verified'  => 'boolean',
        'is_exclusive' => 'boolean',
        'is_active'    => 'boolean',
        'expires_at'   => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function expiresInDays(): ?int
    {
        if (! $this->expires_at) return null;
        return max(0, now()->diffInDays($this->expires_at, false));
    }

    public function getExpiryLabelAttribute(): string
    {
        if (! $this->expires_at) return 'No expiry';
        if ($this->isExpired()) return 'Expired';
        $days = $this->expiresInDays();
        if ($days === 0) return 'Expires today';
        if ($days === 1) return 'Expires tomorrow';
        return "Expires in {$days} days";
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}
