<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Contracts\PaymentGateway;
use App\Services\StripeCheckoutService;
use App\Services\ShoppingCart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function shop()
    {
        return view('pages.shop');
    }

    public function product(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('pages.product', [
            'product' => $product->load('category'),
        ]);
    } 

    public function addProductToCart(Product $product, ShoppingCart $cart): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $cart->add($product);

        return redirect()->route('products.show', $product)
            ->with('status', $product->name . ' added to your cart.');
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function checkout(ShoppingCart $cart)
    {
        if ($cart->items() === []) {
            return redirect()->route('cart')->with('error', 'Add a product to your cart before checking out.');
        }

        return view('pages.checkout');
    }

    public function checkoutReview(ShoppingCart $cart)
    {
        if ($cart->items() === []) {
            return redirect()->route('cart')->with('error', 'Add a product to your cart before checking out.');
        }

        if (! session()->has('checkout')) {
            return redirect()->route('checkout')->with('error', 'Enter your contact and delivery details to review your order.');
        }

        return view('pages.checkout-review');
    }

    public function checkoutOrderConfirmation(
        string $orderNumber,
        Request $request,
        PaymentGateway $gateway,
        StripeCheckoutService $checkout,
        ShoppingCart $cart,
    )
    {
        $order = Order::query()->where('order_number', $orderNumber)->with('items')->firstOrFail();

        if ($order->payment_status !== 'paid') {
            $sessionId = $request->query('session_id');

            abort_unless(
                is_string($sessionId)
                    && $order->stripe_checkout_session_id
                    && hash_equals($order->stripe_checkout_session_id, $sessionId),
                403,
            );

            $stripeSession = $gateway->retrieveCheckoutSession($sessionId);

            if (($stripeSession->payment_status ?? null) !== 'paid'
                || ($stripeSession->metadata->order_number ?? null) !== $order->order_number) {
                return redirect()->route('checkout.review')
                    ->with('error', 'Your payment is still pending. You can retry checkout.');
            }

            $checkout->markPaid($order, $stripeSession);
        }

        $cart->clear();
        session()->forget('checkout');

        return view('pages.checkout-order-confirmation', [
            'order' => $order->fresh('items'),
        ]);
    }

    public function checkoutCancelled(string $orderNumber): RedirectResponse
    {
        $order = Order::query()->where('order_number', $orderNumber)->firstOrFail();

        if ($order->payment_status !== 'paid') {
            $order->update([
                'status' => 'payment_cancelled',
                'payment_status' => 'cancelled',
            ]);
        }

        return redirect()->route('checkout.review')
            ->with('error', 'Payment was cancelled. Your cart is ready when you are.');
    }

    public function cakes()
    {
        return view('pages.cakes');
    }

    public function customCakes()
    {
        return view('pages.custom-cakes');
    }

    public function pastries()
    {
        return view('pages.pastries');
    }

    public function pastriesShow(string $slug): View
    {
        return view('pages.pastry', [
            'slug' => $slug,
        ]);
    }

    public function wedding()
    {
        return view('pages.wedding');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function ourStory()
    {
        return view('pages.our-story');
    }

    public function theMorgans()
    {
        return view('pages.the-morgans');
    }

    public function careers()
    {
        return view('pages.careers');
    }

    public function corporateEnquiries()
    {
        return view('pages.corporate-enquiries');
    }

    public function deliveryInformation()
    {
        return view('pages.delivery-information');
    }

    public function faqs()
    {
        return view('pages.faqs');
    }

    public function allergenInformation()
    {
        return view('pages.allergen-information');
    }

    public function orderTerms()
    {
        return view('pages.order-terms');
    }

    public function connect()
    {
        return view('pages.connect');
    }
}