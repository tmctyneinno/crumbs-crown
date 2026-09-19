<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    /**
     * The three feature/CTA cards along the top.
     * Swap this for a real query (e.g. Promotion::where('type','feature')->get())
     * once this is backed by a CMS/admin panel.
     */
    #[Computed]
    public function features(): array
    {
        return [
            [
                'title'   => "Custom Cakes\nMade Just for You",
                'desc'    => 'Your idea, our oven — let’s create something unforgettable.',
                'cta'     => 'Create your Cake',
                'href'    => '/custom-cakes',
            ],
            [
                'title'   => "Corporate &\nEvent Catering",
                'desc'    => 'From small meetings to big celebrations, we cater it all.',
                'cta'     => 'Explore',
                'href'    => '/catering',
            ],
            [
                'title'   => "Bulk Orders &\nSpecial Requests",
                'desc'    => 'Get in touch for bulk orders, custom treats & more.',
                'cta'     => 'Contact Us',
                'href'    => '/contact',
            ],
        ];
    }

    /**
     * The weekly offer banner. In production this would come from a
     * Promotion model with a start/end date, discount %, product and image.
     */
    #[Computed]
    public function offer(): array
    {
        return [
            'label'        => 'Weekly Special Offer',
            'description'  => 'Order now and get 15% off every banana cake you order, to celebrate the festivities of the week.',
            'cta'          => 'Shop Offers',
            'href'         => '/shop?promo=banana-cake-15',
            'image'        => 'banana-bread.svg',
            'ends_at'      => now()->endOfWeek()->toIso8601String(),
        ];
    }

    
}
?>

<div>
    <div class="bg-white">
        <div class="mx-auto max-w-6xl  px-4 py-10 sm:px-6 lg:px-8">

            {{-- ============ FEATURE CARDS ============ --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                @foreach ($this->features as $feature)
                    <div class="flex flex-col justify-between rounded-3xl bg-[#F6ECE4] p-6">
                        <div>
                            <h3 class="text-[15px] font-bold uppercase leading-snug tracking-tight text-stone-900">
                                @foreach (explode("\n", $feature['title']) as $line)
                                    {{ $line }}@if (! $loop->last)<br>@endif
                                @endforeach
                            </h3>
                            <p class="mt-3 text-sm leading-relaxed text-stone-600">
                                {{ $feature['desc'] }}
                            </p>
                        </div>

                        <a
                            href="{{ $feature['href'] }}"
                            wire:navigate
                            class="mt-5 inline-flex w-fit items-center gap-3 rounded-full bg-white py-1.5 pl-5 pr-1.5 text-sm font-bold text-stone-900 shadow-sm ring-1 ring-black/5 transition-shadow hover:shadow-md"
                        >
                            {{ $feature['cta'] }}
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#4A2A16] text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8M17 7v9" />
                                </svg>
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- ============ WEEKLY SPECIAL OFFER ============ --}}
            @php $offer = $this->offer; @endphp
            <div class="mt-10 overflow-hidden rounded-3xl bg-[#F6ECE4]">
                <div class="flex flex-col items-center gap-8 p-0 sm:p-5 lg:flex-row lg:justify-between lg:px-5">

                    <div class="w-full lg:max-w-lg">
                        <h2 class="font-[Oswald,ui-sans-serif] text-3xl font-bold uppercase tracking-tight text-stone-900 sm:text-4xl">
                            {{ $offer['label'] }}
                        </h2>

                        <p class="mt-4 text-base leading-relaxed text-stone-700">
                            {{ $offer['description'] }}
                        </p>

                        <a
                            href="{{ $offer['href'] }}"
                            wire:navigate
                            class="mt-6 inline-flex w-fit items-center gap-3 rounded-full bg-[#4A2A16] py-2 pl-6 pr-2 text-sm font-bold text-white shadow-sm transition-colors hover:bg-[#3A2011]"
                        >
                            {{ $offer['cta'] }}
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white/15">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8M17 7v9" />
                                </svg>
                            </span>
                        </a>
                    </div>

                    <div class="w-full max-w-md shrink-0 lg:w-[400px]">
                        <img
                            src="{{ asset('images/' . $offer['image']) }}"
                            alt="{{ $offer['label'] }}"
                            loading="lazy"
                            class="aspect-[4/3] w-full rounded-2xl object-cover"
                            onerror="this.src='https://placehold.co/640x480/EFE2D5/6B3A1F?text=%20'"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>