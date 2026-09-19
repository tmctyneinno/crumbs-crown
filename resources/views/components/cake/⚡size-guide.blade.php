<?php

use Livewire\Component;

new class extends Component
{
    public array $sizeGuide = [];
};
?>

<div>
    <section> 
        <div class="rounded-3xl bg-[#F6ECE4] p-6 sm:p-10">
            <div class="flex flex-col gap-10 lg:flex-row lg:items-center lg:justify-between">

                {{-- Text + table --}}
                <div class="w-full lg:max-w-md">
                    <h2 class="text-2xl font-extrabold uppercase tracking-tight text-stone-900">
                        How Much Cake Do You Need?
                    </h2>

                    <div class="mt-6 space-y-4">
                        @foreach ($this->sizeGuide as $row)
                            <div class="grid grid-cols-3 gap-4 text-sm text-stone-700">
                                <span class="font-semibold text-stone-900">{{ $row['size'] }}</span>
                                <span>{{ $row['serves'] }}</span>
                                <span>{{ $row['best_for'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex w-full flex-col items-center gap-5 lg:w-auto lg:items-end">
                    <img
                        src="{{ asset('images/misc/tiered-cake.svg') }}"
                        alt="Tiered celebration cake"
                        loading="lazy"
                        class="h-56 w-auto object-contain sm:h-64"
                        onerror="this.src='https://placehold.co/300x340/EFE2D5/6B3A1F?text=%20'"
                    >
                </div>

                {{-- CTA --}}
                <div class="relative top-12 flex w-full flex-col items-center gap-5 lg:top-24 lg:w-auto lg:items-end">
                    <a
                        href="/contact"
                        wire:navigate
                        class="inline-flex w-fit items-center gap-3 rounded-full bg-white py-1.5 pl-5 pr-1.5 text-sm font-bold text-stone-900 shadow-sm ring-1 ring-black/5 transition-shadow hover:shadow-md"
                    >
                        Contact Us
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#4A2A16] text-white">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8M17 7v9" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>