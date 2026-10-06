<x-layouts.app title="Sign In | Crumbs & Crown">
    <main class="min-h-screen bg-[#f5f2ec] px-4 py-16 sm:px-6">
        <div class="mx-auto max-w-md rounded-3xl border border-stone-200 bg-white p-8 shadow-sm sm:p-10">
            <a href="{{ route('home') }}" class="block text-center">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Crumbs & Crown" class="mx-auto h-16 w-auto object-contain">
            </a>
            <p class="mt-8 text-center text-xs font-semibold uppercase tracking-[0.2em] text-[#936447]">Welcome back</p>
            <h1 class="mt-2 text-center font-serif text-3xl font-semibold text-[#34231d]">Sign in to your account</h1>
            <p class="mt-2 text-center text-sm text-stone-600">Manage your orders and enjoy a sweeter shopping experience.</p>

            @if (session('status'))
                <p role="status" class="mt-6 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</p>
            @endif
            @if ($errors->any())
                <div role="alert" class="mt-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-stone-800">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none focus:border-[#936447] focus:ring-2 focus:ring-[#936447]/20">
                </div>
                <div>
                    <div class="mb-1.5 flex items-center justify-between gap-3">
                        <label for="password" class="text-sm font-medium text-stone-800">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-medium text-[#633e2c] hover:underline">Forgot password?</a>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none focus:border-[#936447] focus:ring-2 focus:ring-[#936447]/20">
                </div>
                <label class="flex items-center gap-2 text-sm text-stone-600">
                    <input name="remember" type="checkbox" value="1" class="rounded border-stone-300 text-[#633e2c] focus:ring-[#936447]">
                    Keep me signed in
                </label>
                <button type="submit" class="w-full rounded-full bg-[#633e2c] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#4f3022]">Sign in</button>
            </form>

            <p class="mt-7 text-center text-sm text-stone-600">
                New to Crumbs & Crown?
                <a href="{{ route('register') }}" class="font-semibold text-[#633e2c] hover:underline">Create an account</a>
            </p>
            <a href="{{ route('shop') }}" class="mt-5 block text-center text-sm text-stone-500 hover:text-[#633e2c] hover:underline">Continue shopping</a>
        </div>
    </main>
</x-layouts.app>
