<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\SaleCalendarController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// ── SEO Routes ───────────────────────────────────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// ── Public Routes ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/store/{slug}', [StoreController::class, 'show'])->name('stores.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/go/{coupon}', [TrackingController::class, 'redirect'])->name('coupon.go');

Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
Route::get('/how-to-use-coupon', [PageController::class, 'howToUse'])->name('how-to-use');
Route::post('/contact-us', [PageController::class, 'contactSubmit'])
    ->middleware('throttle:5,10') // Max 5 submissions per 10 minutes per IP
    ->name('contact.submit');

// Sale Calendar
Route::get('/sale-calendar', [SaleCalendarController::class, 'index'])->name('sale-calendar');
Route::get('/sale-calendar/{slug}', [SaleCalendarController::class, 'show'])->name('sale-calendar.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// ── Admin Auth ────────────────────────────────────────────────────────────────
Route::get('/admin/login', [Admin\AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');

// ── Admin Panel ───────────────────────────────────────────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin')
    ->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Stores
    Route::resource('stores', Admin\StoreController::class);
    Route::patch('stores/{store}/toggle', [Admin\StoreController::class, 'toggle'])
         ->name('stores.toggle');

    // Coupons
    Route::resource('coupons', Admin\CouponController::class);
    Route::patch('coupons/{coupon}/toggle', [Admin\CouponController::class, 'toggle'])
         ->name('coupons.toggle');

    // Categories
    Route::get('categories', [Admin\CategoryController::class, 'index'])
         ->name('categories.index');
    Route::post('categories', [Admin\CategoryController::class, 'store'])
         ->name('categories.store');
    Route::get('categories/{category}/edit', [Admin\CategoryController::class, 'edit'])
         ->name('categories.edit');
    Route::put('categories/{category}', [Admin\CategoryController::class, 'update'])
         ->name('categories.update');
    Route::delete('categories/{category}', [Admin\CategoryController::class, 'destroy'])
         ->name('categories.destroy');

    // SEO Settings
    Route::get('seo', [Admin\SeoSettingsController::class, 'index'])
         ->name('seo.index');
    Route::post('seo', [Admin\SeoSettingsController::class, 'update'])
         ->name('seo.update');

    // Sale Events
    Route::resource('sale-events', Admin\SaleEventController::class);
    Route::patch('sale-events/{sale_event}/toggle', [Admin\SaleEventController::class, 'toggle'])
         ->name('sale-events.toggle');

    // Blog Categories
    Route::resource('blog-categories', Admin\BlogCategoryController::class);

    // Blog Posts
    Route::resource('blog-posts', Admin\BlogPostController::class);
    Route::post('blog-posts/{blog_post}/toggle', [Admin\BlogPostController::class, 'toggle'])
         ->name('blog-posts.toggle');
});
