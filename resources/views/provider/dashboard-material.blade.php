@extends('layouts.material')

@section('title', 'Provider Dashboard')
@section('page_title', 'Provider Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Active Requests Card -->
    <div class="md-card md-card-elevated p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Active Requests</p>
                <h3 class="text-2xl font-semibold mt-1">{{ $activeRequests }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>{{ $activeRequestsChange }}% from last week</span>
                </p>
            </div>
            <div class="bg-primary-100 p-3 rounded-full">
                <span class="material-icons text-primary-600">assignment</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200">
            <a href="{{ route('provider.requests') }}" class="text-primary-600 text-sm font-medium flex items-center">
                View all requests
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Completed Requests Card -->
    <div class="md-card md-card-elevated p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Completed Requests</p>
                <h3 class="text-2xl font-semibold mt-1">{{ $completedRequests }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>{{ $completedRequestsChange }}% from last month</span>
                </p>
            </div>
            <div class="bg-success-100 p-3 rounded-full">
                <span class="material-icons text-success-600">check_circle</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200">
            <a href="{{ route('provider.requests', ['status' => 'completed']) }}" class="text-primary-600 text-sm font-medium flex items-center">
                View completed requests
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Earnings Card -->
    <div class="md-card md-card-elevated p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Earnings</p>
                <h3 class="text-2xl font-semibold mt-1">${{ number_format($totalEarnings, 2) }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>{{ $earningsChange }}% from last month</span>
                </p>
            </div>
            <div class="bg-warning-100 p-3 rounded-full">
                <span class="material-icons text-warning-600">account_balance_wallet</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200">
            <a href="{{ route('provider.earnings') }}" class="text-primary-600 text-sm font-medium flex items-center">
                View earnings details
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Rating Card -->
    <div class="md-card md-card-elevated p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Average Rating</p>
                <h3 class="text-2xl font-semibold mt-1">{{ number_format($averageRating, 1) }} <span class="text-sm text-on-surface-medium">/ 5</span></h3>
                <p class="flex items-center mt-2 text-sm">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $averageRating)
                            <span class="material-icons text-warning-500">star</span>
                        @elseif ($i - 0.5 <= $averageRating)
                            <span class="material-icons text-warning-500">star_half</span>
                        @else
                            <span class="material-icons text-neutral-300">star_outline</span>
                        @endif
                    @endfor
                    <span class="ml-1 text-on-surface-medium">({{ $totalReviews }})</span>
                </p>
            </div>
            <div class="bg-secondary-100 p-3 rounded-full">
                <span class="material-icons text-secondary-600">star</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200">
            <a href="{{ route('provider.reviews') }}" class="text-primary-600 text-sm font-medium flex items-center">
                View all reviews
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Earnings Chart -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium">Monthly Earnings</h3>
                <div class="flex items-center">
                    <button class="md-btn md-btn-text text-xs">
                        <span class="material-icons text-sm mr-1">file_download</span>
                        Export
                    </button>
                    <div class="relative ml-2">
                        <button id="earnings-time-dropdown" class="md-btn md-btn-text text-xs">
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
                <canvas id="earningsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Request Status Chart -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium">Request Status</h3>
                <div class="flex items-center">
                    <button class="md-btn md-btn-text text-xs">
                        <span class="material-icons text-sm mr-1">file_download</span>
                        Export
                    </button>
                    <div class="relative ml-2">
                        <button id="status-time-dropdown" class="md-btn md-btn-text text-xs">
                            <span class="material-icons text-sm mr-1">date_range</span>
                            This Month
                            <span class="material-icons text-sm ml-1">arrow_drop_down</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="h-80">
                <canvas id="requestStatusChart"></canvas>
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
                <a href="{{ route('provider.requests') }}" class="md-btn md-btn-text">
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Service Type</th>
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
                            {{ $request->customer->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $request->service->name }}
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
                            <a href="{{ route('provider.requests.view', $request->id) }}" class="text-primary-600 hover:text-primary-900">View</a>
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

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Earnings Chart
        const earningsCtx = document.getElementById('earningsChart').getContext('2d');
        new Chart(earningsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($earningsChartLabels) !!},
                datasets: [{
                    label: 'Monthly Earnings',
                    data: {!! json_encode($earningsChartData) !!},
                    backgroundColor: 'rgba(30, 136, 229, 0.1)',
                    borderColor: 'rgba(30, 136, 229, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '$' + context.raw;
                            }
                        }
                    }
                }
            }
        });

        // Request Status Chart
        const statusCtx = document.getElementById('requestStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Accepted', 'In Progress', 'Completed', 'Cancelled'],
                datasets: [{
                    data: {!! json_encode($requestStatusChartData) !!},
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(33, 150, 243, 0.8)',
                        'rgba(156, 39, 176, 0.8)',
                        'rgba(76, 175, 80, 0.8)',
                        'rgba(244, 67, 54, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 193, 7, 1)',
                        'rgba(33, 150, 243, 1)',
                        'rgba(156, 39, 176, 1)',
                        'rgba(76, 175, 80, 1)',
                        'rgba(244, 67, 54, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endpush
