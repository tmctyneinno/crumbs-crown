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
            <h2 class="text-sm font-bold uppercase tracking-wide text-stone-900">EXPLORE YOUR FAVOURITE BAKED PASTRIES</h2>
            <a href="{{ route('pastries.index') }}" wire:navigate class="text-xs font-semibold text-[#8A5A34] hover:underline">
                View All Pastries &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7">
            @foreach ($this->categories as $category)
                <a
                    href="{{ route('pastries.show', $category['slug']) }}"
                    wire:navigate
                    class="group flex shrink-0 flex-col items-center gap-3 rounded-2xl bg-[#F6ECE4] p-4 text-center transition-transform hover:-translate-y-0.5"
                >
                    <img
                        src="{{ asset('images/pastries/' . $category['image']) }}"
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