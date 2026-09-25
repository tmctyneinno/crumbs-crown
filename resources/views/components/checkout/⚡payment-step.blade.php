<?php

use Livewire\Component;


new class extends Component
{
    // ── Wizard steps (used to render the top progress bar) ──────────────
    public array $steps = [
        'Occasion', 'Size', 'Flavour', 'Style', 'Design', 'Details', 'Review',
    ];

    // Index (0-based) of the step currently being displayed.
    // This page sits between "Details" (index 5) and "Review" (index 6),
    // so steps 0-5 render as completed and 6 renders as upcoming.
    public int $currentStepIndex = 5;

    // ── Order summary ─────────────────────────────────────────────────
    public float $amount = 108500;

    // ── Payment method selection ────────────────────────────────────────
    // card | bank_transfer | mobile_pay | ussd
    public string $paymentMethod = 'card';

    // ── Card payment fields ──────────────────────────────────────────────
    public string $cardNumber = '';
    public string $expiryDate = '';
    public string $cvv = '';
    public string $nameOnCard = '';

    // ── Promo code ────────────────────────────────────────────────────────
    public string $promoCode = '';
    public ?string $promoMessage = null;
    public bool $promoApplied = false;
    public bool $showConfirmation = false;

    // ── Confirmation details ─────────────────────────────────────────────
    public string $orderNumber = 'CC-20260925-001';
    public string $orderDate = 'Friday, 25th September 2026';
    public string $orderTime = '12:00 PM';
    public string $customerName = 'Tolu Adewole';
    public string $location = '10A, Admiralty Way, Lekki, Lagos';
    public string $bookingReference = 'BOOK-CC-001';
    public string $confirmationEmail = 'Toluadewole@gmail.com';
    public string $confirmationPhone = '+234947362801';

    protected function rules(): array
    {
        $rules = [
            'paymentMethod' => ['required', 'in:card,bank_transfer,mobile_pay,ussd'],
        ];

        if ($this->paymentMethod === 'card') {
            $rules += [
                'cardNumber' => ['required', 'string', 'regex:/^[\d\s]{13,19}$/'],
                'expiryDate' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
                'cvv' => ['required', 'string', 'regex:/^\d{3,4}$/'],
                'nameOnCard' => ['required', 'string', 'max:100'],
            ];
        }

        return $rules;
    }

    public function selectPaymentMethod(string $method): void
    {
        $this->paymentMethod = $method;
        $this->resetErrorBag();
    }

    public function applyPromoCode(): void
    {
        $this->validateOnly('promoCode', ['promoCode' => ['nullable', 'string', 'max:30']]);

        if (blank($this->promoCode)) {
            $this->promoMessage = 'Enter a code first.';
            $this->promoApplied = false;
            return;
        }

        // TODO: replace with a real promo-code lookup against the database.
        $this->promoMessage = 'Promo code applied.';
        $this->promoApplied = true;
    }

    public function pay(): void
    {
        $this->validate();

        // TODO: hand off to your payment gateway, then redirect with the created order.
        $this->redirectRoute('checkout.order-confirmation');
    }

   

};
?>

@if ($showConfirmation)
    <livewire:checkout.orderConfirmation
        :order-number="$orderNumber"
        :date="$orderDate"
        :time="$orderTime"
        :customer-name="$customerName"
        :location="$location"
        :booking-reference="$bookingReference"
        :confirmation-email="$confirmationEmail"
        :confirmation-phone="$confirmationPhone"
    />
