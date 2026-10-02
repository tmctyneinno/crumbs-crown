<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PastriesCategoriesComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_pastry_categories_component_renders_database_products_and_opens_selected_product_search(): void
    {
        $pastries = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);

        $pastry = Product::create([
            'name' => 'Sausage Rolls',
            'description' => 'Flaky pastry filled with seasoned sausage.',
            'price' => 3500,
            'category_id' => $pastries->id,
        ]);

        $this->get('/pastries')
            ->assertOk()
            ->assertSee('Sausage Rolls');

        Livewire::test('pastries.pastries-categories')
            ->call('selectPastry', $pastry->id)
            ->assertRedirect(route('shop', ['search' => $pastry->name]));
    }
}
