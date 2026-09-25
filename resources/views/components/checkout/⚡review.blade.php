<?php

use Livewire\Component;

new class extends Component
{
    public array $wizardSteps = ['Occasion', 'Size', 'Flavour', 'Style', 'Design', 'Details', 'Review'];
    public int $currentStep = 7; // "Review"

    /**
     * In a real app these would come from the order draft in session / DB,
     * built up across the previous wizard steps.
     */
    public array $orderItems = [
        [
            'name'        => 'The Birthday Classic',
            'size'        => '10" Red Velvet',
            'inscription' => 'Happy Birthday Sarah!',
            'qty'         => 1,
            'image'       => 'images/cakes/birthday-classic.svg',
        ],
        [
            'name'        => 'The Birthday Classic',
            'size'        => '10" Red Velvet',
            'inscription' => 'Happy Birthday Sarah!',
            'qty'         => 1,
            'image'       => 'images/cakes/chocolate-fudge-cake.svg',
        ],
        [
            'name'        => 'The Birthday Classic',
            'size'        => '10" Red Velvet',
            'inscription' => 'Happy Birthday Sarah!',
            'qty'         => 1,
            'image'       => 'images/cakes/red-velvet-cake.svg',
        ],
    ];

    public array $customer = [
        'name'  => 'Tolu Adewole',
        'email' => 'Toluadewole@gmail.com',
        'phone' => '+234947362801',
    ];

    public array $delivery = [
        'address' => '10A, Admiralty Way, Lekki, Lagos',
        'dueDate' => '25th May, 2026',
        'time'    => '12:00 PM',
    ];

    public string $personalMessage = 'Happy Birthday Sarah!!';

    public int $subtotal = 105000;
    public int $deliveryFee = 3500;

    public function getTotalProperty(): int
    {
        return $this->subtotal + $this->deliveryFee;
    }

    /**
     * Sends the user back to a given wizard step to make edits.
     * Adjust the route name / param to match your wizard's routing.
     */
    public function editSection(string $step)
    {
        return redirect()->route('checkout.step', ['step' => $step]);
    }

    public function proceedToPayment()
    {
        return redirect()->route('checkout.order-confirmation');
    }
};
?>

<div class="max-w-5xl mx-auto px-4 py-40">
    <div class="rounded-3xl border border-neutral-300 p-6 sm:p-10">

        {{-- ============ Step indicator ============ --}}
        <div class="mb-8 pb-6 border-b border-neutral-200">
            <div class="flex items-start justify-between">
                @foreach ($wizardSteps as $index => $label)
                    @php $step = $index + 1; @endphp
                    <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                        <div class="flex flex-col items-center gap-1.5 shrink-0">
                            <span
                                class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-semibold
                                    {{ $step <= $currentStep
                                        ? 'bg-amber-950 text-white'
                                        : 'border-2 border-neutral-300 text-neutral-400' }}"
                            >
                                {{ $step }}
                            </span>
                            <span
                                class="text-[11px] font-medium whitespace-nowrap
                                    {{ $step === $currentStep ? 'text-amber-950 font-bold' : 'text-neutral-400' }}"
                            >
                                {{ $label }}
                            </span>
                        </div>

                        @if (!$loop->last)
                            <div class="flex-1 h-px border-t-2 border-dashed border-neutral-300 mx-2 mb-5"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ============ Heading ============ --}}
        <h2 class="font-serif text-2xl text-amber-950 mb-1">Almost There</h2>
        <p class="text-sm text-amber-900/70 mb-8">Please review your order details before completing payment.</p>

        {{-- ============ Content ============ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- Left: review card --}}
            <div class="lg:col-span-2 rounded-2xl border border-neutral-300 p-6">

                {{-- Your Order --}}
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-serif text-xl text-amber-950">Your Order</h3>
                    <button type="button" wire:click="editSection('order')" class="inline-flex items-center gap-1 text-sm font-medium text-amber-900 underline">
                        Edit
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4 mb-2">
                    @foreach ($orderItems as $item)
                        <div wire:key="review-item-{{ $loop->index }}" class="flex gap-4">
                            <img
                                src="{{ asset($item['image']) }}"
                                alt="{{ $item['name'] }}"
                                class="h-16 w-16 shrink-0 rounded-lg object-cover"
                                loading="lazy"
                            />
                            <div>
                                <p class="font-serif text-lg text-neutral-900 leading-tight">{{ $item['name'] }}</p>
                                <p class="text-sm text-neutral-500">{{ $item['size'] }}</p>
                                <p class="text-sm text-neutral-500">Inscription: {{ $item['inscription'] }}</p>
                                <p class="text-sm text-neutral-500">Quantity: {{ $item['qty'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr class="my-6 border-neutral-200">

                {{-- Customer Details --}}
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-serif text-xl text-amber-950">Customer Details</h3>
                    <button type="button" wire:click="editSection('contact')" class="inline-flex items-center gap-1 text-sm font-medium text-amber-900 underline">
                        Edit
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                        </svg>
                    </button>
                </div>
                <div class="text-sm text-neutral-700 space-y-1">
                    <p>Name: {{ $customer['name'] }}</p>
                    <p>Email: {{ $customer['email'] }}</p>
                    <p>Phone Number: {{ $customer['phone'] }}</p>
                </div>

                <hr class="my-6 border-neutral-200">

                {{-- Delivery Details --}}
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-serif text-xl text-amber-950">Delivery Details</h3>
                    <button type="button" wire:click="editSection('details')" class="inline-flex items-center gap-1 text-sm font-medium text-amber-900 underline">
                        Edit
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                        </svg>
                    </button>
                </div>
                <div class="text-sm text-neutral-700 space-y-1">
                    <p>Address: {{ $delivery['address'] }}</p>
                    <p>Due Date: {{ $delivery['dueDate'] }}</p>
                    <p>Time: {{ $delivery['time'] }}</p>
                </div>

                <hr class="my-6 border-neutral-200">

                {{-- Personal Message --}}
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-serif text-xl text-amber-950">Personal Message</h3>
                    <button type="button" wire:click="editSection('details')" class="inline-flex items-center gap-1 text-sm font-medium text-amber-900 underline">
                        Edit
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-neutral-700">&ldquo;{{ $personalMessage }}&rdquo;</p>
            </div>

            {{-- Right: order summary --}}
            <div class="rounded-2xl border border-neutral-300 p-6">
                <h3 class="text-base font-bold uppercase tracking-wide text-neutral-900 mb-5">Order Summary</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-neutral-600">Subtotal</span>
                        <span class="font-semibold text-neutral-900">₦{{ number_format($subtotal) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-neutral-600">Delivery</span>
                        <span class="font-semibold text-neutral-900">₦{{ number_format($deliveryFee) }}</span>
                    </div>
                </div>

                <hr class="my-4 border-neutral-200">

                <div class="flex items-center justify-between mb-6">
                    <span class="text-base font-bold text-neutral-900">Total</span>
                    <span class="text-lg font-bold text-neutral-900">₦{{ number_format($this->total) }}</span>
                </div>

                <button
                    type="button"
                    wire:click="proceedToPayment"
                    wire:loading.attr="disabled"
                    class="w-full rounded-full bg-amber-950 py-3 text-xs font-bold uppercase tracking-wide text-white hover:bg-amber-900 transition disabled:opacity-60"
                >
                    Proceed to Payment
                </button>
            </div>
        </div>
    </div>
</div>