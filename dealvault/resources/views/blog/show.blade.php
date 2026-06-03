@extends('layouts.app')

@section('title', $post->seo_title)
@section('meta_description', $post->seo_description)
@section('meta_keywords', $post->seo_keywords)
@section('robots', $post->seo_robots)
@section('canonical', $post->seo_canonical)
@section('og_title', $post->seo_og_title)
@section('og_description', $post->seo_og_description)
@section('og_image', $post->seo_og_image)

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BlogPosting",
    "headline": "{{ $post->title }}",
    "image": "{{ $post->featured_image_url }}",
    "datePublished": "{{ $post->published_at?->toIso8601String() ?? $post->created_at->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
    "author": {
        "@@type": "Organization",
        "name": "{{ $seoSettings['site_name'] ?? 'Valtwise' }}"
    },
    "publisher": {
        "@@type": "Organization",
        "name": "{{ $seoSettings['site_name'] ?? 'Valtwise' }}",
        "logo": {
            "@@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    },
    "description": "{{ $post->seo_description }}",
    "mainEntityOfPage": {
        "@@type": "WebPage",
        "@@id": "{{ route('blog.show', $post->slug) }}"
    },
    "wordCount": "{{ str_word_count(strip_tags($post->content)) }}"
}
</script>

{{-- Breadcrumb Schema --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ route('home') }}"
        },
        {
            "@@type": "ListItem",
            "position": 2,
            "name": "Blog",
            "item": "{{ route('blog.index') }}"
        },
        @if($post->category)
        {
            "@@type": "ListItem",
            "position": 3,
            "name": "{{ $post->category->name }}",
            "item": "{{ route('blog.category', $post->category->slug) }}"
        },
        {
            "@@type": "ListItem",
            "position": 4,
            "name": "{{ $post->title }}"
        }
        @else
        {
            "@@type": "ListItem",
            "position": 3,
            "name": "{{ $post->title }}"
        }
        @endif
    ]
}
</script>
@endpush

@section('content')
{{-- Breadcrumb --}}
<section style="background:var(--dark);padding:20px 0">
    <div class="container">
        <nav style="font-size:13px;color:#71717a">
            <a href="{{ route('home') }}" style="color:#71717a">Home</a>
            <span style="margin:0 8px">›</span>
            <a href="{{ route('blog.index') }}" style="color:#71717a">Blog</a>
            @if($post->category)
            <span style="margin:0 8px">›</span>
            <a href="{{ route('blog.category', $post->category->slug) }}" style="color:#71717a">{{ $post->category->name }}</a>
            @endif
            <span style="margin:0 8px">›</span>
            <span style="color:#f1f5f9">{{ Str::limit($post->title, 40) }}</span>
        </nav>
    </div>
</section>

<article class="section" style="padding-top:40px">
    <div class="container" style="max-width:800px">
        {{-- Header --}}
        <header style="text-align:center;margin-bottom:32px">
            @if($post->category)
            <a href="{{ route('blog.category', $post->category->slug) }}"
               class="badge badge-green" style="margin-bottom:16px;text-decoration:none">
                {{ $post->category->name }}
            </a>
            @endif

            <h1 style="font-size:clamp(28px,5vw,40px);font-weight:700;line-height:1.3;margin-bottom:16px;color:var(--dark)">
                {{ $post->title }}
            </h1>

            <div style="display:flex;justify-content:center;align-items:center;gap:16px;font-size:14px;color:var(--gray-4);flex-wrap:wrap">
                <span>📅 {{ $post->formatted_date }}</span>
                <span>·</span>
                <span>📖 {{ $post->read_time }} min read</span>
                <span>·</span>
                <span>👁️ {{ number_format($post->views) }} views</span>
            </div>
        </header>

        {{-- Featured Image --}}
        @if($post->featured_image)
        <figure style="margin:0 0 32px;border-radius:var(--radius-lg);overflow:hidden">
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                 style="width:100%;height:auto;display:block" width="800" height="450">
        </figure>
        @endif

        {{-- Content --}}
        <div class="blog-content" style="font-size:16px;line-height:1.8;color:#374151">
            {!! $post->content !!}
        </div>

        {{-- Share --}}
        <div style="margin-top:40px;padding-top:24px;border-top:1px solid var(--gray-2)">
            <div style="font-size:14px;font-weight:600;color:var(--dark);margin-bottom:12px">Share this article</div>
            <div style="display:flex;gap:10px">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}"
                   target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#1877f2;color:#fff;border-radius:6px;font-size:13px;font-weight:500;text-decoration:none">
                    Facebook
                </a>
                <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . route('blog.show', $post->slug)) }}"
                   target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#25d366;color:#fff;border-radius:6px;font-size:13px;font-weight:500;text-decoration:none">
                    WhatsApp
                </a>
                <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode(route('blog.show', $post->slug)) }}"
                   style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:var(--gray-4);color:#fff;border-radius:6px;font-size:13px;font-weight:500;text-decoration:none">
                    Email
                </a>
            </div>
        </div>
    </div>
</article>

{{-- Related Posts --}}
@if($relatedPosts->count() > 0)
<section class="section" style="background:var(--gray-1);padding:48px 0">
    <div class="container">
        <h2 class="section-title" style="margin-bottom:24px">Related <span>Articles</span></h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:24px">
            @foreach($relatedPosts as $related)
            <article class="blog-card" style="background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);overflow:hidden;transition:all .2s">
                <a href="{{ route('blog.show', $related->slug) }}" style="display:block;aspect-ratio:16/9;overflow:hidden;background:#f4f4f5">
                    <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}"
                         style="width:100%;height:100%;object-fit:cover;transition:transform .3s"
                         loading="lazy" width="400" height="225">
                </a>
                <div style="padding:20px">
                    @if($related->category)
                    <span class="badge badge-green" style="margin-bottom:10px">{{ $related->category->name }}</span>
                    @endif
                    <h3 style="font-size:16px;font-weight:600;margin-bottom:8px;line-height:1.4">
                        <a href="{{ route('blog.show', $related->slug) }}" style="color:var(--dark)">
                            {{ Str::limit($related->title, 60) }}
                        </a>
                    </h3>
                    <div style="font-size:12px;color:var(--gray-3)">
                        {{ $related->formatted_date }} · {{ $related->read_time }} min
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<style>
    .blog-content h2 {
        font-size: 24px;
        font-weight: 700;
        margin: 32px 0 16px;
        color: var(--dark);
    }
    .blog-content h3 {
        font-size: 20px;
        font-weight: 600;
        margin: 28px 0 12px;
        color: var(--dark);
    }
    .blog-content p {
        margin-bottom: 16px;
    }
    .blog-content ul, .blog-content ol {
        margin: 16px 0;
        padding-left: 24px;
    }
    .blog-content li {
        margin-bottom: 8px;
    }
    .blog-content a {
        color: var(--green);
        text-decoration: underline;
    }
    .blog-content blockquote {
        border-left: 4px solid var(--green);
        padding: 16px 20px;
        margin: 24px 0;
        background: var(--gray-1);
        border-radius: 0 8px 8px 0;
        font-style: italic;
        color: var(--gray-4);
    }
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    .blog-content code {
        background: var(--gray-1);
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 14px;
    }
    .blog-content pre {
        background: var(--dark);
        color: #f1f5f9;
        padding: 20px;
        border-radius: 8px;
        overflow-x: auto;
        margin: 20px 0;
    }
    .blog-content pre code {
        background: none;
        padding: 0;
    }
    .blog-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--green);
    }
    .blog-card:hover img {
        transform: scale(1.05);
    }
</style>
@endsection
