<?php

use Livewire\Component;

new class extends Component
{
    
    public array $cakes = [];
    
};
?>

<div>
    <section>
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start">

            {{-- Intro column --}}
            <div class="w-full shrink-0 lg:w-[220px]">
                <h2 class="text-sm font-bold uppercase tracking-wide text-stone-900">Our Cake Collection</h2>

                <p class="mt-3 text-sm leading-relaxed text-stone-600">
                    Discover our collection of most loved signature cakes, where every single creation is thoughtfully crafted using only the finest, premium ingredients to bring you the ultimate indulgence.
                </p>

                <p class="mt-3 text-sm leading-relaxed text-stone-600">
                    Whether you are gathering with family for an intimate birthday, hosting a grand wedding, our cakes are designed to elevate every celebration into an unforgettable memory.
                </p>

                <a
                    href="/cakes"
                    wire:navigate
                    class="mt-4 inline-flex w-fit items-center gap-3 rounded-full bg-white py-1.5 pl-5 pr-1.5 text-sm font-bold text-stone-900 shadow-sm ring-1 ring-black/5 transition-shadow hover:shadow-md"
                >
                    View All Cakes
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#4A2A16] text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8M17 7v9" />
                        </svg>
                    </span>
                </a>
            </div>

            {{-- Product rail --}}
            <div class="scrollbar-hide -mx-4 flex flex-1 gap-4 overflow-x-auto scroll-smooth px-4 pb-2 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0">
                @foreach ($this->cakes as $cake)
                    <article class="flex w-[190px] shrink-0 flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white">
                        <div class="relative aspect-square w-full overflow-hidden bg-stone-100">
                            <img 
                                src="{{ asset('images/categories/' . $cake['image']) }}"
                                alt="{{ $cake['name'] }}"
                                loading="lazy"
                                class="h-full w-full object-cover"
                                onerror="this.src='https://placehold.co/380x380/EFE7DA/6B3A1F?text=%20'"
                            >
                            <div class="absolute inset-x-0 bottom-0 flex items-center gap-1 bg-[#4A2A16]/90 px-2.5 py-1 text-[10px] font-medium text-white">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h1l.4 2M7 13h10l3-8H5.4M7 13L5.4 5M7 13l-2 5h13" />
                                </svg>
                                Free Delivery until 10/10/26
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col gap-1.5 p-3">
                            <h3 class="text-sm font-semibold text-stone-800">{{ $cake['name'] }}</h3>
                            <p class="text-xs leading-snug text-stone-500">{{ $cake['desc'] }}</p>

                            <div class="flex items-center gap-1">
                                <div class="flex text-amber-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="h-3.5 w-3.5 {{ $i <= round($cake['rating']) ? '' : 'text-stone-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.364 1.118l1.287 3.958c.299.921-.756 1.688-1.54 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.784.57-1.838-.197-1.539-1.118l1.286-3.958a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.285-3.958z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-xs font-medium text-stone-600">{{ number_format($cake['rating'], 1) }}</span>
                            </div>

                            <div class="mt-auto flex items-center justify-between pt-1.5">
                                <button
                                    wire:click="addToCart({{ $cake['id'] }})"
                                    wire:loading.attr="disabled"
                                    wire:target="addToCart({{ $cake['id'] }})"
                                    class="rounded-full bg-[#4A2A16] px-3 py-1.5 text-[11px] font-semibold text-white transition-colors hover:bg-[#3A2011] disabled:opacity-60"
                                >
                                    <span wire:loading.remove wire:target="addToCart({{ $cake['id'] }})">Add to Cart</span>
                                    <span wire:loading wire:target="addToCart({{ $cake['id'] }})">Adding&hellip;</span>
                                </button>
                                <span class="text-sm font-bold text-stone-900">&#8358;{{ number_format($cake['price']) }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</div>