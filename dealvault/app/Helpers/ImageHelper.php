<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Convert image to WebP format
     * Returns the WebP URL if successful, original URL otherwise
     */
    public static function toWebP(string $imagePath, int $quality = 80): ?string
    {
        // Skip if already WebP or external URL
        if (Str::endsWith($imagePath, '.webp') || Str::startsWith($imagePath, ['http://', 'https://'])) {
            return $imagePath;
        }

        // Get the full path
        $publicPath = public_path($imagePath);

        if (!file_exists($publicPath)) {
            return $imagePath;
        }

        // Create WebP path
        $webpPath = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $publicPath);
        $webpUrl = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $imagePath);

        // Return existing WebP if already converted
        if (file_exists($webpPath)) {
            return $webpUrl;
        }

        // Check if GD extension is loaded
        if (!extension_loaded('gd')) {
            return $imagePath;
        }

        // Get image info
        $imageInfo = @getimagesize($publicPath);
        if (!$imageInfo) {
            return $imagePath;
        }

        // Create image resource based on type
        $sourceImage = match($imageInfo[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($publicPath),
            IMAGETYPE_PNG => @imagecreatefrompng($publicPath),
            IMAGETYPE_GIF => @imagecreatefromgif($publicPath),
            default => null
        };

        if (!$sourceImage) {
            return $imagePath;
        }

        // Handle PNG transparency
        if ($imageInfo[2] === IMAGETYPE_PNG) {
            imagepalettetotruecolor($sourceImage);
            imagealphablending($sourceImage, true);
            imagesavealpha($sourceImage, true);
        }

        // Convert to WebP
        $success = @imagewebp($sourceImage, $webpPath, $quality);
        imagedestroy($sourceImage);

        return $success ? $webpUrl : $imagePath;
    }

    /**
     * Generate srcset for responsive images
     */
    public static function generateSrcSet(string $imagePath, array $sizes = [320, 640, 960, 1280]): string
    {
        $srcset = [];

        foreach ($sizes as $width) {
            $srcset[] = self::getResizedUrl($imagePath, $width) . " {$width}w";
        }

        return implode(', ', $srcset);
    }

    /**
     * Get resized image URL (placeholder for future CDN integration)
     */
    public static function getResizedUrl(string $imagePath, int $width): string
    {
        // For now, return original. In production, integrate with CDN
        // Example with imgix: "https://your-domain.imgix.net/{$imagePath}?w={$width}&auto=format"
        return $imagePath;
    }

    /**
     * Optimize and compress an uploaded image
     */
    public static function optimize(string $path, int $maxWidth = 1200, int $quality = 85): bool
    {
        if (!file_exists($path)) {
            return false;
        }

        $imageInfo = @getimagesize($path);
        if (!$imageInfo) {
            return false;
        }

        list($width, $height, $type) = $imageInfo;

        // Skip if already small enough
        if ($width <= $maxWidth) {
            return true;
        }

        // Calculate new dimensions
        $ratio = $maxWidth / $width;
        $newWidth = $maxWidth;
        $newHeight = (int) ($height * $ratio);

        // Create image resource
        $sourceImage = match($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG => @imagecreatefrompng($path),
            IMAGETYPE_GIF => @imagecreatefromgif($path),
            default => null
        };

        if (!$sourceImage) {
            return false;
        }

        // Create resized image
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Handle PNG/GIF transparency
        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resize
        imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save
        $success = match($type) {
            IMAGETYPE_JPEG => imagejpeg($resizedImage, $path, $quality),
            IMAGETYPE_PNG => imagepng($resizedImage, $path, 9 - (int)($quality / 11)),
            IMAGETYPE_GIF => imagegif($resizedImage, $path),
            default => false
        };

        imagedestroy($sourceImage);
        imagedestroy($resizedImage);

        return $success;
    }
}
