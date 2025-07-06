@extends('layouts.app')

@section('title', 'Work With Us')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary-700 to-primary-900 text-white">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Partner with HT Roadside</h1>
                <p class="text-xl mb-0">Join our network of 3000+ service partners across India</p>
            </div>
        </div>
    </section>

    <!-- Partnership Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-6">Why Partner With Us?</h2>
                        <p class="text-gray-600 mb-6">
                            HT Roadside Assistance is continuously expanding its network of service partners across India. By joining our network, you become part of a trusted brand that connects you with customers in need of roadside assistance services.
                        </p>
                        <p class="text-gray-600 mb-6">
                            Whether you're an individual mechanic, tow truck operator, or a service center, we offer customizable solutions to help you grow your business while providing essential services to motorists in need.
                        </p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-money-bill-wave text-xl text-primary-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-1">Quick Payments</h3>
                                    <p class="text-gray-600">
                                        Receive timely payments for your services with our streamlined payment system.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-chart-line text-xl text-primary-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-1">Increased Volume</h3>
                                    <p class="text-gray-600">
                                        Gain access to a steady stream of service requests in your area.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-certificate text-xl text-primary-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-1">Brand Association</h3>
                                    <p class="text-gray-600">
                                        Associate with a trusted brand in the roadside assistance industry.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-tools text-xl text-primary-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-1">Training Support</h3>
                                    <p class="text-gray-600">
                                        Access to training resources to enhance your service quality.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Application Form -->
                    <div class="bg-gray-50 rounded-lg p-8 shadow-sm">
                        <h2 class="text-2xl font-bold mb-6">Partner Application Form</h2>
                        
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('job-applications.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="application_type" value="partner">
                            
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                                <input type="number" id="age" name="age" value="{{ old('age') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                @error('age')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="area" class="block text-sm font-medium text-gray-700 mb-1">Service Area</label>
                                <input type="text" id="area" name="area" value="{{ old('area') }}" required placeholder="City, State" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                @error('area')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                                <select id="service_type" name="service_type" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Service Type</option>
                                    <option value="towing" {{ old('service_type') == 'towing' ? 'selected' : '' }}>Towing Service</option>
                                    <option value="mechanic" {{ old('service_type') == 'mechanic' ? 'selected' : '' }}>Mechanic</option>
                                    <option value="fuel_delivery" {{ old('service_type') == 'fuel_delivery' ? 'selected' : '' }}>Fuel Delivery</option>
                                    <option value="tire_service" {{ old('service_type') == 'tire_service' ? 'selected' : '' }}>Tire Service</option>
                                    <option value="locksmith" {{ old('service_type') == 'locksmith' ? 'selected' : '' }}>Locksmith</option>
                                    <option value="multiple" {{ old('service_type') == 'multiple' ? 'selected' : '' }}>Multiple Services</option>
                                </select>
                                @error('service_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">Years of Experience</label>
                                <input type="number" id="experience" name="experience" value="{{ old('experience') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                @error('experience')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Additional Information</label>
                                <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn-primary w-full">
                                <i class="fas fa-paper-plane mr-2"></i> Submit Application
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Meet Our Team</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        The dedicated professionals behind HT Roadside Assistance
                    </p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($teamMembers as $member)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" class="w-full h-64 object-cover">
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold mb-1">{{ $member['name'] }}</h3>
                            <p class="text-gray-600 mb-4">{{ $member['position'] }}</p>
                            <div class="flex justify-center space-x-3">
                                <a href="#" class="text-gray-400 hover:text-primary-600">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-primary-600">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-primary-600">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-primary-600">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Partner Testimonials</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Hear from our service partners about their experience working with us
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-400 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">"Partnering with HT Roadside has transformed my small towing business. The steady flow of service requests and prompt payments have helped me expand my operations and hire more staff."</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                                <span class="text-xl font-bold text-gray-600">R</span>
                            </div>
                            <div>
                                <h4 class="font-bold">Rajesh Kumar</h4>
                                <p class="text-sm text-gray-500">Towing Partner, Delhi</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 2 -->
                    <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-400 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">"As a mechanic, joining HT Roadside's network has given me access to a wider customer base. The training and support provided have helped me improve my service quality and customer satisfaction."</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                                <span class="text-xl font-bold text-gray-600">A</span>
                            </div>
                            <div>
                                <h4 class="font-bold">Amit Singh</h4>
                                <p class="text-sm text-gray-500">Mechanic Partner, Mumbai</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 3 -->
                    <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-400 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">"I've been a service partner with HT Roadside for over 3 years now. The platform is user-friendly, and the support team is always available to resolve any issues. It's been a rewarding partnership."</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                                <span class="text-xl font-bold text-gray-600">P</span>
                            </div>
                            <div>
                                <h4 class="font-bold">Pradeep Verma</h4>
                                <p class="text-sm text-gray-500">Service Center Owner, Bangalore</p>
                            </div>
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
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Join Our Network?</h2>
                <p class="text-xl mb-8">Apply today and become part of India's growing roadside assistance network</p>
                <a href="#" class="btn-white" onclick="document.querySelector('form').scrollIntoView({behavior: 'smooth'}); return false;">
                    <i class="fas fa-paper-plane mr-2"></i> Apply Now
                </a>
            </div>
        </div>
    </section>
@endsection
