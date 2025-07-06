<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title" data-aos="fade-up">Our Roadside Assistance Services</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                We offer a comprehensive range of roadside assistance services to keep you moving.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Towing Service -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="150">
                <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                    <img src="{{ asset('images/wbg/customer-with-mechanic.png') }}" alt="Towing Service" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Towing Service</h3>
                <p class="text-gray-600 mb-4">
                    We'll tow your vehicle to the nearest repair facility or your preferred location within our service radius.
                </p>
                <a href="{{ route('services.show', 'towing') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                    Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
            
            <!-- Jump Start -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                    <img src="{{ asset('images/wbg/battery-jumpstart.png') }}" alt="Jump Start" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Jump Start</h3>
                <p class="text-gray-600 mb-4">
                    Battery died? Our technicians will jump-start your vehicle to get you back on the road quickly.
                </p>
                <a href="{{ route('services.show', 'jump-start') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                    Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
            
            <!-- Flat Tire -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="250">
                <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                    <img src="{{ asset('images/wbg/flat-tire-change.png') }}" alt="Flat Tire Service" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Flat Tire Service</h3>
                <p class="text-gray-600 mb-4">
                    Got a flat? We'll replace it with your spare or patch it if possible to get you rolling again.
                </p>
                <a href="{{ route('services.show', 'flat-tire') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                    Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
            
            <!-- Fuel Delivery -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                    <img src="{{ asset('images/wbg/fuel-delivery.png') }}" alt="Fuel Delivery" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Fuel Delivery</h3>
                <p class="text-gray-600 mb-4">
                    Run out of gas? We'll deliver fuel to your location so you can reach the nearest gas station.
                </p>
                <a href="{{ route('services.show', 'fuel-delivery') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                    Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
            
            <!-- Lockout Service -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="350">
                <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                    <img src="{{ asset('images/wbg/lockout-service.png') }}" alt="Lockout Service" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Lockout Service</h3>
                <p class="text-gray-600 mb-4">
                    Locked your keys in your car? Our specialists can help you regain access to your vehicle.
                </p>
                <a href="{{ route('services.show', 'lockout') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                    Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
            
            <!-- Battery Replacement -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="400">
                <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                    <img src="{{ asset('images/wbg/battery-replacement.png') }}" alt="Battery Replacement" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Battery Replacement</h3>
                <p class="text-gray-600 mb-4">
                    We can test your battery and replace it on the spot if needed with a new, high-quality battery.
                </p>
                <a href="{{ route('services.show', 'battery-replacement') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                    Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
        </div>
        
        <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="450">
            <a href="{{ route('services.index') }}" class="btn btn-primary">
                View All Services
            </a>
        </div>
    </div>
</section>
