@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary-700 to-primary-900 text-white">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Services</h1>
                <p class="text-xl mb-0">Professional roadside assistance services available 24/7 across India</p>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Comprehensive Roadside Assistance</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        We offer a wide range of services to keep you moving, no matter what roadside emergency you face
                    </p>
                </div>
                
                <div class="grid grid-cols-1 gap-16">
                    <!-- Towing Service -->
                    <div id="towing" class="scroll-mt-24">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div class="order-2 md:order-1">
                                <h3 class="text-2xl font-bold mb-4">Towing Service</h3>
                                <p class="text-gray-600 mb-4">
                                    When your vehicle cannot be repaired on the spot, our towing service ensures it's safely transported to the nearest service center or your preferred location within the coverage limit.
                                </p>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Available 24/7 across India</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Professional equipment for safe towing</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Trained operators to handle all vehicle types</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Coverage varies by plan (50km to unlimited)</span>
                                    </li>
                                </ul>
                                <a href="{{ route('request-service.store') }}" class="btn-primary">
                                    Request This Service
                                </a>
                            </div>
                            <div class="order-1 md:order-2">
                                <img src="{{ asset('images/services/towing.jpg') }}" alt="Towing Service" class="rounded-lg shadow-lg w-full h-auto">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Battery Jumpstart -->
                    <div id="battery-jumpstart" class="scroll-mt-24">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div>
                                <img src="{{ asset('images/services/battery-jumpstart.jpg') }}" alt="Battery Jumpstart" class="rounded-lg shadow-lg w-full h-auto">
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold mb-4">Battery Jumpstart</h3>
                                <p class="text-gray-600 mb-4">
                                    A dead battery can leave you stranded anywhere. Our technicians will jumpstart your vehicle's battery to get you back on the road quickly. If the battery needs replacement, we can assist with that too.
                                </p>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Quick response time</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Professional equipment for safe jumpstarting</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Battery health check included</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Available for all vehicle types</span>
                                    </li>
                                </ul>
                                <a href="{{ route('request-service.store') }}" class="btn-primary">
                                    Request This Service
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fuel Assistance -->
                    <div id="fuel-assistance" class="scroll-mt-24">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div class="order-2 md:order-1">
                                <h3 class="text-2xl font-bold mb-4">Fuel Assistance</h3>
                                <p class="text-gray-600 mb-4">
                                    Run out of fuel? Don't worry. We'll deliver enough fuel to get you to the nearest gas station. Our service includes both petrol and diesel delivery to your location.
                                </p>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Emergency fuel delivery (up to 5 liters)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Both petrol and diesel available</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Wrong fuel extraction service (Gold & Elite plans)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Quick delivery to your location</span>
                                    </li>
                                </ul>
                                <a href="{{ route('request-service.store') }}" class="btn-primary">
                                    Request This Service
                                </a>
                            </div>
                            <div class="order-1 md:order-2">
                                <img src="{{ asset('images/services/fuel-delivery.jpg') }}" alt="Fuel Assistance" class="rounded-lg shadow-lg w-full h-auto">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Flat Tyre Assistance -->
                    <div id="flat-tyre" class="scroll-mt-24">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div>
                                <img src="{{ asset('images/services/flat-tyre.jpg') }}" alt="Flat Tyre Assistance" class="rounded-lg shadow-lg w-full h-auto">
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold mb-4">Flat Tyre Assistance</h3>
                                <p class="text-gray-600 mb-4">
                                    A flat tyre can happen anytime. Our technicians will replace your flat tyre with your spare or repair it if possible. If the tyre is beyond repair, we can arrange for a new tyre at additional cost.
                                </p>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Tyre replacement with your spare</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Puncture repair when possible</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Proper tyre pressure check</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Available for all vehicle types</span>
                                    </li>
                                </ul>
                                <a href="{{ route('request-service.store') }}" class="btn-primary">
                                    Request This Service
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Key Lockout -->
                    <div id="key-lockout" class="scroll-mt-24">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div class="order-2 md:order-1">
                                <h3 class="text-2xl font-bold mb-4">Key Lockout Assistance</h3>
                                <p class="text-gray-600 mb-4">
                                    Locked your keys inside your vehicle? Our technicians use specialized tools to safely unlock your vehicle without causing any damage. Available for Gold and Elite plan members.
                                </p>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Non-destructive entry methods</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Specialized tools and techniques</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Trained technicians for all vehicle models</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Available for Gold and Elite plans</span>
                                    </li>
                                </ul>
                                <a href="{{ route('request-service.store') }}" class="btn-primary">
                                    Request This Service
                                </a>
                            </div>
                            <div class="order-1 md:order-2">
                                <img src="{{ asset('images/services/key-lockout.jpg') }}" alt="Key Lockout Assistance" class="rounded-lg shadow-lg w-full h-auto">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Taxi Services -->
                    <div id="taxi-services" class="scroll-mt-24">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div>
                                <img src="{{ asset('images/services/taxi.jpg') }}" alt="Taxi Services" class="rounded-lg shadow-lg w-full h-auto">
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold mb-4">Taxi Services</h3>
                                <p class="text-gray-600 mb-4">
                                    If your vehicle needs to be towed to a service center, we can arrange a taxi to take you to your destination. The coverage varies by plan, with Elite plan members enjoying up to 50km of free taxi service.
                                </p>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Arrangement of taxi services</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Coverage varies by plan</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Elite plan: Up to 50km free</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Available when vehicle is being towed</span>
                                    </li>
                                </ul>
                                <a href="{{ route('request-service.store') }}" class="btn-primary">
                                    Request This Service
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Services Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Additional Services</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Beyond our core roadside assistance services, we offer these additional benefits to our members
                    </p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Service 1 -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mb-4">
                            <i class="fas fa-map-marked-alt text-2xl text-primary-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Route Guidance</h3>
                        <p class="text-gray-600">
                            Lost your way? Our team can provide directions and route guidance to help you reach your destination safely.
                        </p>
                    </div>
                    
                    <!-- Service 2 -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mb-4">
                            <i class="fas fa-first-aid text-2xl text-primary-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Medical Coordination</h3>
                        <p class="text-gray-600">
                            In case of a medical emergency, we can coordinate with nearby hospitals and arrange for medical assistance.
                        </p>
                    </div>
                    
                    <!-- Service 3 -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mb-4">
                            <i class="fas fa-comment-dots text-2xl text-primary-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Message Relay</h3>
                        <p class="text-gray-600">
                            Need to inform someone about your situation? We can relay urgent messages to your family or friends.
                        </p>
                    </div>
                    
                    <!-- Service 4 -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mb-4">
                            <i class="fas fa-tools text-2xl text-primary-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Minor Repairs</h3>
                        <p class="text-gray-600">
                            Our technicians can perform minor on-site repairs to get your vehicle running again without the need for towing.
                        </p>
                    </div>
                    
                    <!-- Service 5 -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mb-4">
                            <i class="fas fa-hotel text-2xl text-primary-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Hotel Accommodation</h3>
                        <p class="text-gray-600">
                            Elite plan members can enjoy one night of hotel accommodation if their vehicle breaks down far from home.
                        </p>
                    </div>
                    
                    <!-- Service 6 -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mb-4">
                            <i class="fas fa-phone-alt text-2xl text-primary-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">24/7 Phone Support</h3>
                        <p class="text-gray-600">
                            Our customer service team is available round the clock to provide assistance and answer your queries.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary-800 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Get Started?</h2>
                <p class="text-xl mb-8">Choose a plan that suits your needs or contact us for more information</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('plans.index') }}" class="btn-white">
                        <i class="fas fa-tags mr-2"></i> View Our Plans
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '+919415666567')) }}" class="btn-outline-white">
                        <i class="fas fa-phone-alt mr-2"></i> Call Now
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