@else
<div class="max-w-5xl mx-auto px-4 py-20">
    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm p-6 sm:p-10">

        {{-- ── Step progress bar ───────────────────────────────────────── --}}
        <div class="pb-6 mb-8 border-b border-stone-200">
            <ol class="flex items-start justify-between">
                @foreach ($steps as $index => $label)
                    <li class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                        <div class="flex flex-col items-center gap-2 shrink-0">
                            <div @class([
                                'w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold',
                                'bg-[#4A2A1B] text-white' => $index < $currentStepIndex,
                                'bg-[#4A2A1B] text-white ring-2 ring-offset-2 ring-[#4A2A1B]' => $index === $currentStepIndex,
                                'bg-white text-stone-400 border-2 border-stone-300' => $index > $currentStepIndex,
                            ])>
                                {{ $index + 1 }}
                            </div>
                            <span @class([
                                'text-xs font-medium whitespace-nowrap',
                                'text-[#4A2A1B]' => $index <= $currentStepIndex,
                                'text-stone-400' => $index > $currentStepIndex,
                            ])>
                                {{ $label }}
                            </span>
                        </div>

                        @if (!$loop->last)
                            <div class="flex-1 border-t-2 border-dotted border-stone-300 mx-2 mt-[18px]"></div>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>

        {{-- ── Heading ─────────────────────────────────────────────────── --}}
        <div class="mb-6">
            <h1 class="text-2xl font-serif text-[#4A2A1B]">Secure Payment</h1>
            <p class="text-amber-700/80 text-sm mt-1">Choose your preferred payment method</p>
        </div>

        {{-- ── Card payment option (expands to show the form when selected) ── --}}
        <div @class([
            'rounded-2xl border p-5 transition-colors',
            'border-[#4A2A1B]' => $paymentMethod === 'card',
            'border-stone-200' => $paymentMethod !== 'card',
        ])>
            <button
                type="button"
                wire:click="selectPaymentMethod('card')"
                class="w-full flex items-center justify-between"
            >
                <span class="flex items-center gap-3">
                    <span @class([
                        'w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0',
                        'border-emerald-700' => $paymentMethod === 'card',
                        'border-stone-300' => $paymentMethod !== 'card',
                    ])>
                        @if ($paymentMethod === 'card')
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-700"></span>
                        @endif
                    </span>
                    <span class="font-medium text-stone-800">Card Payment</span>
                </span>

                {{-- Mastercard / Visa marks --}}
                <span class="flex items-center gap-2">
                    <span class="relative w-9 h-6 shrink-0" aria-hidden="true">
                        <span class="absolute left-0 w-6 h-6 rounded-full bg-red-500 opacity-90"></span>
                        <span class="absolute right-0 w-6 h-6 rounded-full bg-amber-400 opacity-90 mix-blend-multiply"></span>
                    </span>
                    <span class="text-blue-800 font-black italic text-sm">VISA</span>
                </span>
            </button>

            @if ($paymentMethod === 'card')
                <div class="mt-5 space-y-4">
                    <div>
                        <label for="cardNumber" class="block text-sm font-medium text-stone-700 mb-1.5">
                            Card Number
                        </label>
                        <input
                            id="cardNumber"
                            type="text"
                            inputmode="numeric"
                            maxlength="19"
                            wire:model.blur="cardNumber"
                            placeholder="1234 5678 9234 5678"
                            class="w-full rounded-xl border border-stone-300 px-4 py-3 text-stone-700 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#4A2A1B]/40 focus:border-[#4A2A1B]"
                        >
                        @error('cardNumber') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="expiryDate" class="block text-sm font-medium text-stone-700 mb-1.5">
                                Expiry Date
                            </label>
                            <input
                                id="expiryDate"
                                type="text"
                                maxlength="5"
                                wire:model.blur="expiryDate"
                                placeholder="MM/YY"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-stone-700 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#4A2A1B]/40 focus:border-[#4A2A1B]"
                            >
                            @error('expiryDate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="cvv" class="block text-sm font-medium text-stone-700 mb-1.5">
                                CVV
                            </label>
                            <input
                                id="cvv"
                                type="password"
                                inputmode="numeric"
                                maxlength="4"
                                wire:model.blur="cvv"
                                placeholder="123"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-stone-700 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#4A2A1B]/40 focus:border-[#4A2A1B]"
                            >
                            @error('cvv') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="nameOnCard" class="block text-sm font-medium text-stone-700 mb-1.5">
                            Name on Card
                        </label>
                        <input
                            id="nameOnCard"
                            type="text"
                            wire:model.blur="nameOnCard"
                            placeholder="Tolu Adewole"
                            class="w-full rounded-xl border border-stone-300 px-4 py-3 text-stone-700 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#4A2A1B]/40 focus:border-[#4A2A1B]"
                        >
                        @error('nameOnCard') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            @endif
        </div>

        {{-- ── Other payment methods ──────────────────────────────────── --}}
        <div class="mt-4 space-y-4">
            @foreach ([
                'bank_transfer' => ['label' => 'Bank Transfer', 'desc' => 'Local bank transfer'],
                'mobile_pay' => ['label' => 'Mobile Pay', 'desc' => 'MTN MoMo, AirtelTigo & More'],
                'ussd' => ['label' => 'USSD', 'desc' => '*323# · Pay Securely'],
            ] as $key => $option)
                <button
                    type="button"
                    wire:click="selectPaymentMethod('{{ $key }}')"
                    @class([
                        'w-full flex items-center gap-3 rounded-2xl border p-5 text-left transition-colors',
                        'border-[#4A2A1B]' => $paymentMethod === $key,
                        'border-stone-200 hover:border-stone-300' => $paymentMethod !== $key,
                    ])
                >
                    <span @class([
                        'w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0',
                        'border-emerald-700' => $paymentMethod === $key,
                        'border-stone-300' => $paymentMethod !== $key,
                    ])>
                        @if ($paymentMethod === $key)
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-700"></span>
                        @endif
                    </span>
                    <span>
                        <span class="block font-medium text-stone-800">{{ $option['label'] }}</span>
                        <span class="block text-xs text-stone-400">{{ $option['desc'] }}</span>
                    </span>
                </button>
            @endforeach
        </div>

        
        {{-- ── Promo code ──────────────────────────────────────────────── --}}
        <div class="mt-8">
            <label for="promoCode" class="block text-sm font-semibold text-stone-800 mb-2">
                Have a promo code?
            </label>
            <div class="flex gap-3">
                <input
                    id="promoCode"
                    type="text"
                    wire:model="promoCode"
                    placeholder="Enter code"
                    class="flex-1 rounded-xl border border-stone-300 px-4 py-3 text-stone-700 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#4A2A1B]/40 focus:border-[#4A2A1B]"
                >
                <button
                    type="button"
                    wire:click="applyPromoCode"
                    wire:loading.attr="disabled"
                    wire:target="applyPromoCode"
                    class="px-6 rounded-xl bg-stone-200 text-stone-700 font-semibold hover:bg-stone-300 transition-colors disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="applyPromoCode">Apply</span>
                    <span wire:loading wire:target="applyPromoCode">...</span>
                </button>
            </div>
            @if ($promoMessage)
                <p @class([
                    'mt-2 text-xs',
                    'text-emerald-700' => $promoApplied,
                    'text-stone-500' => !$promoApplied,
                ])>
                    {{ $promoMessage }}
                </p>
            @endif
        </div>

        {{-- ── Pay button ──────────────────────────────────────────────── --}}
        <button
            type="button"
            wire:click="pay"
            wire:loading.attr="disabled"
            wire:target="pay"
            class="mt-8 w-full sm:w-auto sm:float-right rounded-2xl bg-[#4A2A1B] hover:bg-[#5c3624] text-white font-bold text-lg px-10 py-4 transition-colors disabled:opacity-70"
        >
            <span wire:loading.remove wire:target="pay">
                PAY ₦{{ number_format($amount, 0) }}
            </span>
            <span wire:loading wire:target="pay">Processing…</span>
        </button>
        <div class="clear-both"></div>
    </div>
</div>
@endif