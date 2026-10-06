<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PastriesPageDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_pastry_page_sections_use_database_products_and_shared_cart(): void
    {
        $pastryCategory = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);
        $chinChinCategory = Category::create(['name' => 'Chin Chin', 'slug' => 'chin-chin']);

        $pastry = Product::create([
            'name' => 'Database Sausage Roll',
            'description' => 'A flaky pastry with seasoned sausage.',
            'price' => 3500,
            'category_id' => $pastryCategory->id,
        ]);

        Product::create([
            'name' => 'Database Chin Chin',
            'description' => 'Crunchy chin chin bites.',
            'price' => 3000,
            'category_id' => $chinChinCategory->id,
        ]);

        Product::create([
            'name' => 'Hidden Pastry',
            'description' => 'Not available in the shop.',
            'price' => 4500,
            'category_id' => $pastryCategory->id,
            'is_active' => false,
        ]);

        Livewire::test('pastries.index')
            ->assertSee('Database Sausage Roll')
            ->assertSee('/p/', false)
            ->assertSee('Database Chin Chin')
            ->assertDontSee('Hidden Pastry');

        $card = [
            'id' => $pastry->id,
            'name' => $pastry->name,
            'desc' => $pastry->description,
            'price' => $pastry->price,
            'rating' => $pastry->rating,
            'image' => $pastry->image_url,
            'category' => $pastryCategory->name,
        ];

        Livewire::test('pastries.pastries-collection', ['pastries' => [$card]])
            ->call('addToCart', $pastry->id)
            ->assertDispatched('toast')
            ->assertSee('adjustCartQuantity('.$pastry->id.', -1)', false);

        $this->assertSame([$pastry->id => 1], session('cart'));
    }
}
