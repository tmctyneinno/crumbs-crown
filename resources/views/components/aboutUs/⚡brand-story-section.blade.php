<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    /**
     * "Our Values" — the six value cards.
     * Swap for Value::orderBy('sort')->get() once backed by the database.
     */
    #[Computed]
    public function values(): array
    {
        return [
            ['title' => 'Quality',      'desc' => 'We care deeply about what goes into every product.'],
            ['title' => 'Craftmanship', 'desc' => 'Good food is built through skill, patience and attention to detail.'],
            ['title' => 'Creativity',   'desc' => 'We respect the classics but are never afraid to create something new.'],
            ['title' => 'Hospitality',  'desc' => 'Every interaction is part of the Crumbs & Crown experience.'],
            ['title' => 'Consistency',  'desc' => 'Great quality should not depend on which day you order.'],
            ['title' => 'Celebration',  'desc' => 'We believe there is always something worth celebrating.'],
        ];
    }

    /**
     * Bottom category showcase row.
     * Swap for Category::whereIn('slug', [...])->get() once backed by the
     * database.
     */
    #[Computed]
    public function categories(): array
    {
        return [
            ['label' => 'Cakes',     'icon' => 'cake',    'image' => 'cakes.svg'],
            ['label' => 'Cupcakes',  'icon' => 'cupcake', 'image' => 'category-cupcake.svg'],
            ['label' => 'Pastries',  'icon' => 'pastry',  'image' => 'category-pastries.png'],
            ['label' => 'Cookies',   'icon' => 'cookie',  'image' => 'category-cookies.png'],
            ['label' => 'Desserts',  'icon' => 'dessert', 'image' => 'category-desserts.png'],
            ['label' => 'Gift Boxes','icon' => 'gift',    'image' => 'category-gift-boxes.png'],
        ];
    }
};

?>

