<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentGateway
{
    public function createCheckoutSession(Order $order, string $successUrl, string $cancelUrl): object;

    public function retrieveCheckoutSession(string $sessionId): object;

    public function constructWebhookEvent(string $payload, string $signature): object;
}