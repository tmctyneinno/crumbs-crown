<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_displays_active_products_from_the_database_only(): void
    {
        $cakes = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);

        Product::create([
            'name' => 'Admin-created cake',
            'description' => 'A cake managed from the admin.',
            'price' => 25000,
            'category_id' => $cakes->id,
        ]);

        Product::create([
            'name' => 'Hidden cake',
            'description' => 'Not available to customers.',
            'price' => 30000,
            'category_id' => $cakes->id,
            'is_active' => false,
        ]);

        $this->get('/shop')
            ->assertOk()
            ->assertSee('Admin-created cake')
            ->assertSee('Cakes')
            ->assertDontSee('Cupcakes')
            ->assertDontSee('Hidden cake');
    }
}
