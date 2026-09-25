<?php

namespace App\Livewire;

use Livewire\Component;

new class extends Component
{
    // ----- Form state -----
    public string $fullName = '';
    public string $email = '';
    public string $phone = '';
    public string $enquiryType = '';
    public string $message = '';

    /**
     * Top row: contact method cards.
     */
    public array $contactMethods = [
        [
            'icon'        => 'phone',
            'title'       => 'Orders & Customer Care',
            'description' => 'For questions about your order, products, delivery or general assistance',
            'details'     => [
                ['label' => 'Whatsapp', 'value' => '08123456789'],
                ['label' => 'Telephone', 'value' => '08123456789'],
            ],
            'cta'         => 'Contact Customer Care',
            'href'        => '#',
        ],
        [
            'icon'        => 'mail',
            'title'       => 'General Enquiries',
            'description' => 'For general questions about Crumbs & Crown, our products and services',
            'details'     => [
                ['label' => 'Email Address', 'value' => 'hello@crumbsandcrown.com'],
            ],
            'cta'         => 'Send An Email',
            'href'        => 'mailto:hello@crumbsandcrown.com',
        ],
        [
            'icon'        => 'gift',
            'title'       => 'Corporate Gifting',
            'description' => 'Talk to our corporate team about bulk orders, branded gifts and recurring gifts',
            'details'     => [
                ['label' => 'Email Address', 'value' => 'corporate@crumbsandcrown.com'],
            ],
            'cta'         => 'Corporate Enquiry',
            'href'        => 'mailto:corporate@crumbsandcrown.com',
        ],
        [
            'icon'        => 'rings',
            'title'       => 'Weddings & Events',
            'description' => 'Tell us about your wedding or event and we will help you create something memorable',
            'details'     => [
                ['label' => 'Email Address', 'value' => 'events@crumbsandcrown.com'],
            ],
            'cta'         => 'Plan Your Event',
            'href'        => 'mailto:events@crumbsandcrown.com',
        ],
    ];

    /**
     * 2x2 quick-link cards on the lower-left.
     */
    public array $quickLinks = [
        [
            'icon'        => 'cake',
            'title'       => 'Order A Cake',
            'description' => 'Need a cake for an upcoming celebration?',
            'cta'         => 'Order a Cake',
            'href'        => '#',
        ],
        [
            'icon'        => 'truck',
            'title'       => 'Delivery',
            'description' => 'Questions about delivery areas, dates and collection',
            'cta'         => 'View Delivery Info',
            'href'        => '#',
        ],
        [
            'icon'        => 'question',
            'title'       => 'FAQ',
            'description' => 'Find answers to common questions',
            'cta'         => 'Visit FAQ',
            'href'        => '#',
        ],
        [
            'icon'        => 'bag',
            'title'       => 'Shop With Us',
            'description' => 'Ready to browse our collection?',
            'cta'         => 'Shop Now',
            'href'        => '#',
        ],
    ];

    public array $enquiryTypes = [
        'order'      => 'Order enquiry',
        'delivery'   => 'Delivery enquiry',
        'corporate'  => 'Corporate gifting',
        'wedding'    => 'Weddings & events',
        'other'      => 'Something else',
    ];

    protected function rules(): array
    {
        return [
            'fullName'    => 'required|string|max:255',
            'email'       => 'required|email',
            'phone'       => 'nullable|string|max:30',
            'enquiryType' => 'required|string',
            'message'     => 'required|string|max:2000',
        ];
    }

    public function sendMessage(): void
    {
        $this->validate();

        // TODO: dispatch a Mail/Notification here.

        $this->reset(['fullName', 'email', 'phone', 'enquiryType', 'message']);
        $this->dispatch('message-sent');
    }

}
?>

