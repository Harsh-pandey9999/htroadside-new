    
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
