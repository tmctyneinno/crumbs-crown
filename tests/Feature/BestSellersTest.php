<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BestSellersTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_best_sellers_and_categories_come_from_active_products(): void
    {
        $cakes = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $cookies = Category::create(['name' => 'Cookies', 'slug' => 'cookies']);

        Product::create([
            'name' => 'Admin featured cake',
            'description' => 'Selected in the product admin.',
            'price' => 28000,
            'category_id' => $cakes->id,
            'is_featured' => true,
        ]);

        Product::create([
            'name' => 'Hidden homepage product',
            'description' => 'Not visible to customers.',
            'price' => 32000,
            'category_id' => $cookies->id,
            'is_active' => false,
        ]);

        Livewire::test('homepage.best-sellers')
            ->assertSee('Admin featured cake')
            ->assertSee('Cakes')
            ->assertDontSee('Hidden homepage product')
            ->assertDontSee('Cookies');
    }

    public function test_homepage_product_quantity_stays_in_sync_with_shop_cart(): void
    {
        $cakes = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);

        $product = Product::create([
            'name' => 'Featured cart cake',
            'description' => 'Shared cart quantity.',
            'price' => 28000,
            'category_id' => $cakes->id,
            'is_featured' => true,
        ]);

        Livewire::test('homepage.best-sellers')
            ->call('addToCart', $product->id)
            ->assertSee('adjustCartQuantity('.$product->id.', -1)', false);

        Livewire::test('shop.product-catalog')
            ->assertSee('adjustCartQuantity('.$product->id.', -1)', false);

        Livewire::test('homepage.best-sellers')
            ->call('adjustCartQuantity', $product->id, -1)
            ->assertSee('Add to Cart');

        $this->assertSame([], session('cart'));
    }
}
