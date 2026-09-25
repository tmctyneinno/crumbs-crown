<x-layouts.app title="Your Cart | Crumbs & Crown">
    <x-layouts.header />

    <main class="min-h-[60vh] bg-[#fbf7f2] px-4 pb-20 pt-32 sm:px-6">
        <div class="mx-auto max-w-5xl">
            <div class="mb-10">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8B4A2B]">Your order</p>
                <h1 class="mt-2 font-serif text-4xl font-bold text-[#3D2314]">Shopping Cart</h1>
            </div>

            <livewire:cart.index />
        </div>
    </main>

    <livewire:layouts.site-footer />
</x-layouts.app>
