<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin login | Crumbs &amp; Crown</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#34231d] text-stone-900 antialiased">
    <main class="grid min-h-screen lg:grid-cols-[1fr_1fr]">
        <section class="relative flex min-h-[34vh] flex-col justify-between overflow-hidden bg-[#633e2c] px-7 py-8 text-white sm:px-12 lg:min-h-screen lg:px-16 lg:py-12">
            <a href="{{ route('home') }}" class="font-display text-2xl tracking-wide">
                <span class="font-playfair text-2xl font-bold text-white tracking-wide">CRUMBS & CROWN</span>
            </a>
            <div class="relative z-10 max-w-lg py-10">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-200">Shop administration</p>
                <h1 class="mt-4 font-serif text-4xl font-semibold leading-tight sm:text-5xl">A little order behind every sweet thing.</h1>
                <p class="mt-5 max-w-md text-sm leading-6 text-stone-200">Manage the treats, details, and images your customers see in the shop.</p>
            </div>
            <p class="text-xs text-stone-300">Crumbs &amp; Crown · Admin</p>
        </section>

        <section class="flex items-center justify-center bg-[#f5f2ec] px-5 py-12 sm:px-10">
            <div class="w-full max-w-md">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#936447]">Welcome back</p>
                <h2 class="mt-2 font-serif text-3xl font-semibold text-[#34231d]">Admin sign in</h2>
                <p class="mt-2 text-sm text-stone-600">Use your administrator account to continue.</p>

                @if ($errors->any())
                    <div role="alert" class="mt-6 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.store') }}" class="mt-8 space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-stone-800">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="username" required value="{{ old('email') }}" class="w-full rounded-md border border-stone-300 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-[#936447] focus:ring-2 focus:ring-[#936447]/20">
                    </div>
                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-stone-800">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="w-full rounded-md border border-stone-300 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-[#936447] focus:ring-2 focus:ring-[#936447]/20">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-stone-600">
                        <input name="remember" type="checkbox" value="1" class="rounded border-stone-300 text-[#633e2c] focus:ring-[#936447]">
                        Keep me signed in
                    </label>
                    <button type="submit" class="w-full rounded-md bg-[#633e2c] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#4f3022]">Sign in</button>
                </form>
                <a href="{{ route('shop') }}" class="mt-6 inline-block text-sm font-medium text-[#633e2c] hover:underline">Return to shop</a>
            </div>
        </section>
    </main>
</body>
</html>