<section class="rounded-3xl bg-[#FBF3EA] p-6 sm:p-8">
    <div class="max-w-xl">
        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#9A6A4F]">Plan your portions</p>
        <h2 class="mt-2 font-['Playfair_Display'] text-3xl text-[#3D2314] sm:text-4xl">How Much Cake Do You Need?</h2>
    </div>
    <div class="mt-8 overflow-x-auto">
        <table class="w-full min-w-[520px] text-left text-sm">
            <thead class="border-b border-[#DCC8B8] text-xs uppercase tracking-wider text-stone-500"><tr><th class="pb-3">Size</th><th class="pb-3">Serves</th><th class="pb-3">Best for</th></tr></thead>
            <tbody class="divide-y divide-[#DCC8B8] text-stone-700">
                @foreach ($this->sizeGuide as $row)
                    <tr><td class="py-4 font-semibold">{{ $row['size'] }}</td><td class="py-4">{{ $row['serves'] }}</td><td class="py-4">{{ $row['best_for'] }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
