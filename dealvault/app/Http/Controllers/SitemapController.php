<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use App\Models\SaleEvent;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate XML Sitemap
     */
    public function index(): Response
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static pages
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => route('stores.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => route('sale-calendar'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('about'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => route('contact'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => route('faq'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => route('terms'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['url' => route('privacy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['url' => route('how-to-use'), 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $content .= $this->urlEntry($page['url'], now()->toW3cString(), $page['changefreq'], $page['priority']);
        }

        // Store pages (respect sitemap_include setting)
        $stores = Store::where('is_active', true)
            ->where(function ($query) {
                $query->where('sitemap_include', true)
                      ->orWhereNull('sitemap_include'); // Default to include if not set
            })
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);

        foreach ($stores as $store) {
            $content .= $this->urlEntry(
                route('stores.show', $store->slug),
                $store->updated_at->toW3cString(),
                'daily',
                '0.8'
            );
        }

        // Category pages (respect sitemap_include setting)
        $categories = Category::where(function ($query) {
                $query->where('sitemap_include', true)
                      ->orWhereNull('sitemap_include'); // Default to include if not set
            })
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);

        foreach ($categories as $category) {
            $content .= $this->urlEntry(
                route('categories.show', $category->slug),
                $category->updated_at->toW3cString(),
                'weekly',
                '0.7'
            );
        }

        // Sale Event pages (respect sitemap_include setting)
        $saleEvents = SaleEvent::where('is_active', true)
            ->where(function ($query) {
                $query->where('sitemap_include', true)
                      ->orWhereNull('sitemap_include'); // Default to include if not set
            })
            ->orderBy('event_date', 'desc')
            ->get(['slug', 'updated_at', 'event_date']);

        foreach ($saleEvents as $event) {
            $content .= $this->urlEntry(
                route('sale-calendar.show', $event->slug),
                $event->updated_at->toW3cString(),
                'weekly',
                '0.7'
            );
        }

        // Blog index page
        $content .= $this->urlEntry(
            route('blog.index'),
            now()->toW3cString(),
            'daily',
            '0.8'
        );

        // Blog category pages
        $blogCategories = BlogCategory::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);

        foreach ($blogCategories as $blogCategory) {
            $content .= $this->urlEntry(
                route('blog.category', $blogCategory->slug),
                $blogCategory->updated_at->toW3cString(),
                'weekly',
                '0.6'
            );
        }

        // Blog post pages (respect sitemap_include setting)
        $blogPosts = BlogPost::published()
            ->where(function ($query) {
                $query->where('sitemap_include', true)
                      ->orWhereNull('sitemap_include');
            })
            ->orderBy('published_at', 'desc')
            ->get(['slug', 'updated_at', 'published_at']);

        foreach ($blogPosts as $post) {
            $content .= $this->urlEntry(
                route('blog.show', $post->slug),
                $post->updated_at->toW3cString(),
                'weekly',
                '0.6'
            );
        }

        $content .= '</urlset>';

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate a single URL entry
     */
    private function urlEntry(string $url, string $lastmod, string $changefreq, string $priority): string
    {
        return "  <url>\n" .
               "    <loc>{$url}</loc>\n" .
               "    <lastmod>{$lastmod}</lastmod>\n" .
               "    <changefreq>{$changefreq}</changefreq>\n" .
               "    <priority>{$priority}</priority>\n" .
               "  </url>\n";
    }
}
