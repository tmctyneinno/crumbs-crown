<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    /**
     * "Made for Sharing" — platters, boxes and small chops sized for groups.
     * Swap for Product::whereCategory('sharing')->get() once backed by the
     * database.
     */
    #[Computed]
    public function sharingProducts(): array
    {
        return [
            ['id' => 1, 'name' => 'Classic Box',         'desc' => 'A timeless celebration cake made for candles, wishes and happy moments.', 'price' => 12000, 'rating' => 4.5, 'image' => 'classic-box.svg'],
            ['id' => 2, 'name' => 'Premium Box',          'desc' => 'A timeless celebration cake made for candles, wishes and happy moments.', 'price' => 12000, 'rating' => 4.5, 'image' => 'premium-box.svg'],
            ['id' => 3, 'name' => 'Event Platter',        'desc' => 'A timeless celebration cake made for candles, wishes and happy moments.', 'price' => 12000, 'rating' => 4.5, 'image' => 'event-platter.svg'],
            ['id' => 4, 'name' => 'Small Chops',          'desc' => 'A timeless celebration cake made for candles, wishes and happy moments.', 'price' => 12000, 'rating' => 4.5, 'image' => 'small-chops.svg'],
            ['id' => 5, 'name' => 'Premium Small Chops',  'desc' => 'A timeless celebration cake made for candles, wishes and happy moments.', 'price' => 12000, 'rating' => 4.5, 'image' => 'premium-small-chops.svg'],
        ];
    }

    public function addToCart(int $productId): void
    {
        // Replace with real cart logic (session, DB, or a Cart service).
        session()->flash('toast', 'Added to cart.');
        $this->dispatch('cart-updated', productId: $productId)->to('cart-icon');
    }
};
?>

<div>
    <section>
        <div class="text-center">
            <h2 class="font-[Oswald,ui-sans-serif] text-2xl font-bold uppercase tracking-tight text-stone-900 sm:text-3xl">
                Made for Sharing
            </h2>
            <p class="mx-auto mt-2 max-w-xl text-sm text-stone-600 sm:text-base">
                Perfect for events, parties, meetings and celebrations.
            </p>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
            @foreach ($this->sharingProducts as $product)
                <article class="flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white">
                    <div class="relative aspect-square w-full overflow-hidden bg-stone-100">
                        <img
                            src="{{ asset('images/pastries/' . $product['image']) }}"
                            alt="{{ $product['name'] }}"
                            loading="lazy"
                            class="h-full w-full object-cover"
                            onerror="this.src='https://placehold.co/300x300/EFE7DA/6B3A1F?text=%20'"
                        >
                        <div class="absolute inset-x-0 bottom-0 flex items-center gap-1 bg-[#4A2A16]/90 px-2.5 py-1 text-[10px] font-medium text-white">
                            <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h1l.4 2M7 13h10l3-8H5.4M7 13L5.4 5M7 13l-2 5h13" />
                            </svg>
                            <span class="truncate">Free Delivery until 10/10/26</span>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col gap-1.5 p-3">
                        <h3 class="text-sm font-semibold text-stone-800">{{ $product['name'] }}</h3>
                        <p class="text-xs leading-snug text-stone-500">{{ $product['desc'] }}</p>

                        <div class="flex items-center gap-1">
                            <div class="flex text-amber-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="h-3.5 w-3.5 {{ $i <= round($product['rating']) ? '' : 'text-stone-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.364 1.118l1.287 3.958c.299.921-.756 1.688-1.54 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.784.57-1.838-.197-1.539-1.118l1.286-3.958a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.285-3.958z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-xs font-medium text-stone-600">{{ number_format($product['rating'], 1) }}</span>
                        </div>

                        <div class="mt-auto flex flex-wrap items-center justify-between gap-1.5 pt-1.5">
                            <button
                                wire:click="addToCart({{ $product['id'] }})"
                                wire:loading.attr="disabled"
                                wire:target="addToCart({{ $product['id'] }})"
                                class="rounded-full bg-[#4A2A16] px-3 py-1.5 text-[11px] font-semibold text-white transition-colors hover:bg-[#3A2011] disabled:opacity-60"
                            >
                                <span wire:loading.remove wire:target="addToCart({{ $product['id'] }})">Add to Cart</span>
                                <span wire:loading wire:target="addToCart({{ $product['id'] }})">Adding&hellip;</span>
                            </button>
                            <span class="text-sm font-bold text-stone-900">&#8358;{{ number_format($product['price']) }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</div>