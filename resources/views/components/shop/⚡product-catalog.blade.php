<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Services\ShoppingCart;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
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
    public int $minPrice = 0;

    #[Url]
    public int $maxPrice = 1000000;

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

    #[Computed]
    public function categoryOptions(): array
    {
        return Category::active()
            ->whereHas('products', fn ($query) => $query->active())
            ->withCount(['products as count' => fn ($query) => $query->active()])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->mapWithKeys(fn (Category $category) => [$category->slug => [
                'label' => $category->name,
                'count' => $category->count,
            ]])
            ->all();
    }

    #[Computed]
    public function occasionOptions(): array
    {
        return Product::active()
            ->whereNotNull('occasion')
            ->selectRaw('occasion, COUNT(*) as count')
            ->groupBy('occasion')
            ->orderBy('occasion')
            ->get()
            ->mapWithKeys(fn (Product $product) => [$product->occasion => [
                'label' => \Illuminate\Support\Str::headline($product->occasion),
                'count' => $product->count,
            ]])
            ->all();
    }

    #[Computed]
    public function dietaryOptions(): array
    {
        return Product::active()
            ->get(['dietary'])
            ->flatMap(fn (Product $product) => $product->dietary ?? [])
            ->countBy()
            ->sortKeys()
            ->map(fn (int $count, string $tag) => [
                'label' => \Illuminate\Support\Str::headline($tag),
                'count' => $count,
            ])
            ->all();
    }

    #[Computed]
    public function ratingOptions(): array
    {
        return collect(range(5, 1))
            ->mapWithKeys(fn (int $stars) => [$stars => Product::active()
                ->where('rating', '>=', $stars)
                ->where('rating', '<', $stars + 1)
                ->count()])
            ->all();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[On('shop-category-toggled')]
    public function toggleCategory(string $key): void
    {
        $this->toggleInArray('categories', $key);
        $this->syncFilterPanel();
    }

    #[On('shop-occasion-toggled')]
    public function toggleOccasion(string $key): void
    {
        $this->toggleInArray('occasions', $key);
        $this->syncFilterPanel();
    }

    #[On('shop-dietary-toggled')]
    public function toggleDietary(string $key): void
    {
        $this->toggleInArray('dietary', $key);
        $this->syncFilterPanel();
    }

    #[On('shop-rating-toggled')]
    public function toggleRating(int $key): void
    {
        $this->toggleInArray('ratings', $key);
        $this->syncFilterPanel();
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
        $this->minPrice = 0;
        $this->maxPrice = 1000000;
        $this->resetPage();
        $this->dispatch('shop-filters-reset');
        $this->syncFilterPanel();
    }

    #[On('shop-price-range')]
    public function setPriceRange(int $min, int $max): void
    {
        $this->minPrice = $min;
        $this->maxPrice = $max;
        $this->resetPage();
        $this->syncFilterPanel();
    }

    #[On('shop-filters-clear')]
    public function clearFiltersFromPanel(): void
    {
        $this->clearFilters();
    }

    private function syncFilterPanel(): void
    {
        $this->dispatch(
            'shop-filter-state',
            categories: $this->categories,
            minPrice: $this->minPrice,
            maxPrice: $this->maxPrice,
            occasions: $this->occasions,
            dietary: $this->dietary,
            ratings: $this->ratings,
        );
    }

    public function applyFilters(): void
    {
        // Filters are already reactive via wire:model.live, so this mainly
        // matters for the mobile off-canvas filter panel: close it on apply.
        $this->resetPage();
        $this->dispatch('filters-applied');
    }

    public function addToCart(int $productId, ShoppingCart $cart): void
    {
        $product = Product::active()->find($productId);

        if (! $product) {
            return;
        }

        $cart->add($product);
        unset($this->cartQuantities);
        $this->dispatch('cart-updated')->to('cart-icon');
        $this->dispatch('toast', message: $product->name . ' added successfully.', type: 'success');
    }

    public function adjustCartQuantity(int $productId, int $change, ShoppingCart $cart): void
    {
        if (! in_array($change, [-1, 1], true)) {
            return;
        }

        $product = Product::active()->find($productId);

        if (! $product) {
            return;
        }

        if ($change === 1) {
            $cart->add($product);
        } else {
            $cart->changeQuantity($productId, $change);
        }

        unset($this->cartQuantities);
        $this->dispatch('cart-updated')->to('cart-icon');
    }

    #[Computed]
    public function cartQuantities(): array
    {
        return app(ShoppingCart::class)->quantities();
    }

    #[Computed]
    public function products()
    {
        $query = Product::active()
            ->when($this->search !== '', fn ($query) => $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            }))
            ->when($this->categories, fn ($query) => $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->whereIn('slug', $this->categories)))
            ->when($this->occasions, fn ($query) => $query->whereIn('occasion', $this->occasions))
            ->whereBetween('price', [$this->minPrice, $this->maxPrice]);

        if ($this->dietary) {
            $query->where(function ($query) {
                foreach ($this->dietary as $tag) {
                    $query->orWhereJsonContains('dietary', $tag);
                }
            });
        }

        if ($this->ratings) {
            $query->where(function ($query) {
                foreach ($this->ratings as $rating) {
                    $query->orWhere(function ($query) use ($rating) {
                        $query->where('rating', '>=', $rating)
                            ->where('rating', '<', $rating + 1);
                    });
                }
            });
        }

        match ($this->sort) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'rating' => $query->orderByDesc('rating'),
            'newest' => $query->orderByDesc('created_at'),
            default => $query->orderByDesc('is_featured')->orderByDesc('created_at'),
        };

        return $query->paginate($this->perPage);
    }

   
}

