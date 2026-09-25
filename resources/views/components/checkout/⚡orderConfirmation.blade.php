<?php

namespace App\Livewire\Checkout;

use Livewire\Component;

new class extends Component
{
    // ── Store / brand ────────────────────────────────────────────────────
    public string $storeName = 'Crumbs & Crown';

    // ── Order summary ─────────────────────────────────────────────────────
    public string $orderNumber = '';
    public string $date = '';
    public string $time = '';
    public string $customerName = '';
    public string $location = '';
    public string $bookingReference = '';

    // ── Confirmation contact details ────────────────────────────────────
    public string $confirmationEmail = '';
    public string $confirmationPhone = '';

    // ── Navigation ────────────────────────────────────────────────────────
    public string $homeUrl = '/';
    public string $shopUrl = '/shop';

    public function mount(
        string $orderNumber,
        string $date,
        string $time,
        string $customerName,
        string $location,
        string $bookingReference,
        string $confirmationEmail,
        string $confirmationPhone,
        ?string $storeName = null,
        ?string $homeUrl = null,
        ?string $shopUrl = null,
    ): void {
        $this->orderNumber = $orderNumber;
        $this->date = $date;
        $this->time = $time;
        $this->customerName = $customerName;
        $this->location = $location;
        $this->bookingReference = $bookingReference;
        $this->confirmationEmail = $confirmationEmail;
        $this->confirmationPhone = $confirmationPhone;

        if ($storeName) {
            $this->storeName = $storeName;
        }
        if ($homeUrl) {
            $this->homeUrl = $homeUrl;
        }
        if ($shopUrl) {
            $this->shopUrl = $shopUrl;
        }
    }

    
};
?>

<div class="max-w-3xl mx-auto px-4 py-20">

    {{-- ── Heading ─────────────────────────────────────────────────────── --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl sm:text-4xl font-serif text-stone-900">Your Order is Confirmed!</h1>
        <p class="text-stone-500 mt-2">Thank you for choosing {{ $storeName }}</p>
    </div>

    {{-- ── Order card ───────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm p-6 sm:p-10">

        <p class="text-center text-stone-600 max-w-md mx-auto">
            We have reviewed your order and will begin preparing it for your selected date.
        </p>

        {{-- ── Order number ─────────────────────────────────────────────── --}}
        <div class="mt-8 mx-auto max-w-xs rounded-2xl border border-[#4A2A1B] py-5 px-6 text-center">
            <p class="text-xs font-semibold tracking-wide text-[#8a5a3d]">ORDER NUMBER</p>
            <p class="mt-1 text-2xl font-extrabold text-[#4A2A1B]">#{{ $orderNumber }}</p>
        </div>

        {{-- ── Details ───────────────────────────────────────────────────── --}}
        <dl class="mt-8 space-y-4">
            @foreach ([
                'Date' => $date,
                'Time' => $time,
                'Name' => $customerName,
                'Location' => $location,
                'Booking Reference' => $bookingReference,
            ] as $label => $value)
                <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-6">
                    <dt class="w-full sm:w-44 shrink-0 font-bold text-stone-800">{{ $label }}</dt>
                    <dd class="text-stone-700">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>

        {{-- ── Confirmation notice ──────────────────────────────────────── --}}
        <div class="mt-8 rounded-2xl bg-rose-50 px-6 py-4 text-center">
            <p class="text-sm text-stone-700">
                A confirmation has been sent to
                <span class="font-bold">{{ $confirmationEmail }}</span>
                and
                <span class="font-bold">{{ $confirmationPhone }}</span>.
            </p>
        </div>
    </div>

    {{-- ── Actions ──────────────────────────────────────────────────────── --}}
    <div class="mt-6 flex flex-col sm:flex-row gap-4">
        <a
            href="{{ $homeUrl }}"
            class="flex-1 text-center rounded-2xl bg-[#4A2A1B] hover:bg-[#5c3624] text-white font-bold py-4 transition-colors"
        >
            BACK TO HOME
        </a>
        <a
            href="{{ $shopUrl }}"
            class="flex-1 text-center rounded-2xl border border-[#4A2A1B] text-[#4A2A1B] font-bold py-4 hover:bg-[#4A2A1B]/5 transition-colors"
        >
            CONTINUE SHOPPING
        </a>
    </div>
</div>