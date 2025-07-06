@extends('layouts.app')

@section('title', 'Careers - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', 'Join our team at ' . settings('site_name', 'HT Roadside') . '. View current job openings and career opportunities.')

@section('content')
<div class="bg-gray-100">
    <!-- Page Header -->
    <div class="bg-primary-700 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4" data-aos="fade-up">Careers</h1>
            <div class="flex items-center text-sm" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200">Home</a>
                <span class="mx-2">/</span>
                <span>Careers</span>
            </div>
        </div>
    </div>

    <!-- Careers Introduction -->
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto text-center mb-16">
            <h2 class="text-3xl font-bold text-primary-700 mb-6" data-aos="fade-up">Join Our Team</h2>
            <p class="text-lg text-gray-600 mb-8" data-aos="fade-up" data-aos-delay="100">
                At {{ settings('site_name', 'HT Roadside') }}, we're dedicated to providing exceptional roadside assistance services to our members. 
                Our success depends on having passionate, skilled, and customer-focused team members who share our commitment to excellence.
            </p>
            <p class="text-lg text-gray-600" data-aos="fade-up" data-aos-delay="200">
                Explore our current openings below and find the perfect opportunity to grow your career with us.
            </p>
        </div>

        <!-- Why Join Us Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white rounded-lg shadow-lg p-8 text-center" data-aos="fade-up">
                <div class="text-primary-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Competitive Benefits</h3>
                <p class="text-gray-600">
                    We offer comprehensive health insurance, retirement plans, paid time off, and more to ensure our team members' wellbeing.
                </p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8 text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="text-primary-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Growth Opportunities</h3>
                <p class="text-gray-600">
                    We believe in promoting from within and providing ongoing training and development to help you advance your career.
                </p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8 text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="text-primary-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Inclusive Culture</h3>
                <p class="text-gray-600">
                    We foster a diverse and inclusive workplace where every team member is valued, respected, and empowered to contribute.
                </p>
            </div>
        </div>

        <!-- Current Openings -->
        <div class="max-w-5xl mx-auto">
            <h2 class="text-2xl font-bold text-center mb-8" data-aos="fade-up">Current Openings</h2>
            
            @if(session('warning'))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <p>{{ session('warning') }}</p>
                </div>
            @endif
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            @if(count($careers) > 0)
                <div class="space-y-6" data-aos="fade-up" data-aos-delay="100">
                    @foreach($careers as $career)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-primary-700">
                                            <a href="{{ route('careers.show', $career->slug) }}" class="hover:text-primary-600">
                                                {{ $career->title }}
                                                @if($career->featured)
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Featured
                                                    </span>
                                                @endif
                                            </a>
                                        </h3>
                                        <div class="mt-2 text-gray-600">
                                            <span class="inline-flex items-center mr-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                {{ $career->department }}
                                            </span>
                                            <span class="inline-flex items-center mr-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $career->location }}
                                            </span>
                                            <span class="inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $career->type }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-4 md:mt-0">
                                        <a href="{{ route('careers.show', $career->slug) }}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-600 line-clamp-2">{{ $career->description }}</p>
                                </div>
                                @if(isset($career->salary_min) || isset($career->salary_max))
                                    <div class="mt-3 text-gray-700 font-medium">
                                        <span class="inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ isset($career->formatted_salary) ? $career->formatted_salary : '$' . number_format($career->salary_min, 0) . ' - $' . number_format($career->salary_max, 0) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center" data-aos="fade-up">
                    <p class="text-gray-600">No job openings available at this time. Please check back later.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
