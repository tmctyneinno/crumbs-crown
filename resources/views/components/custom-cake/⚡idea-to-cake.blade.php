<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    /**
     * "From Idea to Cake" — the 5-step custom order process, left to right.
     */
    #[Computed]
    public function steps(): array
    {
        return [
            [
                'title' => 'Share your Vision',
                'desc'  => 'Tell us what you are imagining or upload an inspiration image.',
            ],
            [
                'title' => 'Choose your Details',
                'desc'  => 'Select your flavour, size, shape, colours and finishing touches.',
            ],
            [
                'title' => 'Get your Quote',
                'desc'  => "We'll review your request and provide a price based on your design.",
            ],
            [
                'title' => 'We Create',
                'desc'  => 'Our cake artists bring your idea to life with care and precision.',
            ],
            [
                'title' => 'Enjoy your Moment',
                'desc'  => 'Your custom is delivered or ready for pick up. Celebrate!',
            ],
        ];
    }

    /**
     * "Need Some Inspiration?" gallery thumbnails.
     * Swap for Gallery::latest()->take(4)->get() once backed by the database.
     */
    #[Computed]
    public function inspirationGallery(): array
    {
        return [
            ['image' => 'inspo-1.svg', 'alt' => 'Chocolate drip cake with dark chocolate shards'],
            ['image' => 'inspo-2.svg', 'alt' => 'Cream cake with strawberries and chocolate drip'],
            ['image' => 'inspo-3.svg', 'alt' => 'White buttercream cake with gold pearls'],
            ['image' => 'chocolate-fudge-cake.svg', 'alt' => 'Chocolate cake with chocolate bark topping'],
        ];
    }
};

?>

<div class="bg-white">
    <div class="mx-auto max-w-5xl space-y-10 px-4 py-12 sm:px-6">

        {{-- ============ FROM IDEA TO CAKE ============ --}}
        <section>
            <h2 class="text-center font-[Oswald,ui-sans-serif] text-2xl font-bold uppercase tracking-tight text-stone-900 sm:text-3xl">
                From Idea to Cake
            </h2>

            {{-- Fixed 5-column stepper: the dashed connector spans from the
                 centre of the first column (10%) to the centre of the last
                 column (90%), sitting behind the circles so it visually
                 breaks into segments between them. --}}
            <div class="relative mt-10">
                <div class="pointer-events-none absolute left-[10%] right-[10%] top-[22px] border-t-2 border-dashed border-stone-300"></div>

                <div class="relative grid grid-cols-5 gap-2">
                    @foreach ($this->steps as $i => $step)
                        <div class="flex flex-col items-center gap-3 px-1 text-center">
                            <span class="relative z-10 flex h-11 w-11 shrink-0 items-center justify-center rounded-full border-2 border-[#4A2A16] bg-white text-sm font-bold text-[#4A2A16]">
                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <h3 class="text-[13px] font-bold uppercase tracking-wide text-[#6B3A1F] sm:text-sm">
                                {{ $step['title'] }}
                            </h3>

                            <p class="max-w-[170px] text-sm leading-relaxed text-stone-600">
                                {{ $step['desc'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============ NEED SOME INSPIRATION? ============ --}}
        <section>
            <div class="rounded-3xl bg-[#F6ECE4] p-2 sm:p-10">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Text + CTA --}}
                    <div class="w-full lg:max-w-xs">
                        <h2 class="font-[Oswald,ui-sans-serif] text-2xl font-bold uppercase tracking-tight text-stone-900">
                            Need Some Inspiration?
                        </h2>

                        <p class="mt-3 text-sm leading-relaxed text-stone-700">
                            Browse some of our favourite creations and find the perfect ideas for your next celebration.
                        </p>

                        <a
                            href="#"
                            wire:navigate
                            class="mt-5 inline-flex w-fit items-center gap-3 rounded-full bg-[#4A2A16] py-2 pl-6 pr-2 text-sm font-bold text-white shadow-sm transition-colors hover:bg-[#3A2011]"
                        >
                            Get Inspired
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white">
                                <svg class="h-4 w-4" style="color: #4A2A16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8M17 7v9" />
                                </svg>
                            </span>
                        </a>
                    </div>

                    {{-- Gallery --}}
                    <div class="grid w-full grid-cols-2 gap-2 sm:grid-cols-4 lg:w-auto">
                        @foreach ($this->inspirationGallery as $item)
                            <a
                                href="/gallery"
                                wire:navigate
                                class="block aspect-[4/4] w-full overflow-hidden rounded-2xl bg-stone-100 sm:w-[130px]"
                            >
                                <img
                                    src="{{ asset('images/cakes/' . $item['image']) }}"
                                    alt="{{ $item['alt'] }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
                                    onerror="this.src='https://placehold.co/300x400/EFE2D5/6B3A1F?text=%20'"
                                >
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>