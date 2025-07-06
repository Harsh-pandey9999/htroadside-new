@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6" data-aos="fade-up">Our Roadside Assistance Services</h1>
                <p class="text-xl text-primary-100 mb-8" data-aos="fade-up" data-aos-delay="100">
                    We offer a comprehensive range of roadside assistance services to keep you moving. Our professional technicians are available 24/7 to help you get back on the road quickly and safely.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('request-service') }}" class="btn btn-secondary">
                        <i class="fas fa-wrench mr-2"></i> Request Service
                    </a>
                    <a href="{{ route('plans.index') }}" class="btn btn-white">
                        View Membership Plans
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="relative h-16 mt-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="absolute bottom-0 text-white fill-current">
                <path d="M0,96L60,80C120,64,240,32,360,21.3C480,11,600,21,720,42.7C840,64,960,96,1080,96C1200,96,1320,64,1380,48L1440,32L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
            </svg>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
                <!-- Towing Service -->
                <div class="flex flex-col h-full" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-gray-100 rounded-t-xl p-6">
                        <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                            <img src="{{ asset('images/wbg/car-with-map.png') }}" alt="Towing Service" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Towing Service</h3>
                        <p class="text-gray-600 mb-4">
                            When your vehicle can't be fixed on the spot, we'll tow it to the nearest repair facility or your preferred location within our service radius.
                        </p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-b-xl p-6 flex-grow">
                        <h4 class="font-semibold text-gray-900 mb-3">What's Included:</h4>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Local towing to nearest repair facility</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Flatbed towing for all-wheel drive vehicles</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Winching service (if needed)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Motorcycle towing (Premium plan)</span>
                            </li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('services.show', 'towing') }}" class="btn btn-primary w-full">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Jump Start -->
                <div class="flex flex-col h-full" data-aos="fade-up" data-aos-delay="150">
                    <div class="bg-gray-100 rounded-t-xl p-6">
                        <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                            <img src="{{ asset('images/wbg/battery-jumpstart.png') }}" alt="Jump Start" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Jump Start</h3>
                        <p class="text-gray-600 mb-4">
                            If your battery is dead, our technicians will jump-start your vehicle to get you back on the road quickly. We'll also check your charging system.
                        </p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-b-xl p-6 flex-grow">
                        <h4 class="font-semibold text-gray-900 mb-3">What's Included:</h4>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Battery jump start service</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Battery terminal cleaning</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Charging system check</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Battery replacement advice</span>
                            </li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('services.show', 'jump-start') }}" class="btn btn-primary w-full">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Flat Tire -->
                <div class="flex flex-col h-full" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-gray-100 rounded-t-xl p-6">
                        <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                            <img src="{{ asset('images/wbg/flat-tyre-change.png') }}" alt="Flat Tire Service" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Flat Tire Service</h3>
                        <p class="text-gray-600 mb-4">
                            Got a flat? We'll replace it with your spare or patch it if possible to get you rolling again. No spare? We can tow you to a repair facility.
                        </p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-b-xl p-6 flex-grow">
                        <h4 class="font-semibold text-gray-900 mb-3">What's Included:</h4>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Spare tire installation</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Tire patch (when possible)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Tire pressure check</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Lug nut tightening</span>
                            </li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('services.show', 'flat-tire') }}" class="btn btn-primary w-full">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Fuel Delivery -->
                <div class="flex flex-col h-full" data-aos="fade-up" data-aos-delay="250">
                    <div class="bg-gray-100 rounded-t-xl p-6">
                        <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                            <img src="{{ asset('images/wbg/e-wallet-concept-illustration.png') }}" alt="Fuel Delivery" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Fuel Delivery</h3>
                        <p class="text-gray-600 mb-4">
                            Run out of gas? We'll deliver fuel to your location so you can reach the nearest gas station. Members receive complimentary fuel.
                        </p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-b-xl p-6 flex-grow">
                        <h4 class="font-semibold text-gray-900 mb-3">What's Included:</h4>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Emergency fuel delivery</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Gasoline or diesel fuel</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Free fuel for members (up to 3 gallons)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Fuel system inspection</span>
                            </li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('services.show', 'fuel-delivery') }}" class="btn btn-primary w-full">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Lockout Service -->
                <div class="flex flex-col h-full" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-gray-100 rounded-t-xl p-6">
                        <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                            <img src="{{ asset('images/wbg/key-lockout-1.png') }}" alt="Lockout Service" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Lockout Service</h3>
                        <p class="text-gray-600 mb-4">
                            Locked your keys in your car? Our specialists can help you regain access to your vehicle quickly and without damage.
                        </p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-b-xl p-6 flex-grow">
                        <h4 class="font-semibold text-gray-900 mb-3">What's Included:</h4>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Vehicle lockout assistance</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Non-destructive entry methods</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Trunk unlocking</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Broken key extraction</span>
                            </li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('services.show', 'lockout') }}" class="btn btn-primary w-full">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Battery Replacement -->
                <div class="flex flex-col h-full" data-aos="fade-up" data-aos-delay="350">
                    <div class="bg-gray-100 rounded-t-xl p-6">
                        <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                            <img src="{{ asset('images/wbg/battery-jumpstart.png') }}" alt="Battery Replacement" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Battery Replacement</h3>
                        <p class="text-gray-600 mb-4">
                            We can test your battery and replace it on the spot if needed with a new, high-quality battery. Members receive discounted pricing.
                        </p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-b-xl p-6 flex-grow">
                        <h4 class="font-semibold text-gray-900 mb-3">What's Included:</h4>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Battery diagnostic testing</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>On-site battery replacement</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Quality batteries with warranty</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Proper disposal of old battery</span>
                            </li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('services.show', 'battery-replacement') }}" class="btn btn-primary w-full">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Additional Services -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="section-title" data-aos="fade-up">Additional Services</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Beyond our core roadside assistance services, we offer these specialized solutions for our members.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Winching -->
                <div class="card p-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                        <img src="{{ asset('images/wbg/car-crash.png') }}" alt="Winching Service" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Winching Service</h3>
                    <p class="text-gray-600 mb-4">
                        If your vehicle is stuck in mud, snow, or a ditch, our winching service can pull it back onto the road safely.
                    </p>
                    <a href="{{ route('services.show', 'winching') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                        Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                </div>
                
                <!-- Trip Interruption -->
                <div class="card p-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                        <img src="{{ asset('images/wbg/customer-with-mechanic.png') }}" alt="Trip Interruption" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Trip Interruption</h3>
                    <p class="text-gray-600 mb-4">
                        If your vehicle breaks down far from home, we provide reimbursement for lodging, meals, and alternative transportation.
                    </p>
                    <a href="{{ route('services.show', 'trip-interruption') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                        Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                </div>
                
                <!-- Rental Car Assistance -->
                <div class="card p-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 overflow-hidden">
                        <img src="{{ asset('images/wbg/changing-flat-tyre.png') }}" alt="Rental Car Assistance" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Rental Car Assistance</h3>
                    <p class="text-gray-600 mb-4">
                        Premium members receive rental car reimbursement if their vehicle requires extensive repairs after a breakdown.
                    </p>
                    <a href="{{ route('services.show', 'rental-car') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                        Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Emergency Service CTA -->
    <section class="py-16 bg-red-600 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0">
                    <h2 class="text-3xl font-bold mb-2">Need Emergency Assistance?</h2>
                    <p class="text-xl text-red-100">We're available 24/7 to help you get back on the road.</p>
                </div>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '18001234567')) }}" class="btn bg-white text-red-600 hover:bg-red-100 focus:ring-white shadow-lg hover:shadow-xl text-lg px-8">
                    <i class="fas fa-phone-alt mr-2"></i> Call Now
                </a>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="section-title" data-aos="fade-up">Frequently Asked Questions</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Find answers to common questions about our services.
                </p>
            </div>
            
            <div class="max-w-3xl mx-auto" x-data="{selected:null}">
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="150">
                        <button 
                            @click="selected !== 1 ? selected = 1 : selected = null"
                            class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50"
                        >
                            <span class="text-lg font-medium text-gray-900">How much does roadside assistance cost?</span>
                            <i class="fas" :class="selected == 1 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        <div x-show="selected == 1" x-transition class="p-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-gray-600">
                                Our roadside assistance costs vary based on whether you're a member or non-member. For non-members, service calls start at $75 for basic services like jump starts and lockouts, with additional costs for towing based on distance. Members receive services at discounted rates or included in their membership, depending on their plan level. View our membership plans for detailed pricing information.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Question 2 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                        <button 
                            @click="selected !== 2 ? selected = 2 : selected = null"
                            class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50"
                        >
                            <span class="text-lg font-medium text-gray-900">What if my vehicle needs more than roadside assistance?</span>
                            <i class="fas" :class="selected == 2 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        <div x-show="selected == 2" x-transition class="p-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-gray-600">
                                If your vehicle requires repairs beyond what we can provide at the roadside, we'll tow your vehicle to the nearest qualified repair facility or your preferred mechanic (within your plan's towing range). Premium members also receive rental car reimbursement and trip interruption benefits if their vehicle requires extensive repairs while away from home.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Question 3 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="250">
                        <button 
                            @click="selected !== 3 ? selected = 3 : selected = null"
                            class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50"
                        >
                            <span class="text-lg font-medium text-gray-900">Are there any services not covered by membership?</span>
                            <i class="fas" :class="selected == 3 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        <div x-show="selected == 3" x-transition class="p-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-gray-600">
                                While our memberships cover most roadside emergencies, certain services may incur additional charges. These include excessive towing beyond your plan's mileage limit, service for vehicles used for commercial purposes (unless you have a commercial plan), and recovery operations requiring specialized equipment. Additionally, the cost of parts like batteries and fuel (for non-members) are not included in the service call fee.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('faq') }}" class="btn btn-primary">
                        View All FAQs
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Membership CTA -->
    <section class="py-20 bg-gradient-to-r from-primary-800 to-primary-600 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6" data-aos="fade-up">Ready to Join? Get Protected Today!</h2>
                <p class="text-xl text-primary-100 mb-8" data-aos="fade-up" data-aos-delay="100">
                    Sign up for a membership plan and enjoy peace of mind knowing you're covered 24/7, 365 days a year.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('plans.index') }}" class="btn btn-white">
                        View Plans
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">
                        <i class="fas fa-user-plus mr-2"></i> Sign Up Now
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
