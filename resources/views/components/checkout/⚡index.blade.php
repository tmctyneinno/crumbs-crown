<?php

use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public array $wizardSteps = ['Occasion', 'Size', 'Flavour', 'Style', 'Design', 'Details', 'Review'];
    public int $currentStep = 6; // 1-indexed — "Details"

    // ----- Contact fields -----
    public string $fullName = '';
    public string $phone = '';
    public string $email = '';
    public string $notes = '';

    // ----- Delivery -----
    public string $deliveryMethod = ''; // 'delivery' | 'pickup'
    public string $deliveryAddress = '';

    // ----- Calendar -----
    public int $viewYear;
    public int $viewMonth;
    public string $selectedDate;

    public function mount(): void
    {
        $today = Carbon::now();
        $this->viewYear = (int) $today->format('Y');
        $this->viewMonth = (int) $today->format('n');
        $this->selectedDate = $today->format('Y-m-d');
    }

    #[Computed]
    public function monthLabel(): string
    {
        return Carbon::create($this->viewYear, $this->viewMonth, 1)->format('F Y');
    }

    #[Computed]
    public function selectedDateLabel(): string
    {
        return Carbon::parse($this->selectedDate)->format('l, j F Y');
    }

    /**
     * Returns a flat array of day-cells (Mon → Sun grid), each with
     * a date string, day number, and whether it's in the viewed month / today / selected.
     */
    #[Computed]
    public function calendarDays(): array
    {
        $firstOfMonth = Carbon::create($this->viewYear, $this->viewMonth, 1);
        $startOffset = $firstOfMonth->dayOfWeekIso - 1; // 0 = Monday
        $gridStart = $firstOfMonth->copy()->subDays($startOffset);

        $totalCells = 42; // 6 full weeks, keeps the grid stable across months
        $today = Carbon::today()->format('Y-m-d');

        $days = [];
        for ($i = 0; $i < $totalCells; $i++) {
            $date = $gridStart->copy()->addDays($i);
            $dateString = $date->format('Y-m-d');

            $days[] = [
                'date'         => $dateString,
                'day'          => $date->day,
                'inMonth'      => $date->month === $this->viewMonth,
                'isToday'      => $dateString === $today,
                'isSelected'   => $dateString === $this->selectedDate,
                'isPast'       => $date->lt(Carbon::today()),
            ];
        }

        return $days;
    }

    public function prevMonth(): void
    {
        $date = Carbon::create($this->viewYear, $this->viewMonth, 1)->subMonth();
        $this->viewYear = (int) $date->format('Y');
        $this->viewMonth = (int) $date->format('n');
    }

    public function nextMonth(): void
    {
        $date = Carbon::create($this->viewYear, $this->viewMonth, 1)->addMonth();
        $this->viewYear = (int) $date->format('Y');
        $this->viewMonth = (int) $date->format('n');
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
    }

    public function setDeliveryMethod(string $method): void
    {
        $this->deliveryMethod = $method;
    }

    protected function rules(): array
    {
        return [
            'fullName'        => 'required|string|max:255',
            'phone'           => 'required|string|max:30',
            'email'           => 'required|email',
            'notes'           => 'nullable|string|max:1000',
            'deliveryMethod'  => 'required|in:delivery,pickup',
            'deliveryAddress' => 'required_if:deliveryMethod,delivery|nullable|string|max:500',
            'selectedDate'    => 'required|date',
        ];
    }

    public function proceedToNextStep()
    {
        $this->validate();

        return redirect()->route('checkout.review');
    }
};
?>

