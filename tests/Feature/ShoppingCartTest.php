<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_from_the_shop_updates_the_badge_and_cart_page(): void
    {
        $pastries = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);

        $product = Product::create([
            'name' => 'Cart test cake',
            'description' => 'Added from the product catalog.',
            'price' => 12000,
            'category_id' => $pastries->id,
        ]);

        Livewire::test('shop.product-catalog')
            ->call('addToCart', $product->id)
            ->assertDispatched('toast')
            ->assertSee('adjustCartQuantity('.$product->id.', -1)', false)
            ->call('addToCart', $product->id)
            ->assertDispatched('cart-updated');

        $this->assertSame([$product->id => 2], session('cart'));

        $this->get('/shop')->assertSee(
            '<span class="absolute -top-2 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-amber-600 text-[10px] font-bold text-white">2</span>',
            false,
        );

        $this->get('/cart')
            ->assertOk()
            ->assertSee('Cart test cake')
            ->assertSee('/p/', false)
            ->assertSee('₦12,000');

        Livewire::test('cart.index')->call('increment', $product->id);

        $this->assertSame([$product->id => 3], session('cart'));
    }

    public function test_decrementing_the_product_card_quantity_to_zero_restores_add_button(): void
    {
        $cakes = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);

        $product = Product::create([
            'name' => 'Stepper test cake',
            'description' => 'Quantity control test.',
            'price' => 18000,
            'category_id' => $cakes->id,
        ]);

        Livewire::test('shop.product-catalog')
            ->call('addToCart', $product->id)
            ->call('adjustCartQuantity', $product->id, -1)
            ->assertSee('Add to Cart');

        $this->assertSame([], session('cart'));
    }

    public function test_cart_cannot_proceed_to_checkout_when_empty(): void
    {
        Livewire::test('cart.index')
            ->call('proceedToCheckout')
            ->assertDispatched('toast')
            ->assertSee('Your cart is empty.');
    }

    public function test_cart_proceeds_to_checkout_when_it_contains_products(): void
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $product = Product::create([
            'name' => 'Checkout Cake',
            'description' => 'Ready for checkout.',
            'price' => 20000,
            'category_id' => $category->id,
        ]);

        app(\App\Services\ShoppingCart::class)->add($product);

        Livewire::test('cart.index')
            ->call('proceedToCheckout')
            ->assertRedirect(route('checkout'));
    }
}
