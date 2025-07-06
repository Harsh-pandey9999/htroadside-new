@extends('layouts.material')

@section('title', 'Customer Dashboard')
@section('page_title', 'Customer Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Active Requests Card -->
    <div class="md-card md-card-elevated p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Active Requests</p>
                <h3 class="text-2xl font-semibold mt-1">{{ $activeRequests }}</h3>
                <p class="flex items-center mt-2 text-sm {{ $activeRequestsChange >= 0 ? 'text-success-500' : 'text-error-500' }}">
                    <span class="material-icons text-sm mr-1">{{ $activeRequestsChange >= 0 ? 'trending_up' : 'trending_down' }}</span>
                    <span>{{ abs($activeRequestsChange) }}% from last month</span>
                </p>
            </div>
            <div class="bg-primary-100 p-3 rounded-full">
                <span class="material-icons text-primary-600">directions_car</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200">
            <a href="{{ route('customer.service-history', ['status' => 'active']) }}" class="text-primary-600 text-sm font-medium flex items-center">
                View active requests
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Completed Requests Card -->
    <div class="md-card md-card-elevated p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Completed Services</p>
                <h3 class="text-2xl font-semibold mt-1">{{ $completedRequests }}</h3>
                <p class="flex items-center mt-2 text-sm {{ $completedRequestsChange >= 0 ? 'text-success-500' : 'text-error-500' }}">
                    <span class="material-icons text-sm mr-1">{{ $completedRequestsChange >= 0 ? 'trending_up' : 'trending_down' }}</span>
                    <span>{{ abs($completedRequestsChange) }}% from last month</span>
                </p>
            </div>
            <div class="bg-success-100 p-3 rounded-full">
                <span class="material-icons text-success-600">check_circle</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200">
            <a href="{{ route('customer.service-history', ['status' => 'completed']) }}" class="text-primary-600 text-sm font-medium flex items-center">
                View service history
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Total Spent Card -->
    <div class="md-card md-card-elevated p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Spent</p>
                <h3 class="text-2xl font-semibold mt-1">${{ number_format($totalSpent, 2) }}</h3>
                <p class="flex items-center mt-2 text-sm {{ $spentChange >= 0 ? 'text-success-500' : 'text-error-500' }}">
                    <span class="material-icons text-sm mr-1">{{ $spentChange >= 0 ? 'trending_up' : 'trending_down' }}</span>
                    <span>{{ abs($spentChange) }}% from last month</span>
                </p>
            </div>
            <div class="bg-warning-100 p-3 rounded-full">
                <span class="material-icons text-warning-600">account_balance_wallet</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200">
            <a href="{{ route('customer.payments') }}" class="text-primary-600 text-sm font-medium flex items-center">
                View payment history
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Subscription Card -->
    <div class="md-card md-card-elevated p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Subscription Status</p>
                @if($hasActiveSubscription)
                <h3 class="text-2xl font-semibold mt-1">Active</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">verified</span>
                    <span>{{ $subscriptionName }}</span>
                </p>
                @else
                <h3 class="text-2xl font-semibold mt-1">Inactive</h3>
                <p class="text-error-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">info</span>
                    <span>No active subscription</span>
                </p>
                @endif
            </div>
            <div class="bg-secondary-100 p-3 rounded-full">
                <span class="material-icons text-secondary-600">card_membership</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200">
            <a href="{{ route('customer.subscriptions') }}" class="text-primary-600 text-sm font-medium flex items-center">
                Manage subscription
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Quick Actions Card -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200">
            <h3 class="text-lg font-medium">Quick Actions</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('customer.request-service') }}" class="md-card p-4 hover:bg-surface-2 transition-colors flex items-center">
                <div class="bg-primary-100 p-3 rounded-full mr-4">
                    <span class="material-icons text-primary-600">add_circle</span>
                </div>
                <div>
                    <h4 class="font-medium">Request Service</h4>
                    <p class="text-sm text-on-surface-medium">Get roadside assistance</p>
                </div>
            </a>
            <a href="{{ route('customer.payment-methods') }}" class="md-card p-4 hover:bg-surface-2 transition-colors flex items-center">
                <div class="bg-secondary-100 p-3 rounded-full mr-4">
                    <span class="material-icons text-secondary-600">credit_card</span>
                </div>
                <div>
                    <h4 class="font-medium">Payment Methods</h4>
                    <p class="text-sm text-on-surface-medium">Manage your cards</p>
                </div>
            </a>
            <a href="{{ route('customer.profile') }}" class="md-card p-4 hover:bg-surface-2 transition-colors flex items-center">
                <div class="bg-success-100 p-3 rounded-full mr-4">
                    <span class="material-icons text-success-600">person</span>
                </div>
                <div>
                    <h4 class="font-medium">Profile</h4>
                    <p class="text-sm text-on-surface-medium">Update your information</p>
                </div>
            </a>
            <a href="{{ route('customer.vehicles') }}" class="md-card p-4 hover:bg-surface-2 transition-colors flex items-center">
                <div class="bg-warning-100 p-3 rounded-full mr-4">
                    <span class="material-icons text-warning-600">directions_car</span>
                </div>
                <div>
                    <h4 class="font-medium">Vehicles</h4>
                    <p class="text-sm text-on-surface-medium">Manage your vehicles</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Service Usage Chart -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium">Service Usage</h3>
                <div class="flex items-center">
                    <div class="relative">
                        <button id="usage-time-dropdown" class="md-btn md-btn-text text-xs">
                            <span class="material-icons text-sm mr-1">date_range</span>
                            This Year
                            <span class="material-icons text-sm ml-1">arrow_drop_down</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="h-80">
                <canvas id="serviceUsageChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 mb-6">
    <!-- Recent Requests Table -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium">Recent Service Requests</h3>
                <a href="{{ route('customer.service-history') }}" class="md-btn md-btn-text">
                    View All
                    <span class="material-icons text-sm ml-1">arrow_forward</span>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Request ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Service Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Provider</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Location</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @forelse($recentRequests as $request)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            #{{ $request->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $request->service->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $request->provider ? $request->provider->name : 'Not Assigned' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ Str::limit($request->location, 30) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($request->status == 'pending')
                                <span class="md-chip md-chip-warning">Pending</span>
                            @elseif($request->status == 'accepted')
                                <span class="md-chip md-chip-info">Accepted</span>
                            @elseif($request->status == 'in_progress')
                                <span class="md-chip md-chip-primary">In Progress</span>
                            @elseif($request->status == 'completed')
                                <span class="md-chip md-chip-success">Completed</span>
                            @elseif($request->status == 'cancelled')
                                <span class="md-chip md-chip-error">Cancelled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $request->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('customer.service-details', $request->id) }}" class="text-primary-600 hover:text-primary-900">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-neutral-500">
                            No recent requests found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(!$hasActiveSubscription)
