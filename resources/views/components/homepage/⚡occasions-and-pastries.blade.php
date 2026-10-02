<?php

use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function occasions(): array
    {
        $assets = [
            'birthday' => ['image' => 'images/occasions/birthday.svg', 'icon' => 'cake'],
            'wedding' => ['image' => 'images/occasions/wedding.svg', 'icon' => 'rings'],
            'corporate-events' => ['image' => 'images/occasions/corporate.svg', 'icon' => 'gift'],
            'anniversary' => ['image' => 'images/occasions/anniversary.svg', 'icon' => 'heart-hands'],
            'just-because' => ['image' => 'images/occasions/just-because.svg', 'icon' => 'sparkle'],
        ];

        return Product::active()
            ->whereNotNull('occasion')
            ->selectRaw('occasion, COUNT(*) as count')
            ->groupBy('occasion')
            ->orderBy('occasion')
            ->get()
            ->map(fn (Product $product) => [
                'slug' => $product->occasion,
                'name' => Str::headline($product->occasion),
                'count' => $product->count,
                'image' => $assets[$product->occasion]['image'] ?? 'images/occasions/birthday.svg',
                'icon' => $assets[$product->occasion]['icon'] ?? 'cake',
            ])
            ->all();
    }

    #[Computed]
    public function pastries()
    {
        return Product::active()
            ->whereHas('category', fn ($query) => $query->where('slug', 'pastries'))
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->latest()
            ->take(12)
            ->get();
    }

    public function selectOccasion(string $occasion)
    {
        abort_unless(Product::active()->where('occasion', $occasion)->exists(), 404);

        return redirect()->route('shop', ['occasions' => [$occasion]]);
    }

    public function selectPastry(int $pastryId)
    {
        $pastry = Product::active()
            ->whereKey($pastryId)
            ->whereHas('category', fn ($query) => $query->where('slug', 'pastries'))
            ->firstOrFail();

        return redirect()->route('shop', ['categories' => [$pastry->category->slug]]);
    }

};
?>

