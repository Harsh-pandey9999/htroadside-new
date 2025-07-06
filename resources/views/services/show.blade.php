@extends('layouts.app')

@section('title', $service->name)

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">{{ $service->name }}</h1>
                    <p class="text-xl text-primary-100 mb-8">
                        {{ $service->short_description }}
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('request-service', ['service' => $service->slug]) }}" class="btn btn-secondary">
                            <i class="fas fa-wrench mr-2"></i> Request This Service
                        </a>
                        <a href="{{ route('plans.index') }}" class="btn btn-white">
                            View Membership Plans
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 md:pl-10" data-aos="fade-left">
                    <div class="relative">
                        <div class="absolute inset-0 bg-primary-500 rounded-lg transform rotate-3"></div>
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="relative rounded-lg shadow-2xl z-10">
                        
                        @if($service->emergency)
                            <!-- Emergency Badge -->
                            <div class="absolute -top-5 -right-5 bg-red-600 text-white rounded-full px-4 py-2 shadow-lg z-20 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="font-bold">Emergency Service</span>
                            </div>
                        @endif
                        
                        <!-- Price Badge -->
                        <div class="absolute -bottom-5 -left-5 bg-white text-primary-800 rounded-lg px-4 py-3 shadow-lg z-20">
                            <div class="flex items-center space-x-3">
                                <div class="flex flex-col items-center justify-center bg-primary-100 rounded-full w-10 h-10">
                                    <i class="fas fa-tag text-primary-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">From ${{ number_format($service->price, 2) }}</p>
                                    <p class="text-xs text-gray-600">Free for Premium Members</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
    
    <!-- Service Details -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Main Content -->
                <div class="lg:w-2/3" data-aos="fade-up">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">About This Service</h2>
                    
                    <div class="prose prose-lg max-w-none mb-10">
                        {!! $service->description !!}
                    </div>
                    
                    <!-- Features -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">What's Included</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        @foreach($service->features as $feature)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-primary-100 text-primary-600 rounded-full p-2 mr-4">
                                    <i class="fas fa-check text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $feature->title }}</h4>
                                    <p class="text-gray-600">{{ $feature->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- How It Works -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">How It Works</h3>
                    <div class="relative mb-10">
                        <!-- Connection Line -->
                        <div class="hidden md:block absolute top-14 left-12 bottom-14 w-1 bg-primary-200 z-0"></div>
                        
                        <div class="space-y-8 relative z-10">
                            <!-- Step 1 -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-primary-600 text-white rounded-full w-10 h-10 flex items-center justify-center mr-4 z-10">
                                    <span class="font-bold">1</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Request Service</h4>
                                    <p class="text-gray-600">Call our hotline or use our mobile app to request immediate assistance.</p>
                                </div>
                            </div>
                            
                            <!-- Step 2 -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-primary-600 text-white rounded-full w-10 h-10 flex items-center justify-center mr-4 z-10">
                                    <span class="font-bold">2</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Share Your Location</h4>
                                    <p class="text-gray-600">Provide your exact location or use GPS tracking through our app.</p>
                                </div>
                            </div>
                            
                            <!-- Step 3 -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-primary-600 text-white rounded-full w-10 h-10 flex items-center justify-center mr-4 z-10">
                                    <span class="font-bold">3</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Technician Arrives</h4>
                                    <p class="text-gray-600">Our professional technician arrives at your location with the right equipment.</p>
                                </div>
                            </div>
                            
                            <!-- Step 4 -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-primary-600 text-white rounded-full w-10 h-10 flex items-center justify-center mr-4 z-10">
                                    <span class="font-bold">4</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Service Completed</h4>
                                    <p class="text-gray-600">We complete the service and get you back on the road as quickly as possible.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQs -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h3>
                    <div class="space-y-4 mb-10" x-data="{selected:null}">
                        @foreach($service->faqs as $index => $faq)
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <button 
                                    @click="selected !== {{ $index }} ? selected = {{ $index }} : selected = null"
                                    class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50"
                                >
                                    <span class="text-lg font-medium text-gray-900">{{ $faq->question }}</span>
                                    <i class="fas" :class="selected == {{ $index }} ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                                </button>
                                <div x-show="selected == {{ $index }}" x-transition class="p-4 bg-gray-50 border-t border-gray-200">
                                    <p class="text-gray-600">
                                        {{ $faq->answer }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Testimonials -->
                    @if(count($service->testimonials) > 0)
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">What Our Customers Say</h3>
                        <div class="space-y-6 mb-10">
                            @foreach($service->testimonials as $testimonial)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                                    <div class="flex mb-4">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                    <blockquote class="text-gray-600 mb-6 italic">
                                        "{{ $testimonial->content }}"
                                    </blockquote>
                                    <div class="flex items-center">
                                        <img src="{{ asset('storage/' . $testimonial->user->profile_photo) }}" alt="{{ $testimonial->user->name }}" class="w-12 h-12 rounded-full mr-4">
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $testimonial->user->name }}</h4>
                                            <p class="text-gray-500 text-sm">{{ $testimonial->location }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Call to Action -->
                    <div class="bg-primary-50 border border-primary-100 rounded-lg p-8 text-center">
                        <h3 class="text-2xl font-bold text-primary-800 mb-4">Ready to Get Help?</h3>
                        <p class="text-gray-600 mb-6">
                            Request service now or sign up for a membership plan for priority service and exclusive benefits.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('request-service', ['service' => $service->slug]) }}" class="btn btn-primary">
                                <i class="fas fa-wrench mr-2"></i> Request Service
                            </a>
                            <a href="{{ route('plans.index') }}" class="btn btn-outline">
                                View Membership Plans
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:w-1/3" data-aos="fade-up" data-aos-delay="100">
                    <!-- Service Request Card -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden mb-8 sticky top-24">
                        <div class="bg-primary-600 text-white p-6">
                            <h3 class="text-xl font-bold mb-2">Request This Service</h3>
                            <p class="text-primary-100">
                                Get help now or schedule for later
                            </p>
                        </div>
                        <div class="p-6">
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-gray-700">Service Fee:</span>
                                    <span class="font-semibold text-gray-900">${{ number_format($service->price, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-gray-700">Estimated Time:</span>
                                    <span class="font-semibold text-gray-900">{{ $service->estimated_time }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Availability:</span>
                                    <span class="font-semibold text-green-600">24/7</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('request-service', ['service' => $service->slug]) }}" class="btn btn-primary w-full mb-4">
                                Request Now
                            </a>
                            
                            <div class="text-center text-sm text-gray-500 mb-6">
                                or call us directly at
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '18001234567')) }}" class="text-primary-600 font-semibold">
                                    {{ settings('contact_phone', '1-800-123-4567') }}
                                </a>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="font-semibold text-gray-900 mb-4">Member Benefits:</h4>
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span class="text-gray-600">Priority dispatch</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span class="text-gray-600">Discounted or free service</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span class="text-gray-600">No upfront payment</span>
                                    </li>
                                </ul>
                                <div class="mt-6">
                                    <a href="{{ route('plans.index') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                                        View Membership Plans <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Services -->
                    @if(count($relatedServices) > 0)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden mb-8">
                            <div class="bg-gray-100 p-6 border-b border-gray-200">
                                <h3 class="text-xl font-bold text-gray-900">Related Services</h3>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-4">
                                    @foreach($relatedServices as $relatedService)
                                        <li>
                                            <a href="{{ route('services.show', $relatedService->slug) }}" class="flex items-start hover:bg-gray-50 p-2 rounded-lg transition-colors">
                                                <div class="bg-primary-100 text-primary-600 rounded-full w-10 h-10 flex items-center justify-center mr-3 flex-shrink-0">
                                                    <i class="fas fa-{{ $relatedService->icon }} text-sm"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">{{ $relatedService->name }}</h4>
                                                    <p class="text-sm text-gray-600">{{ Str::limit($relatedService->short_description, 60) }}</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Emergency Contact -->
                    <div class="bg-red-600 text-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-white text-red-600 rounded-full w-12 h-12 flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">Emergency Contact</h3>
                            </div>
                            <p class="text-red-100 mb-6">
                                If you're in an unsafe situation or immediate danger, please call emergency services first.
                            </p>
                            <div class="flex space-x-4">
                                <a href="tel:911" class="flex-1 bg-white text-red-600 hover:bg-red-50 py-3 px-4 rounded-lg font-semibold text-center">
                                    Call 911
                                </a>
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '18001234567')) }}" class="flex-1 bg-red-700 hover:bg-red-800 text-white py-3 px-4 rounded-lg font-semibold text-center">
                                    Call Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Other Services -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="section-title" data-aos="fade-up">Explore Our Other Services</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Discover our full range of roadside assistance services to keep you moving.
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($otherServices as $otherService)
                    <div class="card p-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="bg-primary-100 text-primary-600 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                            <i class="fas fa-{{ $otherService->icon }} text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $otherService->name }}</h3>
                        <p class="text-gray-600 mb-4">
                            {{ Str::limit($otherService->short_description, 120) }}
                        </p>
                        <a href="{{ route('services.show', $otherService->slug) }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                            Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('services.index') }}" class="btn btn-primary">
                    View All Services
                </a>
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