<div class="grid grid-cols-1 gap-6 mb-6">
    <!-- Subscription Plans -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200">
            <h3 class="text-lg font-medium">Recommended Subscription Plans</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($subscriptionPlans as $plan)
                <div class="md-card md-card-elevated p-6 flex flex-col">
                    <div class="flex-1">
                        <h4 class="text-xl font-semibold">{{ $plan->name }}</h4>
                        <div class="mt-2 text-2xl font-bold">${{ number_format($plan->price, 2) }}<span class="text-sm font-normal text-neutral-500">/{{ $plan->billing_cycle }}</span></div>
                        <div class="mt-4">
                            <ul class="space-y-2">
                                @foreach($plan->features as $feature)
                                <li class="flex items-start">
                                    <span class="material-icons text-success-500 mr-2">check_circle</span>
                                    <span>{{ $feature }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('customer.subscribe', $plan->id) }}" class="md-btn md-btn-filled w-full">Subscribe Now</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Service Usage Chart
        const usageCtx = document.getElementById('serviceUsageChart').getContext('2d');
        new Chart(usageCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($serviceUsageLabels) !!},
                datasets: [{
                    label: 'Service Usage',
                    data: {!! json_encode($serviceUsageData) !!},
                    backgroundColor: [
                        'rgba(30, 136, 229, 0.8)',
                        'rgba(216, 27, 96, 0.8)',
                        'rgba(76, 175, 80, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(156, 39, 176, 0.8)'
                    ],
                    borderColor: [
                        'rgba(30, 136, 229, 1)',
                        'rgba(216, 27, 96, 1)',
                        'rgba(76, 175, 80, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(156, 39, 176, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush
