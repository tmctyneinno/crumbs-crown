<?php

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Computed;

new class extends Component
{
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

    public function selectPastry(int $productId)
    {
        $pastry = Product::active()
            ->whereHas('category', fn ($query) => $query->where('slug', 'pastries'))
            ->findOrFail($productId);

        return redirect()->route('shop', ['search' => $pastry->name]);
    }
};
?>

<div>
    <section>
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
            class="-mx-4 mb-5 flex flex-nowrap gap-2 overflow-x-auto px-4 pb-2 scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-transparent sm:mx-0 sm:px-0"
        >
            @forelse ($this->pastries as $pastry)
                <button
                    wire:click="selectPastry({{ $pastry->id }})"
                    wire:key="pastry-{{ $pastry->id }}"
                    class="w-36 shrink-0 bg-[#f5ebe3] rounded-2xl p-5 flex flex-col items-center gap-2 hover:shadow-md transition-shadow duration-300 focus:outline-none focus:ring-2 focus:ring-[#4a2b23]"
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
    </section>
</div>