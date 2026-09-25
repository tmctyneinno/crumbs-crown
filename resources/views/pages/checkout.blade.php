<x-layouts.app title="Checkout | Crumbs & Crown">
    <x-layouts.header />

    <main class="min-h-[60vh] bg-[#fbf7f2] px-4 pb-20 pt-32 sm:px-6">
        <div class="mx-auto max-w-5xl">
            <div class="mb-10">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8B4A2B]">Almost there</p>
                <h1 class="mt-2 font-serif text-4xl font-bold text-[#3D2314]">Checkout</h1>
            </div>

            <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
                <form class="space-y-6 lg:col-span-2" action="#" method="post">
                    @csrf

                    <section class="rounded-2xl border border-neutral-300 bg-white p-6">
                        <h2 class="mb-5 text-base font-bold uppercase tracking-wide text-neutral-900">Contact Information</h2>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="fullName" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-neutral-900">Full Name</label>
                                <input id="fullName" name="fullName" type="text" required autocomplete="name" class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm focus:border-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-900/30">
                            </div>
                            <div>
                                <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-neutral-900">Email Address</label>
                                <input id="email" name="email" type="email" required autocomplete="email" class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm focus:border-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-900/30">
                            </div>
                            <div>
                                <label for="phone" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-neutral-900">Phone Number</label>
                                <input id="phone" name="phone" type="tel" required autocomplete="tel" class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm focus:border-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-900/30">
                            </div>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-neutral-300 bg-white p-6">
                        <h2 class="mb-5 text-base font-bold uppercase tracking-wide text-neutral-900">Delivery Details</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="address" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-neutral-900">Delivery Address</label>
                                <textarea id="address" name="address" required rows="3" autocomplete="street-address" class="w-full resize-none rounded-lg border border-neutral-300 px-4 py-2.5 text-sm focus:border-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-900/30"></textarea>
                            </div>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="deliveryDate" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-neutral-900">Preferred Date</label>
                                    <input id="deliveryDate" name="deliveryDate" type="date" required class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm focus:border-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-900/30">
                                </div>
                                <div>
                                    <label for="deliveryTime" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-neutral-900">Preferred Time</label>
                                    <select id="deliveryTime" name="deliveryTime" required class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm focus:border-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-900/30">
                                        <option value="">Select a time</option>
                                        <option>9:00 AM - 12:00 PM</option>
                                        <option>12:00 PM - 3:00 PM</option>
                                        <option>3:00 PM - 7:00 PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-neutral-300 bg-white p-6">
                        <h2 class="mb-5 text-base font-bold uppercase tracking-wide text-neutral-900">Payment Method</h2>
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-neutral-300 p-4">
                            <input type="radio" name="paymentMethod" value="card" checked class="h-4 w-4 accent-amber-900">
                            <span class="text-sm font-semibold text-neutral-900">Pay securely by card</span>
                        </label>
                        <p class="mt-3 text-xs text-neutral-500">Your payment will be completed securely after you place the order.</p>
                    </section>

                    <button type="submit" class="w-full rounded-full bg-amber-950 py-3 text-xs font-bold uppercase tracking-wide text-white transition hover:bg-amber-900">
                        Place Order
                    </button>
                </form>

                <aside class="rounded-2xl border border-neutral-300 bg-white p-6 lg:sticky lg:top-28">
                    <h2 class="mb-5 text-base font-bold uppercase tracking-wide text-neutral-900">Order Summary</h2>
                    <div class="space-y-4 border-b border-neutral-200 pb-5 text-sm">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-neutral-600">The Birthday Classic <span class="text-neutral-400">× 1</span></span>
                            <span class="font-semibold text-neutral-900">₦35,000</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-neutral-600">The Birthday Classic <span class="text-neutral-400">× 2</span></span>
                            <span class="font-semibold text-neutral-900">₦70,000</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-neutral-600">The Birthday Classic <span class="text-neutral-400">× 1</span></span>
                            <span class="font-semibold text-neutral-900">₦35,000</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-5">
                        <span class="text-base font-bold text-neutral-900">Subtotal</span>
                        <span class="text-lg font-bold text-neutral-900">₦140,000</span>
                    </div>
                    <p class="mt-2 text-xs text-neutral-500">Delivery fee will be confirmed based on your address.</p>
                </aside>
            </div>
        </div>
    </main>

    <livewire:layouts.site-footer />
</x-layouts.app>