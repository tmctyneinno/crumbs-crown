<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\ShoppingCart;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    public Product $product;

    public int $quantity = 1;

    public string $size = '6';

    public string $flavour = 'Red Velvet';

    #[Validate('nullable|string|max:20')]
    public string $inscription = '';

    public string $topper = 'none';

    public int $activeImage = 0;

    public array $sizes = self::SIZES;

    public array $flavours = self::FLAVOURS;

    public array $toppers = self::TOPPERS;

    /** Replace with DB-driven options if you store them per product. */
    public const SIZES = [
        '6'  => ['label' => '6"',  'serves' => 'Serves 6-8',   'price' => 35000],
        '8'  => ['label' => '8"',  'serves' => 'Serves 10-12', 'price' => 45000],
        '10' => ['label' => '10"', 'serves' => 'Serves 13-20', 'price' => 50000],
        '12' => ['label' => '12"', 'serves' => 'Serves 20-25', 'price' => 75000],
    ];

    public const FLAVOURS = ['Red Velvet', 'Vanilla', 'Chocolate', 'Lemon', 'Marble'];

    public const TOPPERS = [
        'none'     => ['label' => 'No Topper',         'price' => 0],
        'classic'  => ['label' => 'Classic gold topper', 'price' => 3000],
        'balloons' => ['label' => 'Balloon topper',    'price' => 4500],
    ];

    public function mount(Product $product): void
    {
        $this->product = $product->loadMissing('category');
    }

    protected function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1|max:20',
            'size' => 'required|in:6,8,10,12',
            'flavour' => 'required|in:Red Velvet,Vanilla,Chocolate,Lemon,Marble',
            'inscription' => 'nullable|string|max:20',
            'topper' => 'required|in:none,classic,balloons',
        ];
    }

    #[Computed]
    public function images(): array
    {
        // Falls back to the main image if you have no gallery column/relation.
        $gallery = collect($this->product->gallery ?? [])->filter()->values()->all();

        return $gallery ?: [$this->product->image_url];
    }

    #[Computed]
    public function unitPrice(): int
    {
        return $this->priceForSize($this->size) + self::TOPPERS[$this->topper]['price'];
    }

    public function priceForSize(string $size): int
    {
        return $size === '6'
            ? $this->product->price
            : (self::SIZES[$size]['price'] ?? $this->product->price);
    }

    #[Computed]
    public function total(): int
    {
        return $this->unitPrice * $this->quantity;
    }

    public function increment(): void
    {
        $this->quantity = min($this->quantity + 1, 20);
    }

    public function decrement(): void
    {
        $this->quantity = max($this->quantity - 1, 1);
    }

    public function selectSize(string $size): void
    {
        if (array_key_exists($size, self::SIZES)) {
            $this->size = $size;
        }
    }

    public function addToCart(ShoppingCart $cart): void
    {
        $this->validate();

        $cart->add($this->product, $this->quantity, [
            ...$this->options(),
            'unit_price' => $this->unitPrice,
        ]);

        $this->dispatch('cart-updated')->to('cart-icon');
        $this->dispatch('toast', message: $this->product->name . ' added to your cart.', type: 'success');
    }

    public function buyNow(ShoppingCart $cart)
    {
        $this->addToCart($cart);

        return $this->redirect(route('checkout'), navigate: true);
    }

    protected function options(): array
    {
        return [
            'size'        => self::SIZES[$this->size]['label'],
            'flavour'     => $this->flavour,
            'inscription' => $this->inscription,
            'topper'      => self::TOPPERS[$this->topper]['label'],
        ];
    }

   
};
?>

