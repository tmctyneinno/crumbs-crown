<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    /**
     * "Find Your Cake Style" — visual style categories.
     * Swap for Style::query()->orderBy('sort')->get() once backed by the
     * database.
     */
    #[Computed]
    public function styles(): array
    {
        return [
            [
                'title' => 'Classic & Elegant',
                'desc'  => 'Timeless designs for sophisticated celebrations.',
                'slug'  => 'classic-elegant',
                'image' => 'style-classic-elegant.png',
            ],
            [
                'title' => 'Modern Minimalist',
                'desc'  => 'Clean shapes, subtle details and beautiful finishes.',
                'slug'  => 'modern-minimalist',
                'image' => 'style-modern-minimalist.png',
            ],
            [
                'title' => 'Floral',
                'desc'  => 'Delicate flowers and elegant botanical details.',
                'slug'  => 'floral',
                'image' => 'style-floral.png',
            ],
            [
                'title' => 'Fun & Playful',
                'desc'  => 'Colourful designs made for birthdays and joyful moments.',
                'slug'  => 'fun-playful',
                'image' => 'style-fun-playful.png',
            ],
            [
                'title' => 'Themed',
                'desc'  => 'Personalised cakes inspired by hobbies, character, career and interests.',
                'slug'  => 'themed',
                'image' => 'style-themed.png',
            ],
            [
                'title' => 'Luxury',
                'desc'  => 'Statement cakes designed to steal the spotlight.',
                'slug'  => 'luxury',
                'image' => 'style-luxury.png',
            ],
        ];
    }
};

?>

<div class="bg-white">
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">

        <h2 class="text-center font-[Oswald,ui-sans-serif] text-2xl font-bold uppercase tracking-tight text-stone-900 sm:text-3xl">
            Cakes we have created
        </h2>

        <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($this->styles as $style)
                <a
                    href="#"
                    wire:navigate
                    class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white transition-shadow hover:shadow-md"
                >
                    <div class="aspect-square w-full overflow-hidden bg-stone-100">
                        <img
                            src="{{ asset('images/cakes/' . $style['image']) }}"
                            alt="{{ $style['title'] }}"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            onerror="this.src='https://placehold.co/300x300/EFE7DA/6B3A1F?text=%20'"
                        >
                    </div>

                    <div class="flex flex-1 flex-col gap-1 p-3">
                        <h3 class="text-sm font-bold text-stone-900">
                            {{ $style['title'] }}
                        </h3>
                        <p class="text-xs leading-snug text-stone-500">
                            {{ $style['desc'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>