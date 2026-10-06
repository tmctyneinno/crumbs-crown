<x-layouts.app title="Allergen Information | Crumbs & Crown">
    <x-layouts.header />
    <livewire:layouts.banner
        tagline="Allergen info"
        heading-line1="Ingredients matter"
        heading-line2="to us too"
        description="We prepare our bakes with care and always recommend checking ingredients before purchase."
    />

    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm">
            <h2 class="font-serif text-3xl text-[#3D2314]">Allergen guidance</h2>
            <p class="mt-5 text-stone-600 leading-7">
                Our kitchen handles ingredients including wheat, milk, eggs, soy, nuts, and sesame. While we take care to prevent cross-contact,
                we cannot guarantee a completely allergen-free environment. Please get in touch if you need more detail about a specific product.
            </p>
            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl bg-stone-50 p-5">
                    <h3 class="font-semibold text-[#3D2314]">Common allergens</h3>
                    <p class="mt-2 text-sm text-stone-600">Wheat, gluten, dairy, eggs, soy, nuts, sesame.</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-5">
                    <h3 class="font-semibold text-[#3D2314]">Need advice?</h3>
                    <p class="mt-2 text-sm text-stone-600">Contact our team for ingredient details and product-specific guidance.</p>
                </div>
            </div>
        </div>
    </section>

    <livewire:layouts.site-footer />
</x-layouts.app>
