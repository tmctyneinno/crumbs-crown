<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HomepageOccasionsAndPastriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_occasions_and_pastries_use_active_products_and_shop_filters(): void
    {
        $cakes = Category::create(['name' => 'Cakes', 'slug' => 'cakes']);
        $pastries = Category::create(['name' => 'Pastries', 'slug' => 'pastries']);

        Product::create([
            'name' => 'Birthday Celebration Cake',
            'description' => 'A birthday cake.',
            'price' => 30000,
            'category_id' => $cakes->id,
            'occasion' => 'birthday',
        ]);

        $pastry = Product::create([
            'name' => 'Apple Pastry',
            'description' => 'A flaky pastry.',
            'price' => 8000,
            'category_id' => $pastries->id,
        ]);

        Product::create([
            'name' => 'Hidden Wedding Cake',
            'description' => 'Not available to customers.',
            'price' => 50000,
            'category_id' => $cakes->id,
            'occasion' => 'wedding',
            'is_active' => false,
        ]);

        Livewire::test('homepage.occasions-and-pastries')
            ->assertSee('Birthday')
            ->assertSee('Apple Pastry')
            ->assertDontSee('Hidden Wedding Cake')
            ->call('selectOccasion', 'birthday')
            ->assertRedirect(route('shop', ['occasions' => ['birthday']]));

        Livewire::test('homepage.occasions-and-pastries')
            ->call('selectPastry', $pastry->id)
            ->assertRedirect(route('shop', ['categories' => ['pastries']]));
    }

    public function test_wedding_is_available_from_the_repeatable_starter_catalog(): void
    {
        $this->seed(ProductSeeder::class);
        $this->seed(ProductSeeder::class);

        $weddingCake = Product::with('category')->where('name', 'Wedding Cake')->firstOrFail();
        $this->assertSame('cakes', $weddingCake->category->slug);
        $this->assertSame('wedding', $weddingCake->occasion);
        $this->assertTrue($weddingCake->is_active);

        $this->assertSame(1, Product::where('name', 'Wedding Cake')->count());

        Livewire::test('homepage.occasions-and-pastries')
            ->assertSee('Wedding');
    }

    public function test_starter_pastries_are_seeded_in_the_pastries_category_and_listed(): void
    {
        $this->seed(ProductSeeder::class);

        $pastryNames = [
            'Sausage Rolls',
            'Brownies',
            'Chicken Pies',
            'Croissants',
            'Chin Chin',
            'Meat Pies',
            'Doughnut',
        ];

        $pastryCategory = Category::where('slug', 'pastries')->firstOrFail();

        foreach ($pastryNames as $name) {
            $this->assertDatabaseHas('products', [
                'name' => $name,
                'category_id' => $pastryCategory->id,
            ]);
        }

        $component = Livewire::test('homepage.occasions-and-pastries');

        foreach ($pastryNames as $name) {
            $component->assertSee($name);
        }
    }
}
