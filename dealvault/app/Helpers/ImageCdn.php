<?php

namespace App\Helpers;

class ImageCdn
{
    /**
     * Get the CDN URL for an image
     * Falls back to local URL if CDN is not enabled
     */
    public static function url(string $path, array $options = []): string
    {
        // Check if CDN is enabled
        if (!config('image.cdn.enabled')) {
            return self::localUrl($path);
        }

        $provider = config('image.cdn.provider');
        $baseUrl = config('image.cdn.base_url');

        return match ($provider) {
            'cloudflare' => self::cloudflareUrl($path, $options),
            'cloudinary' => self::cloudinaryUrl($path, $options),
            'imgix' => self::imgixUrl($path, $options),
            'bunny' => self::bunnyUrl($path, $options),
            default => self::localUrl($path),
        };
    }

    /**
     * Local asset URL (fallback)
     */
    protected static function localUrl(string $path): string
    {
        // Clean up path
        $path = ltrim($path, '/');

        // If already an absolute URL, return as-is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset($path);
    }

    /**
     * Cloudflare Images URL
     */
    protected static function cloudflareUrl(string $path, array $options): string
    {
        $baseUrl = config('image.cdn.base_url');
        $accountId = config('image.cdn.account_id');

        // Build variant string
        $variant = $options['variant'] ?? 'public';

        // Format: https://imagedelivery.net/{account_hash}/{image_id}/{variant}
        return "{$baseUrl}/{$accountId}/{$path}/{$variant}";
    }

    /**
     * Cloudinary URL with automatic optimization
     */
    protected static function cloudinaryUrl(string $path, array $options): string
    {
        $baseUrl = config('image.cdn.base_url');

        // Build transformation string
        $transforms = ['f_auto', 'q_auto'];

        if (isset($options['width'])) {
            $transforms[] = "w_{$options['width']}";
        }
        if (isset($options['height'])) {
            $transforms[] = "h_{$options['height']}";
        }
        if (isset($options['crop'])) {
            $transforms[] = "c_{$options['crop']}";
        }

        $transformString = implode(',', $transforms);

        // Format: https://res.cloudinary.com/{cloud_name}/image/upload/{transforms}/{path}
        return "{$baseUrl}/image/upload/{$transformString}/{$path}";
    }

    /**
     * imgix URL with automatic format
     */
    protected static function imgixUrl(string $path, array $options): string
    {
        $baseUrl = config('image.cdn.base_url');

        // Build query params
        $params = ['auto' => 'format,compress'];

        if (isset($options['width'])) {
            $params['w'] = $options['width'];
        }
        if (isset($options['height'])) {
            $params['h'] = $options['height'];
        }
        if (isset($options['quality'])) {
            $params['q'] = $options['quality'];
        }
        if (isset($options['fit'])) {
            $params['fit'] = $options['fit'];
        }

        $query = http_build_query($params);

        return "{$baseUrl}/{$path}?{$query}";
    }

    /**
     * Bunny CDN URL
     */
    protected static function bunnyUrl(string $path, array $options): string
    {
        $baseUrl = config('image.cdn.base_url');

        // Build query params
        $params = [];

        if (isset($options['width'])) {
            $params['width'] = $options['width'];
        }
        if (isset($options['height'])) {
            $params['height'] = $options['height'];
        }
        if (isset($options['quality'])) {
            $params['quality'] = $options['quality'];
        }

        $query = $params ? '?' . http_build_query($params) : '';

        return "{$baseUrl}/{$path}{$query}";
    }

    /**
     * Get responsive srcset for an image
     */
    public static function srcset(string $path, array $widths = [320, 640, 960, 1280]): string
    {
        $srcset = [];

        foreach ($widths as $width) {
            $url = self::url($path, ['width' => $width]);
            $srcset[] = "{$url} {$width}w";
        }

        return implode(', ', $srcset);
    }

    /**
     * Get optimized store logo URL
     */
    public static function storeLogo(string $path): string
    {
        return self::url($path, [
            'width' => config('image.store_logo.width', 200),
            'height' => config('image.store_logo.height', 200),
            'quality' => config('image.store_logo.quality', 85),
            'fit' => 'contain',
        ]);
    }
}
