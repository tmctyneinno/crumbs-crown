<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_order_and_payment_failure_details(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::create([
            'order_number' => 'CC-TEST-ADMIN',
            'status' => 'payment_failed',
            'payment_status' => 'failed',
            'payment_error' => 'stripe_authentication',
            'currency' => 'ngn',
            'subtotal' => 42000,
            'customer_name' => 'Ada Morgan',
            'customer_email' => 'ada@example.com',
            'customer_phone' => '08012345678',
            'delivery_method' => 'delivery',
            'delivery_address' => '14 Market Road, Lagos',
            'delivery_date' => now()->format('Y-m-d'),
        ]);
        $order->items()->create([
            'product_name' => 'Celebration Cake',
            'product_description' => 'A cake for a special day.',
            'options' => ['size' => '8"', 'flavour' => 'Vanilla'],
            'unit_price' => 42000,
            'quantity' => 1,
            'line_total' => 42000,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('CC-TEST-ADMIN')
            ->assertSee('Ada Morgan')
            ->assertSee('ada@example.com')
            ->assertSee('Celebration Cake')
            ->assertSee('Vanilla')
            ->assertSee('Payment failed')
            ->assertSee('Stripe credentials were rejected')
            ->assertSee('42,000');
    }

    public function test_order_management_requires_admin_access(): void
    {
        $this->get(route('admin.orders.index'))
            ->assertRedirect(route('admin.login'));

        $this->actingAs(User::factory()->create())
            ->get(route('admin.orders.index'))
            ->assertForbidden();
    }

    public function test_admin_dashboard_summarizes_order_and_payment_activity(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->createOrder('CC-TEST-PAID', 'paid', 42000);
        $this->createOrder('CC-TEST-FAILED', 'failed', 30000);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Order activity')
            ->assertSee('Orders received')
            ->assertSee('Paid orders')
            ->assertSee('Needs payment follow-up')
            ->assertSee('CC-TEST-PAID')
            ->assertSee('CC-TEST-FAILED');
    }

    private function createOrder(string $orderNumber, string $paymentStatus, int $subtotal): Order
    {
        return Order::create([
            'order_number' => $orderNumber,
            'status' => $paymentStatus === 'paid' ? 'paid' : 'payment_failed',
            'payment_status' => $paymentStatus,
            'currency' => 'ngn',
            'subtotal' => $subtotal,
            'customer_name' => 'Ada Morgan',
            'customer_email' => 'ada@example.com',
            'customer_phone' => '08012345678',
            'delivery_method' => 'pickup',
            'delivery_date' => now()->format('Y-m-d'),
        ]);
    }
}
