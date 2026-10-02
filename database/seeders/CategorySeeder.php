<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Cakes', 'cakes', 'images/categories/cakes.svg', 'images/icons/cake.svg'],
            ['Cupcakes', 'cupcakes', 'images/categories/cupcakes.svg', 'images/icons/cupcake.svg'],
            ['Pastries', 'pastries', 'images/categories/pastries.svg', 'images/icons/pastry.svg'],
            ['Cookies', 'cookies', 'images/categories/cookies.svg', 'images/icons/cookie.svg'],
            ['Desserts', 'desserts', 'images/categories/desserts.svg', 'images/icons/dessert.svg'],
            ['Gift Boxes', 'gift-boxes', 'images/categories/gift-boxes.svg', 'images/icons/gift.svg'],
            ['Small Chops', 'small-chops', 'images/categories/pastries.svg', 'images/icons/pastry.svg'],
            ['Chin Chin', 'chin-chin', 'images/categories/pastries.svg', 'images/icons/pastry.svg'],
        ];

        foreach ($categories as $sortOrder => [$name, $slug, $imagePath, $iconPath]) {
            $category = Category::firstOrCreate(['slug' => $slug], [
                'name' => $name,
                'is_active' => true,
                'sort_order' => $sortOrder,
            ]);

            if (! $category->image_path || ! $category->icon_path) {
                $category->update([
                    'image_path' => $category->image_path ?: $imagePath,
                    'icon_path' => $category->icon_path ?: $iconPath,
                ]);
            }
        }
    }
}
