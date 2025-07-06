@extends('layouts.app')

@section('title', 'Unsubscribed from Newsletter')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6" data-aos="fade-up">
                    Unsubscribed from Newsletter
                </h1>
                <p class="text-xl text-primary-100 mb-8" data-aos="fade-up" data-aos-delay="100">
                    We're sorry to see you go!
                </p>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="relative h-16 mt-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="absolute bottom-0 text-white fill-current">
                <path d="M0,96L60,80C120,64,240,32,360,21.3C480,11,600,21,720,42.7C840,64,960,96,1080,96C1200,96,1320,64,1380,48L1440,32L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
            </svg>
        </div>
    </section>
    
    <!-- Unsubscribed Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-lg mx-auto bg-white rounded-lg shadow-sm p-8 border border-gray-200" data-aos="fade-up">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mb-4">
                        <i class="fas fa-check text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Successfully Unsubscribed</h2>
                    <p class="text-gray-600">
                        <strong>{{ $email }}</strong> has been successfully unsubscribed from our newsletter.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">We'd love to know why you left</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Your feedback helps us improve our newsletter. Would you mind telling us why you unsubscribed?
                    </p>
                    <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="type" value="newsletter_unsubscribe">
                        <input type="hidden" name="email" value="{{ $email }}">
                        
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" name="reason" id="reason_frequency" value="too_frequent" class="form-radio">
                                <label for="reason_frequency" class="ml-2 text-gray-700">Too many emails</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="reason" id="reason_relevance" value="not_relevant" class="form-radio">
                                <label for="reason_relevance" class="ml-2 text-gray-700">Content not relevant to me</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="reason" id="reason_signup" value="didnt_signup" class="form-radio">
                                <label for="reason_signup" class="ml-2 text-gray-700">I didn't sign up for this</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="reason" id="reason_other" value="other" class="form-radio">
                                <label for="reason_other" class="ml-2 text-gray-700">Other reason</label>
                            </div>
                        </div>
                        
                        <div>
                            <textarea name="comments" rows="3" class="form-input w-full" placeholder="Additional comments (optional)"></textarea>
                        </div>
                        
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-outline">
                                Submit Feedback
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="text-center">
                    <p class="text-gray-600 mb-4">
                        Changed your mind? You can always subscribe again.
                    </p>
                    <a href="{{ route('blog.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Blog
                    </a>
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-200 text-center text-sm text-gray-500">
                    <p>
                        If you have any questions, please contact our support team at <a href="mailto:support@htroadside.com" class="text-primary-600 hover:underline">support@htroadside.com</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
