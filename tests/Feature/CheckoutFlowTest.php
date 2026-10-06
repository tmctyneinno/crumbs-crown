<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Services\ShoppingCart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_cart_cannot_open_checkout_or_review(): void
    {
        $this->get(route('checkout'))
            ->assertRedirect(route('cart'));

        $this->get(route('checkout.review'))
            ->assertRedirect(route('cart'));
    }

    public function test_checkout_shows_cart_and_saves_customer_and_delivery_details_for_review(): void
    {
        $product = $this->createProduct();
        app(ShoppingCart::class)->add($product);

        $this->get(route('checkout'))
            ->assertOk()
            ->assertSee('Checkout Cake')
            ->assertSee('20,000');

        Livewire::test('checkout.index')
            ->set('fullName', 'Ada Morgan')
            ->set('phone', '08012345678')
            ->set('email', 'ada@example.com')
            ->set('notes', 'Please call before delivery.')
            ->call('setDeliveryMethod', 'pickup')
            ->call('proceedToNextStep')
            ->assertRedirect(route('checkout.review'));

        $this->assertSame([
            'customer' => [
                'name' => 'Ada Morgan',
                'phone' => '08012345678',
                'email' => 'ada@example.com',
            ],
            'delivery' => [
                'method' => 'pickup',
                'address' => '',
                'postcode' => '',
                'date' => now()->format('Y-m-d'),
                'notes' => 'Please call before delivery.',
            ],
        ], session('checkout'));

        $this->get(route('checkout.review'))
            ->assertOk()
            ->assertSee('Checkout Cake')
            ->assertSee('Ada Morgan')
            ->assertSee('ada@example.com')
            ->assertSee('08012345678')
            ->assertSee('Please call before delivery.')
            ->assertSee('Pickup')
            ->assertSee('20,000');
    }

    public function test_delivery_requires_and_saves_a_postcode_for_order_review(): void
    {
        $product = $this->createProduct();
        app(ShoppingCart::class)->add($product);

        Livewire::test('checkout.index')
            ->set('fullName', 'Ada Morgan')
            ->set('phone', '08012345678')
            ->set('email', 'ada@example.com')
            ->call('setDeliveryMethod', 'delivery')
            ->set('deliveryAddress', '14 Market Road, Lagos')
            ->call('proceedToNextStep')
            ->assertHasErrors(['deliveryPostcode' => 'required_if']);

        Livewire::test('checkout.index')
            ->set('fullName', 'Ada Morgan')
            ->set('phone', '08012345678')
            ->set('email', 'ada@example.com')
            ->call('setDeliveryMethod', 'delivery')
            ->set('deliveryAddress', '14 Market Road, Lagos')
            ->set('deliveryPostcode', '100001')
            ->call('proceedToNextStep')
            ->assertRedirect(route('checkout.review'));

        $this->assertSame('100001', session('checkout.delivery.postcode'));
        $this->get(route('checkout.review'))
            ->assertOk()
            ->assertSee('14 Market Road, Lagos')
            ->assertSee('Postcode: 100001');
    }

    public function test_review_edit_actions_return_to_cart_or_checkout(): void
    {
        $product = $this->createProduct();
        app(ShoppingCart::class)->add($product);
        session()->put('checkout', [
            'customer' => ['name' => 'Ada', 'phone' => '08012345678', 'email' => 'ada@example.com'],
            'delivery' => ['method' => 'pickup', 'address' => '', 'postcode' => '', 'date' => now()->format('Y-m-d'), 'notes' => ''],
        ]);

        Livewire::test('checkout.review')
            ->call('editSection', 'order')
            ->assertRedirect(route('cart'));

        Livewire::test('checkout.review')
            ->call('editSection', 'contact')
            ->assertRedirect(route('checkout'));
    }

    private function createProduct(): Product
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);

        return Product::create([
            'name' => 'Checkout Cake',
            'description' => 'A cake ready for checkout.',
            'price' => 20000,
            'category_id' => $category->id,
            'is_active' => true,
        ]);
    }
}
