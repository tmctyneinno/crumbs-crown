<?php

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\Models\Order;
use RuntimeException;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\StripeClient;
use Stripe\Webhook;

class StripePaymentGateway implements PaymentGateway
{
    private ?StripeClient $client = null;

    public function createCheckoutSession(Order $order, string $successUrl, string $cancelUrl): object
    {
        $lineItems = $order->items->map(function ($item) {
            $options = $item->options ?? [];
            $variant = collect([
                $options['size'] ?? null,
                $options['flavour'] ?? null,
                ($options['topper'] ?? null) !== 'No Topper' ? ($options['topper'] ?? null) : null,
                filled($options['inscription'] ?? null) ? 'Inscription: ' . $options['inscription'] : null,
            ])->filter()->implode(', ');
            $productData = [
                'name' => $item->product_name . ($variant ? ' (' . $variant . ')' : ''),
            ];

            if (filled($item->product_description)) {
                $productData['description'] = $item->product_description;
            }

            return [
                'price_data' => [
                    'currency' => config('services.stripe.currency', 'ngn'),
                    'product_data' => $productData,
                    'unit_amount' => $item->unit_price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        })->all();

        return $this->client()->checkout->sessions->create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'client_reference_id' => $order->order_number,
            'customer_email' => $order->customer_email,
            'metadata' => [
                'order_id' => (string) $order->id,
                'order_number' => $order->order_number,
            ],
            'line_items' => $lineItems,
        ]);
    }

    public function retrieveCheckoutSession(string $sessionId): object
    {
        return $this->client()->checkout->sessions->retrieve($sessionId);
    }

    public function constructWebhookEvent(string $payload, string $signature): object
    {
        $secret = config('services.stripe.webhook_secret');

        if (! is_string($secret) || $secret === '') {
            throw new RuntimeException('Stripe webhook signing secret is not configured.');
        }

        return Webhook::constructEvent($payload, $signature, $secret);
    }

    private function client(): StripeClient
    {
        if ($this->client) {
            return $this->client;
        }

        $secret = config('services.stripe.secret');

        if (! is_string($secret) || $secret === '') {
            throw new RuntimeException('Stripe secret key is not configured.');
        }

        return $this->client = new StripeClient($secret);
    }
}