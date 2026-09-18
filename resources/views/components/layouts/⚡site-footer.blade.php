<?php

use Livewire\Component;

new class extends Component
{
     public string $email = '';

    public array $shopLinks = [
        ['label' => 'Cakes', 'url' => '#'],
        ['label' => 'Pastries & Bakery', 'url' => '#'],
        ['label' => 'Desserts', 'url' => '#'],
        ['label' => 'Confectionery', 'url' => '#'],
        ['label' => 'Gift Boxes', 'url' => '#'],
        ['label' => 'Seasonal Collections', 'url' => '#'],
    ];

    public array $celebrateLinks = [
        ['label' => 'Custom Cakes', 'url' => '#'],
        ['label' => 'Weddings', 'url' => '#'],
        ['label' => 'Events', 'url' => '#'],
        ['label' => 'Corporate Gifting', 'url' => '#'],
    ];

    public array $helpLinks = [
        ['label' => 'Contact Us', 'url' => '#'],
        ['label' => 'Delivery Information', 'url' => '#'],
        ['label' => 'Frequently Asked Questions', 'url' => '#'],
        ['label' => 'Allergen Information', 'url' => '#'],
        ['label' => 'Order Terms', 'url' => '#'],
    ];

    public array $companyLinks = [
        ['label' => 'About Us', 'url' => '#'],
        ['label' => 'Our Story', 'url' => '#'],
        ['label' => 'THE MORGANS', 'url' => '#'],
        ['label' => 'Careers', 'url' => '#'],
        ['label' => 'Corporate Enquiries', 'url' => '#'],
    ];

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        // Handle subscription logic here (e.g. dispatch event, call a service, etc.)

        session()->flash('subscribed', 'Thanks for subscribing! Check your inbox for confirmation.');

        $this->reset('email');
    }
};
?>

<div>
    <footer class="relative ">

        {{-- Wavy Top Edge --}}
        <div class="relative -mb-1">
            <svg
                viewBox="0 0 1440 120"
                preserveAspectRatio="none"
                class="w-full h-24 sm:h-32"
            >
                <path
                    fill="#5A2F20"
                    d="M0,40 C120,120 220,0 340,50 C460,100 540,20 660,60
                    C780,100 860,10 980,40 C1100,70 1180,110 1260,60
                    C1340,20 1400,60 1440,50 L1440,120 L0,120 Z"
                />
            </svg>
        </div>

        {{-- Main Footer Body --}}
        <div class="bg-[#5A2F20] pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Top Grid: Brand + Link Columns --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-6 pb-14">

                    {{-- Brand Column --}}
                    <div class="lg:col-span-4">
                        <h2 class="font-serif text-3xl sm:text-4xl text-white mb-2">
                            Crumbs &amp; Crown
                        </h2>
                        <p class="text-xs uppercase tracking-widest text-white/60 mb-6">
                            A The <span class="font-bold text-white/80">Morgans</span> Company
                        </p>
                        <p class="text-white/70 leading-relaxed max-w-xs">
                            Make your next celebration a little sweeter. From everyday treats to show-stopping custom cakes, we're here to make something worth remembering.
                        </p>
                    </div>

                    {{-- Shop Column --}}
                    <div class="lg:col-span-2">
                        <h3 class="font-serif text-lg text-white mb-4">Shop</h3>
                        <ul class="space-y-3">
                            @foreach ($shopLinks as $link)
                                <li>
                                    <a
                                        href="{{ $link['url'] }}"
                                        wire:navigate
                                        class="text-white/70 hover:text-white transition-colors duration-200"
                                    >
                                        {{ $link['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Celebrate Column --}}
                    <div class="lg:col-span-2">
                        <h3 class="font-serif text-lg text-white mb-4">Celebrate</h3>
                        <ul class="space-y-3">
                            @foreach ($celebrateLinks as $link)
                                <li>
                                    <a
                                        href="{{ $link['url'] }}"
                                        wire:navigate
                                        class="text-white/70 hover:text-white transition-colors duration-200"
                                    >
                                        {{ $link['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Help Column --}}
                    <div class="lg:col-span-2">
                        <h3 class="font-serif text-lg text-white mb-4">Help</h3>
                        <ul class="space-y-3">
                            @foreach ($helpLinks as $link)
                                <li>
                                    <a
                                        href="{{ $link['url'] }}"
                                        wire:navigate
                                        class="text-white/70 hover:text-white transition-colors duration-200"
                                    >
                                        {{ $link['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Company Column --}}
                    <div class="lg:col-span-2">
                        <h3 class="font-serif text-lg text-white mb-4">Company</h3>
                        <ul class="space-y-3">
                            @foreach ($companyLinks as $link)
                                <li>
                                    <a
                                        href="{{ $link['url'] }}"
                                        wire:navigate
                                        class="text-white/70 hover:text-white transition-colors duration-200"
                                    >
                                        {{ $link['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

                {{-- Newsletter Subscribe Bar --}}
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl p-6 sm:p-8 lg:p-10 mb-10">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">

                        {{-- Left: Text --}}
                        <div class="lg:col-span-7">
                            <h3 class="font-serif text-2xl sm:text-3xl text-white mb-2">
                                Subscribe to Our Sweet Newsletter
                            </h3>
                            <p class="text-white/70">
                                Get exclusive offers, new cake alerts, and seasonal treats delivered to your inbox
                            </p>
                        </div>

                        {{-- Right: Form --}}
                        <div class="lg:col-span-5">
                            <form wire:submit="subscribe" class="flex flex-col sm:flex-row items-stretch gap-3">
                                <div class="flex-1">
                                    <input
                                        type="email"
                                        wire:model="email"
                                        placeholder="Enter your Email"
                                        class="w-full h-full bg-white/10 border border-white/30 rounded-full px-5 py-3 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 transition"
                                    >
                                    @error('email')
                                        <span class="text-xs text-red-200 mt-1 block px-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="subscribe"
                                    class="bg-brand-darker hover:bg-black/40 text-white font-semibold px-6 py-3 rounded-full transition-colors duration-300 whitespace-nowrap disabled:opacity-60"
                                >
                                    <span wire:loading.remove wire:target="subscribe">Subscribe</span>
                                    <span wire:loading wire:target="subscribe">Subscribing...</span>
                                </button>
                            </form>

                            {{-- Success Message --}}
                            @if (session('subscribed'))
                                <p class="text-sm text-emerald-200 mt-3">
                                    {{ session('subscribed') }}
                                </p>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-white/20 pt-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 text-sm text-white/60 font-serif">
                        <p>
                            &copy; {{ date('Y') }} Crumbs &amp; Crown. A The Morgans Company. All rights reserved.
                        </p>
                        <div class="text-left sm:text-right">
                            <p>85 Great Portland Street &middot; London W1W 7LT &middot; United Kingdom</p>
                            <p>info@igrcfp.org &middot; +44 (0)20 XXXX XXXX</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </footer>
</div>