@extends('layouts.app')

@section('title', 'Our Plans')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary-700 to-primary-900 text-white">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Plans</h1>
                <p class="text-xl mb-0">Our plans are well-thought-out and meticulously crafted to ensure success in achieving our goals.</p>
            </div>
        </div>
    </section>

    <!-- Plans Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Choose the Perfect Plan for Your Vehicle</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        We offer comprehensive roadside assistance plans designed to meet your specific needs
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Silver Plan -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 transition-transform hover:transform hover:scale-105">
                        <div class="bg-gray-100 p-6 text-center">
                            <h3 class="text-2xl font-bold mb-1">Silver</h3>
                            <p class="text-gray-600 mb-4">2-Wheeler, 0-6 Yrs</p>
                            <div class="text-4xl font-bold text-primary-600 mb-1">₹599</div>
                            <p class="text-sm text-gray-500">including GST</p>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>1 Year Coverage</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>On-site Minor Repair (3 Incidents)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Free Towing up to 50km (1/yr)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Pan India Coverage</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Flat Tyre Assistance (1/yr)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Fuel Delivery (Actuals, Up to 3L/yr)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Assistance Over Phone</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>City Map/Route Guidance</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Taxi Benefit (On Actuals)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Medical Coordination</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Urgent Message Relay</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Brake Adjustment (3/yr)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Headlight Bulbs (On Actuals)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Clutch Pedal Play Setting</span>
                                </li>
                            </ul>
                        </div>
                        <div class="p-6 border-t border-gray-200 bg-gray-50">
                            <a href="{{ route('plans.show', 1) }}" class="btn-primary w-full text-center">Buy Now</a>
                        </div>
                    </div>
                    
                    <!-- Gold Plan -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 transform scale-105 z-10">
                        <div class="bg-yellow-50 p-6 text-center relative">
                            <div class="absolute top-0 right-0 bg-yellow-500 text-white px-4 py-1 rounded-bl-lg font-medium text-sm">Popular</div>
                            <h3 class="text-2xl font-bold mb-1">Gold</h3>
                            <p class="text-gray-600 mb-4">4-Wheeler, 0-6 Yrs</p>
                            <div class="text-4xl font-bold text-primary-600 mb-1">₹2499</div>
                            <p class="text-sm text-gray-500">including GST</p>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>1 Year Coverage</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>On-site Minor Repair (3 Incidents)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Free Towing up to 100km (2/yr)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Pan India Coverage</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Battery Jumpstart (3 Incidents)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Flat Tyre Assistance (5/yr)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Free Fuel Up to 5L/yr</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Wrong Fueling Assistance</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Assistance Over Phone</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>City Map/Route Guidance</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Taxi Benefit (On Actuals)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Medical Coordination</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Urgent Message Relay</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Headlight Bulbs (On Actuals)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Wiper Blade Replacement (On Actuals)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Locked/Lost Key Support</span>
                                </li>
                            </ul>
                        </div>
                        <div class="p-6 border-t border-gray-200 bg-gray-50">
                            <a href="{{ route('plans.show', 2) }}" class="btn-primary w-full text-center">Buy Now</a>
                        </div>
                    </div>
                    
                    <!-- Elite Plan -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 transition-transform hover:transform hover:scale-105">
                        <div class="bg-gray-100 p-6 text-center">
                            <h3 class="text-2xl font-bold mb-1">Elite</h3>
                            <p class="text-gray-600 mb-4">4-Wheeler, 0-5 Yrs</p>
                            <div class="text-4xl font-bold text-primary-600 mb-1">₹3249</div>
                            <p class="text-sm text-gray-500">including GST</p>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>1 Year Coverage</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>On-site Minor Repair (5 Incidents)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Unlimited Towing (2/yr)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Pan India Coverage</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Battery Jumpstart (7 Incidents)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Flat Tyre Assistance (7/yr)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Free Fuel Up to 5L/yr</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Wrong Fueling Assistance</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Assistance Over Phone</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>City Map/Route Guidance</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Taxi Benefit (Up to 50km)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Medical Coordination</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Urgent Message Relay</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Headlight Bulbs (On Actuals)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Wiper Blade Replacement (On Actuals)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Locked/Lost Key Support</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <span>Hotel Accommodation (Max 1 night/yr)</span>
                                </li>
                            </ul>
                        </div>
                        <div class="p-6 border-t border-gray-200 bg-gray-50">
                            <a href="{{ route('plans.show', 3) }}" class="btn-primary w-full text-center">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Frequently Asked Questions</h2>
                    <p class="text-lg text-gray-600">
                        Find answers to common questions about our roadside assistance plans
                    </p>
                </div>
                
                <div class="space-y-4" x-data="{ activeTab: 0 }">
                    <!-- Question 1 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 1 ? 0 : 1" 
                            class="flex justify-between items-center w-full p-4 text-left bg-white hover:bg-gray-50 transition-colors"
                        >
                            <span class="font-medium">How do I request roadside assistance?</span>
                            <i class="fas" :class="activeTab === 1 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="activeTab === 1" class="p-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-gray-600">
                                You can request roadside assistance by calling our 24/7 helpline at {{ settings('contact_phone', '+91 9415666567') }}. Our customer service representative will collect your details, location, and the nature of your emergency, and dispatch the nearest service provider to your location.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Question 2 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 2 ? 0 : 2" 
                            class="flex justify-between items-center w-full p-4 text-left bg-white hover:bg-gray-50 transition-colors"
                        >
                            <span class="font-medium">What is the coverage area for your services?</span>
                            <i class="fas" :class="activeTab === 2 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="activeTab === 2" class="p-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-gray-600">
                                We provide pan-India coverage with our network of 3000+ service partners across 700+ cities. Whether you're in a major city or on a highway, we strive to provide assistance wherever you are.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Question 3 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 3 ? 0 : 3" 
                            class="flex justify-between items-center w-full p-4 text-left bg-white hover:bg-gray-50 transition-colors"
                        >
                            <span class="font-medium">How quickly can I expect help to arrive?</span>
                            <i class="fas" :class="activeTab === 3 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="activeTab === 3" class="p-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-gray-600">
                                Our average response time is 30-45 minutes in urban areas and 45-60 minutes in rural areas. However, actual response times may vary based on your location, traffic conditions, and weather. We always strive to reach you as quickly as possible.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Question 4 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 4 ? 0 : 4" 
                            class="flex justify-between items-center w-full p-4 text-left bg-white hover:bg-gray-50 transition-colors"
                        >
                            <span class="font-medium">Can I purchase a plan after my vehicle breaks down?</span>
                            <i class="fas" :class="activeTab === 4 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="activeTab === 4" class="p-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-gray-600">
                                Our plans are designed for preventive coverage and cannot be purchased for immediate assistance during a breakdown. There is a 24-hour waiting period after purchase before the plan becomes active. However, you can still request our services on a pay-per-use basis during an emergency.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Question 5 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 5 ? 0 : 5" 
                            class="flex justify-between items-center w-full p-4 text-left bg-white hover:bg-gray-50 transition-colors"
                        >
                            <span class="font-medium">Are there any services not covered by the plans?</span>
                            <i class="fas" :class="activeTab === 5 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="activeTab === 5" class="p-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-gray-600">
                                Our plans do not cover major repairs, replacement parts (except those specifically mentioned), damages due to accidents, natural disasters, or illegal activities. Regular maintenance services are also not included. Please refer to the terms and conditions for a complete list of exclusions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary-800 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Need More Information?</h2>
                <p class="text-xl mb-8">Our team is ready to answer any questions you may have about our plans</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('contact') }}" class="btn-white">
                        <i class="fas fa-envelope mr-2"></i> Contact Us
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '+919415666567')) }}" class="btn-outline-white">
                        <i class="fas fa-phone-alt mr-2"></i> Call Now
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
