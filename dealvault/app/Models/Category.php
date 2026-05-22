<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'description'];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class);
    }

    public function activeStores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class)->where('is_active', true);
    }
}
