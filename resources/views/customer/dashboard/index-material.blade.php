@extends('layouts.customer-material')

@section('title', 'Customer Dashboard')
@section('page-heading', 'Dashboard')
@section('page-subheading', 'Overview of your roadside assistance services and requests')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Requests Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Requests</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $totalRequests }}</h3>
                <p class="text-on-surface-medium text-sm mt-2">Lifetime total</p>
            </div>
            <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-primary-600 dark:text-primary-300">assignment</span>
            </div>
        </div>
    </div>

    <!-- Completed Requests Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Completed</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $completedRequests }}</h3>
                <p class="text-on-surface-medium text-sm mt-2">Successfully resolved</p>
            </div>
            <div class="bg-success-50 dark:bg-success-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-success-600 dark:text-success-300">check_circle</span>
            </div>
        </div>
    </div>

    <!-- Total Spent Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Spent</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">${{ number_format($totalSpent, 2) }}</h3>
                <p class="text-on-surface-medium text-sm mt-2">All services</p>
            </div>
            <div class="bg-secondary-100 dark:bg-secondary-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-secondary-600 dark:text-secondary-300">payments</span>
            </div>
        </div>
    </div>

    <!-- Emergency Contacts Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Emergency Contacts</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $emergencyContacts }}</h3>
                <p class="text-on-surface-medium text-sm mt-2">
                    @if($emergencyContacts > 0)
                        Contacts saved
                    @else
                        <a href="{{ route('customer.contacts.create') }}" class="text-primary-600">Add contacts</a>
                    @endif
                </p>
            </div>
            <div class="bg-warning-50 dark:bg-warning-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-warning-600 dark:text-warning-300">contacts</span>
            </div>
        </div>
    </div>
</div>

