<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (Product::exists()) {
            return;
        }

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
        ];

        foreach ($products as $index => [$name, $description, $category, $occasion, $image]) {
            Product::create([
                'name' => $name,
                'description' => $description,
                'price' => 35000,
                'rating' => 4.5,
                'category' => $category,
                'occasion' => $occasion,
                'dietary' => [],
                'image_path' => 'images/cakes/'.$image,
                'is_active' => true,
                'is_featured' => $index < 3,
            ]);
        }
    }
}