<div>
    <section class="w-full bg-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">

            {{-- ================= OCCASIONS HEADER ================= --}}
            <div class="text-center mb-12">
                <p class="text-xs uppercase tracking-widest italic text-gray-500 mb-2">
                    There is Always
                </p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#4a2b23] uppercase mb-4">
                    A Reason for Cake
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    From everyday indulgences to life's biggest celebrations, we have something for everyone.
                </p>
            </div>

            {{-- ================= OCCASIONS GRID ================= --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                @forelse ($this->occasions as $occasion)
                    <button
                        wire:click="selectOccasion('{{ $occasion['slug'] }}')"
                        wire:key="occasion-{{ $occasion['slug'] }}"
                        class="group relative bg-[#f5ebe3] rounded-2xl overflow-hidden text-left focus:outline-none focus:ring-2 focus:ring-[#4a2b23] transition-shadow duration-300 hover:shadow-lg"
                    >
                        {{-- Image --}}
                        <div class="h-40 overflow-hidden">
                            <img
                                src="{{ asset($occasion['image']) }}"
                                alt="{{ $occasion['name'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                        </div>

                        {{-- Icon + Label --}}
                        <div class="relative pt-6 pb-4 px-3 text-center">
                            {{-- Floating Icon --}}
                            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-11 h-11 bg-white rounded-full shadow-md flex items-center justify-center text-[#4a2b23]">
                                @switch($occasion['icon'])
                                    @case('cake')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v3m0 0c-1 0-1.5-1-1-2s1.5-1 2 0-.5 2-1 2zM4 14v6a2 2 0 002 2h12a2 2 0 002-2v-6M4 14a2 2 0 012-2h12a2 2 0 012 2M4 14c1.5 1 3 1 4.5 0s3-1 4.5 0 3 1 4.5 0" />
                                        </svg>
                                        @break
                                    @case('rings')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="9" cy="15" r="4" />
                                            <circle cx="15" cy="15" r="4" />
                                            <path stroke-linecap="round" d="M12 8V6" />
                                        </svg>
                                        @break
                                    @case('gift')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8M20 12a2 2 0 00-2-2H6a2 2 0 00-2 2m16 0H4m8-6c-2 0-3-1.5-2-3s3-1 3 1v2zm0-6c2 0 3 1.5 2 3s-3 1-3-1v-2z" />
                                        </svg>
                                        @break
                                    @case('heart-hands')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21C7 16 2 12.5 2 8.5A4.5 4.5 0 0112 6a4.5 4.5 0 0110 2.5C22 12.5 17 16 12 21z" />
                                        </svg>
                                        @break
                                    @case('sparkle')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h1.5M9 12a3 3 0 106 0 3 3 0 00-6 0zM3 9h1.5M20.5 9H22M12 3v1.5M12 20.5V22M4.9 4.9l1.06 1.06M17.04 17.04l1.06 1.06M4.9 19.1l1.06-1.06M17.04 6.96l1.06-1.06" />
                                        </svg>
                                        @break
                                @endswitch
                            </div>

                            <p class="text-sm font-bold text-gray-900 uppercase tracking-wide mt-3">
                                {{ $occasion['name'] }}
                            </p>
                        </div>
                    </button>
                @empty
                    <p class="col-span-full py-8 text-center text-sm text-gray-500">Occasion selections will appear as products are added.</p>
                @endforelse
            </div>

            {{-- Explore All Button --}}
            <div class="flex justify-center mb-20">
                <a
                    href="{{ route('shop') }}"
                    wire:navigate
                    class="inline-flex items-center gap-2 bg-[#4a2b23] hover:bg-[#3a201a] text-white text-sm font-semibold px-6 py-3 rounded-full transition-colors duration-300"
                >
                    Explore All
                     <span class="inline-flex items-center justify-center w-6 h-6 bg-white rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#3D2314]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H7M17 7V17" />
                        </svg>
                    </span>
                </a>
            </div>

            {{-- ================= PASTRIES SECTION ================= --}}
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 uppercase">
                    Explore Your Favourite Baked Pastries
                </h3>
                <a
                    href="{{ route('pastries.index') }}"
                    wire:navigate
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-800 hover:text-[#4a2b23] transition-colors whitespace-nowrap"
                >
                    View All Pastries
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            {{-- Pastries Scrollable Row --}}
            <div
                x-data="{
                    paused: false,
                    direction: 1,
                    scrollTimer: null,
                    init() {
                        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                        this.scrollTimer = window.setInterval(() => {
                            if (this.paused) return;
                            const maxScroll = this.$el.scrollWidth - this.$el.clientWidth;
                            if (maxScroll <= 0) return;
                            if (this.$el.scrollLeft >= maxScroll) this.direction = -1;
                            if (this.$el.scrollLeft <= 0) this.direction = 1;
                            this.$el.scrollLeft += this.direction;
                        }, 30);
                    },
                    destroy() {
                        window.clearInterval(this.scrollTimer);
                    }
                }"
                @mouseenter="paused = true"
                @mouseleave="paused = false"
                @focusin="paused = true"
                @focusout="paused = false"
                @pointerdown="paused = true"
                @pointerup.window="paused = false"
                @pointercancel.window="paused = false"
                aria-label="Pastry products"
                class="-mx-4 mb-20 flex flex-nowrap gap-4 overflow-x-auto px-4 pb-4 scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-transparent sm:mx-0 sm:px-0"
            >
                @forelse ($this->pastries as $pastry)
                    <button
                        wire:click="selectPastry({{ $pastry->id }})"
                        wire:key="pastry-{{ $pastry->id }}"
                        class="w-36 shrink-0 bg-[#f5ebe3] rounded-2xl p-5 flex flex-col items-center gap-4 hover:shadow-md transition-shadow duration-300 focus:outline-none focus:ring-2 focus:ring-[#4a2b23]"
                    >
                        <img
                            src="{{ $pastry->image_url }}"
                            alt="{{ $pastry->name }}"
                            class="w-20 h-20 object-contain"
                        >
                        <span class="text-sm font-semibold text-gray-800 text-center">
                            {{ $pastry->name }}
                        </span>
                    </button>
                @empty
                    <p class="py-8 text-sm text-gray-500">Pastries will appear here when they are added to the shop.</p>
                @endforelse
            </div>

            {{-- ================= BUILD YOUR BOX CTA ================= --}}
            <div class="bg-[#f5ebe3] rounded-3xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 items-center">

                    {{-- Left: Text --}}
                    <div class="p-8 sm:p-10 lg:p-12">
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 uppercase mb-4">
                            Build Your Perfect Box
                        </h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Choose your box size and pastries you want loaded inside the box. Create the perfect box for your self
                        </p>
                        <a
                            href="#"
                            wire:navigate
                            class="inline-flex items-center gap-2 bg-[#4a2b23] hover:bg-[#3a201a] text-white text-sm font-semibold px-6 py-3 rounded-full transition-colors duration-300"
                        >
                            Build Box
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-white rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#3D2314]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H7M17 7V17" />
                                </svg>
                            </span>
                        </a>
                    </div>

                    {{-- Right: Image --}}
                    <div class="h-64 lg:h-64">
                        <img
                            src="{{ asset('images/pastry-box.svg') }}"
                            alt="Assorted pastry box"
                            class="w-full h-full object-cover"
                        >
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>