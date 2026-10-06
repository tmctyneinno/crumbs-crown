<x-layouts.app title="Your Account | Crumbs & Crown">
    <x-layouts.header />
    <main class="mx-auto min-h-[55vh] max-w-5xl px-4 py-32 sm:px-6 lg:px-8">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#936447]">Your account</p>
        <h1 class="mt-2 font-serif text-4xl font-semibold text-[#34231d]">Welcome, {{ auth()->user()->name }}</h1>
        <p class="mt-3 text-stone-600">Signed in as {{ auth()->user()->email }}</p>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('shop') }}" wire:navigate class="inline-flex rounded-full bg-[#633e2c] px-6 py-3 text-sm font-semibold text-white hover:bg-[#4f3022]">Continue shopping</a>
            @if (auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="inline-flex rounded-full border border-[#633e2c] px-6 py-3 text-sm font-semibold text-[#633e2c] hover:bg-[#633e2c]/5">Admin dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex rounded-full border border-stone-300 px-6 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-100">Sign out</button>
            </form>
        </div>
    </main>
    <livewire:layouts.site-footer />
</x-layouts.app>
