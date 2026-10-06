<x-layouts.app title="Delivery Information | Crumbs & Crown">
    <x-layouts.header />
    <livewire:layouts.banner
        tagline="Delivery"
        heading-line1="How we deliver"
        heading-line2="your sweet moments"
        description="We aim to make every order arrive fresh, beautifully presented, and on time."
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2">
            <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm">
                <h2 class="font-serif text-3xl text-[#3D2314]">Delivery timeline</h2>
                <ul class="mt-6 space-y-4 text-sm leading-7 text-stone-600">
                    <li><span class="font-semibold text-[#3D2314]">Same-day dispatch:</span> available for selected local orders placed before 12pm.</li>
                    <li><span class="font-semibold text-[#3D2314]">Standard delivery:</span> 1–3 working days depending on your location.</li>
                    <li><span class="font-semibold text-[#3D2314]">Weekend orders:</span> delivered Monday or on the next available delivery slot.</li>
                </ul>
            </div>

            <div class="rounded-3xl border border-stone-200 bg-[#f8f4ef] p-8 shadow-sm">
                <h2 class="font-serif text-3xl text-[#3D2314]">Packaging</h2>
                <p class="mt-6 text-sm leading-7 text-stone-600">
                    Every order is carefully packed to protect its finish and keep it fresh. We use insulated packaging and
a secure handling process for all cakes, pastries, and gifting bundles.
                </p>
            </div>
        </div>
    </section>

    <livewire:layouts.site-footer />
</x-layouts.app>
