<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FeaturedCakesTest extends TestCase
{
    use RefreshDatabase;

    public function test_featured_cakes_uses_active_cake_products_and_shared_cart(): void
    {
        $cakes = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $pastries = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);

        $cake = Product::create([
            'name' => 'Featured Cake',
            'description' => 'A database-managed cake.',
            'price' => 24000,
            'category_id' => $cakes->id,
            'is_featured' => true,
        ]);

        Product::create([
            'name' => 'Hidden Cake',
            'description' => 'Not listed publicly.',
            'price' => 28000,
            'category_id' => $cakes->id,
            'is_active' => false,
        ]);

        Product::create([
            'name' => 'Featured Pastry',
            'description' => 'Not a cake.',
            'price' => 5000,
            'category_id' => $pastries->id,
        ]);

        Livewire::test('homepage.featured-cakes')
            ->assertSee('Featured Cake')
            ->assertDontSee('Hidden Cake')
            ->assertDontSee('Featured Pastry')
            ->call('addToCart', $cake->id)
            ->assertSee('Featured Cake added successfully.')
            ->assertSee('adjustCartQuantity('.$cake->id.', -1)', false);

        $this->assertSame([$cake->id => 1], session('cart'));
    }
}
