<!-- ===== KNOW MORE ABOUT US SECTION ===== -->
<section class="py-16 md:py-24 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">

            <!-- Left Content - Image with Badge -->
            <div class="relative">
                <div class="rounded-2xl overflow-hidden">
                    <img src="{{ asset('images/about-baker.jpg') }}"
                        alt="Baker decorating cupcakes"
                        class="w-full h-auto object-cover" />
                </div>

                <!-- Years of Experience Badge -->
                <div class="absolute bottom-4 right-4 bg-[#3D2314]/90 backdrop-blur-sm rounded-xl px-5 py-4 text-white">
                    <p class="text-2xl font-bold leading-none">8+</p>
                    <p class="text-xs mt-1 whitespace-nowrap">Years of Experience</p>
                </div>
            </div>

            <!-- Right Content - About Text -->
            <div>
                <!-- Eyebrow -->
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-8 h-px bg-[#3D2314]"></span>
                    <p class="text-[#8B4A2B] text-xs font-semibold tracking-[0.2em] uppercase">Who are we?</p>
                </div>

                <!-- Heading -->
                <h2 class="text-3xl sm:text-4xl font-bold text-[#1A1A1A] mb-6">
                    KNOW MORE <span class="text-[#8B4A2B]">ABOUT US</span>
                </h2>

                <!-- Body Copy -->
                <div class="space-y-4 text-[#4A4A4A] text-[15px] leading-relaxed">
                    <p>
                        More than cake. It's part of the moment.
                        At Crumbs & Crown, we believe a great cake should do more than look beautiful it should make people pause, smile, and reach for one more slice.
                        What started with a love for baking has grown into a cake studio creating thoughtful, beautifully finished cakes for birthdays, weddings, celebrations, and everything worth marking.
                        From our classic best sellers to completely custom creations, every cake is made with quality ingredients, careful attention to detail, and a whole lot of love.
                    </p>
                </div>

                <!-- Made for your moments -->
                <div class="mt-8 space-y-5">
                    <h3 class="font-bold text-[#1A1A1A] text-base">Made for your moments</h3>

                    <div>
                        <h4 class="font-semibold text-[#1A1A1A] text-[15px]">Freshly Made</h4>
                        <p class="text-[#4A4A4A] text-sm mt-1">Every cake is freshly prepared with care, from the first whisk to the final finish.</p>
           
                        <h4 class="font-semibold text-[#1A1A1A] text-[15px]">Made Your Way</h4>
                        <p class="text-[#4A4A4A] text-sm mt-1">Tell us what you're imagining and we'll turn your idea into something deliciously yours.</p>
             
                        <h4 class="font-semibold text-[#1A1A1A] text-[15px]">Worth Remembering</h4>
                        <p class="text-[#4A4A4A] text-sm mt-1">Because the best celebrations deserve a cake people are still talking about after the last slice.</p>
                    </div>
                </div>

                <!-- Learn More Button -->
                <a href="#" class="inline-flex items-center gap-2 mt-8 px-6 py-3 bg-[#3D2314] text-white text-sm font-semibold rounded-full hover:bg-[#5A2F20] transition-colors duration-300">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H7M17 7V17" />
                    </svg>
                </a>
            </div>

        </div>

        <!-- Features Row -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mt-16">

            <div class="flex flex-col items-center text-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                <img src="{{ asset('images/premium.png') }}"
                    alt="Premium Ingredients"
                    class=" md:w-[30px] lg:w-[30px] h-auto object-contain drop-shadow-2xl shadow-primary" />

                <h4 class="font-semibold text-[#1A1A1A] text-sm">Premium Ingredients</h4>
                <p class="text-[#4A4A4A] text-xs">We only use the finest ingredients</p>
            </div>

            <div class="flex flex-col items-center text-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                 <img src="{{ asset('images/master.png') }}"
                    alt="Master Cake Artists"
                    class=" md:w-[30px] lg:w-[30px] h-auto object-contain drop-shadow-2xl shadow-primary" />
                <h4 class="font-semibold text-[#1A1A1A] text-sm">Master Cake Artists</h4>
                <p class="text-[#4A4A4A] text-xs">Our team of experienced pastry chefs</p>
            </div>

            <div class="flex flex-col items-center text-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                <img src="{{ asset('images/streamline-cyber_design-mug.png') }}"
                    alt="Custom Designs"
                    class=" md:w-[30px] lg:w-[30px] h-auto object-contain drop-shadow-2xl shadow-primary" />
               
                <h4 class="font-semibold text-[#1A1A1A] text-sm">Custom Designs</h4>
                <p class="text-[#4A4A4A] text-xs">From fantasy to elegant reality</p>
            </div>

            <div class="flex flex-col items-center text-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                <img src="{{ asset('images/solar_delivery-broken.png') }}"
                    alt="Nationwide Delivery"
                    class=" md:w-[30px] lg:w-[30px] h-auto object-contain drop-shadow-2xl shadow-primary" />
               
                <h4 class="font-semibold text-[#1A1A1A] text-sm">Nationwide Delivery</h4>
                <p class="text-[#4A4A4A] text-xs">Delivered nationwide with safe packaging</p>
            </div>

            <div class="flex flex-col items-center text-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                <img src="{{ asset('images/award-winning.png') }}"
                    alt="Award Winning"
                    class=" md:w-[30px] lg:w-[30px] h-auto object-contain drop-shadow-2xl shadow-primary" />
               
                <h4 class="font-semibold text-[#1A1A1A] text-sm">Award Winning</h4>
                <p class="text-[#4A4A4A] text-xs">Recognised as one of the top in the country</p>
            </div>

            <div class="flex flex-col items-center text-center gap-3 bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                 <img src="{{ asset('images/made-love.png') }}"
                    alt="Made With Love"
                    class=" md:w-[30px] lg:w-[30px] h-auto object-contain drop-shadow-2xl shadow-primary" />
               
                <h4 class="font-semibold text-[#1A1A1A] text-sm">Made With Love</h4>
                <p class="text-[#4A4A4A] text-xs">Every product made with love and perfection</p>
            </div>

        </div>

    </div>
</section>