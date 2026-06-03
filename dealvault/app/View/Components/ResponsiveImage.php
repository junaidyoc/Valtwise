<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Helpers\ImageHelper;

class ResponsiveImage extends Component
{
    public string $src;
    public string $alt;
    public ?int $width;
    public ?int $height;
    public string $class;
    public string $loading;
    public ?string $webpSrc;
    public ?string $fallbackSrc;

    public function __construct(
        string $src,
        string $alt = '',
        ?int $width = null,
        ?int $height = null,
        string $class = '',
        string $loading = 'lazy'
    ) {
        $this->src = $src;
        $this->alt = $alt;
        $this->width = $width;
        $this->height = $height;
        $this->class = $class;
        $this->loading = $loading;

        // Try to get WebP version
        $this->webpSrc = $this->getWebPUrl($src);
        $this->fallbackSrc = $this->getFallbackUrl($src);
    }

    protected function getWebPUrl(string $src): ?string
    {
        // For external URLs, return null (no WebP conversion)
        if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
            return null;
        }

        // Check if WebP version exists
        $webpPath = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $src);

        if (file_exists(public_path($webpPath))) {
            return asset($webpPath);
        }

        return null;
    }

    protected function getFallbackUrl(string $src): string
    {
        if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
            return $src;
        }

        return asset($src);
    }

    public function render(): View
    {
        return view('components.responsive-image');
    }
}
