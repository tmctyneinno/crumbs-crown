<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Crumbs &amp; Crown</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f5f2ec] text-stone-900 antialiased">
    <x-toast />
    <div class="min-h-screen lg:grid lg:grid-cols-[15rem_minmax(0,1fr)]">
        <aside class="bg-[#34231d] px-5 py-6 text-white lg:min-h-screen">
            <a href="{{ route('admin.dashboard') }}" class="block">
                <span class="font-display text-2xl tracking-wide">Crumbs &amp; Crown</span>
                <span class="mt-1 block text-[10px] font-semibold uppercase tracking-[0.22em] text-amber-200">Shop administration</span>
            </a>
            <nav class="mt-8 flex gap-2 overflow-x-auto text-sm lg:flex-col">
                <a href="{{ route('admin.dashboard') }}" class="shrink-0 rounded-md px-3 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'bg-[#5c4035] text-white' : 'text-stone-300 hover:bg-[#463128]' }}">Overview</a>
                <a href="{{ route('admin.orders.index') }}" class="shrink-0 rounded-md px-3 py-2.5 {{ request()->routeIs('admin.orders.*') ? 'bg-[#5c4035] text-white' : 'text-stone-300 hover:bg-[#463128]' }}">Orders</a>
                <a href="{{ route('admin.enquiries.index') }}" class="shrink-0 rounded-md px-3 py-2.5 {{ request()->routeIs('admin.enquiries.*') ? 'bg-[#5c4035] text-white' : 'text-stone-300 hover:bg-[#463128]' }}">Enquiries</a>
                <a href="{{ route('admin.categories.index') }}" class="shrink-0 rounded-md px-3 py-2.5 {{ request()->routeIs('admin.categories.*') ? 'bg-[#5c4035] text-white' : 'text-stone-300 hover:bg-[#463128]' }}">Categories</a>
                <a href="{{ route('admin.products.index') }}" class="shrink-0 rounded-md px-3 py-2.5 {{ request()->routeIs('admin.products.*') ? 'bg-[#5c4035] text-white' : 'text-stone-300 hover:bg-[#463128]' }}">Products</a>
            </nav>
            <div class="mt-8 border-t border-white/10 pt-5 lg:mt-12">
                <p class="truncate text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="mt-1 truncate text-xs text-stone-400">{{ auth()->user()->email }}</p>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-4">
                    @csrf
                    <button class="text-sm text-amber-200 hover:text-white">Sign out</button>
                </form>
            </div>
        </aside>

        <main class="min-w-0 px-4 py-6 sm:px-7 lg:px-10 lg:py-9">
            <header class="mb-8 border-b border-stone-300 pb-5">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#936447]">Crumbs &amp; Crown / Admin</p>
                <h1 class="mt-2 font-serif text-3xl font-semibold text-[#34231d]">@yield('heading')</h1>
            </header>
            @yield('content')
        </main>
    </div>
</body>
</html>