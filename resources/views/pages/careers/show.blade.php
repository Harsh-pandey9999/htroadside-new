@extends('layouts.app')

@section('title', $career->title . ' - Careers - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', $career->description)

@section('content')
<div class="bg-gray-100">
    <!-- Page Header -->
    <div class="bg-primary-700 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4" data-aos="fade-up">{{ $career->title }}</h1>
            <div class="flex items-center text-sm" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('careers.index') }}" class="text-white hover:text-gray-200">Careers</a>
                <span class="mx-2">/</span>
                <span>{{ $career->title }}</span>
            </div>
        </div>
    </div>

    <!-- Career Detail Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            @if(session('warning'))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <p>{{ session('warning') }}</p>
                </div>
            @endif
            
            <!-- Job Overview -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8" data-aos="fade-up">
                <div class="p-8">
                    <div class="flex flex-wrap items-center mb-6">
                        <div class="w-full md:w-3/4 mb-4 md:mb-0">
                            <h2 class="text-2xl font-bold text-primary-700">{{ $career->title }}</h2>
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
                        <div class="w-full md:w-1/4 text-center md:text-right">
                            <a href="{{ route('careers.apply', $career->slug) }}" class="btn btn-primary btn-lg">Apply Now</a>
                        </div>
                    </div>
                    
                    @if(isset($career->salary_min) || isset($career->salary_max))
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="text-gray-700 font-medium">
                                <span class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-lg">Salary Range: {{ isset($career->formatted_salary) ? $career->formatted_salary : '$' . number_format($career->salary_min, 0) . ' - $' . number_format($career->salary_max, 0) }}</span>
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="prose max-w-none">
                        <h3>Job Description</h3>
                        <p>{{ $career->description }}</p>
                        
                        <h3>Responsibilities</h3>
                        <ul>
                            @if(isset($career->responsibilities_list))
                                @foreach($career->responsibilities_list as $responsibility)
                                    <li>{{ $responsibility }}</li>
                                @endforeach
                            @elseif(is_string($career->responsibilities))
                                @foreach(json_decode($career->responsibilities) as $responsibility)
                                    <li>{{ $responsibility }}</li>
                                @endforeach
                            @endif
                        </ul>
                        
                        <h3>Requirements</h3>
                        <ul>
                            @if(isset($career->requirements_list))
                                @foreach($career->requirements_list as $requirement)
                                    <li>{{ $requirement }}</li>
                                @endforeach
                            @elseif(is_string($career->requirements))
                                @foreach(json_decode($career->requirements) as $requirement)
                                    <li>{{ $requirement }}</li>
                                @endforeach
                            @endif
                        </ul>
                        
                        <h3>Benefits</h3>
                        <ul>
                            @if(isset($career->benefits_list))
                                @foreach($career->benefits_list as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            @elseif(is_string($career->benefits))
                                @foreach(json_decode($career->benefits) as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                            <div class="mb-4 md:mb-0">
                                <p class="text-gray-600">
                                    @if(isset($career->expires_at))
                                        <span class="inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Application deadline: {{ \Carbon\Carbon::parse($career->expires_at)->format('F j, Y') }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('careers.apply', $career->slug) }}" class="btn btn-primary">Apply for this Position</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Share Job -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8" data-aos="fade-up">
                <h3 class="text-lg font-semibold mb-4">Share This Job</h3>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('careers.show', $career->slug)) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($career->title) }}&url={{ urlencode(route('careers.show', $career->slug)) }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('careers.show', $career->slug)) }}&title={{ urlencode($career->title) }}" target="_blank" class="text-blue-700 hover:text-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="mailto:?subject={{ urlencode('Job Opportunity: ' . $career->title) }}&body={{ urlencode('Check out this job opportunity: ' . route('careers.show', $career->slug)) }}" class="text-gray-600 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Related Jobs -->
            @if(isset($relatedCareers) && count($relatedCareers) > 0)
                <div class="mt-12" data-aos="fade-up">
                    <h3 class="text-2xl font-bold mb-6">Similar Positions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedCareers as $relatedCareer)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="p-6">
                                    <h4 class="text-lg font-bold text-primary-700 mb-2">
                                        <a href="{{ route('careers.show', $relatedCareer->slug) }}" class="hover:text-primary-600">
                                            {{ $relatedCareer->title }}
                                        </a>
                                    </h4>
                                    <div class="text-sm text-gray-600 mb-3">
                                        <div class="mb-1">{{ $relatedCareer->department }}</div>
                                        <div>{{ $relatedCareer->location }}</div>
                                    </div>
                                    <a href="{{ route('careers.show', $relatedCareer->slug) }}" class="btn btn-outline-primary btn-sm w-full">View Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
