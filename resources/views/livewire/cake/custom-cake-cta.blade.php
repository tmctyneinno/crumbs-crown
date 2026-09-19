<section class="overflow-hidden rounded-3xl bg-[#3D2314] px-6 py-10 text-white sm:px-10 sm:py-14">
    <div class="max-w-2xl">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-amber-200">Made around your idea</p>
        <h2 class="mt-3 font-['Playfair_Display'] text-3xl sm:text-4xl">Your Idea. Our Oven.</h2>
        <p class="mt-4 leading-7 text-white/70">Bring us your inspiration and we will help shape it into a cake that feels completely yours.</p>
    </div>
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($this->customCakeSteps as $step)
            <div class="border-t border-white/20 pt-4"><span class="text-sm font-semibold text-amber-200">0{{ $loop->iteration }}</span><p class="mt-2 font-medium">{{ $step['label'] }}</p></div>
        @endforeach
    </div>
    <a href="{{ route('contact') }}" class="mt-9 inline-flex rounded-full bg-white px-6 py-3 text-sm font-semibold text-[#3D2314] hover:bg-amber-100">Start your custom order →</a>
</section>
