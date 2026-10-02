<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\ShoppingCart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    #[Computed]
    public function pastries(): array
    {
        return $this->pastryQuery()
            ->limit(4)
            ->get()
            ->map(fn (Product $product) => $this->productCard($product))
            ->all();
    }

    #[Computed]
    public function pastriesTwo(): array
    {
        return $this->pastryQuery()
            ->offset(4)
            ->limit(4)
            ->get()
            ->map(fn (Product $product) => $this->productCard($product))
            ->all();
    }

    #[Computed]
    public function chunchy(): array
    {
        return Product::active()
            ->whereHas('category', fn ($query) => $query->where('slug', 'chin-chin'))
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->latest()
            ->take(8)
            ->get()
            ->map(fn (Product $product) => $this->productCard($product))
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

    public function addToCart(int $productId, ShoppingCart $cart): void
    {
        $product = Product::active()->find($productId);

        if (! $product) {
            return;
        }

        $cart->add($product);
        $this->dispatch('cart-updated')->to('cart-icon');
        session()->flash('toast', $product->name . ' added successfully.');
    }

    private function pastryQuery(): Builder
    {
        return Product::active()
            ->whereHas('category', fn ($query) => $query->where('slug', 'pastries'))
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->orderByDesc('created_at');
    }

    private function productCard(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'desc' => $product->description,
            'price' => $product->price,
            'rating' => $product->rating,
            'image' => $product->image_url,
            'category' => $product->category?->name ?? '',
        ];
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
            <livewire:pastries.pastries-categories />
            <livewire:pastries.pastries-collection :pastries="$this->pastries" />
            <livewire:pastries.custom-pastries-cta :custom-cake-steps="$this->customCakeSteps" />
            <livewire:pastries.pastries-collection-second :pastriesTwo="$this->pastriesTwo" />
            <livewire:pastries.sharing-section />
            <livewire:pastries.pastries-collection-chunchy :chunchy="$this->chunchy" />
            <livewire:pastries.custom-pastries-feedback :custom-cake-steps="$this->customCakeSteps" />
            <livewire:homepage.client-reviews />
            <livewire:homepage.faq />
        </div> 
    </div>

</div>