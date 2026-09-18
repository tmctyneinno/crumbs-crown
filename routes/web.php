<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');

Route::get('/shop', [SiteController::class, 'page'])->defaults('page', 'shop')->name('shop');
Route::get('/cakes', [SiteController::class, 'page'])->defaults('page', 'cakes')->name('cakes');
Route::get('/corporate', [SiteController::class, 'page'])->defaults('page', 'corporate')->name('corporate');
Route::get('/wedding', [SiteController::class, 'page'])->defaults('page', 'wedding')->name('wedding');
Route::get('/about', [SiteController::class, 'page'])->defaults('page', 'about')->name('about');
Route::get('/contact', [SiteController::class, 'page'])->defaults('page', 'contact')->name('contact');
