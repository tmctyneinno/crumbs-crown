<?php

use Livewire\Component;

new class extends Component
{
    public array $reviews = [
        [
            'id' => 1,
            'rating' => 5.0,
            'text' => 'The Chocolate truffle was an absolute delight, everyone loved it',
            'name' => 'Priyla Salma',
        ],
        [
            'id' => 2,
            'rating' => 5.0,
            'text' => 'The wedding cake exceeded all our expectations, truly stunning',
            'name' => 'Michael Johnson',
        ],
        [
            'id' => 3,
            'rating' => 5.0,
            'text' => 'Best red velvet cake I have ever tasted, will order again',
            'name' => 'Sarah Williams',
        ],
        [
            'id' => 4,
            'rating' => 5.0,
            'text' => 'Amazing service and even more amazing pastries, highly recommend',
            'name' => 'David Okafor',
        ],
        [
            'id' => 5,
            'rating' => 5.0,
            'text' => 'The custom birthday cake was exactly what we envisioned, thank you',
            'name' => 'Amaka Chukwu',
        ],
        [
            'id' => 6,
            'rating' => 5.0,
            'text' => 'Fresh, delicious and beautifully packaged every single time',
            'name' => 'Grace Adeyemi',
        ],
    ];

};
?>

<div>
    <section class="w-full bg-white py-16 overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="text-center mb-12">
                <h2 class="font-display font-bold text-3xl sm:text-4xl text-gray-900 uppercase tracking-tight mb-3">
                    Our Clients Review
                </h2>
                <p class="text-gray-600">
                    Hear what our return and new clients have to say
                </p>
            </div>

        </div>

        {{-- Auto-Scrolling Marquee Track --}}
        <div
            x-data="{ paused: false }"
            class="relative w-full"
        >
            {{-- Fade edges --}}
            <div class="pointer-events-none absolute inset-y-0 left-0 w-16 sm:w-32 bg-gradient-to-r from-white to-transparent z-10"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-16 sm:w-32 bg-gradient-to-l from-white to-transparent z-10"></div>

            <div
                class="flex gap-6 w-max"
                :class="paused ? '[animation-play-state:paused]' : '[animation-play-state:running]'"
                style="animation: marquee-scroll 30s linear infinite;"
                @mouseenter="paused = true"
                @mouseleave="paused = false"
            >
                {{-- Render reviews TWICE for seamless infinite loop --}}
                @foreach ([...$reviews, ...$reviews] as $index => $review)
                    <div
                        wire:key="review-{{ $index }}-{{ $review['id'] }}"
                        class="flex-shrink-0 w-72 sm:w-80 bg-white border border-gray-200 rounded-2xl shadow-sm p-6"
                    >
                        {{-- Rating --}}
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex items-center gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg
                                        class="h-4 w-4 {{ $i <= floor($review['rating']) ? 'text-yellow-400' : 'text-gray-200' }}"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.363 1.118l1.287 3.957c.3.921-.755 1.688-1.538 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.197-1.538-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.062 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.287-3.958z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="font-bold text-gray-900">
                                {{ number_format($review['rating'], 1) }}
                            </span>
                        </div>

                        {{-- Review Text --}}
                        <p class="text-gray-700 leading-relaxed mb-6">
                            {{ $review['text'] }}
                        </p>

                        {{-- Reviewer Name --}}
                        <p class="font-bold text-gray-900">
                            -{{ $review['name'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

    </section>
</div>