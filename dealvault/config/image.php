<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image CDN Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your image CDN for faster delivery. Popular options include:
    | - Cloudflare Images (cloudflare)
    | - Cloudinary (cloudinary)
    | - imgix (imgix)
    | - Bunny CDN (bunny)
    | - None/Local (null)
    |
    */

    'cdn' => [
        // Enable/disable CDN (set to true when CDN is configured)
        'enabled' => env('IMAGE_CDN_ENABLED', false),

        // CDN provider: 'cloudflare', 'cloudinary', 'imgix', 'bunny', or null
        'provider' => env('IMAGE_CDN_PROVIDER', null),

        // Base URL for CDN-served images
        'base_url' => env('IMAGE_CDN_URL', ''),

        // Account/Zone ID (for Cloudflare, Cloudinary, etc.)
        'account_id' => env('IMAGE_CDN_ACCOUNT_ID', ''),

        // API Key (for upload/management APIs)
        'api_key' => env('IMAGE_CDN_API_KEY', ''),

        // Secret Key (for signed URLs if required)
        'secret_key' => env('IMAGE_CDN_SECRET_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Optimization Settings
    |--------------------------------------------------------------------------
    */

    'optimization' => [
        // Default quality for JPEG/WebP compression (1-100)
        'quality' => env('IMAGE_QUALITY', 80),

        // Maximum width for uploaded images
        'max_width' => env('IMAGE_MAX_WIDTH', 1200),

        // Maximum height for uploaded images
        'max_height' => env('IMAGE_MAX_HEIGHT', 1200),

        // Auto-convert to WebP when possible
        'auto_webp' => env('IMAGE_AUTO_WEBP', true),

        // Strip EXIF data from uploaded images
        'strip_exif' => env('IMAGE_STRIP_EXIF', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Store Logo Settings
    |--------------------------------------------------------------------------
    */

    'store_logo' => [
        'width' => 200,
        'height' => 200,
        'quality' => 85,
    ],

    /*
    |--------------------------------------------------------------------------
    | CDN URL Transformation Examples
    |--------------------------------------------------------------------------
    |
    | When CDN is enabled, images will be served through the CDN with
    | automatic optimization. Examples:
    |
    | Cloudflare:
    |   https://imagedelivery.net/{account_id}/{image_id}/public
    |
    | Cloudinary:
    |   https://res.cloudinary.com/{cloud_name}/image/upload/f_auto,q_auto/{path}
    |
    | imgix:
    |   https://{subdomain}.imgix.net/{path}?auto=format,compress
    |
    | Bunny CDN:
    |   https://{pullzone}.b-cdn.net/{path}?width=200&quality=80
    |
    */

];
