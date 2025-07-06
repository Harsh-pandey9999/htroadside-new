@extends('layouts.app')

@section('title', 'Error - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', 'Error page for ' . settings('site_name', 'HT Roadside'))

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Error Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl mx-auto text-center">
            <div class="text-red-600 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold mb-4">Oops! Something went wrong</h1>
            
            <p class="text-gray-600 mb-6">
                {{ $message ?? 'We encountered an error while processing your request. Please try again later.' }}
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home mr-2"></i> Return to Home
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">
                    <i class="fas fa-envelope mr-2"></i> Contact Support
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
