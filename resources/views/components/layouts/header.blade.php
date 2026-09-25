<header class="fixed w-full top-0 z-50 bg-[#5A2F20]/95 backdrop-blur-md border-b border-[#5C3A2E]/20" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" wire:navigate class="flex flex-col">
                    <span class="font-playfair text-2xl font-bold text-white tracking-wide">CRUMBS & CROWN</span>
                    <span class="text-[10px] text-amber-200/80 tracking-[0.2em] uppercase">A The Morgans Company</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex space-x-0">
                @foreach ([['home', 'HOME'], ['shop', 'SHOP'], ['cakes', 'CAKES'], ['pastries.index', 'PASTRIES'], ['custom-cakes', 'CUSTOM CAKES'], ['about', 'ABOUT US'], ['connect', 'Connect']] as [$route, $label])
                    <a href="{{ route($route) }}" wire:navigate class="{{ request()->routeIs($route) ? 'text-white/90 border-b-2 border-white' : 'text-white/70' }} hover:text-white px-3 py-2 text-sm font-medium tracking-wide transition-colors">{{ $label }}</a>
                @endforeach
            </nav>

            <!-- Right Icons -->
            <div class="hidden lg:flex items-center space-x-6">
                <button class="text-white/80 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <button class="text-white/80 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </button>
                <livewire:cart-icon />
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white/80 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-[#3D2314] border-t border-[#5C3A2E]/20"
         style="display: none;">
        <div class="px-4 pt-2 pb-6 space-y-1">
            @foreach ([['home', 'HOME'], ['shop', 'SHOP'], ['cakes', 'cakes'], ['pastries.index', 'PASTRIES'], ['custom-cakes', 'CUSTOM CAKES'], ['about', 'ABOUT US'], ['connect', 'Connect']] as [$route, $label])
                <a href="{{ route($route) }}" wire:navigate @click="mobileMenuOpen = false" class="{{ request()->routeIs($route) ? 'text-white border-white bg-[#5C3A2E]/30' : 'text-white/80 border-transparent' }} hover:text-white hover:bg-[#5C3A2E]/30 block px-3 py-3 text-base font-medium border-l-4 transition-colors">{{ $label }}</a>
            @endforeach
        </div>
    </div>
</header>