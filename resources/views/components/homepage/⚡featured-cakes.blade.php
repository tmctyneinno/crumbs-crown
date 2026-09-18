<?php

use Livewire\Component;

new class extends Component
{
    public array $products = [
        [
            'id' => 1,
            'image' => 'images/cakes/chocolate-fudge-cake.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'The Birthday Classic',
            'description' => 'A timeless celebration cake made for candles, wishes and happy moments.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 2,
            'image' => 'images/cakes/birthday-classic.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'The Birthday Classic',
            'description' => 'A timeless celebration cake made for candles, wishes and happy moments.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 3,
            'image' => 'images/cakes/vanilla-cake.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'The Birthday Classic',
            'description' => 'A timeless celebration cake made for candles, wishes and happy moments.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 4,
            'image' => 'images/cakes/strawberry-cake.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'The Birthday Classic',
            'description' => 'A timeless celebration cake made for candles, wishes and happy moments.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 5,
            'image' => 'images/cakes/strawberry-cake2.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'The Birthday Classic',
            'description' => 'A timeless celebration cake made for candles, wishes and happy moments.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 6,
            'image' => 'images/cakes/fruit-cake.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'The Birthday Classic',
            'description' => 'A timeless celebration cake made for candles, wishes and happy moments.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 7,
            'image' => 'images/cakes/sparkler-cake.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'The Birthday Classic',
            'description' => 'A timeless celebration cake made for candles, wishes and happy moments.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 8,
            'image' => 'images/cakes/fruit-cake.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'The Birthday Classic',
            'description' => 'A timeless celebration cake made for candles, wishes and happy moments.',
            'rating' => 4.5,
            'price' => 35000,
        ],
    ];

    public function addToCart($productId)
    {
        $product = collect($this->products)->firstWhere('id', $productId);

        $this->dispatch('cart-updated', product: $product);

        session()->flash('message', $product['name'] . ' added to cart!');
    }
};
?> 

<div>
    <section class="w-full bg-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">

            {{-- Header --}}
            <div class="text-center mb-12">
                <h2 class="text-[#4a2b23] font-display font-bold text-3xl sm:text-4xl text-gray-900 uppercase tracking-tight mb-3">
                    Featured Cakes
                </h2>
                <p class="text-gray-600">
                    Our Chef's Selection of the Finest Cakes
                </p>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach ($products as $product)
                    <div
                        wire:key="product-{{ $product['id'] }}"
                        class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden group"
                    >
                        {{-- Product Image --}}
                        <div class="relative">
                            <img
                                src="{{ asset($product['image']) }}"
                                alt="{{ $product['name'] }}"
                                class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                            {{-- Delivery Badge --}}
                            <div class="absolute bottom-0 left-0 right-0 bg-black/60 backdrop-blur-sm text-white text-xs py-2 px-3 flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ $product['delivery'] }}
                            </div>
                        </div>

                        {{-- Product Info --}}
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 text-lg mb-1">
                                {{ $product['name'] }}
                            </h3>
                            <p class="text-sm text-gray-500 mb-3 line-clamp-2 leading-relaxed">
                                {{ $product['description'] }}
                            </p>

                            {{-- Rating --}}
                            <div class="flex items-center gap-1 mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg
                                        class="h-4 w-4 {{ $i <= floor($product['rating']) ? 'text-yellow-400' : 'text-gray-200' }}"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.363 1.118l1.287 3.957c.3.921-.755 1.688-1.538 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.197-1.538-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.062 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.287-3.958z" />
                                    </svg>
                                @endfor
                                <span class="text-sm text-gray-500 ml-1">{{ $product['rating'] }}</span>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-between">
                                <button
                                    wire:click="addToCart({{ $product['id'] }})"
                                    wire:loading.attr="disabled"
                                    wire:target="addToCart({{ $product['id'] }})"
                                    class="bg-brand-dark hover:bg-brand-darker text-white text-sm font-semibold px-4 py-2 rounded-full transition-colors duration-300 disabled:opacity-60"
                                >
                                    <span wire:loading.remove wire:target="addToCart({{ $product['id'] }})">
                                        Add to Cart
                                    </span>
                                    <span wire:loading wire:target="addToCart({{ $product['id'] }})">
                                        Adding...
                                    </span>
                                </button>
                                <span class="font-bold text-gray-900">
                                    ₦{{ number_format($product['price']) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Flash Message --}}
            @if (session()->has('message'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-transition
                    class="fixed top-6 right-6 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50"
                >
                    {{ session('message') }}
                </div>
            @endif

            {{-- Weekly Special Offer Banner --}}
            <div class="bg-brand-cream rounded-3xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 items-center">

                    {{-- Left: Text --}}
                    <div class="p-8 sm:p-10 lg:p-12">
                        <h3 class="font-display text-2xl sm:text-3xl text-gray-900 uppercase mb-4">
                            Weekly Special Offer
                        </h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Order now and get 15% off every banana cake you order, to celebrate the festivities of the week
                        </p>
                        <a
                            href="#"
                            wire:navigate
                            class="inline-flex items-center gap-2 bg-brand-dark hover:bg-brand-darker text-white text-sm font-semibold px-6 py-3 rounded-full transition-colors duration-300"
                        >
                            Shop Offers
                             <span class="inline-flex items-center justify-center w-6 h-6 bg-white rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#3D2314]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H7M17 7V17" />
                                </svg>
                            </span> 
                        </a>
                    </div>

                    {{-- Right: Image --}}
                    <div class="h-64 lg:h-80 p-6 lg:pr-10">
                        <img
                            src="{{ asset('images/banana-bread.svg') }}"
                            alt="Banana cake slices on a plate"
                            class="w-full h-full object-cover rounded-2xl shadow-md"
                        >
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>