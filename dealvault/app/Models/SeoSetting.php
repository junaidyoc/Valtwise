<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SeoSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key with optional default
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("seo_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("seo_setting_{$key}");
    }

    /**
     * Get all settings as key-value array
     */
    public static function allSettings(): array
    {
        return Cache::remember('seo_settings_all', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        Cache::forget('seo_settings_all');
        // Clear individual keys
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("seo_setting_{$key}");
        }
    }
}