<div class="bg-white">
    <div class="mx-auto max-w-6xl space-y-14 px-4 py-12 sm:px-6">

        {{-- ============ BORN IN NIGERIA / THE MORGANS ============ --}}
        <section class="rounded-3xl bg-[#F6ECE4] p-8 sm:p-12">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-2">

                <div>
                    <h2 class="font-serif text-2xl font-bold leading-tight text-stone-900 sm:text-3xl">
                        Born in Nigeria,<br>Built for More.
                    </h2>
                    <p class="mt-4 text-sm leading-relaxed text-stone-700">
                        We are building Crumbs &amp; Crown from Nigeria with international ambition, Creating a brand whose quality, creativity and experience can travel beyond borders.
                    </p>
                </div>

                <div class="md:border-l md:border-stone-300 md:pl-10">
                    <h2 class="font-serif text-xl font-bold text-stone-900 sm:text-2xl">
                        The Morgans
                    </h2>
                    <p class="mt-4 text-sm leading-relaxed text-stone-700">
                        Crumbs &amp; Crown is a brand owned by THE MORGANS, a diversified business group with interests across technology, professional services, media, business development and other commercial ventures.
                    </p>
                    <p class="mt-4 text-sm leading-relaxed text-stone-700">
                        As part of THE MORGANS portfolio Crumbs &amp; Crown is being developed as a scalable consumer business with ambitions across retail, digital commerce, corporate gifting, packaged foods, hospitality and international markets.
                    </p>
                </div>
            </div>
        </section>

        {{-- ============ PHILOSOPHY BANNER ============ --}}
        <section class="rounded-3xl bg-[#3A2011] p-8 sm:p-12">
            <p class="text-xs font-bold uppercase tracking-wide text-amber-400 sm:text-sm">
                Taste Comes First
            </p>
            <p class="mt-2 max-w-md text-xs leading-relaxed text-white/70 sm:text-sm">
                Beautiful products may catch attention<br>
                But people return because they taste exceptional
            </p>

            <h3 class="mt-8 font-serif text-2xl font-bold leading-tight text-white sm:text-3xl">
                Presentation gets<br>the first look.
            </h3>

            <h3 class="mt-4 font-serif text-2xl font-bold leading-tight text-amber-400 sm:text-3xl">
                Taste earns the<br>second order.
            </h3>
        </section>

        {{-- ============ OUR VALUES ============ --}}
        <section>
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-[#4A2A16]"></span>
                <span class="text-sm italic text-[#6B3A1F]">What Guides Us</span>
            </div>
            <h2 class="mt-2 font-serif text-3xl font-bold text-stone-900 sm:text-4xl">
                Our Values
            </h2>

            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                @foreach ($this->values as $i => $value)
                    <div class="relative flex flex-col items-center gap-3 rounded-2xl border border-stone-200 bg-white px-4 pb-6 pt-4 text-center">
                        <span class="absolute left-4 top-4 flex h-6 w-6 items-center justify-center rounded-full border border-stone-300 text-[10px] font-semibold text-stone-500">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>

                        <svg class="mt-6 h-7 w-7 text-[#6B3A1F]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 20A7 7 0 019.8 6.1C15.5 5 20 6 20 6s1 4.5-.1 10.2A7 7 0 0111 20z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 21c0-4 3-9 8-11" />
                        </svg>

                        <h3 class="text-sm font-bold uppercase tracking-wide text-stone-900">
                            {{ $value['title'] }}
                        </h3>
                        <p class="text-xs leading-relaxed text-stone-500">
                            {{ $value['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ============ CATEGORY SHOWCASE ============ --}}
        <section>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                @foreach ($this->categories as $category)
                    <a href="/categories/{{ Str::slug($category['label']) }}" wire:navigate class="group block">
                        <div class="relative flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-[#FBF4EC]">
                            {{-- decorative blob --}}
                            <span class="absolute -bottom-6 -right-6 h-24 w-24 rounded-full bg-[#F6ECE4]"></span>

                            {{-- icon badge --}}
                            <span class="absolute left-3 top-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-[#4A2A16] text-white">
                                @switch($category['icon'])
                                    @case('cake')
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-6a2 2 0 012-2h12a2 2 0 012 2v6M4 21h16M6 13V9a2 2 0 012-2h8a2 2 0 012 2v4M12 7V4m0 0a1.2 1.2 0 100-2.4A1.2 1.2 0 0012 4z" />
                                        </svg>
                                        @break
                                    @case('cupcake')
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21l-1.5-9h13L17 21H7zM6 12c0-3 2.5-5 6-5s6 2 6 5M12 7V4" />
                                        </svg>
                                        @break
                                    @case('pastry')
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10c1.5-4 4.5-6 9-6s7.5 2 9 6c-2 1-2 3 0 4-1.5 4-4.5 6-9 6s-7.5-2-9-6c2-1 2-3 0-4z" />
                                        </svg>
                                        @break
                                    @case('cookie')
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.5 12.5a8.5 8.5 0 11-9-8.5c0 2 1.5 3.5 3.5 3.5s3.5-1.5 3.5-3a8.5 8.5 0 012 8z" />
                                            <circle cx="9" cy="13" r="0.8" fill="currentColor" stroke="none" />
                                            <circle cx="13" cy="16" r="0.8" fill="currentColor" stroke="none" />
                                            <circle cx="15" cy="11" r="0.8" fill="currentColor" stroke="none" />
                                        </svg>
                                        @break
                                    @case('dessert')
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v4a8 8 0 01-16 0V4zM8 20h8M12 16v4" />
                                        </svg>
                                        @break
                                    @case('gift')
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12v8H4v-8M2 8h20v4H2V8zm10 0V4m0 4a2 2 0 10-2-2m2 2a2 2 0 102-2" />
                                        </svg>
                                        @break
                                @endswitch
                            </span>

                            <img
                                src="{{ asset('images/categories/' . $category['image']) }}"
                                alt="{{ $category['label'] }}"
                                loading="lazy"
                                class="relative z-10 h-4/5 w-4/5 object-contain transition-transform duration-300 group-hover:scale-105"
                                onerror="this.src='https://placehold.co/240x240/EFE2D5/6B3A1F?text=%20'"
                            >
                        </div>

                        <p class="mt-3 text-sm font-bold text-stone-900">
                            {{ $category['label'] }}
                        </p>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
</div>