@extends('layouts.provider-material')

@section('title', 'Provider Dashboard')
@section('page-heading', 'Provider Dashboard')
@section('page-subheading', 'Overview of your service requests, earnings, and performance')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Requests Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Requests</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $totalRequests }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>12% increase</span>
                </p>
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
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>8% increase</span>
                </p>
            </div>
            <div class="bg-success-50 dark:bg-success-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-success-600 dark:text-success-300">check_circle</span>
            </div>
        </div>
    </div>

    <!-- Earnings Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Earnings</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">${{ number_format($totalEarnings, 2) }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>15% increase</span>
                </p>
            </div>
            <div class="bg-secondary-100 dark:bg-secondary-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-secondary-600 dark:text-secondary-300">payments</span>
            </div>
        </div>
    </div>

    <!-- Rating Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Rating</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ number_format($averageRating, 1) }}</h3>
                <div class="flex items-center mt-2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($averageRating))
                            <span class="material-icons text-warning-500 text-sm">star</span>
                        @elseif ($i - 0.5 <= $averageRating)
                            <span class="material-icons text-warning-500 text-sm">star_half</span>
                        @else
                            <span class="material-icons text-neutral-300 dark:text-neutral-600 text-sm">star</span>
                        @endif
                    @endfor
                    <span class="text-xs text-on-surface-medium ml-1">({{ $totalReviews }})</span>
                </div>
            </div>
            <div class="bg-warning-50 dark:bg-warning-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-warning-600 dark:text-warning-300">star</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Monthly Earnings Chart -->
    <div class="md-card md-card-elevated lg:col-span-2">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-on-surface-high">Monthly Earnings</h3>
                <div class="flex items-center">
                    <button class="md-btn md-btn-text text-xs">
                        <span class="material-icons text-sm mr-1">file_download</span>
                        Export
                    </button>
                    <div class="relative ml-2" x-data="{ open: false }">
                        <button @click="open = !open" class="md-btn md-btn-text text-xs">
                            <span class="material-icons text-sm mr-1">date_range</span>
                            This Year
                            <span class="material-icons text-sm ml-1">arrow_drop_down</span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-40 bg-surface-1 rounded-md shadow-md z-10">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-on-surface-high hover:bg-surface-3">This Month</a>
                                <a href="#" class="block px-4 py-2 text-sm text-on-surface-high hover:bg-surface-3">This Quarter</a>
                                <a href="#" class="block px-4 py-2 text-sm text-on-surface-high hover:bg-surface-3">This Year</a>
                                <a href="#" class="block px-4 py-2 text-sm text-on-surface-high hover:bg-surface-3">Last Year</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="h-80">
                <canvas id="earningsChart" class="md-chart" data-chart-type="bar"></canvas>
            </div>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-on-surface-high">Today's Schedule</h3>
                <a href="{{ route('provider.schedule') }}" class="md-btn md-btn-text text-xs">
                    View Calendar
                </a>
            </div>
        </div>
        <div class="p-6">
            @if(count($todayAppointments) > 0)
                <div class="space-y-4">
                    @foreach($todayAppointments as $appointment)
                    <div class="flex items-start space-x-4">
                        <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-2 rounded-md text-center min-w-[60px]">
                            <p class="text-primary-600 dark:text-primary-300 text-sm font-medium">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-on-surface-high">{{ $appointment->service_type }}</p>
                            <p class="text-sm text-on-surface-medium">{{ $appointment->location }}</p>
                            <div class="flex items-center mt-1">
                                <img src="{{ asset('images/avatar.jpg') }}" alt="Customer" class="h-5 w-5 rounded-full mr-2">
                                <span class="text-xs text-on-surface-medium">{{ $appointment->customer_name }}</span>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('provider.requests.show', $appointment->id) }}" class="text-primary-600 hover:text-primary-800" data-tooltip="View Details">
                                <span class="material-icons">visibility</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-6 text-center">
                    <span class="material-icons text-4xl text-neutral-400 dark:text-neutral-600 mb-2">event_busy</span>
                    <p class="text-on-surface-medium">No appointments scheduled for today</p>
                    <a href="{{ route('provider.schedule') }}" class="md-btn md-btn-outlined mt-4">Check Your Schedule</a>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 mb-6">
    <!-- Pending Service Requests -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-on-surface-high">Pending Service Requests</h3>
                <a href="{{ route('provider.requests.index') }}" class="md-btn md-btn-text">
                    View All
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="md-table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Location</th>
                        <th>Requested Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingRequests as $request)
                    <tr>
                        <td>#{{ $request->id }}</td>
                        <td>
                            <div class="flex items-center">
                                <img src="{{ asset('images/avatar.jpg') }}" alt="User Avatar" class="h-8 w-8 rounded-full mr-3">
                                <div>
                                    <p class="font-medium text-on-surface-high">{{ $request->customer_name }}</p>
                                    <p class="text-xs text-on-surface-medium">{{ $request->customer_phone }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $request->service_type }}</td>
                        <td>{{ $request->location }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->requested_time)->format('M d, Y h:i A') }}</td>
                        <td>
                            <span class="md-chip md-chip-warning">Pending</span>
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('provider.requests.show', $request->id) }}" class="text-primary-600 hover:text-primary-800" data-tooltip="View Details">
                                    <span class="material-icons">visibility</span>
                                </a>
                                <button type="button" class="text-success-600 hover:text-success-800" data-tooltip="Accept Request">
                                    <span class="material-icons">check_circle</span>
                                </button>
                                <button type="button" class="text-error-600 hover:text-error-800" data-tooltip="Decline Request">
                                    <span class="material-icons">cancel</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Recent Activity -->
    <div class="md-card md-card-elevated lg:col-span-2">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-on-surface-high">Recent Activity</h3>
        </div>
        <div class="p-6">
            <div class="relative">
                <!-- Timeline line -->
                <div class="absolute top-0 left-4 bottom-0 w-0.5 bg-neutral-200 dark:bg-neutral-700"></div>
                
                <div class="space-y-6">
                    @foreach($recentActivities as $activity)
                    <div class="flex items-start relative">
                        <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-2 rounded-full z-10 mr-4">
                            <span class="material-icons text-primary-600 dark:text-primary-300 text-sm">{{ $activity->icon }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-on-surface-high">{{ $activity->title }}</p>
                            <p class="text-sm text-on-surface-medium">{{ $activity->description }}</p>
                            <p class="text-xs text-on-surface-medium mt-1">{{ \Carbon\Carbon::parse($activity->time)->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-on-surface-high">Performance Metrics</h3>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                <!-- Acceptance Rate -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-on-surface-high">Acceptance Rate</p>
                        <p class="text-sm font-medium text-on-surface-high">{{ $acceptanceRate }}%</p>
                    </div>
                    <div class="h-2 bg-neutral-200 dark:bg-neutral-700 rounded-full overflow-hidden">
                        <div class="h-full bg-primary-600 rounded-full" style="width: {{ $acceptanceRate }}%"></div>
                    </div>
                </div>
                
                <!-- Completion Rate -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-on-surface-high">Completion Rate</p>
                        <p class="text-sm font-medium text-on-surface-high">{{ $completionRate }}%</p>
                    </div>
                    <div class="h-2 bg-neutral-200 dark:bg-neutral-700 rounded-full overflow-hidden">
                        <div class="h-full bg-success-500 rounded-full" style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>
                
                <!-- On-Time Arrival -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-on-surface-high">On-Time Arrival</p>
                        <p class="text-sm font-medium text-on-surface-high">{{ $onTimeRate }}%</p>
                    </div>
                    <div class="h-2 bg-neutral-200 dark:bg-neutral-700 rounded-full overflow-hidden">
                        <div class="h-full bg-secondary-500 rounded-full" style="width: {{ $onTimeRate }}%"></div>
                    </div>
                </div>
                
                <!-- Customer Satisfaction -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-on-surface-high">Customer Satisfaction</p>
                        <p class="text-sm font-medium text-on-surface-high">{{ $satisfactionRate }}%</p>
                    </div>
                    <div class="h-2 bg-neutral-200 dark:bg-neutral-700 rounded-full overflow-hidden">
                        <div class="h-full bg-warning-500 rounded-full" style="width: {{ $satisfactionRate }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <a href="{{ route('provider.performance') }}" class="md-btn md-btn-outlined w-full">View Detailed Performance</a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action FAB -->
<div class="fixed bottom-6 right-6">
    <button class="md-fab" aria-label="Quick actions" data-tooltip="Quick actions">
        <span class="material-icons">add</span>
    </button>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Earnings Chart
        const earningsCtx = document.getElementById('earningsChart').getContext('2d');
        new Chart(earningsCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Earnings',
                    data: [1200, 1500, 1800, 1600, 2100, 2400, 2800, 3000, 2700, 3200, 3500, 3800],
                    backgroundColor: 'rgba(33, 150, 243, 0.8)',
                    borderColor: 'rgba(33, 150, 243, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#333',
                        bodyColor: '#666',
                        borderColor: 'rgba(200, 200, 200, 0.5)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return '$ ' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$ ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
