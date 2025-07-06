@extends('layouts.app')

@section('title', 'Service Request Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('provider.service-requests.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left mr-2"></i> Back to Service Requests
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-900/30 dark:text-green-300" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 dark:bg-red-900/30 dark:text-red-300" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Service Request #{{ $serviceRequest->id }}
            </h1>
            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                {{ $serviceRequest->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                   ($serviceRequest->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                   ($serviceRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                   ($serviceRequest->status === 'accepted' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                   'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'))) }}">
                {{ ucfirst(str_replace('_', ' ', $serviceRequest->status)) }}
            </span>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Request Details -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Request Details</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Service Type</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->service->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Title</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->title }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->description }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Created</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Emergency</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->is_emergency ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Details -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Customer Details</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->user->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Location Details -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Location Details</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Address</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->location_address }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">City, State</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->location_city }}, {{ $serviceRequest->location_state }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Country</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->location_country }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Postal Code</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->location_postal_code }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Vehicle Details -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Vehicle Details</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Make & Model</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->vehicle_make }} {{ $serviceRequest->vehicle_model }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Year</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->vehicle_year }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Color</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->vehicle_color }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">License Plate</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $serviceRequest->vehicle_license_plate }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex flex-wrap gap-2">
            @if($serviceRequest->status === 'pending')
                <form action="{{ route('provider.service-requests.accept', $serviceRequest->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-check mr-2"></i> Accept Request
                    </button>
                </form>
            @endif
            
            @if(in_array($serviceRequest->status, ['accepted', 'in_progress']))
                <button type="button" data-modal-target="completeModal" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-check-circle mr-2"></i> Mark as Complete
                </button>
                
                <button type="button" data-modal-target="cancelModal" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                    <i class="fas fa-times-circle mr-2"></i> Cancel Request
                </button>
                
                <button type="button" data-modal-target="addNoteModal" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                    <i class="fas fa-sticky-note mr-2"></i> Add Note
                </button>
            @endif
        </div>
    </div>
    
    <!-- Status Updates -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Status Updates</h2>
        </div>
        
        <div class="p-6">
            @if($statusUpdates->count() > 0)
                <div class="relative">
                    <div class="absolute left-5 top-0 h-full w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                    
                    <div class="space-y-6 relative">
                        @foreach($statusUpdates as $update)
                            <div class="relative pl-8">
                                <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full bg-blue-500"></div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $update->status)) }}</h3>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $update->notes }}</p>
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 sm:text-right mt-1 sm:mt-0">
                                        {{ $update->created_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-gray-500 dark:text-gray-400">No status updates yet.</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Notes -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Notes</h2>
        </div>
        
        <div class="p-6">
            @if($notes->count() > 0)
                <div class="space-y-4">
                    @foreach($notes as $note)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-gray-900 dark:text-white">{{ $note->content }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $note->user->name }} • {{ $note->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                @if($note->is_private)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                        Private
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-gray-500 dark:text-gray-400">No notes yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Complete Modal -->
<div id="completeModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full mx-auto shadow-xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Mark as Complete</h3>
            </div>
            
            <form action="{{ route('provider.service-requests.complete', $serviceRequest->id) }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="mb-4">
                        <label for="completion_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Completion Notes</label>
                        <textarea id="completion_notes" name="completion_notes" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
                    </div>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Please provide details about the service performed and any additional information.
                    </p>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-3">
                    <button type="button" data-modal-close="completeModal" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Complete Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full mx-auto shadow-xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Cancel Request</h3>
            </div>
            
            <form action="{{ route('provider.service-requests.cancel', $serviceRequest->id) }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="mb-4">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cancellation Reason</label>
                        <textarea id="cancellation_reason" name="cancellation_reason" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
                    </div>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Please provide a reason for cancelling this service request.
                    </p>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-3">
                    <button type="button" data-modal-close="cancelModal" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
                        Back
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Cancel Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div id="addNoteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full mx-auto shadow-xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Add Note</h3>
            </div>
            
            <form action="{{ route('provider.service-requests.add-note', $serviceRequest->id) }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Note Content</label>
                        <textarea id="content" name="content" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
                    </div>
                    
                    <div class="flex items-center">
                        <input id="is_private" name="is_private" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                        <label for="is_private" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Private note (only visible to providers)
                        </label>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-3">
                    <button type="button" data-modal-close="addNoteModal" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Note
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
    });
</script>
@endsection
@endsection
