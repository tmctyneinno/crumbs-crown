<x-layouts.app title="Pastry Details | Crumbs & Crown">
    <x-layouts.header />
    <livewire:layouts.banner
        tagline="Pastries"
        heading-line1="Freshly baked"
        heading-line2="just for you"
        description="Explore our pastry collection and discover a flavour worth savoring."
    />

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-stone-200 bg-white p-10 text-center shadow-sm">
            <p class="text-sm uppercase tracking-[0.2em] text-[#8A5A34]">Featured pastry</p>
            <h2 class="mt-4 font-serif text-4xl text-[#3D2314]">{{ ucfirst(str_replace('-', ' ', $slug ?? 'signature pastry')) }}</h2>
            <p class="mt-6 text-stone-600 leading-7">
                This pastry is part of our handcrafted collection, prepared with rich butter, premium ingredients, and a finishing touch designed to delight.
            </p>
            <a href="{{ route('pastries.index') }}" wire:navigate class="mt-8 inline-flex rounded-full bg-[#3D2314] px-6 py-3 text-sm font-semibold text-white hover:bg-[#2d1f1a]">
                Back to pastries
            </a>
        </div>
    </section>

    <livewire:layouts.site-footer />
</x-layouts.app>
