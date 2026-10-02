<?php

use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Services\ShoppingCart;

new class extends Component
{
    public array $items = [];

    public string $specialInstructions = '';

    public function mount(ShoppingCart $cart): void
    {
        $this->items = $cart->items();
    }

    #[Computed]
    public function subtotal(): int
    {
        return collect($this->items)->sum(fn ($item) => $item['price'] * $item['qty']);
    }

    #[Computed]
    public function total(): int
    {
        // Delivery is calculated at checkout, so total mirrors subtotal here.
        return $this->subtotal;
    }

    public function increment(string|int $lineId): void
    {
        app(ShoppingCart::class)->changeLineQuantity($lineId, 1);
        $this->refreshCart();
    }

    public function decrement(string|int $lineId): void
    {
        app(ShoppingCart::class)->changeLineQuantity($lineId, -1);
        $this->refreshCart();
    }

    public function remove(string|int $lineId): void
    {
        app(ShoppingCart::class)->removeLine($lineId);
        $this->refreshCart();
    }

    private function refreshCart(): void
    {
        $this->items = app(ShoppingCart::class)->items();
        $this->dispatch('cart-updated')->to('cart-icon');
    }

    public function proceedToCheckout()
    {
        if ($this->items === []) {
            $this->dispatch('toast', message: 'Add a product to your cart before checking out.', type: 'error');

            return;
        }

        return redirect()->route('checkout');
    }
};
?>

<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ============ Cart items ============ --}}
        <div class="lg:col-span-2 rounded-2xl border border-neutral-300 p-6">
            <div class="divide-y divide-neutral-200">
                @forelse ($items as $item)
                    <div wire:key="item-{{ $item['line_id'] }}" class="flex flex-col sm:flex-row gap-4 py-6 first:pt-0">

                        <img
                            src="{{ $item['image'] }}"
                            alt="{{ $item['name'] }}"
                            class="h-28 w-28 shrink-0 rounded-xl object-cover"
                            loading="lazy"
                        />

                        <div class="flex-1 flex flex-col">
                            <h3 class="text-lg font-semibold text-neutral-900"><a href="{{ route('products.show', $item['id']) }}" wire:navigate class="hover:text-[#633e2c] hover:underline">{{ $item['name'] }}</a></h3>
                            <p class="text-sm text-neutral-500">{{ $item['size'] }}</p>

                            <div class="flex items-center gap-4 mb-3">
                                <div class="inline-flex items-center rounded-lg border border-neutral-300 overflow-hidden">
                                    <button
                                        type="button"
                                        wire:click="decrement('{{ $item['line_id'] }}')"
                                        class="h-9 w-9 flex items-center justify-center text-neutral-700 hover:bg-neutral-100 disabled:opacity-40"
                                        {{ $item['qty'] <= 1 ? 'disabled' : '' }}
                                        aria-label="Decrease quantity"
                                    >
                                        &minus;
                                    </button>
                                    <span class="h-9 w-10 flex items-center justify-center text-sm font-medium border-x border-neutral-300">
                                        {{ $item['qty'] }}
                                    </span>
                                    <button
                                        type="button"
                                        wire:click="increment('{{ $item['line_id'] }}')"
                                        class="h-9 w-9 flex items-center justify-center text-neutral-700 hover:bg-neutral-100"
                                        aria-label="Increase quantity"
                                    >
                                        +
                                    </button>
                                </div>

                                <span class="text-lg font-semibold text-neutral-900">
                                    ₦{{ number_format($item['price']) }}
                                </span>
                            </div>

                            <div class="flex items-center gap-4 text-sm">
                                <button
                                    type="button"
                                    wire:click="remove('{{ $item['line_id'] }}')"
                                    wire:confirm="Remove this item from your cart?"
                                    class="underline text-neutral-700 hover:text-neutral-900"
                                >
                                    Remove
                                </button>
                            </div>
                            @if (! empty($item['options']['flavour']))
                                <p class="mt-2 text-xs text-neutral-500">Flavour: {{ $item['options']['flavour'] }}</p>
                            @endif
                            @if (! empty($item['options']['inscription']))
                                <p class="mt-1 text-xs text-neutral-500">Inscription: {{ $item['options']['inscription'] }}</p>
                            @endif
                            @if (! empty($item['options']['topper']) && $item['options']['topper'] !== 'No Topper')
                                <p class="mt-1 text-xs text-neutral-500">{{ $item['options']['topper'] }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center">
                        <p class="text-sm text-neutral-500">Your cart is empty.</p>
                        <a href="{{ route('shop') }}" wire:navigate class="mt-3 inline-block text-sm font-semibold text-[#633e2c] hover:underline">Browse the shop</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                <label for="specialInstructions" class="block text-sm font-bold uppercase tracking-wide text-neutral-900 mb-2">
                    Special Instruction For Your Order? <span class="font-normal normal-case text-neutral-400">(Optional)</span>
                </label>
                <textarea
                    id="specialInstructions"
                    wire:model="specialInstructions"
                    rows="4"
                    placeholder="e.g Please handle with care, Its a surprise"
                    class="w-full rounded-lg border border-neutral-300 px-4 py-3 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900 resize-none"
                ></textarea>
            </div>
        </div>

        {{-- ============ Order summary ============ --}}
        <div class="rounded-2xl border border-neutral-300 p-6">
            <h2 class="text-base font-bold uppercase tracking-wide text-neutral-900 mb-5">Order Summary</h2>

            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-neutral-600">Subtotal</span>
                    <span class="font-semibold text-neutral-900">₦{{ number_format($this->subtotal) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-neutral-600">Delivery</span>
                    <span class="text-neutral-500">Calculated at Checkout</span>
                </div>
            </div>

            <hr class="my-4 border-neutral-200">

            <div class="flex items-center justify-between mb-6">
                <span class="text-base font-bold text-neutral-900">Total</span>
                <span class="text-lg font-bold text-neutral-900">₦{{ number_format($this->total) }}</span>
            </div>

            <button
                type="button"
                wire:click="proceedToCheckout"
                wire:loading.attr="disabled"
                @disabled($items === [])
                class="w-full rounded-full bg-amber-950 py-3 text-xs font-bold uppercase tracking-wide text-white hover:bg-amber-900 transition disabled:opacity-60 mb-3"
            >
                Proceed To Checkout
            </button>

            <a
                href="{{ route('shop') }}"
                wire:navigate
                class="block text-center w-full rounded-full border border-neutral-300 py-3 text-xs font-bold uppercase tracking-wide text-neutral-800 hover:bg-neutral-50 transition mb-6"
            >
                Continue Shopping
            </a>

            <p class="text-sm text-neutral-700 mb-2">We accept</p>
            <div class="flex items-center gap-2">
                <span class="flex h-6 items-center rounded border border-neutral-200 px-2 text-[11px] font-black italic text-blue-800">VISA</span>
                <span class="flex h-6 items-center rounded border border-neutral-200 px-2">
                    <span class="h-3 w-3 rounded-full bg-red-500 -mr-1"></span>
                    <span class="h-3 w-3 rounded-full bg-yellow-500 opacity-90"></span>
                </span>
            </div>
        </div>
    </div>
</div>