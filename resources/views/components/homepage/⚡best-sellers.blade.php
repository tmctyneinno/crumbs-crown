<?php

use Livewire\Component;

new class extends Component
{
    public array $products = [
        [
            'id' => 1,
            'image' => 'images/cakes/wedding-cake.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'Wedding Cake',
            'description' => 'Elegant, beautifully crafted cakes designed to make your special day memorable.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 2,
            'image' => 'images/cakes/chocolate-fudge-cake.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'Chocolate Fudge Cake',
            'description' => 'Rich, and irresistibly chocolatey, perfect for anyone with a serious sweet tooth.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 3,
            'image' => 'images/cakes/birthday-classic.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'The Birthday Classic',
            'description' => 'A timeless celebration cake made for candles, wishes and happy moments.',
            'rating' => 4.5,
            'price' => 35000,
        ],
        [
            'id' => 4,
            'image' => 'images/cakes/red-velvet-cake.svg',
            'delivery' => 'Free Delivery until 10/10/26',
            'name' => 'Red Velvet Cake',
            'description' => 'Soft, velvety layers paired with smooth cream frosting for a classic favourite.',
            'rating' => 4.5,
            'price' => 35000,
        ],
    ];

     public array $categories = [
        ['id' => 1, 'name' => 'Cakes', 'icon' => 'images/icons/cake.svg', 'photo' => 'images/categories/cakes.svg'],
        ['id' => 2, 'name' => 'Cupcakes', 'icon' => 'images/icons/cupcake.svg', 'photo' => 'images/categories/cupcakes.svg'],
        ['id' => 3, 'name' => 'Pastries', 'icon' => 'images/icons/pastry.svg', 'photo' => 'images/categories/pastries.svg'],
        ['id' => 4, 'name' => 'Cookies', 'icon' => 'images/icons/cookie.svg', 'photo' => 'images/categories/cookies.svg'],
        ['id' => 5, 'name' => 'Desserts', 'icon' => 'images/icons/dessert.svg', 'photo' => 'images/categories/desserts.svg'],
        ['id' => 6, 'name' => 'Gift Boxes', 'icon' => 'images/icons/gift.svg', 'photo' => 'images/categories/gift-boxes.svg'],
    ];

    public array $customSteps = [
        ['icon' => 'users', 'label' => 'Choose your Design'],
        ['icon' => 'handshake', 'label' => 'Pick your Flavor'],
        ['icon' => 'gift', 'label' => 'Select Shape & Size'],
        ['icon' => 'cake', 'label' => 'Share your Inspiration'],
    ];

};
?>

<div>
   <section class="w-full bg-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight uppercase mb-3">
                Our Best Sellers
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Discover our most loved cakes, carefully crafted to make every celebration special
            </p>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            @foreach ($products as $product)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden group">

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
                                class="bg-[#4a2b23] hover:bg-[#3a201a] text-white text-sm font-semibold px-4 py-2 rounded-full transition-colors duration-300 disabled:opacity-60"
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

        {{-- Categories --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-16">
            @foreach ($categories as $category)
                <a
                    href="#"
                    wire:navigate
                    class="relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden p-4 flex flex-col justify-between h-32"
                >
                    {{-- Icon Badge --}}
                    <div class="absolute top-3 left-3 w-9 h-9 bg-[#4a2b23] rounded-full flex items-center justify-center z-10">
                        <img src="{{ asset($category['icon']) }}" alt="" class="w-4 h-4 object-contain">
                    </div>

                    {{-- Background Photo --}}
                    <img
                        src="{{ asset($category['photo']) }}"
                        alt="{{ $category['name'] }}"
                        class="absolute right-2 top-2 w-16 h-16 object-contain opacity-90"
                    >

                    {{-- Label --}}
                    <span class="mt-auto text-sm font-semibold text-gray-800">
                        {{ $category['name'] }}
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Custom Cake CTA --}}
        <div class="bg-[#f5ebe3] rounded-3xl p-8 sm:p-10 lg:p-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">

                {{-- Left: Text --}}
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 uppercase mb-4">
                        Your Idea. Our Oven.
                    </h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        From birthdays and weddings to those "just because" moments, we will turn your ideas into something beautiful and delicious
                    </p>
                    <a
                        href="#"
                        wire:navigate
                        class="inline-flex items-center gap-2 bg-[#4a2b23] hover:bg-[#3a201a] text-white text-sm font-semibold px-6 py-3 rounded-full transition-colors duration-300"
                    >
                        Create your own custom cake
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8m9 0v9" />
                        </svg>
                    </a>
                </div>

                {{-- Right: Steps --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach ($customSteps as $step)
                        <div class="bg-white rounded-xl p-4 flex flex-col items-center justify-center text-center gap-3 h-32">
                            <div class="text-[#4a2b23]">
                                @switch($step['icon'])
                                    @case('users')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a4 4 0 10-8 0" />
                                        </svg>
                                        @break
                                    @case('handshake')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M9 16l-4 4V4a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H9z" />
                                        </svg>
                                        @break
                                    @case('gift')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        @break
                                    @case('cake')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8m16 0a2 2 0 00-2-2H6a2 2 0 00-2 2m16 0H4m8-6V4m0 2c-1 0-1.5-1-1-2s1.5-1 2 0-.5 2-1 2z" />
                                        </svg>
                                        @break
                                @endswitch
                            </div>
                            <span class="text-xs font-semibold text-gray-700 leading-tight">
                                {{ $step['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
</section>
</div>