?>

<div class="min-h-screen bg-[#FBF7F0]" x-data="{ mobileFiltersOpen: false }">

    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-6">
        <div class="flex gap-8">

            {{-- ============ SIDEBAR (desktop) ============ --}}
            <aside class="hidden w-[300px] shrink-0 lg:block">
                <livewire:shop.filters-panel />
            </aside>

            {{-- ============ MAIN CONTENT ============ --}}
            <div class="flex-1 min-w-0">

                {{-- Top bar: search + sort --}}
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div id="product-search" class="relative flex-1 sm:max-w-xl">
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
                                        src="{{ $product->image_url }}"
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
                                    <h3 class="text-base font-semibold text-stone-800"><a href="{{ \App\Models\Product::detailUrlForId($product['id']) }}" wire:navigate class="hover:text-[#633e2c] hover:underline">{{ $product['name'] }}</a></h3>
                                    <p class="text-sm leading-snug text-stone-500">{{ \Illuminate\Support\Str::limit($product['desc'], 15) }}</p>

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

                                    <div class="mt-auto flex flex-nowrap items-center justify-between gap-1 pt-2">
                                        @if (($this->cartQuantities[$product['id']] ?? 0) > 0)
                                            <div class="inline-flex shrink-0 items-center overflow-hidden rounded-full border border-[#4A2A16] text-[#4A2A16]">
                                                <button
                                                    type="button"
                                                    wire:click="adjustCartQuantity({{ $product['id'] }}, -1)"
                                                    wire:loading.attr="disabled"
                                                    aria-label="Remove one {{ $product['name'] }}"
                                                    class="flex h-8 w-8 items-center justify-center text-base hover:bg-[#4A2A16]/10 disabled:opacity-50"
                                                >&minus;</button>
                                                <span class="min-w-7 text-center text-xs font-semibold" aria-live="polite">{{ $this->cartQuantities[$product['id']] }}</span>
                                                <button
                                                    type="button"
                                                    wire:click="adjustCartQuantity({{ $product['id'] }}, 1)"
                                                    wire:loading.attr="disabled"
                                                    aria-label="Add one {{ $product['name'] }}"
                                                    class="flex h-8 w-8 items-center justify-center text-base hover:bg-[#4A2A16]/10 disabled:opacity-50"
                                                >+</button>
                                            </div>
                                        @else
                                            <button
                                                wire:click="addToCart({{ $product['id'] }})"
                                                wire:loading.attr="disabled"
                                                wire:target="addToCart({{ $product['id'] }})"
                                                class="min-w-20 shrink-0 whitespace-nowrap rounded-full bg-[#4A2A16] px-2 py-2 text-center text-xs font-semibold text-white transition-colors hover:bg-[#3A2011] disabled:opacity-60"
                                            >
                                                <span wire:loading.remove wire:target="addToCart({{ $product['id'] }})">Add to Cart</span>
                                                <span wire:loading wire:target="addToCart({{ $product['id'] }})">Adding…</span>
                                            </button>
                                        @endif
                                        <span class="whitespace-nowrap text-right text-sm font-bold text-stone-900">&#8358;{{ number_format($product['price']) }}</span>
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