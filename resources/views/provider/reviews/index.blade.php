@extends('layouts.app')

@section('title', 'My Reviews')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">My Reviews</h1>
    
    <!-- Review Stats -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-8">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="text-5xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['average_rating'], 1) }}</div>
                    <div class="flex items-center mt-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($stats['average_rating']))
                                <i class="fas fa-star text-yellow-400"></i>
                            @elseif ($i - 0.5 <= $stats['average_rating'])
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                            @else
                                <i class="far fa-star text-yellow-400"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $stats['total_reviews'] }} reviews</div>
                </div>
                
                <div class="col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Rating Distribution</h3>
                    
                    @foreach(range(5, 1) as $rating)
                        <div class="flex items-center mb-2">
                            <div class="w-12 text-sm text-gray-600 dark:text-gray-400">{{ $rating }} star</div>
                            <div class="w-full mx-2">
                                <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $stats['rating_percentages'][$rating] }}%"></div>
                                </div>
                            </div>
                            <div class="w-12 text-sm text-gray-600 dark:text-gray-400 text-right">{{ $stats['rating_percentages'][$rating] }}%</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Controls -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <form action="{{ route('provider.reviews.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-end space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="w-full sm:w-1/4">
                    <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Filter by Rating
                    </label>
                    <select id="rating" name="rating" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">All Ratings</option>
                        @foreach(range(5, 1) as $rating)
                            <option value="{{ $rating }}" {{ request('rating') == $rating ? 'selected' : '' }}>{{ $rating }} Stars</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full sm:w-1/4">
                    <label for="service" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Filter by Service
                    </label>
                    <select id="service" name="service" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">All Services</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ request('service') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full sm:w-1/4">
                    <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Sort By
                    </label>
                    <select id="sort" name="sort" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Rating</option>
                        <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Rating</option>
                    </select>
                </div>
                
                <div class="w-full sm:w-1/4">
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-filter mr-2"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Reviews List -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Customer Reviews</h2>
        </div>
        
        @if($reviews->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($reviews as $review)
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($review->user->profile_photo)
                                    <img src="{{ asset('storage/' . $review->user->profile_photo) }}" alt="{{ $review->user->name }}" class="h-10 w-10 rounded-full">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->user->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                                
                                <div class="mt-1 flex items-center">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star text-yellow-400"></i>
                                            @else
                                                <i class="far fa-star text-yellow-400"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">for {{ $review->serviceRequest->service->name }}</span>
                                </div>
                                
                                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                    <p>{{ $review->comment }}</p>
                                </div>
                                
                                @if($review->provider_response)
                                    <div class="mt-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                @if(auth()->user()->profile_photo)
                                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full">
                                                @else
                                                    <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                        <i class="fas fa-user text-blue-500 dark:text-blue-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Your Response</h4>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $review->response_at->format('M d, Y') }}</p>
                                                </div>
                                                
                                                <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                                    <p>{{ $review->provider_response }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <button type="button" data-modal-target="responseModal" data-review-id="{{ $review->id }}" class="respond-button inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                            <i class="fas fa-reply mr-1.5"></i> Respond
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-10">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No reviews found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    No reviews match your current filter.
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Response Modal -->
<div id="responseModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full mx-auto shadow-xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Respond to Review</h3>
            </div>
            
            <form id="responseForm" action="" method="POST">
                @csrf
                <div class="p-6">
                    <div class="mb-4">
                        <label for="provider_response" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Your Response</label>
                        <textarea id="provider_response" name="provider_response" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
                    </div>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Your response will be visible to the customer and all users viewing this review.
                    </p>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-3">
                    <button type="button" data-modal-close="responseModal" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Response
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal functionality
        document.querySelectorAll('[data-modal-target]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                document.getElementById(modalId).classList.remove('hidden');
            });
        });
        
        document.querySelectorAll('[data-modal-close]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-close');
                document.getElementById(modalId).classList.add('hidden');
            });
        });
        
        // Response form handling
        document.querySelectorAll('.respond-button').forEach(button => {
            button.addEventListener('click', () => {
                const reviewId = button.getAttribute('data-review-id');
                const form = document.getElementById('responseForm');
                form.action = `/provider/reviews/${reviewId}/respond`;
            });
        });
    });
</script>
@endsection
@endsection
