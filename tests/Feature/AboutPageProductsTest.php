<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AboutPageProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_product_rails_show_active_pastries_from_the_catalog(): void
    {
        $pastries = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);
        $cakes = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);

        $activePastries = collect(range(1, 6))->map(fn (int $number) => Product::create([
            'name' => "Catalog Pastry {$number}",
            'description' => "Description for pastry {$number}.",
            'price' => 2500 * $number,
            'category_id' => $pastries->id,
        ]));

        Product::create([
            'name' => 'Inactive Pastry',
            'description' => 'Not currently available.',
            'price' => 3000,
            'category_id' => $pastries->id,
            'is_active' => false,
        ]);

        Product::create([
            'name' => 'Catalog Cake',
            'description' => 'A cake, not a pastry.',
            'price' => 20000,
            'category_id' => $cakes->id,
        ]);

        Livewire::test('aboutUs.index')
            ->assertSee($activePastries[0]->name)
            ->assertSee($activePastries[5]->name)
            ->assertSee('/products/', false)
            ->assertDontSee('Inactive Pastry')
            ->assertDontSee('Catalog Cake')
            ->assertDontSee('Red Velvet Classic');
    }
}
