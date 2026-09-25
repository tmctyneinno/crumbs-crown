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
                        Your Idea. Our Oven.
                    </h2>

                    <p class="mt-3 text-sm leading-relaxed text-stone-700">
                        From birthdays and weddings to those "just because" moments, we will turn your ideas into something beautiful and delicious.
                    </p>

                    <a
                        href="/custom-cakes"
                        wire:navigate
                        class="mt-5 inline-flex w-fit items-center gap-3 rounded-full bg-[#4A2A16] py-2 pl-6 pr-2 text-sm font-bold text-white shadow-sm transition-colors hover:bg-[#3A2011]"
                    >
                        Create your own custom cake
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white">
                            <svg class="h-4 w-4" style="color: #4A2A16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8M17 7v9" />
                            </svg>
                        </span>
                    </a>
                </div>

                {{-- Steps --}}
                <div class="grid w-full grid-cols-2 gap-3 sm:grid-cols-4 lg:w-auto">
                    @foreach ($this->customCakeSteps as $step)
                        <div class="flex flex-col items-center gap-3 rounded-2xl bg-white p-4 text-center sm:w-[100px]">
                            <span class="flex h-10 w-10 items-center justify-center text-stone-800">
                                @switch($step['icon'])
                                    @case('users')
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20v-1a4 4 0 00-4-4H7a4 4 0 00-4 4v1M9 11a3 3 0 100-6 3 3 0 000 6zm9 9v-1a3.5 3.5 0 00-2.5-3.36M15 4.3a3 3 0 010 5.4" />
                                        </svg>
                                        @break
                                    @case('flavor')
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3-3 3 3M9 15h6M3 7l3 3-3 3M21 7l-3 3 3 3" />
                                        </svg>
                                        @break
                                    @case('gift')
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12v8H4v-8M2 8h20v4H2V8zm10 0V4m0 4a2 2 0 10-2-2m2 2a2 2 0 102-2" />
                                        </svg>
                                        @break
                                    @case('bag')
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16l-1.5 12h-13L4 8zm4 0V6a4 4 0 018 0v2" />
                                        </svg>
                                        @break
                                @endswitch
                            </span>
                            <span class="text-xs font-semibold leading-snug text-stone-800">
                                {{ $step['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>