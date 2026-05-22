<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Stores
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/store/{slug}', [StoreController::class, 'show'])->name('stores.show');

// Categories
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Affiliate redirect + click tracking
Route::get('/go/{coupon}', [TrackingController::class, 'redirect'])->name('coupon.go');