<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// ── Public Routes ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/store/{slug}', [StoreController::class, 'show'])->name('stores.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/go/{coupon}', [TrackingController::class, 'redirect'])->name('coupon.go');

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
    Route::delete('categories/{category}', [Admin\CategoryController::class, 'destroy'])
         ->name('categories.destroy');
});
