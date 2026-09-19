<section>
    <div class="flex items-end justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#9A6A4F]">Fresh from the studio</p>
            <h2 class="mt-2 font-['Playfair_Display'] text-3xl text-[#3D2314] sm:text-4xl">Our Cake Collection</h2>
        </div>
        <a href="{{ route('shop') }}" class="text-sm font-semibold text-[#6B3A1F] hover:underline">View all cakes →</a>
    </div>
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($this->cakes as $cake)
            <article class="overflow-hidden rounded-2xl border border-stone-200 bg-white">
                <img src="{{ asset('images/cakes/' . $cake['image']) }}" alt="{{ $cake['name'] }}" class="aspect-square w-full object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-stone-800">{{ $cake['name'] }}</h3>
                    <p class="mt-1 line-clamp-2 text-sm leading-6 text-stone-500">{{ $cake['desc'] }}</p>
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <span class="font-bold text-[#4A2A16]">₦{{ number_format($cake['price']) }}</span>
                        <button wire:click="addToCart({{ $cake['id'] }})" class="rounded-full bg-[#4A2A16] px-4 py-2 text-xs font-semibold text-white hover:bg-[#3A2011]">Add to cart</button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
