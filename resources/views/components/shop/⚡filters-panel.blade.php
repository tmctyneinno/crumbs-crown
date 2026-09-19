<?php

use Livewire\Component;

new class extends Component
{
    public array $categories = [];
    public int $minPrice = 1000;
    public int $maxPrice = 100000;
    public array $occasions = [];
    public array $dietary = [];
    public array $ratings = [];

    public array $categoryOptions = [
        'cakes' => ['label' => 'Cakes', 'count' => 66],
        'cupcakes' => ['label' => 'Cupcakes', 'count' => 66],
        'pastries' => ['label' => 'Pastries', 'count' => 66],
        'desserts' => ['label' => 'Desserts', 'count' => 66],
        'chocolates' => ['label' => 'Chocolates', 'count' => 66],
        'small-chops' => ['label' => 'Small Chops', 'count' => 66],
        'chin-chin' => ['label' => 'Chin Chin', 'count' => 66],
        'corporate-events' => ['label' => 'Corporate Events', 'count' => 66],
    ];

    public array $occasionOptions = [
        'birthday' => ['label' => 'Birthday', 'count' => 66],
        'wedding' => ['label' => 'Wedding', 'count' => 66],
        'anniversary' => ['label' => 'Anniversary', 'count' => 66],
        'corporate-events' => ['label' => 'Corporate Events', 'count' => 66],
        'just-because' => ['label' => 'Just Because', 'count' => 66],
    ];

    public array $dietaryOptions = [
        'eggless' => ['label' => 'Eggless', 'count' => 66],
        'sugar-free' => ['label' => 'Sugar-free', 'count' => 66],
        'gluten-free' => ['label' => 'Gluten-free', 'count' => 66],
        'low-sugar' => ['label' => 'Low-sugar', 'count' => 66],
    ];

    public array $ratingOptions = [5 => 66, 4 => 66, 3 => 66, 2 => 66, 1 => 66];

    public function toggleCategory(string $key): void
    {
        $this->toggle('categories', $key);
    }

    public function toggleOccasion(string $key): void
    {
        $this->toggle('occasions', $key);
    }

    public function toggleDietary(string $key): void
    {
        $this->toggle('dietary', $key);
    }

    public function toggleRating(int $key): void
    {
        $this->toggle('ratings', $key);
    }

    public function clearFilters(): void
    {
        $this->reset(['categories', 'minPrice', 'maxPrice', 'occasions', 'dietary', 'ratings']);
        $this->minPrice = 1000;
        $this->maxPrice = 100000;
    }

    public function applyFilters(): void
    {
        $this->dispatch('filters-applied');
    }

    private function toggle(string $property, string|int $value): void
    {
        $values = $this->{$property};
        $index = array_search($value, $values, true);

        if ($index === false) {
            $values[] = $value;
        } else {
            unset($values[$index]);
        }

        $this->{$property} = array_values($values);
    }
};
?>

