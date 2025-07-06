    
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
