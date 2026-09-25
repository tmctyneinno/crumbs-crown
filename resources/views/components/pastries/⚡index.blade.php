<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    /**
     * "Find Your Perfect Cake" — occasion categories.
     * Swap for Category::query()->withCount('products')->get() once
     * backed by the database.
     */
    #[Computed]
    public function categories(): array
    {
        return [
            ['name' => 'Sausage Rolls',    'slug' => 'sausage-rolls',    'image' => 'sausage-rolls.svg'],
            ['name' => 'Brownies',      'slug' => 'brownies',     'image' => 'brownies.svg'],
            ['name' => 'Chicken Pies',  'slug' => 'chicken-pies', 'image' => 'chicken-pies.svg'],
            ['name' => 'Croissants',   'slug' => 'croissants',  'image' => 'croissants.svg'],
            ['name' => 'Chin Chin',  'slug' => 'chin-chin', 'image' => 'chin-chin.svg'],
            ['name' => 'Meat Pies',      'slug' => 'meat-pies',     'image' => 'meat-pies.svg'],
            ['name' => 'Doughnut',    'slug' => 'doughnut',   'image' => 'doughnut.svg'],
        ];
    }

    /**
     * "Our Pastry Collection" — featured products shown in the horizontal rail.
     * Swap for Product::featured()->take(8)->get() once backed by the database.
     */
    #[Computed]
    public function pastries(): array
    {
        return [
            ['id' => 1, 'name' => 'Meat Pie', 'desc' => 'A timeless celebration cake made for candles, wishes and happy moments.', 'price' => 35000, 'rating' => 4.5, 'image' => 'meat-pie-2.svg'],
            ['id' => 2, 'name' => 'Doughnut', 'desc' => 'Rich chocolate layers finished with a smooth, glossy ganache.', 'price' => 35000, 'rating' => 4.5, 'image' => 'doughnut.svg'],
            ['id' => 3, 'name' => 'Egg Roll', 'desc' => 'Vanilla sponge with a chocolate drip and fresh strawberries on top.', 'price' => 35000, 'rating' => 4.5, 'image' => 'egg-roll.svg'],
            ['id' => 4, 'name' => 'Puff Puff', 'desc' => 'A light celebration cake finished with seasonal fruit.', 'price' => 35000, 'rating' => 4.5, 'image' => 'puff-puff.svg'],
            ['id' => 5, 'name' => 'Red Velvet Classic', 'desc' => 'Soft red velvet sponge layered with cream cheese frosting.', 'price' => 35000, 'rating' => 4.5, 'image' => 'red-velvet-cake.svg'],
        ];
    }

    /**
     * "Choose Your Flavour" rail.
     */
    #[Computed]
    public function flavours(): array
    {
        return [
            ['name' => 'Chocolate',  'image' => 'chocolate-fudge-cake.svg'],
            ['name' => 'Strawberry', 'image' => 'strawberry-cake.svg'],
            ['name' => 'Red Velvet', 'image' => 'red-velvet-cake.svg'],
            ['name' => 'Vanilla',    'image' => 'vanilla-cake.svg'],
            ['name' => 'Caramel',    'image' => 'birthday-classic.svg'],
            ['name' => 'Coconut',    'image' => 'fruit-cake.svg'],
            ['name' => 'Lemon',      'image' => 'sparkler-cake.svg'],
        ];
    }

    /**
     * "How Much Cake Do You Need?" size guide table.
     */
    #[Computed]
    public function sizeGuide(): array
    {
        return [
            ['size' => '6 Inch',  'serves' => '6 - 10 people',  'best_for' => 'Small Celebrations'],
            ['size' => '8 Inch',  'serves' => '10 - 16 people', 'best_for' => 'Birthdays'],
            ['size' => '10 Inch', 'serves' => '20 - 30 people', 'best_for' => 'Parties'],
            ['size' => '12 Inch', 'serves' => '30 - 45 people', 'best_for' => 'Large Celebrations'],
            ['size' => 'Tiered',  'serves' => '50+ people',     'best_for' => 'Weddings & Events'],
        ];
    }

    /**
     * "Your Idea. Our Oven." — the custom cake process steps.
     */
    #[Computed]
    public function customCakeSteps(): array
    {
        return [
            ['label' => 'Choose your Design', 'icon' => 'users'],
            ['label' => 'Pick your Flavor',    'icon' => 'flavor'],
            ['label' => 'Select Shape & Size', 'icon' => 'gift'],
            ['label' => 'Share your Inspiration', 'icon' => 'bag'],
        ];
    }

    public function addToCart(int $productId): void
    {
        // Replace with real cart logic (session, DB, or a Cart service).
        session()->flash('toast', 'Added to cart.');
        $this->dispatch('cart-updated', productId: $productId)->to('cart-icon');
    }

}

?>

<div>
    <div class="bg-white">

        {{-- Toast --}}
        @if (session('toast'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="fixed top-5 right-5 z-50 rounded-xl bg-[#4A2A16] px-5 py-3 text-sm font-medium text-white shadow-lg"
            >
                {{ session('toast') }}
            </div>
        @endif

        <div class="mx-auto max-w-5xl space-y-14 px-4 py-12 sm:px-6">
             <livewire:pastries.pastries-categories :categories="$this->categories" />
             <livewire:pastries.pastries-collection :pastries="$this->pastries" />
             
        </div> 
    </div>

    <livewire:layouts.site-footer />
</div>