<div>
   <div class="rounded-2xl border border-stone-200 bg-white p-5">

    {{-- Header --}}
    <div class="mb-5 flex items-center justify-between">
        <h2 class="text-sm font-bold uppercase tracking-wide text-stone-800">Filter Products</h2>
        <button wire:click="clearFilters" class="text-sm font-medium text-[#6B3A1F] hover:underline">
            Clear All
        </button>
    </div>

    {{-- Categories --}}
    <div class="border-t border-stone-200 py-4" x-data="{ open: true }">
        <button type="button" @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-stone-800">
            CATEGORIES
            <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-collapse class="mt-3 space-y-2.5">
            <label class="flex cursor-pointer items-center justify-between text-sm text-stone-700">
                <span class="flex items-center gap-2">
                    <input type="checkbox" checked disabled class="h-4 w-4 rounded border-stone-300 text-[#4A2A16] focus:ring-[#4A2A16]">
                    All Products
                </span>
                <span class="text-stone-400">(256)</span>
            </label>

            @foreach ($this->categoryOptions as $key => $opt)
                <label class="flex cursor-pointer items-center justify-between text-sm text-stone-700">
                    <span class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            wire:click="toggleCategory('{{ $key }}')"
                            @checked(in_array($key, $categories, true))
                            class="h-4 w-4 rounded border-stone-300 text-[#4A2A16] focus:ring-[#4A2A16]"
                        >
                        {{ $opt['label'] }}
                    </span>
                    <span class="text-stone-400">({{ $opt['count'] }})</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Price range --}}
    <div class="border-t border-stone-200 py-4" x-data="{ open: true }">
        <button type="button" @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-stone-800">
            PRICE RANGE
            <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-collapse class="mt-4 space-y-4">
            <input
                type="range"
                min="1000"
                max="100000"
                step="1000"
                wire:model.live.debounce.300ms="maxPrice"
                class="w-full accent-[#4A2A16]"
            >
            <div class="flex items-center justify-between text-sm font-medium text-stone-700">
                <span>&#8358;{{ number_format($minPrice) }}</span>
                <span>&#8358;{{ number_format($maxPrice) }}+</span>
            </div>

            <div class="space-y-2.5 pt-1">
                @foreach ([
                    ['label' => 'Under ₦5,000', 'min' => 0, 'max' => 5000],
                    ['label' => '₦5,000 - ₦20,000', 'min' => 5000, 'max' => 20000],
                    ['label' => '₦20,000 - ₦50,000', 'min' => 20000, 'max' => 50000],
                    ['label' => '₦50,000 - ₦100,000', 'min' => 50000, 'max' => 100000],
                    ['label' => '₦100,000+', 'min' => 100000, 'max' => 1000000],
                ] as $band)
                    <label class="flex cursor-pointer items-center justify-between text-sm text-stone-700">
                        <span class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                wire:click="$set('minPrice', {{ $band['min'] }}); $set('maxPrice', {{ $band['max'] }})"
                                class="h-4 w-4 rounded border-stone-300 text-[#4A2A16] focus:ring-[#4A2A16]"
                            >
                            {{ $band['label'] }}
                        </span>
                        <span class="text-stone-400">(66)</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Occasions --}}
    <div class="border-t border-stone-200 py-4" x-data="{ open: true }">
        <button type="button" @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-stone-800">
            OCCASIONS
            <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-collapse class="mt-3 space-y-2.5">
            @foreach ($this->occasionOptions as $key => $opt)
                <label class="flex cursor-pointer items-center justify-between text-sm text-stone-700">
                    <span class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            wire:click="toggleOccasion('{{ $key }}')"
                            @checked(in_array($key, $occasions, true))
                            class="h-4 w-4 rounded border-stone-300 text-[#4A2A16] focus:ring-[#4A2A16]"
                        >
                        {{ $opt['label'] }}
                    </span>
                    <span class="text-stone-400">({{ $opt['count'] }})</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Dietary preference --}}
    <div class="border-t border-stone-200 py-4" x-data="{ open: true }">
        <button type="button" @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-stone-800">
            DIETARY PREFERENCE
            <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-collapse class="mt-3 space-y-2.5">
            @foreach ($this->dietaryOptions as $key => $opt)
                <label class="flex cursor-pointer items-center justify-between text-sm text-stone-700">
                    <span class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            wire:click="toggleDietary('{{ $key }}')"
                            @checked(in_array($key, $dietary, true))
                            class="h-4 w-4 rounded border-stone-300 text-[#4A2A16] focus:ring-[#4A2A16]"
                        >
                        {{ $opt['label'] }}
                    </span>
                    <span class="text-stone-400">({{ $opt['count'] }})</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Ratings --}}
    <div class="border-t border-stone-200 py-4" x-data="{ open: true }">
        <button type="button" @click="open = !open" class="flex w-full items-center justify-between text-sm font-semibold text-stone-800">
            RATINGS
            <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-collapse class="mt-3 space-y-2.5">
            @foreach ($this->ratingOptions as $stars => $count)
                <label class="flex cursor-pointer items-center justify-between text-sm text-stone-700">
                    <span class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            wire:click="toggleRating({{ $stars }})"
                            @checked(in_array($stars, $ratings, true))
                            class="h-4 w-4 rounded border-stone-300 text-[#4A2A16] focus:ring-[#4A2A16]"
                        >
                        <span class="flex text-amber-400">
                            @for ($i = 0; $i < $stars; $i++)
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.364 1.118l1.287 3.958c.299.921-.756 1.688-1.54 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.784.57-1.838-.197-1.539-1.118l1.286-3.958a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.285-3.958z" />
                                </svg>
                            @endfor
                        </span>
                    </span>
                    <span class="text-stone-400">({{ $count }})</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Apply --}}
    <button
        wire:click="applyFilters"
        @click="mobileFiltersOpen = false"
        class="mt-5 w-full rounded-full bg-[#4A2A16] py-3 text-sm font-semibold text-white transition-colors hover:bg-[#3A2011]"
    >
        Apply Filters
    </button>
</div>
</div>