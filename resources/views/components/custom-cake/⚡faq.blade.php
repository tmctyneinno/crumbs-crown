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
                'question' => 'How early should i place my order for a custom cake?',
                'answer'   => 'Please place your order at least 5–7 days before your celebration. Larger, tiered, or highly detailed cakes may require more notice so we have enough time for design, baking, decoration, and delivery.',
            ],
            [
                'question' => 'Can i send a reference picture for my custom cake?',
                'answer'   => 'Yes. You can send a reference picture through our enquiry form or share it with our cake team when discussing your order. We use it to understand your preferred colours, shape, style, and details.',
            ],
            [
                'question' => 'Can you recreate a cake from a picture?',
                'answer'   => 'Yes. We can create a cake inspired by a reference image, subject to the design, size, flavours, and finishing details. We will confirm what can be recreated and provide a quote before production.',
            ],
            [
                'question' => 'Can i combine different cake flavours in one order?',
                'answer'   => 'Yes, selected flavours can be combined in one cake. Our team will advise on compatible fillings and how the tiers or cake layers should be arranged.',
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
                'question' => 'Do you make wedding cakes?',
                'answer'   => 'Yes. We make wedding cakes in a range of sizes, flavours, and designs, including simple celebration cakes and multi-tiered centrepieces. Contact us early so we can confirm availability for your date.',
            ],
            [
                'question' => 'How much does a custom cake cost?',
                'answer'   => 'The price depends on the cake size, flavour, number of tiers, design complexity, and decorations. Share your requirements with us and we will prepare a personalised quote.',
            ],
            [
                'question' => 'Do you deliver custom cakes?',
                'answer'   => 'Yes, we deliver custom cakes to available locations. Delivery timing and cost depend on your address, cake size, and event date, and will be confirmed with your order.',
            ],
            [
                'question' => 'Can i change my design after submitting my request?',
                'answer'   => 'Please contact us as soon as possible. Changes may be possible before ingredients are purchased or production begins, but changes made later may affect the price, design, or delivery date.',
            ],
        ];
    }
};

?>

<div>
    <div class="bg-white">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6">

            <h2 class="text-center font-[Oswald,ui-sans-serif] text-2xl font-bold uppercase tracking-tight text-stone-900 sm:text-3xl">
                Custom Cake Questions? We&rsquo;ve Got Answers
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