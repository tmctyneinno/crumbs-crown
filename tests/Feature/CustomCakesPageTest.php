<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CustomCakesPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_custom_cake_gallery_uses_live_cake_products(): void
    {
        $cakes = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $pastries = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);

        Product::create([
            'name' => 'Wedding Celebration Cake',
            'description' => 'A cake for the wedding occasion.',
            'price' => 48000,
            'category_id' => $cakes->id,
            'occasion' => 'wedding',
        ]);

        Product::create([
            'name' => 'Hidden Cake',
            'description' => 'Not visible in the shop.',
            'price' => 28000,
            'category_id' => $cakes->id,
            'is_active' => false,
        ]);

        Product::create([
            'name' => 'Sausage Roll',
            'description' => 'A pastry, not a cake.',
            'price' => 3500,
            'category_id' => $pastries->id,
        ]);

        Livewire::test('custom-cake.cake-created')
            ->assertSee('Wedding Celebration Cake')
            ->assertDontSee('Hidden Cake')
            ->assertDontSee('Sausage Roll');

        $this->get('/custom-cakes')
            ->assertOk()
            ->assertSee('Wedding Celebration Cake');
    }
}
