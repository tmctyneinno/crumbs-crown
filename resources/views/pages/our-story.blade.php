<x-layouts.app title="Our Story | Crumbs & Crown">
    <x-layouts.header />
    <livewire:layouts.banner
        tagline="Our story"
        heading-line1="A bakery built on"
        heading-line2="sweet memories"
        description="From humble beginnings to celebration-worthy bakes, our story is shaped by flavor, care, and connection."
    />

    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2 items-center">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-[#8A5A34]">Since day one</p>
                <h2 class="mt-4 font-serif text-4xl text-[#3D2314]">Crafted with intention</h2>
                <p class="mt-6 text-stone-600 leading-7">
                    Crumbs & Crown began with a simple idea: create beautiful, honest bakes that turn everyday moments into cherished ones.
                    Whether it is a weekday pastry or a statement cake for a grand occasion, every detail is shaped with care.
                </p>
            </div>
            <div class="rounded-3xl bg-[#f8f4ef] p-8 shadow-sm">
                <p class="text-stone-600 leading-7">
                    We believe in quality ingredients, thoughtful presentation, and warm service. Our kitchen is built around making your celebrations feel personal, elegant, and memorable.
                </p>
            </div>
        </div>
    </section>

    <livewire:layouts.site-footer />
</x-layouts.app>