<!-- Active Request (if any) -->
@if($activeRequest)
<div class="md-card md-card-elevated mb-6">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-on-surface-high">Active Request</h3>
            <a href="{{ route('customer.requests.show', $activeRequest->id) }}" class="md-btn md-btn-text">
                View Details
            </a>
        </div>
    </div>
    <div class="p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center">
            <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full mb-4 md:mb-0 md:mr-6">
                <span class="material-icons text-primary-600 dark:text-primary-300">local_shipping</span>
            </div>
            
            <div class="flex-1">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                    <div>
                        <h4 class="text-xl font-medium text-on-surface-high">{{ $activeRequest->service_type }}</h4>
                        <p class="text-on-surface-medium">Request #{{ $activeRequest->id }} • {{ \Carbon\Carbon::parse($activeRequest->created_at)->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <span class="md-chip md-chip-primary">{{ $activeRequest->status }}</span>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-on-surface-medium">Location</p>
                        <p class="font-medium text-on-surface-high">{{ $activeRequest->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-on-surface-medium">Vehicle</p>
                        <p class="font-medium text-on-surface-high">{{ $activeRequest->vehicle_make }} {{ $activeRequest->vehicle_model }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-on-surface-medium">Provider</p>
                        <p class="font-medium text-on-surface-high">{{ $activeRequest->provider_name ?? 'Assigning...' }}</p>
                    </div>
                </div>
                
                <!-- Progress Stepper -->
                <div class="md-stepper horizontal">
                    <div class="md-stepper-items">
                        <div class="md-stepper-item {{ in_array($activeRequest->status, ['Requested', 'Assigned', 'En Route', 'Arrived', 'Completed']) ? 'completed' : '' }}">
                            <div class="md-stepper-circle">
                                <span class="material-icons">check</span>
                            </div>
                            <div class="md-stepper-label">Requested</div>
                        </div>
                        <div class="md-stepper-line"></div>
                        
                        <div class="md-stepper-item {{ in_array($activeRequest->status, ['Assigned', 'En Route', 'Arrived', 'Completed']) ? 'completed' : '' }}">
                            <div class="md-stepper-circle">
                                <span class="material-icons">check</span>
                            </div>
                            <div class="md-stepper-label">Assigned</div>
                        </div>
                        <div class="md-stepper-line"></div>
                        
                        <div class="md-stepper-item {{ in_array($activeRequest->status, ['En Route', 'Arrived', 'Completed']) ? 'completed' : '' }}">
                            <div class="md-stepper-circle">
                                <span class="material-icons">check</span>
                            </div>
                            <div class="md-stepper-label">En Route</div>
                        </div>
                        <div class="md-stepper-line"></div>
                        
                        <div class="md-stepper-item {{ in_array($activeRequest->status, ['Arrived', 'Completed']) ? 'completed' : '' }}">
                            <div class="md-stepper-circle">
                                <span class="material-icons">check</span>
                            </div>
                            <div class="md-stepper-label">Arrived</div>
                        </div>
                        <div class="md-stepper-line"></div>
                        
                        <div class="md-stepper-item {{ $activeRequest->status === 'Completed' ? 'completed' : '' }}">
                            <div class="md-stepper-circle">
                                <span class="material-icons">check</span>
                            </div>
                            <div class="md-stepper-label">Completed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
            <button class="md-btn md-btn-outlined" data-tooltip="Call Provider">
                <span class="material-icons mr-2">call</span>
                Call
            </button>
            <button class="md-btn md-btn-outlined" data-tooltip="Message Provider">
                <span class="material-icons mr-2">message</span>
                Message
            </button>
            <button class="md-btn md-btn-outlined" data-tooltip="Share Location">
                <span class="material-icons mr-2">share_location</span>
                Share Location
            </button>
            <button class="md-btn md-btn-outlined md-btn-error" data-tooltip="Cancel Request">
                <span class="material-icons mr-2">cancel</span>
                Cancel
            </button>
        </div>
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Recent Service Requests -->
    <div class="md-card md-card-elevated lg:col-span-2">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-on-surface-high">Recent Service Requests</h3>
                <a href="{{ route('customer.requests.index') }}" class="md-btn md-btn-text">
                    View All
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="md-table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Provider</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentRequests as $request)
                    <tr>
                        <td>#{{ $request->id }}</td>
                        <td>
                            <div class="flex items-center">
                                <span class="material-icons text-neutral-500 mr-2">{{ $request->service_icon }}</span>
                                <span>{{ $request->service_type }}</span>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}</td>
                        <td>
                            @if($request->provider_name)
                                <div class="flex items-center">
                                    <img src="{{ asset('images/avatar.jpg') }}" alt="Provider" class="h-6 w-6 rounded-full mr-2">
                                    <span>{{ $request->provider_name }}</span>
                                </div>
                            @else
                                <span class="text-neutral-500">-</span>
                            @endif
                        </td>
                        <td>
                            @if($request->status === 'Completed')
                                <span class="md-chip md-chip-success">Completed</span>
                            @elseif($request->status === 'Cancelled')
                                <span class="md-chip md-chip-error">Cancelled</span>
                            @elseif($request->status === 'En Route')
                                <span class="md-chip md-chip-warning">En Route</span>
                            @elseif($request->status === 'Assigned')
                                <span class="md-chip md-chip-info">Assigned</span>
                            @else
                                <span class="md-chip md-chip-primary">{{ $request->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('customer.requests.show', $request->id) }}" class="text-primary-600 hover:text-primary-800" data-tooltip="View Details">
                                    <span class="material-icons">visibility</span>
                                </a>
                                @if($request->status === 'Completed')
                                <a href="{{ route('customer.reviews.create', $request->id) }}" class="text-warning-600 hover:text-warning-800" data-tooltip="Leave Review">
                                    <span class="material-icons">star_rate</span>
                                </a>
                                @endif
                                <button type="button" class="text-neutral-600 hover:text-neutral-800" data-tooltip="More Options">
                                    <span class="material-icons">more_vert</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Subscription Details -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-on-surface-high">Subscription</h3>
        </div>
        
        @if($subscription)
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-xl font-medium text-on-surface-high">{{ $subscription->plan_name }}</h4>
                    <p class="text-on-surface-medium">{{ $subscription->description }}</p>
                </div>
                <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full">
                    <span class="material-icons text-primary-600 dark:text-primary-300">card_membership</span>
                </div>
            </div>
            
            <div class="space-y-4 mb-6">
                <div class="flex items-center justify-between">
                    <span class="text-on-surface-medium">Status</span>
                    <span class="md-chip md-chip-success">Active</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-on-surface-medium">Renewal Date</span>
                    <span class="text-on-surface-high font-medium">{{ \Carbon\Carbon::parse($subscription->renewal_date)->format('M d, Y') }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-on-surface-medium">Services Remaining</span>
                    <span class="text-on-surface-high font-medium">{{ $subscription->services_remaining }} / {{ $subscription->services_total }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-on-surface-medium">Monthly Fee</span>
                    <span class="text-on-surface-high font-medium">${{ number_format($subscription->monthly_fee, 2) }}</span>
                </div>
            </div>
            
            <div class="pt-4 border-t border-neutral-200 dark:border-neutral-700">
                <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                    <a href="{{ route('customer.subscriptions.show', $subscription->id) }}" class="md-btn md-btn-outlined">View Details</a>
                    <a href="{{ route('customer.subscriptions.upgrade') }}" class="md-btn md-btn-filled">Upgrade Plan</a>
                </div>
            </div>
        </div>
        @else
        <div class="p-6 flex flex-col items-center justify-center text-center">
            <span class="material-icons text-4xl text-neutral-400 dark:text-neutral-600 mb-2">card_membership</span>
            <h4 class="text-lg font-medium text-on-surface-high mb-2">No Active Subscription</h4>
            <p class="text-on-surface-medium mb-6">Subscribe to a plan to get priority service and discounted rates</p>
            <a href="{{ route('customer.subscriptions.plans') }}" class="md-btn md-btn-filled">View Plans</a>
        </div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- My Vehicles -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-on-surface-high">My Vehicles</h3>
                <a href="{{ route('customer.vehicles.create') }}" class="md-btn md-btn-text">
                    Add Vehicle
                </a>
            </div>
        </div>
        
        @if(count($vehicles) > 0)
        <div class="p-6">
            <div class="space-y-4">
                @foreach($vehicles as $vehicle)
                <div class="flex items-center p-3 border border-neutral-200 dark:border-neutral-700 rounded-lg hover:bg-surface-2 transition-colors">
                    <div class="bg-neutral-100 dark:bg-neutral-800 p-3 rounded-full mr-4">
                        <span class="material-icons text-neutral-600 dark:text-neutral-400">directions_car</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-on-surface-high">{{ $vehicle->make }} {{ $vehicle->model }}</h4>
                        <p class="text-sm text-on-surface-medium">{{ $vehicle->year }} • {{ $vehicle->license_plate }}</p>
                    </div>
                    <a href="{{ route('customer.vehicles.edit', $vehicle->id) }}" class="text-primary-600 hover:text-primary-800" data-tooltip="Edit Vehicle">
                        <span class="material-icons">edit</span>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="p-6 flex flex-col items-center justify-center text-center">
            <span class="material-icons text-4xl text-neutral-400 dark:text-neutral-600 mb-2">directions_car</span>
            <h4 class="text-lg font-medium text-on-surface-high mb-2">No Vehicles Added</h4>
            <p class="text-on-surface-medium mb-6">Add your vehicles to speed up the request process</p>
            <a href="{{ route('customer.vehicles.create') }}" class="md-btn md-btn-outlined">Add Vehicle</a>
        </div>
        @endif
    </div>
    
    <!-- Emergency Contacts -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-on-surface-high">Emergency Contacts</h3>
                <a href="{{ route('customer.contacts.create') }}" class="md-btn md-btn-text">
                    Add Contact
                </a>
            </div>
        </div>
        
        @if(count($contacts) > 0)
        <div class="p-6">
            <div class="space-y-4">
                @foreach($contacts as $contact)
                <div class="flex items-center p-3 border border-neutral-200 dark:border-neutral-700 rounded-lg hover:bg-surface-2 transition-colors">
                    <div class="bg-neutral-100 dark:bg-neutral-800 p-3 rounded-full mr-4">
                        <span class="material-icons text-neutral-600 dark:text-neutral-400">person</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-on-surface-high">{{ $contact->name }}</h4>
                        <p class="text-sm text-on-surface-medium">{{ $contact->phone }}</p>
                        <p class="text-xs text-on-surface-medium">{{ $contact->relationship }}</p>
                    </div>
                    <button type="button" class="text-primary-600 hover:text-primary-800 mr-2" data-tooltip="Call Contact">
                        <span class="material-icons">call</span>
                    </button>
                    <a href="{{ route('customer.contacts.edit', $contact->id) }}" class="text-primary-600 hover:text-primary-800" data-tooltip="Edit Contact">
                        <span class="material-icons">edit</span>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="p-6 flex flex-col items-center justify-center text-center">
            <span class="material-icons text-4xl text-neutral-400 dark:text-neutral-600 mb-2">contacts</span>
            <h4 class="text-lg font-medium text-on-surface-high mb-2">No Emergency Contacts</h4>
            <p class="text-on-surface-medium mb-6">Add contacts to notify in case of emergency</p>
            <a href="{{ route('customer.contacts.create') }}" class="md-btn md-btn-outlined">Add Contact</a>
        </div>
        @endif
    </div>
    
    <!-- Quick Tips -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-on-surface-high">Roadside Tips</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-2 rounded-full mr-3 mt-1">
                        <span class="material-icons text-primary-600 dark:text-primary-300 text-sm">lightbulb</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-on-surface-high">Flat Tire Safety</h4>
                        <p class="text-sm text-on-surface-medium">Pull over to a safe location away from traffic before attempting to change a flat tire.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-2 rounded-full mr-3 mt-1">
                        <span class="material-icons text-primary-600 dark:text-primary-300 text-sm">lightbulb</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-on-surface-high">Battery Maintenance</h4>
                        <p class="text-sm text-on-surface-medium">Check your battery terminals regularly for corrosion and clean them with a wire brush if needed.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-2 rounded-full mr-3 mt-1">
                        <span class="material-icons text-primary-600 dark:text-primary-300 text-sm">lightbulb</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-on-surface-high">Emergency Kit</h4>
                        <p class="text-sm text-on-surface-medium">Keep an emergency kit in your vehicle with flashlights, first aid supplies, and non-perishable food.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                <a href="{{ route('customer.tips') }}" class="md-btn md-btn-outlined w-full">View All Tips</a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action FAB -->
<div class="fixed bottom-6 right-6">
    <a href="{{ route('customer.requests.create') }}" class="md-fab" aria-label="New request" data-tooltip="New request">
        <span class="material-icons">add</span>
    </a>
</div>

@endsection
