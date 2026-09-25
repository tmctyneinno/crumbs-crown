<?php

use Livewire\Component;

new class extends Component
{
    public array $customCakeSteps = [];
};
?>

<div>
    <section>
        <div class="rounded-3xl bg-[#F6ECE4] p-6 sm:p-10">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

                {{-- Text + CTA --}}
                <div class="w-full lg:max-w-sm">
                    <h2 class="text-2xl font-extrabold uppercase tracking-tight text-stone-900">
                        Freshly from the Oven
                    </h2>

                    <p class="mt-3 text-sm leading-relaxed text-stone-700">
                        From birthdays and weddings to those "just because" moments, we will turn your ideas into something beautiful and delicious.
                    </p>

                    <a
                        href="/custom-cakes"
                        wire:navigate
                        class="mt-5 inline-flex w-fit items-center gap-3 rounded-full bg-[#4A2A16] py-2 pl-6 pr-2 text-sm font-bold text-white shadow-sm transition-colors hover:bg-[#3A2011]"
                    >
                        Create your own custom parties
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white">
                            <svg class="h-4 w-4" style="color: #4A2A16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8M17 7v9" />
                            </svg>
                        </span>
                    </a>
                </div>

                {{-- Single image --}}
                <div class="w-full ">
                    <div class="overflow-hidden rounded-[16px] border border-[#E8D8C6] bg-white p-1 shadow-sm">
                        <img
                            src="{{ asset('images/pastries/pastry-img.svg') }}"
                            alt="Custom pastries"
                            class="h-[220px] w-full rounded-[16px] object-cover"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>