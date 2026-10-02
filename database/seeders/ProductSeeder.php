<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CategorySeeder::class);

        $products = [
            ['The Birthday Classic', 'A timeless celebration cake made for candles, wishes and happy moments.', 'cakes', 'birthday', 'birthday-classic.svg'],
            ['Glazed Ring Donuts', 'Soft, pillowy donuts finished with a light golden glaze.', 'pastries', 'just-because', 'chocolate-fudge-cake.svg'],
            ['Berry Drip Delight', 'Vanilla sponge with a chocolate drip and fresh strawberries on top.', 'cakes', 'birthday', 'fruit-cake.svg'],
            ['Crunchy Chin Chin Bowl', 'Golden, crunchy chin chin bites, perfect for sharing at parties.', 'chin-chin', 'corporate-events', 'red-velvet-cake.svg'],
            ['Beef Pastry Pocket', 'Flaky pastry filled with seasoned minced beef and vegetables.', 'small-chops', 'corporate-events', 'sparkler-cake.svg'],
            ['Classic Red Velvet', 'Layers of red velvet sponge with smooth cream cheese frosting.', 'cakes', 'anniversary', 'strawberry-cake.svg'],
            ['Chocolate Dream Drip', 'Rich chocolate sponge finished with a dark chocolate ganache drip.', 'cakes', 'birthday', 'strawberry-cake2.svg'],
            ['Paw Patrol Party Cake', 'A fun themed cake with a hand-piped topper, made for little ones.', 'cakes', 'birthday', 'vanilla-cake.svg'],
            ['Meat Pie Pocket', 'A warm, flaky pastry packed with peppered meat and potatoes.', 'small-chops', 'corporate-events', 'wedding-cake.svg'],
            ['Wedding Cake', 'An elegant celebration cake crafted for a memorable wedding day.', 'cakes', 'wedding', 'wedding-cake.svg'],
        ];

        foreach ($products as $index => [$name, $description, $category, $occasion, $image]) {
            $categoryModel = Category::firstOrCreate(
                ['slug' => $category],
                ['name' => Str::headline($category)],
            );

            Product::firstOrCreate(['name' => $name], [
                'description' => $description,
                'price' => 35000,
                'rating' => 4.5,
                'category_id' => $categoryModel->id,
                'occasion' => $occasion,
                'dietary' => [],
                'image_path' => 'images/cakes/'.$image,
                'is_active' => true,
                'is_featured' => $index < 3,
            ]);
        }

        $pastries = [
            ['Sausage Rolls', 'Flaky pastry filled with seasoned sausage.', 'sausage-rolls.svg', 3500],
            ['Brownies', 'Rich, fudgy chocolate brownies.', 'brownies.svg', 4500],
            ['Chicken Pies', 'Golden pastry filled with savory chicken.', 'chicken-pies.svg', 5000],
            ['Croissants', 'Buttery, flaky croissants baked until golden.', 'croissants.svg', 4000],
            ['Chin Chin', 'Crunchy golden chin chin bites for sharing.', 'chin-chin.svg', 3000],
            ['Meat Pies', 'Flaky pastry filled with seasoned minced meat.', 'meat-pies.svg', 5000],
            ['Doughnut', 'Soft, sweet doughnuts finished with a light glaze.', 'doughnut.svg', 2500],
        ];

        $pastryCategory = Category::firstOrCreate(
            ['slug' => 'pastries'],
            ['name' => 'Pastries'],
        );

        foreach ($pastries as [$name, $description, $image, $price]) {
            Product::firstOrCreate(['name' => $name], [
                'description' => $description,
                'price' => $price,
                'rating' => 4.5,
                'category_id' => $pastryCategory->id,
                'occasion' => null,
                'dietary' => [],
                'image_path' => 'images/pastries/'.$image,
                'is_active' => true,
                'is_featured' => false,
            ]);
        }
    }
}
