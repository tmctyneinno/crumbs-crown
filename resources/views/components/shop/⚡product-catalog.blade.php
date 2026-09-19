<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    // ----- Search & sort -----
    #[Url]
    public string $search = '';

    #[Url]
    public string $sort = 'featured';

    // ----- Filters: Categories -----
    #[Url]
    public array $categories = [];

    // ----- Filters: Price range -----
    #[Url]
    public int $minPrice = 1000;

    #[Url]
    public int $maxPrice = 100000;

    // ----- Filters: Occasions -----
    #[Url]
    public array $occasions = [];

    // ----- Filters: Dietary preference -----
    #[Url]
    public array $dietary = [];

    // ----- Filters: Ratings -----
    #[Url]
    public array $ratings = [];

    public int $perPage = 6;

    protected $paginationTheme = 'tailwind';

    /**
     * Static filter option definitions with counts.
     * In a real app these counts would be derived from the query itself.
     */
    #[Computed]
    public function categoryOptions(): array
    {
        return [
            'cakes'            => ['label' => 'Cakes', 'count' => 66],
            'cupcakes'         => ['label' => 'Cupcakes', 'count' => 66],
            'pastries'         => ['label' => 'Pastries', 'count' => 66],
            'desserts'         => ['label' => 'Desserts', 'count' => 66],
            'chocolates'       => ['label' => 'Chocolates', 'count' => 66],
            'small-chops'      => ['label' => 'Small Chops', 'count' => 66],
            'chin-chin'        => ['label' => 'Chin Chin', 'count' => 66],
            'corporate-events' => ['label' => 'Corporate Events', 'count' => 66],
        ];
    }

    #[Computed]
    public function occasionOptions(): array
    {
        return [
            'birthday'         => ['label' => 'Birthday', 'count' => 66],
            'wedding'          => ['label' => 'Wedding', 'count' => 66],
            'anniversary'      => ['label' => 'Anniversary', 'count' => 66],
            'corporate-events' => ['label' => 'Corporate Events', 'count' => 66],
            'just-because'     => ['label' => 'Just Because', 'count' => 66],
        ];
    }

    #[Computed]
    public function dietaryOptions(): array
    {
        return [
            'eggless'    => ['label' => 'Eggless', 'count' => 66],
            'sugar-free' => ['label' => 'Sugar-free', 'count' => 66],
            'gluten-free'=> ['label' => 'Gluten-free', 'count' => 66],
            'low-sugar'  => ['label' => 'Low-sugar', 'count' => 66],
        ];
    }

    #[Computed]
    public function ratingOptions(): array
    {
        return [
            5 => 66,
            4 => 66,
            3 => 66,
            2 => 66,
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function toggleCategory(string $key): void
    {
        $this->toggleInArray('categories', $key);
    }

    public function toggleOccasion(string $key): void
    {
        $this->toggleInArray('occasions', $key);
    }

    public function toggleDietary(string $key): void
    {
        $this->toggleInArray('dietary', $key);
    }

    public function toggleRating(int $key): void
    {
        $this->toggleInArray('ratings', $key);
    }

    protected function toggleInArray(string $property, string|int $value): void
    {
        $current = $this->{$property};

        if (in_array($value, $current, true)) {
            $this->{$property} = array_values(array_diff($current, [$value]));
        } else {
            $current[] = $value;
            $this->{$property} = $current;
        }

        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['categories', 'occasions', 'dietary', 'ratings', 'search']);
        $this->minPrice = 1000;
        $this->maxPrice = 100000;
        $this->resetPage();
    }

    public function applyFilters(): void
    {
        // Filters are already reactive via wire:model.live, so this mainly
        // matters for the mobile off-canvas filter panel: close it on apply.
        $this->resetPage();
        $this->dispatch('filters-applied');
    }

    public function addToCart(int $productId): void
    {
        // Replace with real cart logic (session, DB, or a Cart service).
        $product = collect($this->allProducts())->firstWhere('id', $productId);

        $this->dispatch('cart-updated', productId: $productId)->to('cart-icon');

        session()->flash('toast', ($product['name'] ?? 'Item') . ' added to cart.');
    }

    /**
     * The full unfiltered catalog. Swap this for a real Eloquent model query,
     * e.g. Product::query()->with('images')->
     */
    protected function allProducts(): array
    {
        return [
            ['id' => 1,  'name' => 'The Birthday Classic',       'desc' => 'A timeless celebration cake made for candles, wishes and happy moments.', 'price' => 35000, 'rating' => 4.5, 'category' => 'cakes',      'occasion' => 'birthday',    'image' => 'birthday-classic.svg'],
            ['id' => 2,  'name' => 'Glazed Ring Donuts',          'desc' => 'Soft, pillowy donuts finished with a light golden glaze.',                'price' => 35000, 'rating' => 4.5, 'category' => 'pastries',   'occasion' => 'just-because','image' => 'chocolate-fudge-cake.svg'],
            ['id' => 3,  'name' => 'Berry Drip Delight',          'desc' => 'Vanilla sponge with a chocolate drip and fresh strawberries on top.',      'price' => 35000, 'rating' => 4.5, 'category' => 'cakes',      'occasion' => 'birthday',    'image' => 'fruit-cake.svg'],
            ['id' => 4,  'name' => 'Crunchy Chin Chin Bowl',      'desc' => 'Golden, crunchy chin chin bites, perfect for sharing at parties.',        'price' => 35000, 'rating' => 4.5, 'category' => 'chin-chin',  'occasion' => 'corporate-events', 'image' => 'red-velvet-cake.svg'],
            ['id' => 5,  'name' => 'Beef Pastry Pocket',          'desc' => 'Flaky pastry filled with seasoned minced beef and vegetables.',           'price' => 35000, 'rating' => 4.5, 'category' => 'small-chops','occasion' => 'corporate-events', 'image' => 'sparkler-cake.svg'],
            ['id' => 6,  'name' => 'Classic Red Velvet',          'desc' => 'Layers of red velvet sponge with smooth cream cheese frosting.',          'price' => 35000, 'rating' => 4.5, 'category' => 'cakes',      'occasion' => 'anniversary', 'image' => 'strawberry-cake.svg'],
            ['id' => 7,  'name' => 'Chocolate Dream Drip',        'desc' => 'Rich chocolate sponge finished with a dark chocolate ganache drip.',      'price' => 35000, 'rating' => 4.5, 'category' => 'cakes',      'occasion' => 'birthday',    'image' => 'strawberry-cake2.svg'],
            ['id' => 8,  'name' => 'Paw Patrol Party Cake',       'desc' => 'A fun themed cake with a hand-piped topper, made for little ones.',       'price' => 35000, 'rating' => 4.5, 'category' => 'cakes',      'occasion' => 'birthday',    'image' => 'vanilla-cake.svg'],
            ['id' => 9,  'name' => 'Meat Pie Pocket',             'desc' => 'A warm, flaky pastry packed with peppered meat and potatoes.',            'price' => 35000, 'rating' => 4.5, 'category' => 'small-chops','occasion' => 'corporate-events', 'image' => 'wedding-cake.svg'],
        ];
    }

    #[Computed]
    public function products()
    {
        $items = collect($this->allProducts())
            ->when($this->search !== '', function ($collection) {
                $term = mb_strtolower($this->search);
                return $collection->filter(
                    fn ($product) => str_contains(mb_strtolower($product['name']), $term)
                        || str_contains(mb_strtolower($product['desc']), $term)
                );
            })
            ->when(! empty($this->categories), fn ($collection) => $collection->filter(
                fn ($product) => in_array($product['category'], $this->categories, true)
            ))
            ->when(! empty($this->occasions), fn ($collection) => $collection->filter(
                fn ($product) => in_array($product['occasion'], $this->occasions, true)
            ))
            ->when(! empty($this->ratings), fn ($collection) => $collection->filter(
                fn ($product) => in_array((int) floor($product['rating']), $this->ratings, true)
            ))
            ->filter(fn ($product) => $product['price'] >= $this->minPrice && $product['price'] <= $this->maxPrice)
            ->values();

        $items = match ($this->sort) {
            'price_low'  => $items->sortBy('price')->values(),
            'price_high' => $items->sortByDesc('price')->values(),
            'rating'     => $items->sortByDesc('rating')->values(),
            'newest'     => $items->sortByDesc('id')->values(),
            default      => $items,
        };

        $page = $this->getPage();
        $slice = $items->slice(($page - 1) * $this->perPage, $this->perPage)->values();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $slice,
            $items->count(),
            $this->perPage,
            $page,
            ['path' => request()->url(), 'pageName' => 'page']
        );
    }

   
}

