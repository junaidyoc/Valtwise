<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get posts in this category
     */
    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }

    /**
     * Get published posts count
     */
    public function publishedPosts(): HasMany
    {
        return $this->posts()->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /**
     * Scope: Active categories only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
