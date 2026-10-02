<?php

use App\Models\Product;
use App\Services\ShoppingCart;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function products()
    {
        return $this->nigerianProducts()
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->latest()
            ->take(3)
            ->get();
    }

    public array $giftingFeatures = [
        ['icon' => 'users', 'label' => 'Employee Recognition'],
        ['icon' => 'handshake', 'label' => 'Client Appreciation'],
        ['icon' => 'gift', 'label' => 'Festive Gifting'],
        ['icon' => 'cake', 'label' => 'Bespoke Solutions'],
    ];

    #[Computed]
    public function cartQuantities(): array
    {
        return app(ShoppingCart::class)->quantities();
    }

    public function addToCart(int $productId, ShoppingCart $cart): void
    {
        $product = $this->nigerianProducts()->find($productId);

        if (! $product) {
            return;
        }

        $cart->add($product);
        unset($this->cartQuantities);
        $this->dispatch('cart-updated')->to('cart-icon');
        $this->dispatch('toast', message: $product->name . ' added successfully.', type: 'success');
    }

    public function adjustCartQuantity(int $productId, int $change, ShoppingCart $cart): void
    {
        if (! in_array($change, [-1, 1], true)) {
            return;
        }

        $product = $this->nigerianProducts()->find($productId);

        if (! $product) {
            return;
        }

        if ($change === 1) {
            $cart->add($product);
        } else {
            $cart->changeQuantity($productId, $change);
        }

        unset($this->cartQuantities);
        $this->dispatch('cart-updated')->to('cart-icon');
    }

    private function nigerianProducts(): Builder
    {
        return Product::active()
            ->whereHas('category', fn ($query) => $query->whereIn('slug', ['small-chops', 'chin-chin']));
    }
};
?>

