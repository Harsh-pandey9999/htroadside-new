@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary-700 to-primary-900 text-white">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">24/7 Roadside Assistance You Can Trust</h1>
                <p class="text-xl md:text-2xl mb-8">Fast response, trained professionals, and affordable plans across India</p>
                <div class="flex flex-wrap gap-4">
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '+919415666567')) }}" class="btn-primary bg-red-600 hover:bg-red-700">
                        <i class="fas fa-phone-alt mr-2"></i> Get Help Now
                    </a>
                    <a href="{{ route('plans.index') }}" class="btn-secondary">
                        <i class="fas fa-tags mr-2"></i> Explore Plans
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Intro Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Your Reliable Partner on the Road</h2>
                <p class="text-lg text-gray-600 mb-8">
                    HT Roadside Assistance provides 24/7 emergency roadside support services across India. 
                    With our network of trained professionals, we ensure you're never stranded on the road.
                </p>
                
                <!-- Coverage Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
                    <div class="bg-gray-50 rounded-lg p-8 shadow-sm">
                        <div class="text-5xl font-bold text-primary-600 mb-2">3000+</div>
                        <div class="text-xl font-medium">Trained Partners</div>
                        <p class="mt-2 text-gray-600">Professional technicians ready to assist you</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-8 shadow-sm">
                        <div class="text-5xl font-bold text-primary-600 mb-2">700+</div>
                        <div class="text-xl font-medium">Cities Covered</div>
                        <p class="mt-2 text-gray-600">Pan-India coverage for your peace of mind</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Preview Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Services</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    We offer a comprehensive range of roadside assistance services to keep you moving
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden transition-transform hover:transform hover:scale-105">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-{{ $service->icon ?? 'car' }} text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $service->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($service->short_description, 100) }}</p>
                        <a href="{{ route('services.show', $service->slug) }}" class="text-primary-600 font-medium hover:text-primary-700">
                            Learn More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('services.index') }}" class="btn-secondary">
                    View All Services
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary-800 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Need Immediate Assistance?</h2>
                <p class="text-xl mb-8">Our team is available 24/7 to help you with any roadside emergency</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '+919415666567')) }}" class="btn-white">
                        <i class="fas fa-phone-alt mr-2"></i> Call Now: {{ settings('contact_phone', '+91 9415666567') }}
                    </a>
                    <a href="{{ route('contact') }}" class="btn-outline-white">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Preview Section -->
    @if(isset($featuredPosts) && $featuredPosts->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Latest Articles</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Tips, advice, and insights to keep you safe on the road
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredPosts as $post)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-newspaper text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $post->category->name }}</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt, 100) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-primary-600 font-medium hover:text-primary-700">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('blog.index') }}" class="btn-secondary">
                    View All Articles
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">What Our Customers Say</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Don't just take our word for it - hear from our satisfied customers
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">"I was stranded on the highway late at night with a flat tire. HT Roadside's technician arrived in just 30 minutes and got me back on the road quickly. Excellent service!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                            <span class="text-xl font-bold text-gray-600">R</span>
                        </div>
                        <div>
                            <h4 class="font-bold">Rahul Sharma</h4>
                            <p class="text-sm text-gray-500">Delhi</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">"Their Silver plan has saved me multiple times. The battery jumpstart service was quick and professional. Highly recommend HT Roadside to all two-wheeler owners."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                            <span class="text-xl font-bold text-gray-600">P</span>
                        </div>
                        <div>
                            <h4 class="font-bold">Priya Patel</h4>
                            <p class="text-sm text-gray-500">Mumbai</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">"I accidentally locked my keys in the car during a business trip. HT Roadside's technician was professional and helped me get back in without any damage. Worth every penny!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                            <span class="text-xl font-bold text-gray-600">S</span>
                        </div>
                        <div>
                            <h4 class="font-bold">Suresh Kumar</h4>
                            <p class="text-sm text-gray-500">Bangalore</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
