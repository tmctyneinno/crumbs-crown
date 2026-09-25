<?php

namespace App\Livewire;

use Livewire\Component;

new class extends Component
{
    /**
     * Feature cards data. Swap the `image` paths for your own
     * asset() / Storage::url() calls as needed.
     */
    public array $features = [
        [
            'title'       => 'Exceptional Taste',
            'description' => 'Products created with flavour as the foundation',
            'image'       => 'images/misc/tiered-cake.svg',
        ],
        [
            'title'       => 'Seamless Ordering',
            'description' => 'Making it easy to find, order and enjoy what you love',
            'image'       => 'images/misc/tiered-cake.svg',
        ],
    ];

};

?>

<div>
   <div class="w-full py-10 px-4">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($features as $feature)
            <div
                wire:key="feature-{{ $loop->index }}"
                class="relative overflow-hidden rounded-[28px] bg-[#f7ece2] min-h-[220px] sm:min-h-[260px]"
            >
                {{-- Text content --}}
                <div class="relative z-10 h-full flex flex-col justify-center gap-3 pl-8 pr-40 py-10 sm:pl-10 sm:pr-48">
                    <h3 class="font-black uppercase tracking-tight text-2xl sm:text-3xl text-neutral-900 leading-none">
                        {{ $feature['title'] }}
                    </h3>
                    <p class="text-neutral-800 text-base sm:text-lg leading-snug max-w-[220px]">
                        {{ $feature['description'] }}
                    </p>
                </div>

                {{-- Image, bleeding off the right / bottom edge of the card --}}
                <img
                    src="{{ asset($feature['image']) }}"
                    alt="{{ $feature['title'] }}"
                    class="pb-5 pointer-events-none select-none absolute right-0 bottom-0 h-[80%] max-h-none w-auto object-contain object-bottom-right translate-y-2"
                    loading="lazy"
                />
            </div>
        @endforeach
    </div>
</div>

</div>