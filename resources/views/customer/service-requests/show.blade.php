@extends('layouts.app')

@section('title', 'Service Request Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('customer.service-requests.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left mr-2"></i> Back to Service Requests
        </a>
    
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-900/30 dark:text-green-300" role="alert">
            <p>{{ session('success') }}</p>
        
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 dark:bg-red-900/30 dark:text-red-300" role="alert">
            <p>{{ session('error') }}</p>
        
    @endif
    
    <!-- Request Header -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        Service Request #{{ $serviceRequest->id }}
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Requested on {{ $serviceRequest->created_at->format('M d, Y \a\t h:i A') }}
                    </p>
                
                
                <div class="mt-4 md:mt-0 flex items-center">
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        {{ $serviceRequest->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                           ($serviceRequest->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                           ($serviceRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                           'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200')) }}">
                        {{ ucfirst(str_replace('_', ' ', $serviceRequest->status)) }}
                    </span>
                    
                    @if(in_array($serviceRequest->status, ['pending', 'accepted']))
                        <form action="{{ route('customer.service-requests.cancel', $serviceRequest->id) }}" method="POST" class="ml-3">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to cancel this request?')">
                                <i class="fas fa-times mr-1"></i> Cancel Request
                            </button>
                        </form>
                    @endif
                
            
        
    
    
    <div class="mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Provider Information -->
            @if($serviceRequest->provider)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Service Provider</h2>
                    
                    
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($serviceRequest->provider->profile_photo)
                                    <img src="{{ asset('storage/' . $serviceRequest->provider->profile_photo) }}" alt="{{ $serviceRequest->provider->name }}" class="h-16 w-16 rounded-full">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                        <i class="fas fa-user text-blue-500 dark:text-blue-400 text-2xl"></i>
                                    
                                @endif
                            
                            
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $serviceRequest->provider->name }}</h3>
                                
                                @if($serviceRequest->provider->average_rating)
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($serviceRequest->provider->average_rating))
                                                <i class="fas fa-star text-yellow-400"></i>
                                            @elseif($i - 0.5 <= $serviceRequest->provider->average_rating)
                                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                                            @else
                                                <i class="far fa-star text-yellow-400"></i>
                                            @endif
                                        @endfor
                                        <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ number_format($serviceRequest->provider->average_rating, 1) }} ({{ $serviceRequest->provider->reviews_count }} reviews)
                                        </span>
                                    
                                @endif
                                
                                @if($serviceRequest->status === 'accepted' && $serviceRequest->estimated_arrival_time)
                                    <div class="mt-3 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        <i class="fas fa-clock mr-1"></i> ETA: {{ \Carbon\Carbon::parse($serviceRequest->estimated_arrival_time)->format('h:i A') }}
                                    
                                @endif
                            
                        
                        
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if($serviceRequest->provider->phone)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</h4>
                                        <p class="mt-1 text-base text-gray-900 dark:text-white">
                                            <a href="tel:{{ $serviceRequest->provider->phone }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                <i class="fas fa-phone-alt mr-1"></i> {{ $serviceRequest->provider->phone }}
                                            </a>
                                        </p>
                                    
                                @endif
                                
                                @if($serviceRequest->provider->email)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</h4>
                                        <p class="mt-1 text-base text-gray-900 dark:text-white">
                                            <a href="mailto:{{ $serviceRequest->provider->email }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                <i class="fas fa-envelope mr-1"></i> {{ $serviceRequest->provider->email }}
                                            </a>
                                        </p>
                                    
                                @endif
                            
                        
                    
                
            @endif
            
            <!-- Status Timeline -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Status Timeline</h2>
                
                
                <div class="p-6">
                    <ol class="relative border-l border-gray-200 dark:border-gray-700">
                        <li class="mb-6 ml-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-800 dark:bg-blue-900">
                                <i class="fas fa-plus text-blue-600 dark:text-blue-400"></i>
                            </span>
                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                Request Created
                            </h3>
                            <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $serviceRequest->created_at->format('M d, Y \a\t h:i A') }}</time>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                Service request for {{ $serviceRequest->service->name }} was submitted.
                            </p>
                        </li>
                        
                        @if($serviceRequest->status !== 'pending')
                            <li class="mb-6 ml-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-800 dark:bg-green-900">
                                    <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                                </span>
                                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    Request Accepted
                                </h3>
                                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $serviceRequest->accepted_at ? $serviceRequest->accepted_at->format('M d, Y \a\t h:i A') : 'N/A' }}</time>
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                    @if($serviceRequest->provider)
                                        {{ $serviceRequest->provider->name }} accepted your request.
                                    @else
                                        Your request was accepted.
                                    @endif
                                </p>
                            </li>
                        @endif
                        
                        @if($serviceRequest->status === 'in_progress')
                            <li class="mb-6 ml-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-800 dark:bg-blue-900">
                                    <i class="fas fa-truck text-blue-600 dark:text-blue-400"></i>
                                </span>
                                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    Provider En Route
                                </h3>
                                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $serviceRequest->in_progress_at ? $serviceRequest->in_progress_at->format('M d, Y \a\t h:i A') : 'N/A' }}</time>
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                    @if($serviceRequest->provider)
                                        {{ $serviceRequest->provider->name }} is on the way to your location.
                                    @else
                                        Provider is on the way to your location.
                                    @endif
                                </p>
                            </li>
                        @endif
                        
                        @if($serviceRequest->status === 'completed')
                            <li class="mb-6 ml-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-800 dark:bg-green-900">
                                    <i class="fas fa-flag-checkered text-green-600 dark:text-green-400"></i>
                                </span>
                                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    Service Completed
                                </h3>
                                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $serviceRequest->completed_at ? $serviceRequest->completed_at->format('M d, Y \a\t h:i A') : 'N/A' }}</time>
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                    Your service request has been completed successfully.
                                </p>
                            </li>
                        @endif
                        
                        @if($serviceRequest->status === 'cancelled')
                            <li class="ml-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-red-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-800 dark:bg-red-900">
                                    <i class="fas fa-times text-red-600 dark:text-red-400"></i>
                                </span>
                                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    Request Cancelled
                                </h3>
                                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $serviceRequest->cancelled_at ? $serviceRequest->cancelled_at->format('M d, Y \a\t h:i A') : 'N/A' }}</time>
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                    @if($serviceRequest->cancellation_reason)
                                        Reason: {{ $serviceRequest->cancellation_reason }}
                                    @else
                                        This service request was cancelled.
                                    @endif
                                </p>
                            </li>
                        @endif
                    </ol>
                
            
        
    
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Location Information -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Location</h2>
            
            
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                        {{ $serviceRequest->location_address }}<br>
                        {{ $serviceRequest->location_city }}, {{ $serviceRequest->location_state }} {{ $serviceRequest->location_zip }}
                    </p>
                
                
                @if($serviceRequest->location_notes)
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Location Notes</h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $serviceRequest->location_notes }}</p>
                    
                @endif
                
                @if($serviceRequest->location_latitude && $serviceRequest->location_longitude)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">GPS Coordinates</h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-white">
                            {{ $serviceRequest->location_latitude }}, {{ $serviceRequest->location_longitude }}
                        </p>
                    
                    
                    <div class="mt-4 h-48 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden">
                        <div id="map" class="h-full w-full">
                    
                @endif
            
        
        
        <!-- Vehicle Information -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Vehicle</h2>
            
            
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Vehicle</h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                        {{ $serviceRequest->vehicle->year }} {{ $serviceRequest->vehicle->make }} {{ $serviceRequest->vehicle->model }}
                    </p>
                
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Color</h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $serviceRequest->vehicle->color }}</p>
                
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">License Plate</h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $serviceRequest->vehicle->license_plate }}</p>
                
                
                @if($serviceRequest->vehicle_notes)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Vehicle Notes</h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $serviceRequest->vehicle_notes }}</p>
                    
                @endif
            
        
        
        <!-- Service Details -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Service Details</h2>
            
            
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Service Type</h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $serviceRequest->service->name }}</p>
                
                
                @if($serviceRequest->is_emergency)
                    <div class="mb-4">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Emergency Request
                        </span>
                    
                @endif
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                        ${{ number_format($serviceRequest->price, 2) }}
                        @if($serviceRequest->is_emergency)
                            <span class="text-xs text-gray-500 dark:text-gray-400">(includes emergency fee)</span>
                        @endif
                    </p>
                
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Status</h3>
                    <p class="mt-1 text-base">
                        @if($serviceRequest->payment_status === 'paid')
                            <span class="text-green-600 dark:text-green-400"><i class="fas fa-check-circle mr-1"></i> Paid</span>
                        @elseif($serviceRequest->payment_status === 'pending')
                            <span class="text-yellow-600 dark:text-yellow-400"><i class="fas fa-clock mr-1"></i> Pending</span>
                        @else
                            <span class="text-gray-600 dark:text-gray-400"><i class="fas fa-times-circle mr-1"></i> Not Paid</span>
                        @endif
                    </p>
                
            
        
    
    <!-- Notes and Communication -->
    <div class="mt-6">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Notes & Communication</h2>
            </div>
            
            <div class="p-6">
                @if(count($serviceRequest->notes) > 0)
                    <div class="space-y-4">
                        @foreach($serviceRequest->notes as $note)
                            <div class="p-4 {{ $note->user_id === auth()->id() ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-gray-50 dark:bg-gray-700/50' }} rounded-lg">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        @if($note->user->profile_photo)
                                            <img src="{{ asset('storage/' . $note->user->profile_photo) }}" alt="{{ $note->user->name }}" class="h-8 w-8 rounded-full">
                                        @else
                                            <div class="h-8 w-8 rounded-full {{ $note->user_id === auth()->id() ? 'bg-blue-100 dark:bg-blue-900' : 'bg-gray-200 dark:bg-gray-700' }} flex items-center justify-center">
                                                <i class="fas fa-user {{ $note->user_id === auth()->id() ? 'text-blue-500 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $note->user->name }} 
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    ({{ $note->user->is_service_provider ? 'Provider' : 'You' }})
                                                </span>
                                            </h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $note->created_at->format('M d, Y \a\t h:i A') }}</p>
                                        </div>
                                        
                                        <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                            <p>{{ $note->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No notes yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            There are no notes or messages for this service request.
                        </p>
                    </div>
                @endif
                
                @if(in_array($serviceRequest->status, ['pending', 'accepted', 'in_progress']))
                    <div class="mt-6">
                        <form action="{{ route('customer.service-requests.add-note', $serviceRequest->id) }}" method="POST">
                            @csrf
                            <div>
                                <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Add a Note</label>
                                <textarea id="note" name="content" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Add details or questions about your request..."></textarea>
                            </div>
                            
                            <div class="mt-3 text-right">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-paper-plane mr-2"></i> Send Note
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Review Section -->
    @if($serviceRequest->status === 'completed' && !$serviceRequest->review)
        <div class="mt-6">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Leave a Review</h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('customer.service-requests.review', $serviceRequest->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rating</label>
                            <div class="flex items-center" id="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" data-rating="{{ $i }}" class="rating-star text-2xl text-gray-300 dark:text-gray-600 hover:text-yellow-400 focus:text-yellow-400 focus:outline-none">
                                        <i class="far fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="">
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Your Review</label>
                            <textarea id="comment" name="comment" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Share your experience with this service..."></textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="text-right">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-star mr-2"></i> Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif($serviceRequest->review)
        <div class="mt-6">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Your Review</h2>
                </div>
                
                <div class="p-6">
                    <div class="mb-4">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $serviceRequest->review->rating)
                                    <i class="fas fa-star text-yellow-400 text-xl"></i>
                                @else
                                    <i class="far fa-star text-yellow-400 text-xl"></i>
                                @endif
                            @endfor
                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                Submitted on {{ $serviceRequest->review->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-gray-700 dark:text-gray-300">
                        <p>{{ $serviceRequest->review->comment }}</p>
                    </div>
                    
                    @if($serviceRequest->review->provider_response)
                        <div class="mt-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @if($serviceRequest->provider && $serviceRequest->provider->profile_photo)
                                        <img src="{{ asset('storage/' . $serviceRequest->provider->profile_photo) }}" alt="{{ $serviceRequest->provider->name }}" class="h-8 w-8 rounded-full">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-500 dark:text-blue-400"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Provider Response</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $serviceRequest->review->response_at->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                        <p>{{ $serviceRequest->review->provider_response }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Map initialization if coordinates exist
        @if(isset($serviceRequest->location_latitude) && isset($serviceRequest->location_longitude))
            // This is a placeholder for map initialization
            // In a real implementation, you would use Google Maps, Mapbox, or Leaflet
            const mapElement = document.getElementById('map');
            if (mapElement) {
                // Initialize map here
                console.log('Map would be initialized with coordinates: {{ $serviceRequest->location_latitude }}, {{ $serviceRequest->location_longitude }}');
            }
        @endif
        
        // Star rating functionality
        const ratingStars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('rating-input');
        
        if (ratingStars.length > 0 && ratingInput) {
            ratingStars.forEach(star => {
                star.addEventListener('click', () => {
                    const rating = parseInt(star.dataset.rating);
                    ratingInput.value = rating;
                    
                    // Update star appearance
                    ratingStars.forEach((s, index) => {
                        const starIcon = s.querySelector('i');
                        if (index < rating) {
                            starIcon.className = 'fas fa-star';
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300', 'dark:text-gray-600');
                        } else {
                            starIcon.className = 'far fa-star';
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300', 'dark:text-gray-600');
                        }
                    });
                });
            });
        }
    });
</script>
@endsection
@endsection
