<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NigerianCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_collection_lists_active_nigerian_products_and_adds_them_to_shared_cart(): void
    {
        $smallChops = Category::create(['name' => 'Small Chops', 'slug' => 'small-chops']);
        $chinChin = Category::create(['name' => 'Chin Chin', 'slug' => 'chin-chin']);
        $pastries = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);

        $product = Product::create([
            'name' => 'Nigerian Meat Pie',
            'description' => 'A savory Nigerian-inspired pastry.',
            'price' => 4500,
            'category_id' => $smallChops->id,
        ]);

        Product::create([
            'name' => 'Hidden Chin Chin',
            'description' => 'Not available to customers.',
            'price' => 3000,
            'category_id' => $chinChin->id,
            'is_active' => false,
        ]);

        Product::create([
            'name' => 'Regular Croissant',
            'description' => 'Outside the Nigerian collection categories.',
            'price' => 4000,
            'category_id' => $pastries->id,
        ]);

        Livewire::test('homepage.nigerian-collection')
            ->assertSee('Nigerian Meat Pie')
            ->assertDontSee('Hidden Chin Chin')
            ->assertDontSee('Regular Croissant')
            ->call('addToCart', $product->id)
            ->assertSee('Nigerian Meat Pie added successfully.')
            ->assertSee('adjustCartQuantity('.$product->id.', -1)', false);

        $this->assertSame([$product->id => 1], session('cart'));
    }
}
