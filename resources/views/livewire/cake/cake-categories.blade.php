<section>
    <div class="flex items-end justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#9A6A4F]">Find your moment</p>
            <h2 class="mt-2 font-['Playfair_Display'] text-3xl text-[#3D2314] sm:text-4xl">Find Your Perfect Cake</h2>
        </div>
        <a href="{{ route('contact') }}" class="hidden text-sm font-semibold text-[#6B3A1F] hover:underline sm:block">Need something custom? →</a>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7">
        @foreach ($this->categories as $category)
            @php
                $categoryImage = match ($category['slug']) {
                    'cupcake' => 'cupcakes.svg',
                    'corporate' => 'gift-boxes.svg',
                    'baby-shower', 'wedding', 'anniversary', 'graduation' => 'cakes.svg',
                    default => 'cakes.svg',
                };
            @endphp
            <a href="{{ route('cakes', ['category' => $category['slug']]) }}" class="group text-center">
                <div class="flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-[#FBF3EA] p-5 transition group-hover:-translate-y-1 group-hover:shadow-md">
                    <img src="{{ asset('images/categories/' . $categoryImage) }}" alt="{{ $category['name'] }}" class="h-full w-full object-contain transition duration-300 group-hover:scale-105">
                </div>
                <p class="mt-3 text-sm font-semibold text-stone-700">{{ $category['name'] }}</p>
            </a>
        @endforeach
    </div>
</section>
