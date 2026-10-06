<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProductDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_product_details_show_all_catalog_information(): void
    {
        $category = Category::create(['name' => 'Celebration Cakes', 'slug' => 'celebration-cakes']);
        $product = Product::create([
            'name' => 'Birthday Cake',
            'description' => 'A soft vanilla cake for celebrations.',
            'price' => 32000,
            'rating' => 4.8,
            'category_id' => $category->id,
            'occasion' => 'birthday-party',
            'dietary' => ['eggless', 'gluten-free'],
            'is_active' => true,
        ]);

        $this->get($product->detail_url)
            ->assertOk()
            ->assertSee('Birthday Cake')
            ->assertSee('A soft vanilla cake for celebrations.')
            ->assertSee('Celebration Cakes')
            ->assertSee('Birthday Party')
            ->assertSee('Eggless')
            ->assertSee('Gluten Free')
            ->assertSee('32,000')
            ->assertSee('wire:click="addToCart"', false);
    }

    public function test_inactive_products_are_not_publicly_accessible(): void
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $product = Product::create([
            'name' => 'Hidden Cake',
            'description' => 'Not available in the shop.',
            'price' => 18000,
            'category_id' => $category->id,
            'is_active' => false,
        ]);

        $this->get($product->detail_url)->assertNotFound();
    }

    public function test_product_details_can_add_the_product_to_the_shared_cart(): void
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $product = Product::create([
            'name' => 'Cart Cake',
            'description' => 'Available from the product detail page.',
            'price' => 18000,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this->from($product->detail_url)
            ->post(route('products.cart.store', ['token' => basename(parse_url($product->detail_url, PHP_URL_PATH))]));
        $response->assertRedirect();

        $this->assertSame([$product->id => 1], session('cart'));
        $this->get($response->headers->get('Location'))->assertSee('Cart Cake added to your cart.');
    }

    public function test_product_detail_urls_use_hashids_and_reject_plain_numeric_ids(): void
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $product = Product::create([
            'name' => 'Private ID Cake',
            'description' => 'A product with a protected URL.',
            'price' => 18000,
            'category_id' => $category->id,
        ]);

        $this->assertStringNotContainsString('/'.$product->id, $product->detail_url);
        $this->get($product->detail_url)->assertOk()->assertSee('Private ID Cake');
        $this->get('/products/'.$product->id)->assertNotFound();
    }

    public function test_product_detail_hashid_is_short_and_unknown_tokens_are_rejected(): void
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $product = Product::create([
            'name' => 'Compact URL Cake',
            'description' => 'A product with a short Hashids URL.',
            'price' => 18000,
            'category_id' => $category->id,
        ]);

        $token = basename(parse_url($product->detail_url, PHP_URL_PATH));

        $this->assertLessThan(10, strlen($token));
        $this->assertStringStartsWith('/p/', parse_url($product->detail_url, PHP_URL_PATH));
        $this->get($product->detail_url)->assertOk()->assertSee('Compact URL Cake');
        $this->get('/p/0000000000')->assertNotFound();
    }

    public function test_product_detail_adds_the_selected_quantity_to_the_shared_cart(): void
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $product = Product::create([
            'name' => 'Quantity Cake',
            'description' => 'Added from the product detail component.',
            'price' => 18000,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        Livewire::test('shop.product-show', ['product' => $product])
            ->set('quantity', 3)
            ->call('addToCart')
            ->assertDispatched('toast')
            ->assertDispatched('cart-updated');

        $this->assertSame([$product->id => 3], session('cart'));
    }

    public function test_product_detail_preserves_selected_options_and_price_in_cart(): void
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $product = Product::create([
            'name' => 'Custom Cake',
            'description' => 'A cake with selected options.',
            'price' => 18000,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        Livewire::test('shop.product-show', ['product' => $product])
            ->set('size', '8')
            ->set('flavour', 'Chocolate')
            ->set('inscription', 'Happy Birthday')
            ->set('topper', 'classic')
            ->call('addToCart');

        $item = app(\App\Services\ShoppingCart::class)->items()[0];

        $this->assertSame('8"', $item['size']);
        $this->assertSame(48000, $item['price']);
        $this->assertSame('Chocolate', $item['options']['flavour']);
        $this->assertSame('Happy Birthday', $item['options']['inscription']);
        $this->assertSame('Classic gold topper', $item['options']['topper']);

        $this->get(route('cart'))
            ->assertOk()
            ->assertSee('8"')
            ->assertSee('Chocolate')
            ->assertSee('Happy Birthday')
            ->assertSee('Classic gold topper')
            ->assertSee('48,000');

        $this->get(route('checkout'))
            ->assertOk()
            ->assertSee('8"')
            ->assertSee('Chocolate')
            ->assertSee('Happy Birthday')
            ->assertSee('48,000');

        Livewire::test('cart.index')->call('increment', $item['line_id']);
        $this->assertSame([$product->id => 2], session('cart'));
    }

    public function test_product_detail_rejects_unknown_variant_options(): void
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $product = Product::create([
            'name' => 'Validated Cake',
            'description' => 'A cake with validated options.',
            'price' => 18000,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        Livewire::test('shop.product-show', ['product' => $product])
            ->set('size', '999')
            ->call('addToCart')
            ->assertHasErrors('size');

        $this->assertSame([], session('cart', []));
    }

    public function test_buy_now_adds_the_product_and_opens_checkout(): void
    {
        $category = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $product = Product::create([
            'name' => 'Buy Now Cake',
            'description' => 'Ready to order now.',
            'price' => 18000,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        Livewire::test('shop.product-show', ['product' => $product])
            ->set('quantity', 2)
            ->call('buyNow')
            ->assertRedirect(route('checkout'));

        $this->assertSame([$product->id => 2], session('cart'));
        $this->get(route('checkout'))->assertOk()->assertSee('Buy Now Cake');
    }
}