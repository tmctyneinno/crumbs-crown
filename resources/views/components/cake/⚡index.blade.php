<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    #[Computed]
    public function categories(): array
    {
        $categories = [
            ['name' => 'Birthday Cakes', 'slug' => 'birthday', 'filter' => 'occasions', 'image' => 'category-birthday.svg'],
            ['name' => 'Wedding Cakes', 'slug' => 'wedding', 'filter' => 'occasions', 'image' => 'category-wedding.svg'],
            ['name' => 'Anniversary Cakes', 'slug' => 'anniversary', 'filter' => 'occasions', 'image' => 'category-anniversary.svg'],
            ['name' => 'Graduation Cakes', 'slug' => 'graduation', 'filter' => 'occasions', 'image' => 'category-graduation.svg'],
            ['name' => 'Baby Shower Cakes', 'slug' => 'baby-shower', 'filter' => 'occasions', 'image' => 'category-baby-shower.svg'],
            ['name' => 'Cupcake Cakes', 'slug' => 'cupcakes', 'filter' => 'categories', 'image' => 'category-cupcake.svg'],
            ['name' => 'Corporate Cakes', 'slug' => 'corporate-events', 'filter' => 'occasions', 'image' => 'category-corporate.svg'],
        ];

        $knownSlugs = array_column($categories, 'slug');
        $otherOccasions = Product::active()
            ->whereHas('category', fn ($query) => $query->where('slug', 'cakes'))
            ->whereNotNull('occasion')
            ->distinct()
            ->orderBy('occasion')
            ->pluck('occasion')
            ->reject(fn (string $occasion) => in_array($occasion, $knownSlugs, true))
            ->map(fn (string $occasion) => [
                'name' => \Illuminate\Support\Str::headline($occasion) . ' Cakes',
                'slug' => $occasion,
                'filter' => 'occasions',
                'image' => 'category-birthday.svg',
            ])
            ->all();

        return [...$categories, ...$otherOccasions];
    }

    #[Computed]
    public function cakes(): array
    {
        return Product::active()
            ->whereHas('category', fn ($query) => $query->where('slug', 'cakes'))
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->latest()
            ->take(8)
            ->get()
            ->map(fn (Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'desc' => $product->description,
                'price' => $product->price,
                'rating' => $product->rating,
                'image' => $product->image_url,
            ])
            ->all();
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

}

?>

<div>
    <div class="bg-white">

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