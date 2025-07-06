@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary-700 to-primary-900 text-white">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">About HT Roadside Assistance</h1>
                <p class="text-xl mb-0">Your reliable partner for emergency roadside support across India</p>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="mb-12">
                    <h2 class="text-3xl font-bold mb-6">Our Mission</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        At HT Roadside Assistance, our mission is to provide prompt, reliable, and professional roadside assistance services to motorists across India. We understand that vehicle breakdowns can happen at any time, and our goal is to ensure that help is always just a phone call away.
                    </p>
                    <p class="text-lg text-gray-600">
                        We are committed to delivering exceptional customer service, employing trained technicians, using modern equipment, and offering affordable plans to make roadside assistance accessible to everyone.
                    </p>
                </div>
                
                <div class="mb-12">
                    <h2 class="text-3xl font-bold mb-6">Customer-Centric Approach</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        Our customer-centric approach is at the heart of everything we do. We prioritize your safety and convenience, ensuring that our services are available 24/7, regardless of your location. Our team is trained to handle a wide range of roadside emergencies with professionalism and efficiency.
                    </p>
                    <p class="text-lg text-gray-600">
                        We continuously gather feedback from our customers to improve our services and meet the evolving needs of motorists across the country.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose Us</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    We stand out from the competition with our commitment to excellence
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-100 flex items-center justify-center">
                        <i class="fas fa-clock text-2xl text-primary-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">24/7 Availability</h3>
                    <p class="text-gray-600">
                        Our services are available round the clock, ensuring help is always available when you need it most.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-100 flex items-center justify-center">
                        <i class="fas fa-bolt text-2xl text-primary-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Fast Response</h3>
                    <p class="text-gray-600">
                        We pride ourselves on our quick response times, minimizing your wait during emergencies.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-100 flex items-center justify-center">
                        <i class="fas fa-user-tie text-2xl text-primary-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Trained Professionals</h3>
                    <p class="text-gray-600">
                        Our network consists of skilled technicians equipped with modern tools and equipment.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-100 flex items-center justify-center">
                        <i class="fas fa-map-marked-alt text-2xl text-primary-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Pan-India Coverage</h3>
                    <p class="text-gray-600">
                        With 3000+ partners across 700+ cities, we offer extensive coverage throughout India.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Network Strength -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-6">Our Network Strength</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        HT Roadside Assistance has built a robust network of over 3,000 trained service partners across more than 700 cities in India. This extensive coverage allows us to provide prompt assistance to motorists, regardless of their location.
                    </p>
                    <p class="text-lg text-gray-600 mb-6">
                        Our partners undergo rigorous training and certification to ensure they meet our high standards of service quality. They are equipped with the latest tools and technology to handle a wide range of roadside emergencies efficiently.
                    </p>
                    <p class="text-lg text-gray-600">
                        We continuously expand our network to reach more locations and reduce response times, making roadside assistance more accessible to motorists across the country.
                    </p>
                </div>
                <div class="bg-gray-100 p-8 rounded-lg">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-5xl font-bold text-primary-600 mb-2">3000+</div>
                            <div class="text-xl font-medium">Service Partners</div>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold text-primary-600 mb-2">700+</div>
                            <div class="text-xl font-medium">Cities Covered</div>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold text-primary-600 mb-2">24/7</div>
                            <div class="text-xl font-medium">Availability</div>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold text-primary-600 mb-2">30min</div>
                            <div class="text-xl font-medium">Avg. Response Time</div>
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
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Experience Our Services?</h2>
                <p class="text-xl mb-8">Choose from our range of affordable plans or contact us for immediate assistance</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('plans.index') }}" class="btn-white">
                        <i class="fas fa-tags mr-2"></i> View Our Plans
                    </a>
                    <a href="{{ route('contact') }}" class="btn-outline-white">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
