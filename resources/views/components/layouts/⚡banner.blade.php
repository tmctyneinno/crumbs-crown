<?php

use Livewire\Component;

new class extends Component
{
    public string $brandLabel = 'A The';
    public string $brandName = 'Morgans';
    public string $brandSuffix = 'Company';

    public string $tagline = '';
    public string $headingLine1 = '';
    public string $headingLine2 = '';
    public string $description = '';

    public string $buttonLabel = 'View All Products';
    public string $buttonUrl = '#';

};
?>

<div>
    <section class="w-full bg-[#5A2F20] px-4 sm:px-6 lg:px-8 pt-6 pb-16 sm:pb-20 lg:pb-24">
        <div class="max-w-7xl mx-auto">

            {{-- Top Brand Tag --}}
            <p class="text-[10px] sm:text-xs uppercase tracking-widest text-white/50 mb-10 sm:mb-16">
                {{ $brandLabel }} <span class="font-bold text-white/70">{{ $brandName }}</span> {{ $brandSuffix }}
            </p>

            {{-- Tagline with line --}}
            <div class="flex items-center gap-3 mb-6">
                <span class="w-8 h-[2px] bg-white/60"></span>
                <span class="uppercase tracking-widest text-sm font-medium text-white/80">
                    {{ $tagline }}
                </span>
            </div>

            {{-- Heading --}}
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-white leading-[1.1] mb-6">
                {{ $headingLine1 }}<br>
                {{ $headingLine2 }}
            </h1>

            {{-- Description --}}
            <p class="text-white/70 text-base sm:text-lg max-w-5xl mb-8">
                {{ $description }}
            </p>

            {{-- CTA Button --}}
            <a
                href="{{ $buttonUrl }}"
                wire:navigate
                class="inline-flex items-center gap-3 bg-white hover:bg-white/90 text-brand-dark text-sm font-semibold pl-6 pr-2 py-2 rounded-full transition-colors duration-300"
            >
                {{ $buttonLabel }}
                <span class="w-7 h-7 bg-brand-dark rounded-full flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8m9 0v9" />
                    </svg>
                </span>
            </a>

        </div>
    </section>
</div>