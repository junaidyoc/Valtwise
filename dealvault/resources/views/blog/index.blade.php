@extends('layouts.app')

@section('title', 'Blog — ' . ($seoSettings['site_name'] ?? 'Valtwise'))
@section('meta_description', 'Read the latest tips, guides, and news about saving money with coupon codes and deals from Valtwise.')
@section('meta_keywords', 'coupon tips, money saving, deals guide, shopping tips, promo codes blog')

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
    "@@type": "Blog",
    "name": "{{ $seoSettings['site_name'] ?? 'Valtwise' }} Blog",
    "description": "Tips, guides, and news about saving money with coupon codes and deals",
    "url": "{{ route('blog.index') }}",
    "publisher": {
        "@@type": "Organization",
        "name": "{{ $seoSettings['site_name'] ?? 'Valtwise' }}",
        "logo": {
            "@@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    }
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
            <span style="color:#f1f5f9">Blog</span>
        </nav>
        <h1 style="font-size:clamp(28px,4vw,36px);font-weight:700;color:#fff;margin-bottom:8px">
            Valtwise <span style="color:#4ade80">Blog</span>
        </h1>
        <p style="color:#a1a1aa;font-size:15px;max-width:500px">
            Tips, guides, and news to help you save money on every purchase.
        </p>
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
                        {{-- Featured Image --}}
                        <a href="{{ route('blog.show', $post->slug) }}" style="display:block;aspect-ratio:16/9;overflow:hidden;background:#f4f4f5">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform .3s"
                                 loading="lazy" width="400" height="225">
                        </a>

                        <div style="padding:20px">
                            {{-- Category --}}
                            @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}"
                               class="badge badge-green" style="margin-bottom:10px;text-decoration:none">
                                {{ $post->category->name }}
                            </a>
                            @endif

                            {{-- Title --}}
                            <h2 style="font-size:17px;font-weight:600;margin-bottom:8px;line-height:1.4">
                                <a href="{{ route('blog.show', $post->slug) }}" style="color:var(--dark)">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            {{-- Excerpt --}}
                            <p style="font-size:13px;color:var(--gray-4);line-height:1.6;margin-bottom:12px">
                                {{ $post->short_excerpt }}
                            </p>

                            {{-- Meta --}}
                            <div style="display:flex;align-items:center;gap:12px;font-size:12px;color:var(--gray-3)">
                                <span>{{ $post->formatted_date }}</span>
                                <span>·</span>
                                <span>{{ $post->read_time }} min read</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div style="margin-top:32px;display:flex;justify-content:center">
                    {{ $posts->links() }}
                </div>
                @else
                <div style="text-align:center;padding:60px 20px;color:var(--gray-4)">
                    <div style="font-size:48px;margin-bottom:16px">📝</div>
                    <div style="font-size:18px;font-weight:600;margin-bottom:8px">No posts yet</div>
                    <p>Check back soon for new articles!</p>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside style="position:sticky;top:80px">
                {{-- Categories --}}
                @if($categories->count() > 0)
                <div style="background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px;margin-bottom:20px">
                    <h3 style="font-size:15px;font-weight:600;margin-bottom:16px;color:var(--dark)">Categories</h3>
                    <ul style="list-style:none;padding:0;margin:0">
                        @foreach($categories as $cat)
                        <li style="margin-bottom:10px">
                            <a href="{{ route('blog.category', $cat->slug) }}"
                               style="display:flex;justify-content:space-between;align-items:center;font-size:14px;color:var(--gray-4);transition:color .2s">
                                <span>{{ $cat->name }}</span>
                                <span style="background:var(--gray-1);padding:2px 8px;border-radius:10px;font-size:11px">{{ $cat->published_posts_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Featured Posts --}}
                @if($featuredPosts->count() > 0)
                <div style="background:var(--white);border:1px solid var(--gray-2);border-radius:var(--radius-lg);padding:20px">
                    <h3 style="font-size:15px;font-weight:600;margin-bottom:16px;color:var(--dark)">⭐ Featured</h3>
                    @foreach($featuredPosts as $featured)
                    <a href="{{ route('blog.show', $featured->slug) }}"
                       style="display:flex;gap:12px;margin-bottom:16px;text-decoration:none">
                        <img src="{{ $featured->featured_image_url }}" alt="{{ $featured->title }}"
                             style="width:60px;height:60px;border-radius:8px;object-fit:cover" loading="lazy" width="60" height="60">
                        <div style="flex:1;min-width:0">
                            <div style="font-size:13px;font-weight:500;color:var(--dark);line-height:1.4;margin-bottom:4px">
                                {{ Str::limit($featured->title, 50) }}
                            </div>
                            <div style="font-size:11px;color:var(--gray-3)">{{ $featured->read_time }} min read</div>
                        </div>
                    </a>
                    @endforeach
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
