{{-- Responsive Image Component with WebP Support --}}
@if($webpSrc)
<picture>
    <source srcset="{{ $webpSrc }}" type="image/webp">
    <img
        src="{{ $fallbackSrc }}"
        alt="{{ $alt }}"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        @if($class) class="{{ $class }}" @endif
        loading="{{ $loading }}"
        onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($alt) }}&background=f3f4f6&color=374151&size=80'"
    >
</picture>
@else
<img
    src="{{ $fallbackSrc }}"
    alt="{{ $alt }}"
    @if($width) width="{{ $width }}" @endif
    @if($height) height="{{ $height }}" @endif
    @if($class) class="{{ $class }}" @endif
    loading="{{ $loading }}"
    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($alt) }}&background=f3f4f6&color=374151&size=80'"
>
@endif
