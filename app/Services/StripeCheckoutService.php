<?php

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use Stripe\Exception\AuthenticationException;

class StripeCheckoutService
{
    public function __construct(private PaymentGateway $gateway)
    {
    }

    public function start(ShoppingCart $cart): string
    {
        $items = $cart->items();
        $checkout = session('checkout');

        if ($items === [] || ! is_array($checkout)) {
            throw new RuntimeException('The cart or checkout details are missing.');
        }

        $customer = $checkout['customer'] ?? [];
        $delivery = $checkout['delivery'] ?? [];

        if (! filled($customer['name'] ?? null)
            || ! filled($customer['email'] ?? null)
            || ! filled($customer['phone'] ?? null)
            || ! filled($delivery['method'] ?? null)
            || ($delivery['method'] === 'delivery' && ! filled($delivery['postcode'] ?? null))
            || ! filled($delivery['date'] ?? null)) {
            throw new RuntimeException('Checkout contact and delivery details are incomplete.');
        }

        $order = DB::transaction(function () use ($items, $customer, $delivery): Order {
            $subtotal = collect($items)->sum(fn (array $item) => $item['price'] * $item['qty']);
            $order = Order::create([
                'order_number' => 'CC-' . now()->format('ymd') . '-' . Str::upper(Str::random(8)),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'currency' => config('services.stripe.currency', 'ngn'),
                'subtotal' => $subtotal,
                'customer_name' => $customer['name'],
                'customer_email' => $customer['email'],
                'customer_phone' => $customer['phone'],
                'delivery_method' => $delivery['method'],
                'delivery_address' => $delivery['address'] ?? null,
                'delivery_postcode' => $delivery['postcode'] ?? null,
                'delivery_date' => $delivery['date'],
                'notes' => $delivery['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_description' => $item['description'] ?? null,
                    'options' => $item['options'] ?? [],
                    'unit_price' => $item['price'],
                    'quantity' => $item['qty'],
                    'line_total' => $item['price'] * $item['qty'],
                ]);
            }

            return $order->load('items');
        });

        try {
            $session = $this->gateway->createCheckoutSession(
                $order,
                route('checkout.order-confirmation', ['orderNumber' => $order->order_number]) . '?session_id={CHECKOUT_SESSION_ID}',
                route('checkout.cancel', ['orderNumber' => $order->order_number]),
            );

            if (! isset($session->id, $session->url)) {
                throw new RuntimeException('Stripe did not return a checkout URL.');
            }

            $order->update(['stripe_checkout_session_id' => $session->id]);

            return $session->url;
        } catch (\Exception $exception) {
            $order->update([
                'status' => 'payment_failed',
                'payment_status' => 'failed',
                'payment_error' => $exception instanceof AuthenticationException
                    ? 'stripe_authentication'
                    : 'stripe_checkout',
            ]);

            throw $exception;
        } catch (\Error $exception) {
            $order->update([
                'status' => 'payment_failed',
                'payment_status' => 'failed',
                'payment_error' => 'stripe_checkout',
            ]);

            throw $exception;
        }
    }

    public function handleWebhook(object $event): void
    {
        $type = $event->type ?? '';
        $session = $event->data->object ?? null;
        $sessionId = $session->id ?? null;

        if (! is_string($sessionId) || $sessionId === '') {
            return;
        }

        $order = Order::query()
            ->where('stripe_checkout_session_id', $sessionId)
            ->first();

        if (! $order || ($session->metadata->order_number ?? null) !== $order->order_number) {
            return;
        }

        if (in_array($type, ['checkout.session.completed', 'checkout.session.async_payment_succeeded'], true)) {
            if ($type === 'checkout.session.async_payment_succeeded' || ($session->payment_status ?? null) === 'paid') {
                $this->markPaid($order, $session);
            }

            return;
        }

        if (in_array($type, ['checkout.session.async_payment_failed', 'checkout.session.expired'], true) && $order->payment_status !== 'paid') {
            $order->update([
                'status' => 'payment_failed',
                'payment_status' => 'failed',
            ]);
        }
    }

    public function markPaid(Order $order, object $session): void
    {
        DB::transaction(function () use ($order, $session): void {
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);

            if ($lockedOrder->payment_status === 'paid') {
                return;
            }

            $paymentIntent = $session->payment_intent ?? null;
            $paymentIntentId = is_object($paymentIntent) ? ($paymentIntent->id ?? null) : $paymentIntent;

            $lockedOrder->update([
                'status' => 'paid',
                'payment_status' => 'paid',
                'stripe_payment_intent_id' => is_string($paymentIntentId) ? $paymentIntentId : null,
                'paid_at' => now(),
            ]);
        });
    }
}