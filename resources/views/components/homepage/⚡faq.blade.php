<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    /**
     * Left column — first 4 questions, top to bottom.
     */
    #[Computed]
    public function leftFaqs(): array
    {
        return [
            [
                'question' => 'How fresh are your pastries?',
                'answer'   => 'Every pastry is baked fresh to order — nothing sits in a warehouse. Orders placed before our daily cut-off go into the oven the same day and reach you within hours of baking.',
            ],
            [
                'question' => 'Do you offer same day delivery?',
                'answer'   => 'Same-day delivery is available in select areas for orders placed before 12pm. Choose your delivery window at checkout and we\'ll confirm availability for your address right away.',
            ],
            [
                'question' => 'Can I order pastries in bulk?',
                'answer'   => 'Absolutely. Bulk orders for offices, parties and events are one of our specialities — reach out at least 48 hours ahead so we can plan quantities and delivery around your date.',
            ],
            [
                'question' => 'Do you cater corporate events?',
                'answer'   => 'Yes, we regularly cater office meetings, launches and corporate functions of all sizes, with platters and boxed options designed for easy sharing.',
            ],
        ];
    }

    /**
     * Right column — last 4 questions, top to bottom.
     */
    #[Computed]
    public function rightFaqs(): array
    {
        return [
            [
                'question' => 'Can I customise a pastry box?',
                'answer'   => 'Yes — you can mix and match flavours, swap out items you don\'t like, and add a personalised note card at checkout. For fully custom assortments, use our Custom Cake & Box builder or contact us directly.',
            ],
            [
                'question' => 'How many pieces come in a small chops box?',
                'answer'   => 'Our standard small chops box holds 20 pieces, with a mixed selection of our most popular bites. Larger boxes and bulk trays are available for bigger gatherings.',
            ],
            [
                'question' => 'How should I store my pastries?',
                'answer'   => 'Most pastries are best kept at room temperature in an airtight container for up to 2 days. Cream- or fruit-filled items should be refrigerated and eaten within 3 days for the best taste and texture.',
            ],
            [
                'question' => 'Do you offer event catering packages?',
                'answer'   => 'We do — from small gatherings to full-scale events, our catering packages can be tailored to your guest count, budget and theme. Get in touch and we\'ll put together a quote.',
            ],
        ];
    }
};

?>

<div>
    <div class="bg-white">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">

            <h2 class="text-center font-[Oswald,ui-sans-serif] text-2xl font-bold uppercase tracking-tight text-stone-900 sm:text-3xl">
                Pastry Questions? We&rsquo;ve Got Answers
            </h2>

            {{-- Two independent columns, side by side from md and up --}}
            <div class="mt-8 flex flex-col gap-4 md:flex-row md:items-start md:gap-8">

                {{-- LEFT COLUMN --}}
                <div class="flex w-full flex-col gap-4 md:w-1/2">
                    @foreach ($this->leftFaqs as $faq)
                        <div
                            x-data="{ open: false }"
                            class="rounded-2xl border border-[#8A5A3A]/40 bg-white transition-colors"
                            :class="open ? 'border-[#4A2A16]' : ''"
                        >
                            <button
                                type="button"
                                @click="open = !open"
                                :aria-expanded="open"
                                class="flex w-full items-center justify-between gap-4 px-6 py-4 text-left"
                            >
                                <span class="text-base font-medium text-[#5C3A22]">
                                    {{ $faq['question'] }}
                                </span>
                                <svg
                                    class="h-5 w-5 shrink-0 text-[#5C3A22] transition-transform duration-200"
                                    :class="open ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-collapse x-cloak>
                                <p class="px-6 pb-5 text-sm leading-relaxed text-stone-600">
                                    {{ $faq['answer'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="flex w-full flex-col gap-4 md:w-1/2">
                    @foreach ($this->rightFaqs as $faq)
                        <div
                            x-data="{ open: false }"
                            class="rounded-2xl border border-[#8A5A3A]/40 bg-white transition-colors"
                            :class="open ? 'border-[#4A2A16]' : ''"
                        >
                            <button
                                type="button"
                                @click="open = !open"
                                :aria-expanded="open"
                                class="flex w-full items-center justify-between gap-4 px-6 py-4 text-left"
                            >
                                <span class="text-base font-medium text-[#5C3A22]">
                                    {{ $faq['question'] }}
                                </span>
                                <svg
                                    class="h-5 w-5 shrink-0 text-[#5C3A22] transition-transform duration-200"
                                    :class="open ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-collapse x-cloak>
                                <p class="px-6 pb-5 text-sm leading-relaxed text-stone-600">
                                    {{ $faq['answer'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>