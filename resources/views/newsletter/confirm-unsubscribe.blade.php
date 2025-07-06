@extends('layouts.app')

@section('title', 'Unsubscribe from Newsletter')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6" data-aos="fade-up">
                    Unsubscribe from Newsletter
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
    
    <!-- Unsubscribe Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-lg mx-auto bg-white rounded-lg shadow-sm p-8 border border-gray-200" data-aos="fade-up">
                <div class="text-center mb-8">
                    <i class="far fa-envelope-open text-5xl text-gray-400 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Confirm Unsubscribe</h2>
                    <p class="text-gray-600">
                        Are you sure you want to unsubscribe <strong>{{ $email }}</strong> from our newsletter?
                    </p>
                </div>
                
                <form action="{{ route('newsletter.unsubscribe', $token) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('home') }}" class="btn btn-outline">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check mr-2"></i> Confirm Unsubscribe
                        </button>
                    </div>
                </form>
                
                <div class="mt-8 pt-6 border-t border-gray-200 text-center text-sm text-gray-500">
                    <p>
                        If you unsubscribed by mistake, you can always subscribe again on our website.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
