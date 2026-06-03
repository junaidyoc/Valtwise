@extends('layouts.app')

@section('title', $category->name . ' — Blog — ' . ($seoSettings['site_name'] ?? 'Valtwise'))
@section('meta_description', $category->description ?: 'Read articles about ' . $category->name . ' - tips, guides, and news from Valtwise.')

@push('pagination_meta')
@if(isset($posts) && $posts->hasPages())
    @if($posts->previousPageUrl())
    <link rel="prev" href="{{ $posts->previousPageUrl() }}">
    @endif
    @if($posts->nextPageUrl())
    <link rel="next" href="{{ $posts->nextPageUrl() }}">
    @endif
@endif
@endpush

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "CollectionPage",
    "name": "{{ $category->name }} — Valtwise Blog",
    "description": "{{ $category->description ?: 'Articles about ' . $category->name }}",
    "url": "{{ route('blog.category', $category->slug) }}"
}
</script>

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
        {
            "@@type": "ListItem",
            "position": 3,
            "name": "{{ $category->name }}"
        }
    ]
}
</script>
@endpush

@section('content')
{{-- Hero Section --}}
<section style="background:var(--dark);padding:48px 0 40px">
    <div class="container">
        <nav style="font-size:13px;color:#71717a;margin-bottom:16px">
            <a href="{{ route('home') }}" style="color:#71717a">Home</a>
            <span style="margin:0 8px">›</span>
            <a href="{{ route('blog.index') }}" style="color:#71717a">Blog</a>
            <span style="margin:0 8px">›</span>
            <span style="color:#f1f5f9">{{ $category->name }}</span>
        </nav>
        <h1 style="font-size:clamp(28px,4vw,36px);font-weight:700;color:#fff;margin-bottom:8px">
            {{ $category->name }}
        </h1>
        @if($category->description)
        <p style="color:#a1a1aa;font-size:15px;max-width:500px">
            {{ $category->description }}
        </p>
        @endif
        <div style="margin-top:12px;font-size:13px;color:#71717a">
            {{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 300px;gap:40px;align-items:start">
            {{-- Main Content --}}
            <div>
                @if($posts->count() > 0)
                <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:24px">
                    @foreach($posts as $post)
                    <article class="blog-card" style="background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);overflow:hidden;transition:all .2s">
                        <a href="{{ route('blog.show', $post->slug) }}" style="display:block;aspect-ratio:16/9;overflow:hidden;background:#f4f4f5">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform .3s"
                                 loading="lazy" width="400" height="225">
                        </a>
                        <div style="padding:20px">
                            <h2 style="font-size:17px;font-weight:600;margin-bottom:8px;line-height:1.4">
                                <a href="{{ route('blog.show', $post->slug) }}" style="color:var(--dark)">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p style="font-size:13px;color:var(--gray-4);line-height:1.6;margin-bottom:12px">
                                {{ $post->short_excerpt }}
                            </p>
                            <div style="display:flex;align-items:center;gap:12px;font-size:12px;color:var(--gray-3)">
                                <span>{{ $post->formatted_date }}</span>
                                <span>·</span>
                                <span>{{ $post->read_time }} min read</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div style="margin-top:32px;display:flex;justify-content:center">
                    {{ $posts->links() }}
                </div>
                @else
                <div style="text-align:center;padding:60px 20px;color:var(--gray-4)">
                    <div style="font-size:48px;margin-bottom:16px">📝</div>
                    <div style="font-size:18px;font-weight:600;margin-bottom:8px">No posts in this category</div>
                    <p>Check back soon or <a href="{{ route('blog.index') }}" style="color:var(--green)">browse all articles</a>.</p>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside style="position:sticky;top:80px">
                {{-- Categories --}}
                @if($categories->count() > 0)
                <div style="background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px">
                    <h3 style="font-size:15px;font-weight:600;margin-bottom:16px;color:var(--dark)">All Categories</h3>
                    <ul style="list-style:none;padding:0;margin:0">
                        @foreach($categories as $cat)
                        <li style="margin-bottom:10px">
                            <a href="{{ route('blog.category', $cat->slug) }}"
                               style="display:flex;justify-content:space-between;align-items:center;font-size:14px;color:{{ $cat->id === $category->id ? 'var(--green)' : 'var(--gray-4)' }};font-weight:{{ $cat->id === $category->id ? '600' : '400' }};transition:color .2s">
                                <span>{{ $cat->name }}</span>
                                <span style="background:var(--gray-1);padding:2px 8px;border-radius:10px;font-size:11px">{{ $cat->published_posts_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </aside>
        </div>
    </div>
</section>

<style>
    .blog-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--green);
    }
    .blog-card:hover img {
        transform: scale(1.05);
    }
    aside a:hover {
        color: var(--green) !important;
    }
    @media (max-width: 900px) {
        .container > div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
        aside {
            position: static !important;
        }
    }
</style>
@endsection
