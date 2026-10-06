<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminEnquiryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->middleware('throttle:6,1')->name('login.store');
    Route::get('/register', [CustomerAuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->middleware('throttle:6,1')->name('register.store');
    Route::get('/forgot-password', [CustomerAuthController::class, 'forgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [CustomerAuthController::class, 'sendPasswordResetLink'])->middleware('throttle:6,1')->name('password.email');
    Route::get('/reset-password/{token}', [CustomerAuthController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [CustomerAuthController::class, 'resetPassword'])->name('password.update');
});
Route::middleware('auth')->group(function () {
    Route::get('/account', [CustomerAuthController::class, 'account'])->name('account');
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
});

Route::get('/shop', [SiteController::class, 'shop'])->name('shop'); 
Route::get('/p/{token}', [SiteController::class, 'product'])->name('products.show');
Route::post('/p/{token}/cart', [SiteController::class, 'addProductToCart'])->name('products.cart.store');
Route::get('/cart', [SiteController::class, 'cart'])->name('cart');
Route::get('/checkout', [SiteController::class, 'checkout'])->name('checkout');
Route::get('/checkout/review', [SiteController::class, 'checkoutReview'])->name('checkout.review');
Route::get('/checkout/order-confirmation/{orderNumber}', [SiteController::class, 'checkoutOrderConfirmation'])->name('checkout.order-confirmation');
Route::get('/checkout/cancel/{orderNumber}', [SiteController::class, 'checkoutCancelled'])->name('checkout.cancel');
Route::post('/stripe/webhook', StripeWebhookController::class)->name('stripe.webhook');
Route::get('/cakes', [SiteController::class, 'cakes'])->name('cakes');
Route::get('/custom-cakes', [SiteController::class, 'customCakes'])->name('custom-cakes');
Route::get('/pastries', [SiteController::class, 'pastries'])->name('pastries.index');
Route::get('/pastries/{slug}', [SiteController::class, 'pastriesShow'])->name('pastries.show');
Route::get('/wedding', [SiteController::class, 'wedding'])->name('wedding');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/our-story', [SiteController::class, 'ourStory'])->name('our-story');
Route::get('/the-morgans', [SiteController::class, 'theMorgans'])->name('the-morgans');
Route::get('/careers', [SiteController::class, 'careers'])->name('careers');
Route::get('/corporate-enquiries', [SiteController::class, 'corporateEnquiries'])->name('corporate-enquiries');
Route::get('/delivery-information', [SiteController::class, 'deliveryInformation'])->name('delivery-information');
Route::get('/faqs', [SiteController::class, 'faqs'])->name('faqs');
Route::get('/allergen-information', [SiteController::class, 'allergenInformation'])->name('allergen-information');
Route::get('/order-terms', [SiteController::class, 'orderTerms'])->name('order-terms');
Route::get('/connect', [SiteController::class, 'connect'])->name('connect');
Route::get('/contact', [SiteController::class, 'connect'])->name('contact');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->middleware('throttle:6,1')->name('login.store');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
        Route::get('/', [AdminProductController::class, 'dashboard'])->name('dashboard');
        Route::get('/enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('products', AdminProductController::class)->except(['show']);
    });
});
