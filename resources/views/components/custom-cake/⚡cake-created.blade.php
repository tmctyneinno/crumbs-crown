<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    #[Computed]
    public function featuredCreations(): array
    {
        $creations = Product::active()
            ->whereHas('category', fn ($query) => $query->where('slug', 'cakes'))
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (Product $product) => [
                'title' => $product->name,
                'desc' => $product->description,
                'image' => $product->image_url,
            ])
            ->all();

        if ($creations !== []) {
            return $creations;
        }

        return [
            [
                'title' => 'The Birthday Classic',
                'desc' => 'A timeless celebration cake made for candles, wishes and happy moments.',
                'image' => asset('images/cakes/birthday-classic.svg'),
            ],
            [
                'title' => 'Berry Drip Delight',
                'desc' => 'Vanilla sponge with a chocolate drip and fresh strawberries on top.',
                'image' => asset('images/cakes/fruit-cake.svg'),
            ],
            [
                'title' => 'Classic Red Velvet',
                'desc' => 'Layers of red velvet sponge with smooth cream cheese frosting.',
                'image' => asset('images/cakes/strawberry-cake.svg'),
            ],
            [
                'title' => 'Chocolate Dream Drip',
                'desc' => 'Rich chocolate sponge finished with a dark chocolate ganache drip.',
                'image' => asset('images/cakes/chocolate-fudge-cake.svg'),
            ],
            [
                'title' => 'Paw Patrol Party Cake',
                'desc' => 'A fun themed cake with a hand-piped topper, made for little ones.',
                'image' => asset('images/cakes/vanilla-cake.svg'),
            ],
            [
                'title' => 'Wedding Cake',
                'desc' => 'An elegant celebration cake crafted for a memorable wedding day.',
                'image' => asset('images/cakes/wedding-cake.svg'),
            ],
        ];
    }
};

?>

<div class="bg-white">
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">

        <h2 class="text-center font-[Oswald,ui-sans-serif] text-2xl font-bold uppercase tracking-tight text-stone-900 sm:text-3xl">
            Cakes we have created
        </h2>

        <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($this->featuredCreations as $creation)
                <a
                    href="{{ route('shop', ['search' => $creation['title']]) }}"
                    wire:navigate
                    class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white transition-shadow hover:shadow-md"
                >
                    <div class="aspect-square w-full overflow-hidden bg-stone-100">
                        <img
                            src="{{ $creation['image'] }}"
                            alt="{{ $creation['title'] }}"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            onerror="this.src='https://placehold.co/300x300/EFE7DA/6B3A1F?text=%20'"
                        >
                    </div>

                    <div class="flex flex-1 flex-col gap-1 p-3">
                        <h3 class="text-sm font-bold text-stone-900">
                            {{ $creation['title'] }}
                        </h3>
                        <p class="text-xs leading-snug text-stone-500">
                            {{ $creation['desc'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>