<div>
   <div class="bg-white">

    {{-- ============ TOP: contact method cards ============ --}}
    <div class="max-w-5xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($contactMethods as $method)
                <div wire:key="method-{{ $loop->index }}" class="flex flex-col rounded-2xl border border-neutral-200 p-5">
                    <div class="text-neutral-800 mb-4">
                        <livewire:connect.icon :name="$method['icon']" :class="'w-7 h-7'" />

                    </div>

                    <h3 class="font-serif text-lg text-amber-900 mb-1.5">{{ $method['title'] }}</h3>
                    <p class="text-sm text-neutral-500 leading-snug mb-4">{{ $method['description'] }}</p>

                    <div class="space-y-2.5 mb-5">
                        @foreach ($method['details'] as $detail)
                            <div>
                                <p class="text-sm font-semibold text-amber-900">{{ $detail['label'] }}</p>
                                <p class="text-sm text-neutral-600">{{ $detail['value'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <a
                        href="{{ $method['href'] }}"
                        class="mt-auto inline-flex items-center justify-between gap-2 rounded-full border border-neutral-300 pl-4 pr-1.5 py-1.5 text-xs font-semibold tracking-wide uppercase text-neutral-800 hover:bg-neutral-50 transition"
                    >
                        {{ $method['cta'] }}
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-amber-950 text-white">
                            <livewire:connect.icon :name="'arrow-up-right'" :class="'w-3.5 h-3.5'" />

                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============ BOTTOM: quick links + location + form ============ --}}
    <div class="bg-[#f5ece2] py-12">
        <div class="max-w-5xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            {{-- Left column --}}
            <div class="flex flex-col gap-6">

                {{-- 2x2 quick links --}}
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($quickLinks as $link)
                        <div wire:key="quick-{{ $loop->index }}" class="rounded-2xl bg-white border border-neutral-200 p-5 flex flex-col">
                            <span class="mb-3 flex h-9 w-9 items-center justify-center rounded-full bg-neutral-100 text-neutral-700">
                                <livewire:connect.icon :name="$link['icon']" :class="'w-4.5 h-4.5'" />
                            </span>
                            <h4 class="text-sm font-bold uppercase tracking-wide text-neutral-900 mb-1">{{ $link['title'] }}</h4>
                            <p class="text-xs text-neutral-400 leading-snug mb-3">{{ $link['description'] }}</p>
                            <a href="{{ $link['href'] }}" class="mt-auto inline-flex items-center gap-1 text-xs font-bold text-amber-900 hover:underline">
                                {{ $link['cta'] }}
                                <livewire:connect.icon :name="'arrow-right'" :class="'w-3.5 h-3.5'" />
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Location card --}}
                <div class="rounded-2xl bg-white border border-neutral-200 p-5 overflow-hidden">
                    <h4 class="text-sm font-bold uppercase tracking-wide text-neutral-900 mb-4">Crumbs & Crown</h4>

                    <div class="grid grid-cols-2 gap-4 mb-5 text-sm">
                        <div>
                            <p class="font-bold text-neutral-900 mb-1">Address</p>
                            <p class="flex items-center gap-1 text-neutral-500">
                                <livewire:connect.icon :name="'pin'" :class="'w-4 h-4'" />
                                Lagos, Nigeria
                            </p>
                        </div>
                        <div>
                            <p class="font-bold text-neutral-900 mb-1">Opening Hours</p>
                            <p class="text-neutral-500">Monday - Saturday</p>
                            <p class="text-neutral-400">9:00 AM - 7:00 PM</p>
                        </div>
                        <div class="col-start-2">
                            <p class="text-neutral-500">Sunday</p>
                            <p class="text-neutral-400">10:00 AM - 5:00 PM</p>
                        </div>
                    </div>

                    <div class="-mx-5 -mb-5">
                        <img
                            src="{{ asset('images/map-placeholder.png') }}"
                            alt="Map to Crumbs & Crown"
                            class="w-full h-48 object-cover grayscale sepia-[.2] opacity-90"
                            loading="lazy"
                        />
                    </div>
                </div>
            </div>

            {{-- Right column: form --}}
            <div class="rounded-2xl bg-white border border-neutral-200 p-6 sm:p-8">
                <form wire:submit="sendMessage" class="space-y-5">
                    <div>
                        <label for="fullName" class="block text-xs font-bold uppercase tracking-wide text-neutral-900 mb-1.5">Full Name</label>
                        <input
                            id="fullName" type="text" wire:model="fullName" placeholder="Enter your full name"
                            class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900"
                        />
                        @error('fullName') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wide text-neutral-900 mb-1.5">Email Address</label>
                        <input
                            id="email" type="email" wire:model="email" placeholder="Enter your email"
                            class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900"
                        />
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wide text-neutral-900 mb-1.5">Phone Number</label>
                        <input
                            id="phone" type="tel" wire:model="phone" placeholder="Enter your phone number"
                            class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900"
                        />
                        @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="enquiryType" class="block text-xs font-bold uppercase tracking-wide text-neutral-900 mb-1.5">What Can We Help You With</label>
                        <div class="relative">
                            <select
                                id="enquiryType" wire:model="enquiryType"
                                class="w-full appearance-none rounded-lg border border-neutral-300 px-4 py-2.5 text-sm text-neutral-700 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900"
                            >
                                <option value="" disabled selected>Select an enquiry type</option>
                                @foreach ($enquiryTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-neutral-500">
                                <livewire:connect.icon :name="'chevron-down'" :class="'w-4 h-4'" />
                            </span>
                        </div>
                        @error('enquiryType') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-bold uppercase tracking-wide text-neutral-900 mb-1.5">Message</label>
                        <textarea
                            id="message" wire:model="message" rows="4" placeholder="Tell us what we can help you with...."
                            class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 text-sm placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-900/30 focus:border-amber-900 resize-none"
                        ></textarea>
                        @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage"
                        class="inline-flex items-center gap-2 rounded-full bg-amber-950 px-6 py-3 text-xs font-bold uppercase tracking-wide text-white hover:bg-amber-900 transition disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="sendMessage">Send Message</span>
                        <span wire:loading wire:target="sendMessage">Sending...</span>
                        <livewire:connect.icon :name="'arrow-right'" :class="'w-4 h-4'" />
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('message-sent', () => {
            alert('Thanks — your message has been sent!');
        });
    });
</script>

</div>