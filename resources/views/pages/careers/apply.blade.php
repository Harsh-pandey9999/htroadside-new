@extends('layouts.app')

@section('title', 'Apply for ' . $career->title . ' - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', 'Apply for the ' . $career->title . ' position at ' . settings('site_name', 'HT Roadside'))

@section('content')
<div class="bg-gray-100">
    <!-- Page Header -->
    <div class="bg-primary-700 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4" data-aos="fade-up">Apply for {{ $career->title }}</h1>
            <div class="flex items-center text-sm" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('careers.index') }}" class="text-white hover:text-gray-200">Careers</a>
                <span class="mx-2">/</span>
                <a href="{{ route('careers.show', $career->slug) }}" class="text-white hover:text-gray-200">{{ $career->title }}</a>
                <span class="mx-2">/</span>
                <span>Apply</span>
            </div>
        </div>
    </div>

    <!-- Application Form -->
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-3xl mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Application Submitted!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <p>{{ session('warning') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Please correct the following errors:</p>
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-lg overflow-hidden" data-aos="fade-up">
                <div class="p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-primary-700 mb-2">{{ $career->title }}</h2>
                        <div class="text-gray-600">
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

                    <form action="{{ route('careers.submit-application', $career->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-700 font-medium mb-2">Full Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="Your full name">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="your.email@example.com">
                            </div>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number *</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="(123) 456-7890">
                        </div>
                        
                        <div>
                            <label for="resume" class="block text-gray-700 font-medium mb-2">Resume/CV * (PDF, DOC, DOCX, max 10MB)</label>
                            <input type="file" name="resume" id="resume" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                accept=".pdf,.doc,.docx">
                            <p class="mt-1 text-sm text-gray-500">Please upload your resume in PDF, DOC, or DOCX format (max 10MB)</p>
                        </div>
                        
                        <div>
                            <label for="cover_letter" class="block text-gray-700 font-medium mb-2">Cover Letter (Optional)</label>
                            <textarea name="cover_letter" id="cover_letter" rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Tell us why you're interested in this position and what makes you a great candidate.">{{ old('cover_letter') }}</textarea>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="privacy_policy" name="privacy_policy" type="checkbox" required
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="privacy_policy" class="font-medium text-gray-700">
                                    I agree to the <a href="{{ route('privacy') }}" target="_blank" class="text-primary-600 hover:text-primary-500">Privacy Policy</a> and consent to the processing of my personal data for recruitment purposes. *
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn btn-primary btn-lg w-full">
                                Submit Application
                            </button>
                        </div>
                        
                        <p class="text-sm text-gray-500">
                            Fields marked with * are required. Your application will be reviewed by our HR team, and we'll contact you if your qualifications match our requirements.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
