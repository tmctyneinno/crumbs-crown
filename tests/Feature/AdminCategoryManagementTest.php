<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_categories_and_cannot_delete_a_category_with_products(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.categories.index'))
            ->assertOk()
            ->assertSee('S/N');

        $this->post(route('admin.categories.store'), [
            'name' => 'Seasonal Cakes',
            'slug' => 'Seasonal Cakes',
            'description' => 'Limited seasonal selections.',
            'sort_order' => 7,
            'is_active' => '1',
        ])->assertRedirect(route('admin.categories.index'));

        $category = Category::where('slug', 'seasonal-cakes')->firstOrFail();

        $this->get(route('admin.categories.edit', $category))
            ->assertOk()
            ->assertSee('Seasonal Cakes');

        $this->put(route('admin.categories.update', $category), [
            'name' => 'Seasonal Favorites',
            'slug' => 'Seasonal Favorites',
            'description' => 'Updated seasonal selections.',
            'sort_order' => 4,
            'is_active' => '1',
        ])->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Seasonal Favorites',
            'slug' => 'seasonal-favorites',
        ]);

        Product::create([
            'name' => 'Seasonal Tart',
            'description' => 'A tart in the seasonal category.',
            'price' => 18000,
            'category_id' => $category->id,
        ]);

        $this->from(route('admin.categories.index'))
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('error');
    }

    public function test_products_cannot_be_created_without_a_category(): void
    {
        $this->expectException(QueryException::class);

        Product::create([
            'name' => 'Uncategorized product',
            'description' => 'Every product needs a category.',
            'price' => 1000,
        ]);
    }
}
