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
            ['name' => 'Birthday Cakes',    'slug' => 'birthday',    'image' => 'category-birthday.svg'],
            ['name' => 'Wedding Cakes',      'slug' => 'wedding',     'image' => 'category-wedding.svg'],
            ['name' => 'Anniversary Cakes',  'slug' => 'anniversary', 'image' => 'category-anniversary.svg'],
            ['name' => 'Graduation Cakes',   'slug' => 'graduation',  'image' => 'category-graduation.svg'],
            ['name' => 'Baby Shower Cakes',  'slug' => 'baby-shower', 'image' => 'category-baby-shower.svg'],
            ['name' => 'Cupcake Cakes',      'slug' => 'cupcake',     'image' => 'category-cupcake.svg'],
            ['name' => 'Corporate Cakes',    'slug' => 'corporate',   'image' => 'category-corporate.svg'],
        ];
    }

    /**
     * "Our Cake Collection" — featured products shown in the horizontal rail.
     * Swap for Product::featured()->take(8)->get() once backed by the database.
     */
    #[Computed]
    public function cakes(): array
    {
        return [
            ['id' => 1, 'name' => 'The Birthday Classic', 'desc' => 'A timeless celebration cake made for candles, wishes and happy moments.', 'price' => 35000, 'rating' => 4.5, 'image' => 'category-baby-shower.svg'],
            ['id' => 2, 'name' => 'Chocolate Fudge Cake', 'desc' => 'Rich chocolate layers finished with a smooth, glossy ganache.', 'price' => 35000, 'rating' => 4.5, 'image' => 'strawberry-cake.svg'],
            ['id' => 3, 'name' => 'Berry Drip Delight', 'desc' => 'Vanilla sponge with a chocolate drip and fresh strawberries on top.', 'price' => 35000, 'rating' => 4.5, 'image' => 'category-corporate.svg'],
            ['id' => 4, 'name' => 'Fresh Fruit Cake', 'desc' => 'A light celebration cake finished with seasonal fruit.', 'price' => 35000, 'rating' => 4.5, 'image' => 'category-wedding.svg'],
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
             <livewire:cake.cake-categories :categories="$this->categories" />
             <livewire:cake.cake-collection :cakes="$this->cakes" />
             <livewire:cake.flavours :flavours="$this->flavours" />
             <livewire:cake.size-guide :size-guide="$this->sizeGuide" />
             <livewire:cake.custom-cake-cta :custom-cake-steps="$this->customCakeSteps" />
        </div> 
    </div>

    <livewire:layouts.site-footer />
</div>