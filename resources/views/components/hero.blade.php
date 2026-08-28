<!-- ===== HERO SECTION ===== -->
<section class=" relative min-h-screen bg-[#5A2F20] pt-20 overflow-hidden">

    <!-- Large Background Wordmark - BACK LAYER -->
    <div class=" absolute inset-0 z-10 bg-center bg-no-repeat bg-[length:auto_75%] sm:bg-[length:auto_80%] lg:bg-[length:auto_90%] pointer-events-none" style="background-image: url('/images/crumbs-crown-bg.png');">
       
    </div>
    <!-- ===== LEFT CONTENT ===== -->
    <div class="space-y-8 z-30 translate-y-12 px-14  text-center lg:text-left">
        <!-- Description -->
        <p class="text-white text-base sm:text-lg  max-w-md mx-auto lg:mx-0 font-sans text-[13px] font-semibold text-white uppercase">
            CRAFTED TO DELIGHT
        </p>
    </div>

    <!-- Hero Container -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen flex items-center">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full py-16 lg:py-20">
            
            <!-- ===== LEFT CONTENT ===== -->
            <div class="space-y-8 z-30 translate-y-42 text-center lg:text-left">

                <!-- Description -->
                <div class="space-y-1">
                    <p class="w-50 font-semibold text-white text-[16px] sm:text-lg leading-relaxed">
                        Premium taste. Beautifully presented. Built to scale.
                    </p>
                    <p class="w-80 text-white/70 text-[16px] sm:text-lg">
                        Indulge in our handcrafted cakes, pastries and luxury treats made for life's sweetest moments.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                    <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#3D2314] font-semibold rounded-full hover:bg-gold hover:text-[#3D2314] hover:shadow-gold transition-all duration-300 group">
                        Shop Now
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

            </div>

            <!-- ===== RIGHT CONTENT ===== -->
            <div class="relative z-30 flex justify-center lg:absolute lg:inset-0 lg:items-center pointer-events-none">

                <div class="relative pointer-events-auto w-full max-w-[500px] lg:max-w-none">

                    <!-- Glow Orbs -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-gold/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-10 -left-12 w-56 h-56 bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Cake Container with Custom Asset Image -->
                    <div class="relative flex items-center justify-center">

                        <!-- Cake Image with Custom Asset - FRONT LAYER -->
                        <div class="relative hover-scale cursor-pointer z-40">
                            <img src="{{ asset('images/hand-cake.png') }}"
                                alt="Hand holding cake"
                                class="w-[280px] sm:w-[350px] md:w-[420px] lg:w-[480px] h-auto object-contain drop-shadow-2xl shadow-primary" />

                            <!-- Shadow Under Image -->
                            <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 w-3/4 h-10 bg-black/40 rounded-full blur-xl pointer-events-none"></div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-4 sm:bottom-8 left-1/2 -translate-x-1/2 animation-bounce-slow text-white/30 z-30">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>

    <!-- Video Thumbnail (Bottom Right - Desktop Only) -->
    <div class="absolute bottom-4 sm:bottom-8 right-4 sm:right-8 hidden xl:block z-30">
        <div class="relative group cursor-pointer">
            <div class="w-44 sm:w-48 h-28 sm:h-32 bg-[#5C3A2E]/50 rounded-2xl overflow-hidden border border-white/10 hover:border-white/20 transition-all">
                <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=400&h=300&fit=crop&crop=center"
                     alt="Baking Process"
                     class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-opacity" />
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/90 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#3D2314] ml-0.5 sm:ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </div>
                </div>
            </div>
            <p class="text-white/50 text-xs text-center mt-1.5 tracking-wide">Watch Our Process</p>
        </div>
    </div>

</section>