<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CakeIndexPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_cake_page_uses_active_cake_products_and_horizontal_category_and_flavour_rails(): void
    {
        $cakes = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $pastries = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);

        $cake = Product::create([
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

        Livewire::test('cake.index')
            ->assertSee('Wedding Cakes')
            ->assertSee('Graduation Cakes')
            ->assertSee('Baby Shower Cakes')
            ->assertSee('Cupcake Cakes')
            ->assertSee('Corporate Cakes')
            ->assertSee('Wedding Celebration Cake')
            ->assertSee('/products/', false)
            ->assertDontSee('Hidden Cake')
            ->assertDontSee('Sausage Roll')
            ->assertSee('flex-nowrap')
            ->assertSee('Choose Your Flavour');

        $this->get('/cakes')->assertOk()->assertSee('Wedding Celebration Cake');
    }
}
