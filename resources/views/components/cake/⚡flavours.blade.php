<?php

use Livewire\Component;

new class extends Component
{
    public array $flavours = [];
};
?>

<div>
    <section>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-sm font-bold uppercase tracking-wide text-stone-900">Choose Your Flavour</h2>
            <a href="/flavours" wire:navigate class="text-xs font-semibold text-[#8A5A34] hover:underline">
                Explore All Flavours &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7">
            @foreach ($this->flavours as $flavour)
                <a
                    href="/flavours/{{ Str::slug($flavour['name']) }}"
                    wire:navigate
                    class="group flex shrink-0 flex-col items-center gap-3 rounded-2xl bg-[#F6ECE4] p-4 text-center transition-transform hover:-translate-y-0.5"
                >
                    <img
                        src="{{ asset('images/flavours/' . $flavour['image']) }}"
                        alt="{{ $flavour['name'] }}"
                        loading="lazy"
                        class="h-14 w-14 rounded-full object-cover"
                        onerror="this.src='https://placehold.co/112x112/EFE2D5/6B3A1F?text=%20'"
                    >
                    <span class="text-xs font-semibold text-stone-800">{{ $flavour['name'] }}</span>
                </a>
            @endforeach
        </div>
    </section>
</div>