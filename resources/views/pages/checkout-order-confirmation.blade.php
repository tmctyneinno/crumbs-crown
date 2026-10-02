<x-layouts.app title="Order Confirmation | Crumbs & Crown">
    <x-layouts.header />

    <main class="mx-auto max-w-3xl px-4 py-32 sm:px-6">
        <div class="rounded-2xl border border-stone-200 bg-white p-6 text-center sm:p-10">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Payment received</p>
            <h1 class="mt-3 font-serif text-3xl font-semibold text-[#34231d]">Thank you, {{ $order->customer_name }}</h1>
            <p class="mt-3 text-sm text-stone-600">Your order is confirmed. We’ll contact you with any delivery updates.</p>
            <p class="mt-7 text-xs font-semibold uppercase tracking-wide text-stone-500">Order number</p>
            <p class="mt-1 text-xl font-semibold text-[#34231d]">{{ $order->order_number }}</p>
            <div class="mt-8 divide-y divide-stone-100 border-y border-stone-200 text-left">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between gap-4 py-3 text-sm">
                        <span class="text-stone-700">{{ $item->product_name }} × {{ $item->quantity }}</span>
                        <span class="font-semibold text-stone-900">&#8358;{{ number_format($item->line_total) }}</span>
                    </div>
                @endforeach
            </div>
            <p class="mt-5 text-right text-sm font-semibold text-stone-900">Paid: &#8358;{{ number_format($order->subtotal) }}</p>
            <a href="{{ route('shop') }}" wire:navigate class="mt-8 inline-flex rounded-md bg-[#633e2c] px-5 py-3 text-sm font-semibold text-white hover:bg-[#4f3022]">Continue shopping</a>
        </div>
    </main>

    <livewire:layouts.site-footer />
</x-layouts.app>