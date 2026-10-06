<x-layouts.app title="Order Terms | Crumbs & Crown">
    <x-layouts.header />
    <livewire:layouts.banner
        tagline="Order terms"
        heading-line1="Simple, clear"
        heading-line2="ordering terms"
        description="We want every order to feel easy, transparent, and stress-free."
    />

    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <h3 class="font-serif text-2xl text-[#3D2314]">Order confirmation</h3>
                <p class="mt-3 text-stone-600">Once your order is confirmed, we reserve your selected date and product. We will confirm any custom design details before production begins.</p>
            </div>
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <h3 class="font-serif text-2xl text-[#3D2314]">Payment</h3>
                <p class="mt-3 text-stone-600">A deposit may be required for bespoke or high-value orders. Remaining balances are due before delivery or collection.</p>
            </div>
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <h3 class="font-serif text-2xl text-[#3D2314]">Cancellations and changes</h3>
                <p class="mt-3 text-stone-600">Changes may be possible depending on production stage. Please contact us as early as possible so we can help.</p>
            </div>
        </div>
    </section>

    <livewire:layouts.site-footer />
</x-layouts.app>
