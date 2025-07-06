@extends('layouts.app')

@section('title', $plan->name . ' - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', $plan->description)

@section('content')
<div class="bg-gray-100">
    <!-- Page Header -->
    <div class="bg-primary-700 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4" data-aos="fade-up">{{ $plan->name }}</h1>
            <div class="flex items-center text-sm" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('plans.index') }}" class="text-white hover:text-gray-200">Plans</a>
                <span class="mx-2">/</span>
                <span>{{ $plan->name }}</span>
            </div>
        </div>
    </div>

    <!-- Plan Detail Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-4xl mx-auto">
            <div class="p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-primary-700">{{ $plan->name }}</h2>
                        <p class="text-gray-600 mt-2">{{ $plan->description }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="text-4xl font-bold text-primary-700">${{ number_format($plan->price, 2) }}</div>
                        <div class="text-gray-500">per {{ $plan->interval ?? 'month' }}</div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-xl font-semibold mb-4">What's Included</h3>
                    <ul class="space-y-3">
                        @if(isset($plan->features_list))
                            @foreach($plan->features_list as $feature)
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        @elseif(is_string($plan->features))
                            @foreach(json_decode($plan->features) as $feature)
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="mt-8">
                    <a href="{{ route('request-service.create') }}" class="btn btn-primary btn-lg w-full md:w-auto">Subscribe Now</a>
                </div>
            </div>

            <div class="bg-gray-50 p-8 border-t border-gray-200">
                <h3 class="text-xl font-semibold mb-4">Frequently Asked Questions</h3>
                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-lg">How do I sign up for this plan?</h4>
                        <p class="text-gray-600 mt-1">You can sign up for this plan by clicking the "Subscribe Now" button above and following the registration process. You'll need to provide your personal and payment information to complete the subscription.</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-lg">Can I cancel my subscription at any time?</h4>
                        <p class="text-gray-600 mt-1">Yes, you can cancel your subscription at any time. Your coverage will continue until the end of your current billing period.</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-lg">Is there a limit to how many service calls I can make?</h4>
                        <p class="text-gray-600 mt-1">The number of service calls you can make depends on your plan. Please review the plan details above for specific information about service call limits.</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-lg">How quickly can I expect assistance after making a service request?</h4>
                        <p class="text-gray-600 mt-1">Our average response time is 30-45 minutes, but this can vary based on your location, weather conditions, and service provider availability.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <h3 class="text-2xl font-bold mb-8">Compare with Other Plans</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($otherPlans ?? [] as $otherPlan)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h4 class="text-xl font-bold">{{ $otherPlan->name }}</h4>
                            <div class="text-2xl font-bold text-primary-700 my-4">${{ number_format($otherPlan->price, 2) }}</div>
                            <p class="text-gray-600 mb-4">{{ $otherPlan->description }}</p>
                            <a href="{{ route('plans.show', $otherPlan->slug) }}" class="btn btn-outline-primary w-full">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