<div>
   <main class="mx-auto max-w-5xl px-4 pb-16 pt-28 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" class="mb-6 text-xs text-stone-500">
        <a href="{{ route('home') }}" wire:navigate class="hover:text-stone-900 hover:underline">Home</a>
        <span aria-hidden="true" class="mx-1">&gt;</span>
        <a href="{{ route('shop') }}" wire:navigate class="hover:text-stone-900 hover:underline">Shop</a>
        <span aria-hidden="true" class="mx-1">&gt;</span>
        <span class="text-stone-800">{{ $product->name }}</span>
    </nav>

    <article class="grid gap-8 lg:grid-cols-2 lg:gap-12">
        {{-- Gallery --}}
        <div>
            <div class="aspect-square overflow-hidden rounded-2xl bg-stone-100">
                <img src="{{ $this->images[$activeImage] ?? $this->images[0] }}"
                     alt="{{ $product->name }}"
                     class="h-full w-full object-cover"
                     fetchpriority="high">
            </div>

            @if (count($this->images) > 1)
                <div class="mt-4 grid grid-cols-4 gap-3">
                    @foreach ($this->images as $i => $image)
                        <button type="button"
                                wire:click="$set('activeImage', {{ $i }})"
                                aria-label="Show image {{ $i + 1 }}"
                                @class([
                                    'aspect-square overflow-hidden rounded-lg border-2 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#633e2c]',
                                    'border-[#633e2c]' => $activeImage === $i,
                                    'border-transparent opacity-80 hover:opacity-100' => $activeImage !== $i,
                                ])>
                            <img src="{{ $image }}" alt="" class="h-full w-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- CTAs (desktop: under gallery like the design) --}}
            <div class="mt-6 space-y-3">
                <button type="button" wire:click="addToCart" wire:loading.attr="disabled"
                        class="inline-flex min-h-12 w-full items-center justify-center rounded-lg bg-[#633e2c] px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white transition hover:bg-[#4f3022] disabled:opacity-60">
                    Add to Crown Bag
                </button>
                <button type="button" wire:click="buyNow" wire:loading.attr="disabled"
                        class="inline-flex min-h-12 w-full items-center justify-center rounded-lg border border-[#633e2c] bg-white px-6 py-3 text-sm font-semibold uppercase tracking-wide text-[#633e2c] transition hover:bg-stone-50 disabled:opacity-60">
                    Buy now
                </button>

            </div>
        </div>

        {{-- Details --}}
        <div class="flex flex-col">
            @if ($product->category)
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#936447]">{{ $product->category->name }}</p>
            @endif
            <h1 class="font-serif text-3xl font-semibold text-[#34231d] sm:text-4xl">{{ $product->name }}</h1>

            <div class="mt-3 flex items-center gap-2 text-sm text-stone-500"
                 aria-label="Rated {{ number_format($product->rating, 1) }} out of 5">
                <span class="flex text-amber-500" aria-hidden="true">
                    @for ($s = 1; $s <= 5; $s++)
                        <svg class="size-5 {{ $s <= round($product->rating) ? 'fill-current' : 'fill-stone-200' }}" viewBox="0 0 20 20"><path d="M10 1.5l2.6 5.5 6 .8-4.4 4.2 1.1 6-5.3-2.9-5.3 2.9 1.1-6L1.4 7.8l6-.8L10 1.5z"/></svg>
                    @endfor
                </span>
                <span>{{ number_format($product->rating, 1) }} ({{ $product->reviews_count ?? 0 }} reviews)</span>
            </div>

            <p class="mt-6 font-serif text-3xl font-semibold text-[#34231d]">&#8358;{{ number_format($this->total) }}</p>

            <p class="mt-4 whitespace-pre-line text-base leading-7 text-stone-700">{{ $product->description }}</p>

            @if ($product->occasion || $product->dietary)
                <dl class="mt-5 grid gap-4 border-y border-stone-200 py-5 sm:grid-cols-2">
                    @if ($product->occasion)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Occasion</dt>
                            <dd class="mt-1 text-sm font-medium text-stone-800">{{ \Illuminate\Support\Str::headline($product->occasion) }}</dd>
                        </div>
                    @endif
                    @if ($product->dietary)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Dietary</dt>
                            <dd class="mt-1 flex flex-wrap gap-2">
                                @foreach ($product->dietary as $tag)
                                    <span class="text-sm font-medium text-stone-800">{{ \Illuminate\Support\Str::headline($tag) }}</span>
                                @endforeach
                            </dd>
                        </div>
                    @endif
                </dl>
            @endif

            {{-- Quantity --}}
            <div class="mt-7">
                <h2 class="text-sm font-bold uppercase tracking-wide text-[#34231d]">Quantity</h2>
                <div class="mt-2 inline-flex items-center overflow-hidden rounded-lg border border-[#936447]/60">
                    <button type="button" wire:click="decrement" aria-label="Decrease quantity"
                            class="grid size-11 place-items-center text-xl text-[#34231d] hover:bg-stone-50 disabled:opacity-40"
                            @disabled($quantity <= 1)>&minus;</button>
                    <span class="grid h-11 w-12 place-items-center border-x border-[#936447]/60 text-base font-semibold" aria-live="polite">{{ $quantity }}</span>
                    <button type="button" wire:click="increment" aria-label="Increase quantity"
                            class="grid size-11 place-items-center text-xl text-[#34231d] hover:bg-stone-50">+</button>
                </div>
            </div>

            {{-- Size --}}
            <fieldset class="mt-7">
                <legend class="text-sm font-bold uppercase tracking-wide text-[#34231d]">
                    Size <span class="font-normal normal-case tracking-normal text-stone-600">(Serving)</span>
                </legend>
                <div class="mt-2 grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @foreach ($this->sizes as $key => $opt)
                        <label @class([
                            'flex cursor-pointer flex-col items-center rounded-lg border px-2 py-3 text-center transition focus-within:ring-2 focus-within:ring-[#633e2c]',
                            'border-2 border-[#633e2c] bg-[#633e2c]/5' => $size === (string) $key,
                            'border-[#936447]/50 hover:border-[#633e2c]' => $size !== (string) $key,
                        ])>
                            <input type="radio" wire:model.live="size" value="{{ $key }}" class="sr-only">
                            <span class="font-semibold text-[#34231d]">{{ $opt['label'] }}</span>
                            <span class="mt-1 text-[10px] text-stone-600">{{ $opt['serves'] }}</span>
                            <span class="mt-2 text-sm font-semibold text-[#34231d]">&#8358;{{ number_format($this->priceForSize((string) $key)) }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            {{-- Flavour --}}
            <div class="mt-7">
                <label for="flavour" class="text-sm font-bold uppercase tracking-wide text-[#34231d]">Flavour</label>
                <select id="flavour" wire:model="flavour"
                        class="mt-2 block w-full rounded-lg border border-[#936447]/60 bg-white px-4 py-3 text-sm text-stone-800 focus:border-[#633e2c] focus:ring-[#633e2c]">
                    @foreach ($this->flavours as $f)
                        <option value="{{ $f }}">{{ $f }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Inscription --}}
            <div class="mt-7" x-data="{ count: $wire.inscription.length }">
                <label for="inscription" class="text-sm font-bold uppercase tracking-wide text-[#34231d]">
                    Cake inscription <span class="font-normal normal-case tracking-normal text-stone-600">(Optional)</span>
                </label>
                <div class="relative mt-2">
                    <input id="inscription" type="text" maxlength="20"
                           wire:model="inscription"
                           x-on:input="count = $event.target.value.length"
                           placeholder="e.g Happy Birthday Sarah!!"
                           class="block w-full rounded-lg border border-[#936447]/60 bg-white py-3 pl-4 pr-16 text-sm text-stone-800 placeholder:text-stone-400 focus:border-[#633e2c] focus:ring-[#633e2c]">
                    <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-xs text-stone-400">
                        <span x-text="count">0</span>/20
                    </span>
                </div>
                @error('inscription') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Topper --}}
            <div class="mt-7">
                <label for="topper" class="text-sm font-bold uppercase tracking-wide text-[#34231d]">
                    Add a cake topper <span class="font-normal normal-case tracking-normal text-stone-600">(Optional)</span>
                </label>
                <select id="topper" wire:model.live="topper"
                        class="mt-2 block w-full rounded-lg border border-[#936447]/60 bg-white px-4 py-3 text-sm text-stone-800 focus:border-[#633e2c] focus:ring-[#633e2c]">
                    @foreach ($this->toppers as $key => $t)
                        <option value="{{ $key }}">
                            {{ $t['label'] }}@if ($t['price'] > 0) (+&#8358;{{ number_format($t['price']) }})@endif
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </article>
</main>
</div>