<div class="max-w-5xl mx-auto px-4 py-50">
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
        <h2 class="font-serif text-2xl text-amber-950 mb-1">Contact and Delivery Details</h2>
        <p class="text-sm text-amber-900/70 mb-8">So we can reach and deliver your order</p>

        {{-- ============ Contact fields ============ --}}
        <div class="space-y-5 mb-8">
            <div>
                <label for="fullName" class="block text-sm font-bold text-neutral-900 mb-1.5">Full Name</label>
                <input
                    id="fullName" type="text" wire:model="fullName" placeholder="Enter your full name"
                    class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900"
                />
                @error('fullName') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="phone" class="block text-sm font-bold text-neutral-900 mb-1.5">Phone Number</label>
                    <input
                        id="phone" type="tel" wire:model="phone" placeholder="Enter your phone number"
                        class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900"
                    />
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-bold text-neutral-900 mb-1.5">Email Address</label>
                    <input
                        id="email" type="email" wire:model="email" placeholder="Enter your email address"
                        class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900"
                    />
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-bold text-neutral-900 mb-1.5">
                    Additional Notes <span class="font-normal text-neutral-400">(Optional)</span>
                </label>
                <textarea
                    id="notes" wire:model="notes" rows="3" placeholder="Any additional information?...."
                    class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900 resize-none"
                ></textarea>
            </div>
        </div>

        {{-- ============ Calendar + Delivery method ============ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

            {{-- Calendar --}}
            <div>
                <p class="text-sm font-bold text-neutral-900 mb-2">When do you need it?</p>
                <div class="rounded-xl border border-neutral-300 p-4">
                    <div class="flex items-center justify-between mb-4">
                        <button type="button" wire:click="prevMonth" class="h-7 w-7 flex items-center justify-center text-neutral-600 hover:text-neutral-900" aria-label="Previous month">
                            &lsaquo;
                        </button>
                        <span class="text-sm font-bold text-neutral-900">{{ $this->monthLabel }}</span>
                        <button type="button" wire:click="nextMonth" class="h-7 w-7 flex items-center justify-center text-neutral-600 hover:text-neutral-900" aria-label="Next month">
                            &rsaquo;
                        </button>
                    </div>

                    <div class="grid grid-cols-7 gap-y-1.5 text-center">
                        @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dow)
                            <span class="text-xs text-neutral-400 pb-1">{{ $dow }}</span>
                        @endforeach

                        @foreach ($this->calendarDays as $cell)
                            <button
                                type="button"
                                wire:key="day-{{ $cell['date'] }}"
                                wire:click="selectDate('{{ $cell['date'] }}')"
                                @disabled($cell['isPast'] && !$cell['isToday'])
                                class="mx-auto flex h-8 w-8 items-center justify-center rounded-full text-sm transition
                                    {{ $cell['isSelected']
                                        ? 'bg-amber-950 text-white font-semibold'
                                        : ($cell['inMonth'] ? 'text-neutral-800 hover:bg-neutral-100' : 'text-neutral-300') }}
                                    {{ $cell['isPast'] && !$cell['isToday'] && !$cell['isSelected'] ? 'opacity-40 cursor-not-allowed' : '' }}"
                            >
                                {{ $cell['day'] }}
                            </button>
                        @endforeach
                    </div>

                    <p class="text-center text-sm font-bold text-neutral-900 mt-4">
                        {{ $this->selectedDateLabel }}
                    </p>
                </div>
                @error('selectedDate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Delivery or Pickup --}}
            <div>
                <p class="text-sm font-bold text-neutral-900 mb-2">Delivery or Pickup</p>
                <div class="space-y-4">
                    <button
                        type="button"
                        wire:click="setDeliveryMethod('delivery')"
                        class="w-full text-left rounded-xl border p-4 flex items-start gap-4 transition
                            {{ $deliveryMethod === 'delivery' ? 'border-amber-950 ring-1 ring-amber-950' : 'border-neutral-300 hover:border-neutral-400' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 shrink-0 text-neutral-800">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25h5.25l3 6.75v3.75a1.5 1.5 0 0 1-1.5 1.5h-1.5m-6-11.25v11.25m0-11.25h-6.75a1.5 1.5 0 0 0-1.5 1.5v6.75" />
                        </svg>
                        <div>
                            <p class="font-bold text-neutral-900 mb-0.5">Delivery</p>
                            <p class="text-sm text-neutral-500">I prefer it delivered to the provided location below</p>
                        </div>
                    </button>

                    <button
                        type="button"
                        wire:click="setDeliveryMethod('pickup')"
                        class="w-full text-left rounded-xl border p-4 flex items-start gap-4 transition
                            {{ $deliveryMethod === 'pickup' ? 'border-amber-950 ring-1 ring-amber-950' : 'border-neutral-300 hover:border-neutral-400' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 shrink-0 text-neutral-800">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                        <div>
                            <p class="font-bold text-neutral-900 mb-0.5">Pick up</p>
                            <p class="text-sm text-neutral-500">I prefer to pick up from your store</p>
                        </div>
                    </button>
                </div>
                @error('deliveryMethod') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ============ Delivery address ============ --}}
        @if ($deliveryMethod !== 'pickup')
            <div class="mb-8">
                <label for="deliveryAddress" class="block text-sm font-bold text-neutral-900 mb-1.5">Delivery Address</label>
                <input
                    id="deliveryAddress" type="text" wire:model="deliveryAddress" placeholder="Enter your Delivery address"
                    class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900"
                />
                @error('deliveryAddress') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        @endif

        {{-- ============ Actions ============ --}}
        <div class="flex justify-end">
            <button
                type="button"
                wire:click="proceedToNextStep"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 rounded-full bg-amber-950 pl-6 pr-2 py-2 text-sm font-semibold text-white hover:bg-amber-900 transition disabled:opacity-60"
            >
                Proceed to Next Step
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-white/15">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0H8.25m11.25 0v11.25" />
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>