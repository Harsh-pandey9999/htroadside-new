<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title" data-aos="fade-up">How It Works</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                Getting roadside assistance is quick and easy. Here's how our service works.
            </p>
        </div>
        
        <div class="relative">
            <!-- Connection Line (Desktop) -->
            <div class="hidden lg:block absolute top-1/2 left-0 right-0 h-1 bg-primary-200 -translate-y-1/2 z-0"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="150">
                    <div class="bg-primary-600 text-white rounded-full w-16 h-16 flex items-center justify-center mb-6 shadow-lg overflow-hidden">
                        <img src="{{ asset('images/wbg/e-wallet-concept-illustration.png') }}" alt="Request Service" class="w-full h-full object-cover">
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md w-full">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Request Service</h3>
                        <p class="text-gray-600">
                            Call our hotline or use our mobile app to request immediate roadside assistance.
                        </p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-primary-600 text-white rounded-full w-16 h-16 flex items-center justify-center mb-6 shadow-lg overflow-hidden">
                        <img src="{{ asset('images/wbg/car-with-map.png') }}" alt="Share Location" class="w-full h-full object-cover">
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md w-full">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Share Location</h3>
                        <p class="text-gray-600">
                            Share your exact location or use GPS tracking through our app for precise service.
                        </p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="250">
                    <div class="bg-primary-600 text-white rounded-full w-16 h-16 flex items-center justify-center mb-6 shadow-lg overflow-hidden">
                        <img src="{{ asset('images/wbg/customer-with-mechanic.png') }}" alt="Technician Arrives" class="w-full h-full object-cover">
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md w-full">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Technician Arrives</h3>
                        <p class="text-gray-600">
                            Our professional technician arrives at your location with the right equipment.
                        </p>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-primary-600 text-white rounded-full w-16 h-16 flex items-center justify-center mb-6 shadow-lg overflow-hidden">
                        <img src="{{ asset('images/wbg/changing-flat-tyre.png') }}" alt="Problem Solved" class="w-full h-full object-cover">
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md w-full">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Problem Solved</h3>
                        <p class="text-gray-600">
                            We fix your issue on the spot or tow your vehicle to a preferred location.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="350">
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                Download our mobile app for faster service and real-time tracking of your technician.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="#" class="inline-flex items-center bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <i class="fab fa-apple text-2xl mr-3"></i>
                    <div class="text-left">
                        <div class="text-xs">Download on the</div>
                        <div class="text-sm font-semibold">App Store</div>
                    </div>
                </a>
                <a href="#" class="inline-flex items-center bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <i class="fab fa-google-play text-2xl mr-3"></i>
                    <div class="text-left">
                        <div class="text-xs">Get it on</div>
                        <div class="text-sm font-semibold">Google Play</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
