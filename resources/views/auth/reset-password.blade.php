<x-layouts.app title="Choose a New Password | Crumbs & Crown">
    <main class="min-h-screen bg-[#f5f2ec] px-4 py-16 sm:px-6">
        <div class="mx-auto max-w-md rounded-3xl border border-stone-200 bg-white p-8 shadow-sm sm:p-10">
            <a href="{{ route('home') }}" class="block text-center">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Crumbs & Crown" class="mx-auto h-16 w-auto object-contain">
            </a>
            <p class="mt-8 text-center text-xs font-semibold uppercase tracking-[0.2em] text-[#936447]">Account recovery</p>
            <h1 class="mt-2 text-center font-serif text-3xl font-semibold text-[#34231d]">Choose a new password</h1>

            @if ($errors->any())
                <div role="alert" class="mt-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="mt-8 space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-stone-800">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email', $email) }}" class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none focus:border-[#936447] focus:ring-2 focus:ring-[#936447]/20">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-stone-800">New password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none focus:border-[#936447] focus:ring-2 focus:ring-[#936447]/20">
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-stone-800">Confirm new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none focus:border-[#936447] focus:ring-2 focus:ring-[#936447]/20">
                </div>
                <button type="submit" class="w-full rounded-full bg-[#633e2c] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#4f3022]">Reset password</button>
            </form>
        </div>
    </main>
</x-layouts.app>