?>

<div class="min-h-screen bg-[#FBF7F0]" x-data="{ mobileFiltersOpen: false }">

    {{-- Toast --}}
    @if (session('toast'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="fixed top-5 right-5 z-50 rounded-xl bg-[#4A2A16] px-5 py-3 text-sm font-medium text-white shadow-lg"
        >
            {{ session('toast') }}
        </div>
    @endif

    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex gap-8">

            {{-- ============ SIDEBAR (desktop) ============ --}}
            <aside class="hidden w-[300px] shrink-0 lg:block">
                <livewire:shop.filters-panel />
            </aside>

            {{-- ============ MAIN CONTENT ============ --}}
            <div class="flex-1 min-w-0">

                {{-- Top bar: search + sort --}}
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="relative flex-1 sm:max-w-xl">
                        <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                        <input
                            type="text"
                            wire:model.live.debounce.400ms="search"
                            placeholder="Search cakes, pastries, desserts...."
                            class="w-full rounded-full border border-stone-200 bg-white py-3 pl-12 pr-4 text-sm text-stone-700 placeholder:text-stone-400 focus:border-[#6B3A1F] focus:outline-none focus:ring-2 focus:ring-[#6B3A1F]/20"
                        >
                    </div>

                    <div class="flex items-center justify-between gap-3 sm:justify-end">
                        {{-- Mobile filter trigger --}}
                        <button
                            type="button"
                            @click="mobileFiltersOpen = true"
                            class="inline-flex items-center gap-2 rounded-full border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-700 lg:hidden"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M6 12h12M10 20h4" />
                            </svg>
                            Filters
                        </button>

                        <label class="flex items-center gap-2 text-sm text-stone-500">
                            <span class="hidden sm:inline">Sort by:</span>
                            <select
                                wire:model.live="sort"
                                class="rounded-full border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-700 focus:border-[#6B3A1F] focus:outline-none focus:ring-2 focus:ring-[#6B3A1F]/20"
                            >
                                <option value="featured">Featured</option>
                                <option value="newest">Newest</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="rating">Top Rated</option>
                            </select>
                        </label>
                    </div>
                </div>

                {{-- Active filter chips --}}
                @php
                    $hasActiveFilters = $categories || $occasions || $dietary || $ratings || $search;
                @endphp
                @if ($hasActiveFilters)
                    <div class="mb-5 flex flex-wrap items-center gap-2">
                        @foreach ($categories as $cat)
                            <button wire:click="toggleCategory('{{ $cat }}')" class="inline-flex items-center gap-1.5 rounded-full bg-[#4A2A16]/5 px-3 py-1.5 text-xs font-medium text-[#4A2A16]">
                                {{ $this->categoryOptions[$cat]['label'] ?? $cat }}
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        @endforeach
                        @foreach ($occasions as $occ)
                            <button wire:click="toggleOccasion('{{ $occ }}')" class="inline-flex items-center gap-1.5 rounded-full bg-[#4A2A16]/5 px-3 py-1.5 text-xs font-medium text-[#4A2A16]">
                                {{ $this->occasionOptions[$occ]['label'] ?? $occ }}
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        @endforeach
                        <button wire:click="clearFilters" class="text-xs font-semibold text-[#6B3A1F] underline underline-offset-2">
                            Clear all
                        </button>
                    </div>
                @endif

                {{-- Result count --}}
                <p class="mb-4 text-sm text-stone-500">
                    {{ $this->products->total() }} {{ Str::plural('result', $this->products->total()) }}
                </p>

                {{-- Product grid --}}
                @if ($this->products->count())
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3 xl:grid-cols-4" wire:loading.class="opacity-50" wire:target="search,sort,toggleCategory,toggleOccasion,toggleDietary,toggleRating,clearFilters,gotoPage,nextPage,previousPage">
                        @foreach ($this->products as $product)
                            <article class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition-shadow hover:shadow-md">
                                <div class="relative aspect-square w-full overflow-hidden bg-stone-100">
                                    <img
                                        src="{{ asset('images/cakes/' . $product['image']) }}"
                                        alt="{{ $product['name'] }}"
                                        loading="lazy"
                                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                        onerror="this.src='https://placehold.co/400x400/EFE7DA/6B3A1F?text=%20'"
                                    >
                                    <div class="absolute inset-x-0 bottom-0 flex items-center gap-1.5 bg-[#4A2A16]/90 px-3 py-1.5 text-[11px] font-medium text-white">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h1l.4 2M7 13h10l3-8H5.4M7 13L5.4 5M7 13l-2 5h13" />
                                        </svg>
                                        Free Delivery until 10/10/26
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col gap-2 p-4">
                                    <h3 class="text-base font-semibold text-stone-800">{{ $product['name'] }}</h3>
                                    <p class="text-sm leading-snug text-stone-500">{{ $product['desc'] }}</p>

                                    <div class="flex items-center gap-1.5">
                                        <div class="flex text-amber-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="h-4 w-4 {{ $i <= round($product['rating']) ? '' : 'text-stone-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.364 1.118l1.287 3.958c.299.921-.756 1.688-1.54 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.784.57-1.838-.197-1.539-1.118l1.286-3.958a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.285-3.958z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm font-medium text-stone-600">{{ number_format($product['rating'], 1) }}</span>
                                    </div>

                                    <div class="mt-auto flex items-center justify-between pt-2">
                                        <button
                                            wire:click="addToCart({{ $product['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:target="addToCart({{ $product['id'] }})"
                                            class="rounded-full bg-[#4A2A16] px-4 py-2 text-xs font-semibold text-white transition-colors hover:bg-[#3A2011] disabled:opacity-60"
                                        >
                                            <span wire:loading.remove wire:target="addToCart({{ $product['id'] }})">Add to Cart</span>
                                            <span wire:loading wire:target="addToCart({{ $product['id'] }})">Adding…</span>
                                        </button>
                                        <span class="text-base font-bold text-stone-900">&#8358;{{ number_format($product['price']) }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8 flex justify-center">
                        {{ $this->products->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-stone-300 bg-white py-16 text-center">
                        <p class="text-lg font-semibold text-stone-700">No products match your filters</p>
                        <p class="mt-1 text-sm text-stone-500">Try widening your price range or clearing a filter.</p>
                        <button wire:click="clearFilters" class="mt-4 rounded-full bg-[#4A2A16] px-5 py-2.5 text-sm font-semibold text-white">
                            Clear all filters
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ============ MOBILE FILTERS DRAWER ============ --}}
    <div
        x-show="mobileFiltersOpen"
        x-cloak
        class="fixed inset-0 z-40 lg:hidden"
        style="display: none;"
    >
        <div class="absolute inset-0 bg-black/40" @click="mobileFiltersOpen = false"></div>
        <div
            x-show="mobileFiltersOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 h-full w-[85%] max-w-sm overflow-y-auto bg-[#FBF7F0] p-5"
        >
            <div class="mb-4 flex items-center justify-between">
                <span class="text-sm font-semibold text-stone-800">Filter Products</span>
                <button @click="mobileFiltersOpen = false" class="text-stone-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <livewire:shop.filters-panel />
        </div>
    </div>
</div>