<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminEnquiryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');

Route::get('/shop', [SiteController::class, 'shop'])->name('shop'); 
Route::get('/products/{product}', [SiteController::class, 'product'])->name('products.show');
Route::post('/products/{product}/cart', [SiteController::class, 'addProductToCart'])->name('products.cart.store');
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
