<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        // Core
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'category_id',

        // SEO
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

        // Publishing
        'is_published',
        'is_featured',
        'published_at',
        'views',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'sitemap_include' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $slug)
    {
        return $query->whereHas('category', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Get featured image URL with fallback
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            if (str_starts_with($this->featured_image, 'http')) {
                return $this->featured_image;
            }
            return asset('storage/' . $this->featured_image);
        }

        // Placeholder image based on title
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->title) . '&background=16a34a&color=ffffff&size=600&font-size=0.33';
    }

    /**
     * Calculate estimated read time
     */
    public function getReadTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average reading speed
        return max(1, $minutes);
    }

    /**
     * Get short excerpt
     */
    public function getShortExcerptAttribute(): string
    {
        if ($this->excerpt) {
            return Str::limit($this->excerpt, 120);
        }
        return Str::limit(strip_tags($this->content), 120);
    }

    // ─── SEO Accessors ─────────────────────────────────────────────────────────

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: $this->title . ' — Valtwise Blog';
    }

    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        if ($this->excerpt) {
            return Str::limit($this->excerpt, 155);
        }
        return Str::limit(strip_tags($this->content), 155);
    }

    public function getSeoKeywordsAttribute(): string
    {
        return $this->focus_keyword ?: '';
    }

    public function getSeoOgTitleAttribute(): string
    {
        return $this->og_title ?: $this->seo_title;
    }

    public function getSeoOgDescriptionAttribute(): string
    {
        return $this->og_description ?: $this->seo_description;
    }

    public function getSeoOgImageAttribute(): string
    {
        return $this->og_image ?: $this->featured_image_url;
    }

    public function getSeoRobotsAttribute(): string
    {
        $index = $this->robots_index ?? 'index';
        $follow = $this->robots_follow ?? 'follow';
        return "{$index}, {$follow}";
    }

    public function getSeoCanonicalAttribute(): string
    {
        return $this->canonical_url ?: route('blog.show', $this->slug);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Increment view count
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Get formatted published date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->published_at?->format('M d, Y') ?? $this->created_at->format('M d, Y');
    }

    /**
     * Check if post is draft
     */
    public function getIsDraftAttribute(): bool
    {
        return !$this->is_published || !$this->published_at || $this->published_at->isFuture();
    }
}
