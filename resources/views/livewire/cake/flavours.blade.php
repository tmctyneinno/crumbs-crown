<section>
    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#9A6A4F]">Make it yours</p>
    <h2 class="mt-2 font-['Playfair_Display'] text-3xl text-[#3D2314] sm:text-4xl">Choose Your Flavour</h2>
    <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7">
        @foreach ($this->flavours as $flavour)
            <div class="group text-center">
                <div class="flex aspect-square items-center justify-center overflow-hidden rounded-full bg-[#FBF3EA] p-3">
                    <img src="{{ asset('images/cakes/' . $flavour['image']) }}" alt="{{ $flavour['name'] }} cake" class="h-full w-full rounded-full object-cover transition duration-300 group-hover:scale-105">
                </div>
                <p class="mt-3 text-sm font-semibold text-stone-700">{{ $flavour['name'] }}</p>
            </div>
        @endforeach
    </div>
</section>
