<?php

use Livewire\Component;

new class extends Component
{
    public array $categories = [];
};
?>
 
<div>
    <section>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-sm font-bold uppercase tracking-wide text-stone-900">Find Your Perfect Cake</h2>
            <a href="{{ route('shop', ['categories' => ['cakes']]) }}" wire:navigate class="text-xs font-semibold text-[#8A5A34] hover:underline">
                View All Categories &rarr;
            </a>
        </div>

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
            role="region"
            aria-label="Cake occasions"
            class="-mx-4 flex flex-nowrap gap-4 overflow-x-auto px-4 pb-4 scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-transparent sm:mx-0 sm:px-0"
        >
            @foreach ($this->categories as $category)
                <a
                    href="{{ route('shop', [$category['filter'] => [$category['slug']]]) }}"
                    wire:navigate
                    class="group flex w-32 shrink-0 flex-col items-center gap-3 rounded-2xl bg-[#F6ECE4] p-4 text-center transition-transform hover:-translate-y-0.5"
                >
                    <img
                        src="{{ asset('images/categories/' . $category['image']) }}"
                        alt="{{ $category['name'] }}"
                        loading="lazy"
                        class=" rounded-full object-cover"
                        onerror="this.src='https://placehold.co/112x112/EFE2D5/6B3A1F?text=%20'"
                    >
                    <span class="text-xs font-semibold leading-snug text-stone-800">
                        {{ $category['name'] }}
                    </span>
                </a>
            @endforeach
        </div>
    </section>
</div>