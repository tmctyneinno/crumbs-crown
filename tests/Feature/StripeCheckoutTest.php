<?php

namespace Tests\Feature;

use App\Contracts\PaymentGateway;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Services\ShoppingCart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery;
use Tests\TestCase;
use UnexpectedValueException;

class StripeCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_review_creates_an_order_and_redirects_to_hosted_stripe_checkout(): void
    {
        $product = $this->createProduct();
        app(ShoppingCart::class)->add($product);
        session()->put('checkout', $this->checkoutDetails());

        $gateway = Mockery::mock(PaymentGateway::class);
        $gateway->shouldReceive('createCheckoutSession')
            ->once()
            ->withArgs(function (Order $order, string $successUrl, string $cancelUrl): bool {
                $this->assertSame(20000, $order->subtotal);
                $this->assertSame('Ada Morgan', $order->customer_name);
                $this->assertCount(1, $order->items);
                $this->assertStringContainsString('/checkout/order-confirmation/' . $order->order_number, $successUrl);
                $this->assertStringContainsString('/checkout/cancel/' . $order->order_number, $cancelUrl);

                return true;
            })
            ->andReturn((object) [
                'id' => 'cs_test_session',
                'url' => 'https://checkout.stripe.test/session',
            ]);
        $this->app->instance(PaymentGateway::class, $gateway);

        Livewire::test('checkout.review')
            ->call('proceedToPayment')
            ->assertRedirect('https://checkout.stripe.test/session');

        $order = Order::with('items')->firstOrFail();
        $this->assertSame('cs_test_session', $order->stripe_checkout_session_id);
        $this->assertSame('unpaid', $order->payment_status);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_name' => 'Payment Cake',
            'unit_price' => 20000,
            'quantity' => 1,
            'line_total' => 20000,
        ]);
    }

    public function test_signed_checkout_webhook_marks_the_order_paid(): void
    {
        $order = $this->createOrder('CC-TEST-PAID', 'cs_test_paid');
        $event = (object) [
            'type' => 'checkout.session.completed',
            'data' => (object) [
                'object' => (object) [
                    'id' => 'cs_test_paid',
                    'payment_status' => 'paid',
                    'payment_intent' => 'pi_test_paid',
                    'metadata' => (object) ['order_number' => $order->order_number],
                ],
            ],
        ];

        $gateway = Mockery::mock(PaymentGateway::class);
        $gateway->shouldReceive('constructWebhookEvent')->once()->andReturn($event);
        $this->app->instance(PaymentGateway::class, $gateway);

        $this->postJson(route('stripe.webhook'), [], ['Stripe-Signature' => 'test-signature'])
            ->assertOk()
            ->assertJson(['received' => true]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
            'payment_status' => 'paid',
            'stripe_payment_intent_id' => 'pi_test_paid',
        ]);
        $this->assertNotNull($order->fresh()->paid_at);
    }

    public function test_invalid_webhook_signature_is_rejected(): void
    {
        $gateway = Mockery::mock(PaymentGateway::class);
        $gateway->shouldReceive('constructWebhookEvent')
            ->once()
            ->andThrow(new UnexpectedValueException('Invalid signature.'));
        $this->app->instance(PaymentGateway::class, $gateway);

        $this->postJson(route('stripe.webhook'), [], ['Stripe-Signature' => 'bad-signature'])
            ->assertBadRequest();
    }

    public function test_success_return_verifies_payment_before_clearing_cart(): void
    {
        $product = $this->createProduct();
        $order = $this->createOrder('CC-TEST-RETURN', 'cs_test_return');
        app(ShoppingCart::class)->add($product);

        $gateway = Mockery::mock(PaymentGateway::class);
        $gateway->shouldReceive('retrieveCheckoutSession')
            ->once()
            ->with('cs_test_return')
            ->andReturn((object) [
                'id' => 'cs_test_return',
                'payment_status' => 'paid',
                'payment_intent' => 'pi_test_return',
                'metadata' => (object) ['order_number' => $order->order_number],
            ]);
        $this->app->instance(PaymentGateway::class, $gateway);

        $this->get(route('checkout.order-confirmation', [
            'orderNumber' => $order->order_number,
            'session_id' => 'cs_test_return',
        ]))
            ->assertOk()
            ->assertSee('Payment received')
            ->assertSee($order->order_number);

        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame([], session('cart', []));
    }

    private function createProduct(): Product
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);

        return Product::create([
            'name' => 'Payment Cake',
            'description' => 'A cake ready for Stripe checkout.',
            'price' => 20000,
            'category_id' => $category->id,
            'is_active' => true,
        ]);
    }

    private function createOrder(string $orderNumber, string $sessionId): Order
    {
        return Order::create([
            'order_number' => $orderNumber,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'currency' => 'ngn',
            'subtotal' => 20000,
            'customer_name' => 'Ada Morgan',
            'customer_email' => 'ada@example.com',
            'customer_phone' => '08012345678',
            'delivery_method' => 'pickup',
            'delivery_date' => now()->format('Y-m-d'),
            'stripe_checkout_session_id' => $sessionId,
        ]);
    }

    private function checkoutDetails(): array
    {
        return [
            'customer' => [
                'name' => 'Ada Morgan',
                'phone' => '08012345678',
                'email' => 'ada@example.com',
            ],
            'delivery' => [
                'method' => 'pickup',
                'address' => '',
                'date' => now()->format('Y-m-d'),
                'notes' => '',
            ],
        ];
    }
}
