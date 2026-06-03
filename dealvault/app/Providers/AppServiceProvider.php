<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SeoSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use custom admin pagination view
        Paginator::defaultView('vendor.pagination.admin');

        // Share nav categories with all views using the main layout
        View::composer('layouts.app', function ($view) {
            $navCategories = Category::parents()
                ->with(['children' => fn($q) => $q->orderBy('name')->limit(8)])
                ->withCount('activeStores')
                ->orderByDesc('active_stores_count')
                ->limit(6)
                ->get();

            // Get global SEO settings
            $seoSettings = [
                'site_name' => SeoSetting::get('site_name', 'Valtwise'),
                'default_og_image' => SeoSetting::get('default_og_image', asset('images/og-default.jpg')),
                'twitter_handle' => SeoSetting::get('twitter_handle'),
                'google_analytics_id' => SeoSetting::get('google_analytics_id'),
                'google_search_console_verification' => SeoSetting::get('google_search_console_verification'),
                'default_robots' => SeoSetting::get('default_robots', 'index, follow'),
                'breadcrumbs_enabled' => SeoSetting::get('global_breadcrumbs_enabled', '1') === '1',
            ];

            $view->with('navCategories', $navCategories);
            $view->with('seoSettings', $seoSettings);
        });
    }
}
