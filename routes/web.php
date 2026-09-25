<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');

Route::get('/shop', [SiteController::class, 'shop'])->name('shop');
Route::get('/cakes', [SiteController::class, 'cakes'])->name('cakes');
Route::get('/custom-cakes', [SiteController::class, 'customCakes'])->name('custom-cakes');
Route::get('/pastries', [SiteController::class, 'pastries'])->name('pastries.index');
Route::get('/pastries/{slug}', [SiteController::class, 'pastries.show'])->name('pastries.show');
Route::get('/wedding', [SiteController::class, 'wedding'])->name('wedding');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/connect', [SiteController::class, 'connect'])->name('connect');
Route::get('/contact', [SiteController::class, 'connect'])->name('contact');
