<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentGateway;
use App\Services\StripeCheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, PaymentGateway $gateway, StripeCheckoutService $checkout): JsonResponse
    {
        $signature = $request->header('Stripe-Signature');

        if (! is_string($signature) || $signature === '') {
            return response()->json(['message' => 'Missing Stripe signature.'], 400);
        }

        try {
            $event = $gateway->constructWebhookEvent($request->getContent(), $signature);
        } catch (UnexpectedValueException|SignatureVerificationException $exception) {
            return response()->json(['message' => 'Invalid Stripe webhook signature.'], 400);
        }

        $checkout->handleWebhook($event);

        return response()->json(['received' => true]);
    }
}