<div>
    <section class="w-full bg-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- ================= NIGERIAN COLLECTION CARD ================= --}}
            <div class="bg-[#F6EFE9] rounded-3xl p-6 sm:p-8 lg:p-12">

                {{-- Top Row: Label + Explore Button --}}
                <div class="flex flex-wrap items-center justify-between gap-4 mb-8 lg:mb-10">
                    <p class="text-xs sm:text-sm uppercase tracking-[0.2em] font-bold text-gray-900">
                        Nigerian-Inspired Collection
                    </p>

                    <a
                        href="{{ route('shop', ['categories' => ['small-chops', 'chin-chin']]) }}"
                        wire:navigate
                        class="bg-[#5A2F20] inline-flex items-center gap-3 bg-brand-dark hover:bg-brand-darker text-white text-sm sm:text-base font-semibold pl-6 pr-2 py-2 rounded-full transition-colors duration-300 whitespace-nowrap"
                    >
                        Explore the Collection
                        <span class="inline-flex items-center justify-center w-6 h-6 bg-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#3D2314]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </span> 
                    </a> 
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">

                    {{-- Left: Text Content --}}
                    <div class="lg:col-span-4">
                        <h2 class="font-display font-bold text-3xl sm:text-3xl text-gray-900 uppercase leading-none mb-2">
                            Familiar Flavours.
                        </h2>
                        <p class="font-serif italic text-xl sm:text-2xl text-amber-600 mb-6">
                            A new expression
                        </p>

                        <p class="text-gray-700 text-base leading-relaxed mb-8">
                            Our Nigerian-inspired collection celebrates flavours many of us know and love, interpreted through the contemporary Crumbs &amp; Crown experience.
                        </p>

                        {{-- Quote Box --}}
                        <div class="bg-[#5A2F20] border-2 border-amber-500/50 rounded-2xl p-6 bg-brand-dark text-center">
                            <div class="flex justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 16l-3-3 5.5-5.5L12 12l4.5-4.5L22 13l-3 3-4.5-4.5L10 16 5 11.5 5 16z" />
                                </svg>
                            </div>
                            <p class="text-white text-base mb-3">
                                This is not about<br>replacing tradition
                            </p>
                            <p class="text-amber-400 font-extrabold uppercase text-xl leading-snug">
                                It is About Enjoying<br>It Differently
                            </p>
                        </div>
                    </div>

                    {{-- Right: Product Grid --}}
                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 lg:gap-6">
                            @forelse ($this->products as $product)
                                <div
                                    wire:key="product-{{ $product->id }}"
                                    class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden group"
                                >
                                    {{-- Product Image --}}
                                    <div class="relative">
                                        <img
                                            src="{{ $product->image_url }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-56 sm:h-64 lg:h-72 object-cover group-hover:scale-105 transition-transform duration-500"
                                        >
                                        {{-- Delivery Badge --}}
                                        <div class="absolute bottom-0 left-0 right-0 bg-black/60 backdrop-blur-sm text-white text-xs py-2 px-3 flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            {{ $product->category?->name }}
                                        </div>
                                    </div>

                                    {{-- Product Info --}}
                                    <div class="p-2">
                                        <h3 class="font-bold text-gray-900 text-lg mb-2">
                                            <a href="{{ route('products.show', $product) }}" wire:navigate class="hover:text-[#633e2c] hover:underline">
                                            {{ $product->name }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500 mb-3 leading-relaxed">
                                            {{ $product->description }}
                                        </p>

                                        {{-- Rating --}}
                                        <div class="flex items-center gap-1 mb-4">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg
                                                    class="h-4 w-4 {{ $i <= floor($product->rating) ? 'text-yellow-400' : 'text-gray-200' }}"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.363 1.118l1.287 3.957c.3.921-.755 1.688-1.538 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.197-1.538-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.062 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.287-3.958z" />
                                                </svg>
                                            @endfor
                                            <span class="text-sm text-gray-500 ml-1">{{ number_format($product->rating, 1) }}</span>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex items-center justify-between gap-2">
                                            @if (($this->cartQuantities[$product->id] ?? 0) > 0)
                                                <div class="inline-flex shrink-0 items-center overflow-hidden rounded-full border border-brand-dark text-brand-dark">
                                                    <button type="button" wire:click="adjustCartQuantity({{ $product->id }}, -1)" wire:loading.attr="disabled" aria-label="Remove one {{ $product->name }}" class="flex h-9 w-9 items-center justify-center text-base hover:bg-brand-dark/10 disabled:opacity-50">&minus;</button>
                                                    <span class="min-w-8 text-center text-sm font-semibold" aria-live="polite">{{ $this->cartQuantities[$product->id] }}</span>
                                                    <button type="button" wire:click="adjustCartQuantity({{ $product->id }}, 1)" wire:loading.attr="disabled" aria-label="Add one {{ $product->name }}" class="flex h-9 w-9 items-center justify-center text-base hover:bg-brand-dark/10 disabled:opacity-50">+</button>
                                                </div>
                                            @else
                                                <button
                                                    wire:click="addToCart({{ $product->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="addToCart({{ $product->id }})"
                                                    class="bg-brand-dark hover:bg-brand-darker text-white text-sm font-semibold px-4 py-2.5 rounded-full transition-colors duration-300 disabled:opacity-60"
                                                >
                                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                                                    <span wire:loading wire:target="addToCart({{ $product->id }})">Adding...</span>
                                                </button>
                                            @endif
                                            <span class="font-bold text-gray-900">
                                                ₦{{ number_format($product->price) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="col-span-full py-8 text-center text-sm text-gray-500">Nigerian-inspired products will appear here as they are added to the shop.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

            {{-- ================= BUSINESS GIFTING SECTION ================= --}}
            <div class="bg-[#F6EFE9] rounded-3xl p-6 sm:p-8 lg:p-10 mt-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                    {{-- Left: Text --}}
                    <div class="lg:col-span-4">
                        <h2 class="font-display font-bold text-2xl sm:text-3xl text-gray-900 uppercase mb-4">
                            Business Gifting
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Thoughtful gifts that strengthen relationships, motivate teams and leave a lasting impression
                        </p>
                        <a
                            href="{{ route('shop', ['occasions' => ['corporate-events']]) }}"
                            wire:navigate
                            class="bg-[#5A2F20] inline-flex items-center gap-2 bg-brand-dark hover:bg-brand-darker text-white text-sm font-semibold px-5 py-2.5 rounded-full transition-colors duration-300"
                        >
                            Explore Corporate Orders
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-white rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#3D2314]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H7M17 7V17" />
                                </svg>
                            </span> 
                        </a>
                    </div>

                    {{-- Right: Feature Icons --}}
                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach ($giftingFeatures as $feature)
                                <div class="bg-white rounded-2xl p-6 flex flex-col items-center justify-center text-center gap-4 h-36 shadow-sm">
                                    <div class="text-gray-800">
                                        @switch($feature['icon'])
                                            @case('users')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a4 4 0 10-8 0" />
                                                </svg>
                                                @break
                                            @case('handshake')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M9 16l-4 4V4a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H9z" />
                                                </svg>
                                                @break
                                            @case('gift')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                @break
                                            @case('cake')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 14v6a2 2 0 002 2h12a2 2 0 002-2v-6m-16 0a2 2 0 012-2h12a2 2 0 012 2m-16 0h16M12 8V4m0 2c-1 0-1.5-1-1-2s1.5-1 2 0-.5 2-1 2z" />
                                                </svg>
                                                @break
                                        @endswitch
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800 leading-tight">
                                        {{ $feature['label'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>


            </div>
    </section>
</div> 