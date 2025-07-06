@extends('layouts.app')

@section('title', $service->name . ' - HT Roadside Assistance')
@section('meta_description', $service->short_description)

@section('content')
<div class="bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-primary-700 text-white">
        <div class="container mx-auto px-4 py-16 md:py-24">
            <div class="max-w-3xl">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">{{ $service->name }}</h1>
                <p class="text-xl md:text-2xl opacity-90">{{ $service->short_description }}</p>
            </div>
        </div>
        <div class="absolute bottom-0 right-0 w-1/3 h-full hidden lg:block">
            @if($service->image)
                <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-primary-800 flex items-center justify-center">
                    <i class="fas {{ $service->icon ?? 'fa-car' }} text-6xl text-white opacity-30"></i>
                </div>
            @endif
        </div>
    </div>

    <!-- Service Details -->
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Main Content -->
            <div class="w-full md:w-2/3">
                <div class="bg-white rounded-lg shadow-sm p-6 md:p-8">
                    <!-- Service Description -->
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br(e($service->description)) !!}
                    </div>

                    <!-- Features -->
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold mb-6">What's Included</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-primary-100 rounded-full p-3">
                                    <i class="fas fa-check text-primary-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium">24/7 Availability</h3>
                                    <p class="text-gray-600">We're available around the clock for emergencies</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-primary-100 rounded-full p-3">
                                    <i class="fas fa-check text-primary-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium">Fast Response Time</h3>
                                    <p class="text-gray-600">Average arrival time of 30 minutes or less</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-primary-100 rounded-full p-3">
                                    <i class="fas fa-check text-primary-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium">Certified Technicians</h3>
                                    <p class="text-gray-600">Experienced professionals to handle your needs</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-primary-100 rounded-full p-3">
                                    <i class="fas fa-check text-primary-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium">Transparent Pricing</h3>
                                    <p class="text-gray-600">No hidden fees or surprise charges</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQs -->
                <div class="mt-8 bg-white rounded-lg shadow-sm p-6 md:p-8">
                    <h2 class="text-2xl font-bold mb-6">Frequently Asked Questions</h2>
                    <div class="space-y-6">
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="flex justify-between items-center w-full text-left font-medium text-lg">
                                <span>How quickly can I expect service?</span>
                                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                            <div x-show="open" class="mt-2 text-gray-600">
                                Our average response time is 30 minutes or less, depending on your location and current demand. In emergency situations, we prioritize calls to ensure the fastest possible service.
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-6" x-data="{ open: false }">
                            <button @click="open = !open" class="flex justify-between items-center w-full text-left font-medium text-lg">
                                <span>Is this service covered by my insurance?</span>
                                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                            <div x-show="open" class="mt-2 text-gray-600">
                                Many insurance policies include roadside assistance coverage. We recommend checking with your insurance provider to confirm what's covered. We work with most major insurance companies and can help you navigate the claims process.
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-6" x-data="{ open: false }">
                            <button @click="open = !open" class="flex justify-between items-center w-full text-left font-medium text-lg">
                                <span>What areas do you service?</span>
                                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                            <div x-show="open" class="mt-2 text-gray-600">
                                We provide service throughout the greater metropolitan area and surrounding suburbs. Our coverage area extends approximately 50 miles from the city center. For locations outside this area, please contact us to confirm availability.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full md:w-1/3">
                <!-- Request Service Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-4">Request This Service</h3>
                    <p class="text-gray-600 mb-6">Need help right away? Fill out this form and we'll dispatch a technician to your location.</p>
                    
                    <form action="{{ route('request-service.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Your Location</label>
                            <input type="text" id="location" name="location" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Describe Your Issue</label>
                            <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full btn btn-primary py-3">Request Service Now</button>
                    </form>
                    
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">Or call us directly</p>
                        <a href="tel:1-800-555-0123" class="block mt-2 text-xl font-bold text-primary-600 hover:text-primary-700">1-800-555-0123</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Services -->
    <div class="bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-8 text-center">Other Services You Might Need</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- These would ideally be dynamically populated with other services -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="h-48 bg-gray-200">
                        <img src="{{ asset('images/services/towing.jpg') }}" alt="Towing Service" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Towing Service</h3>
                        <p class="text-gray-600 mb-4">Fast and reliable towing to your preferred destination.</p>
                        <a href="{{ route('services.show', 'towing-service') }}" class="text-primary-600 font-medium hover:text-primary-700">
                            Learn More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="h-48 bg-gray-200">
                        <img src="{{ asset('images/services/jump-start.jpg') }}" alt="Battery Jump Start" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Battery Jump Start</h3>
                        <p class="text-gray-600 mb-4">Get your vehicle started when your battery fails.</p>
                        <a href="{{ route('services.show', 'battery-jump-start') }}" class="text-primary-600 font-medium hover:text-primary-700">
                            Learn More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="h-48 bg-gray-200">
                        <img src="{{ asset('images/services/fuel-delivery.jpg') }}" alt="Fuel Delivery" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Fuel Delivery</h3>
                        <p class="text-gray-600 mb-4">Emergency fuel when you run out on the road.</p>
                        <a href="{{ route('services.show', 'fuel-delivery') }}" class="text-primary-600 font-medium hover:text-primary-700">
                            Learn More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="bg-primary-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl opacity-90 mb-8 max-w-2xl mx-auto">Join thousands of satisfied customers who trust us for their roadside assistance needs.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('plans.index') }}" class="btn btn-white py-3 px-8">View Our Plans</a>
                <a href="{{ route('contact') }}" class="btn btn-outline-white py-3 px-8">Contact Us</a>
            </div>
        </div>
    </div>
</div>

@if(session('warning'))
<div class="fixed bottom-4 right-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-md" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="ml-3">
            <p>{{ session('warning') }}</p>
        </div>
        <div class="ml-auto">
            <button @click="show = false" class="text-yellow-700 hover:text-yellow-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>
@endif
@endsection
