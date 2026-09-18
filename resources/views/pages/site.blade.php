<x-layouts.app :title="$page['title'] . ' | Crumbs & Crown'">
    <x-layouts.header />

    <main class="bg-stone-50 pt-20">
        <section class="bg-[#3D2314] text-white">
            <div class="mx-auto grid min-h-[580px] max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24">
                <div class="max-w-xl">
                    <p class="mb-5 text-sm font-semibold uppercase tracking-[0.28em] text-amber-200">{{ $page['eyebrow'] }}</p>
                    <h1 class="font-['Playfair_Display'] text-5xl leading-tight sm:text-6xl">{{ $page['title'] }}</h1>
                    <p class="mt-6 max-w-lg text-lg leading-8 text-white/70">{{ $page['description'] }}</p>
                    <a href="{{ route('contact') }}" class="mt-9 inline-flex items-center rounded-full bg-white px-7 py-3.5 font-semibold text-[#3D2314] transition hover:bg-amber-100">
                        Start a conversation
                        <span class="ml-3 text-lg">→</span>
                    </a>
                </div>

                <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-[#5A2F20] shadow-2xl">
                    <img src="{{ asset($page['image']) }}" alt="{{ $page['title'] }}" class="aspect-[4/3] w-full object-cover" />
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#3D2314] to-transparent p-6 pt-20">
                        <p class="text-sm uppercase tracking-[0.2em] text-white/70">Made for the moment</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ($page['items'] as $item)
                    <div class="border-t-2 border-[#5A2F20] pt-5">
                        <p class="font-['Playfair_Display'] text-2xl text-[#3D2314]">{{ $item }}</p>
                        <p class="mt-2 text-sm leading-6 text-stone-500">Carefully considered, beautifully finished and ready to make the occasion feel like yours.</p>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <x-layouts.footer />
</x-layouts.app>