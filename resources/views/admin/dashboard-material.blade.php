@extends('admin.layouts.material')

@section('title', 'Admin Dashboard')
@section('page-heading', 'Admin Dashboard')
@section('page-subheading', 'Overview of platform performance and key metrics')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Users Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Users</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $totalUsers }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>12% increase</span>
                </p>
            </div>
            <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-primary-600 dark:text-primary-300">people</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
            <a href="{{ route('admin.users.index') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium flex items-center">
                View all users
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Service Providers Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Service Providers</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $totalProviders }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>8% increase</span>
                </p>
            </div>
            <div class="bg-secondary-100 dark:bg-secondary-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-secondary-600 dark:text-secondary-300">handyman</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
            <a href="{{ route('admin.providers.index') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium flex items-center">
                View all providers
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Services Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Services</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $totalServices }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>5% increase</span>
                </p>
            </div>
            <div class="bg-success-50 dark:bg-success-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-success-600 dark:text-success-300">build</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
            <a href="{{ route('admin.services.index') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium flex items-center">
                View all services
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Requests Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Service Requests</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $totalRequests }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>15% increase</span>
                </p>
            </div>
            <div class="bg-warning-50 dark:bg-warning-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-warning-600 dark:text-warning-300">assignment</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
            <a href="{{ route('admin.requests.index') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium flex items-center">
                View all requests
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Revenue Chart -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-on-surface-high">Monthly Revenue</h3>
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
                <canvas id="revenueChart" class="md-chart" data-chart-type="line"></canvas>
            </div>
        </div>
    </div>

    <!-- Request Status Chart -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-on-surface-high">Request Status</h3>
                <div class="flex items-center">
                    <button class="md-btn md-btn-text text-xs">
                        <span class="material-icons text-sm mr-1">file_download</span>
                        Export
                    </button>
                    <div class="relative ml-2" x-data="{ open: false }">
                        <button @click="open = !open" class="md-btn md-btn-text text-xs">
                            <span class="material-icons text-sm mr-1">date_range</span>
                            This Month
                            <span class="material-icons text-sm ml-1">arrow_drop_down</span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-40 bg-surface-1 rounded-md shadow-md z-10">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-on-surface-high hover:bg-surface-3">This Week</a>
                                <a href="#" class="block px-4 py-2 text-sm text-on-surface-high hover:bg-surface-3">This Month</a>
                                <a href="#" class="block px-4 py-2 text-sm text-on-surface-high hover:bg-surface-3">This Quarter</a>
                                <a href="#" class="block px-4 py-2 text-sm text-on-surface-high hover:bg-surface-3">This Year</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="h-80">
                <canvas id="requestStatusChart" class="md-chart" data-chart-type="doughnut"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Revenue Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Revenue</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">${{ number_format($totalRevenue, 2) }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>18% increase</span>
                </p>
            </div>
            <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-primary-600 dark:text-primary-300">attach_money</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
            <a href="{{ route('admin.payments.index') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium flex items-center">
                View revenue details
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Payments Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Total Payments</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $totalPayments }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>10% increase</span>
                </p>
            </div>
            <div class="bg-secondary-100 dark:bg-secondary-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-secondary-600 dark:text-secondary-300">payments</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
            <a href="{{ route('admin.payments.index') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium flex items-center">
                View all payments
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Applications Stats Card -->
    <div class="md-card p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-on-surface-medium text-sm font-medium">Job Applications</p>
                <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $totalApplications }}</h3>
                <p class="text-success-500 flex items-center mt-2 text-sm">
                    <span class="material-icons text-sm mr-1">trending_up</span>
                    <span>7% increase</span>
                </p>
            </div>
            <div class="bg-success-50 dark:bg-success-900 dark:bg-opacity-30 p-3 rounded-full">
                <span class="material-icons text-success-600 dark:text-success-300">work</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
            <a href="{{ route('admin.applications.index') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium flex items-center">
                View all applications
                <span class="material-icons text-sm ml-1">arrow_forward</span>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 mb-6">
    <!-- Pending Requests Table -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-on-surface-high">Pending Service Requests</h3>
                <a href="{{ route('admin.requests.index') }}" class="md-btn md-btn-text">
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
                        <th>Status</th>
                        <th>Created</th>
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
                                    <p class="font-medium text-on-surface-high">{{ $request->user->name }}</p>
                                    <p class="text-xs text-on-surface-medium">{{ $request->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $request->service->name }}</td>
                        <td>{{ $request->location }}</td>
                        <td>
                            <span class="md-chip md-chip-warning">Pending</span>
                        </td>
                        <td>{{ $request->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.requests.show', $request) }}" class="text-primary-600 hover:text-primary-800" data-tooltip="View Details">
                                    <span class="material-icons">visibility</span>
                                </a>
                                <a href="{{ route('admin.requests.edit', $request) }}" class="text-secondary-600 hover:text-secondary-800" data-tooltip="Edit Request">
                                    <span class="material-icons">edit</span>
                                </a>
                                <button type="button" class="text-error-600 hover:text-error-800" data-tooltip="Delete Request">
                                    <span class="material-icons">delete</span>
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

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: [12500, 15000, 17500, 16000, 19000, 21500, 25000, 26000, 24500, 28000, 30000, 32000],
                    backgroundColor: 'rgba(33, 150, 243, 0.1)',
                    borderColor: 'rgba(33, 150, 243, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
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

        // Request Status Chart
        const requestStatusCtx = document.getElementById('requestStatusChart').getContext('2d');
        new Chart(requestStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [65, 15, 12, 8],
                    backgroundColor: [
                        'rgba(76, 175, 80, 0.8)',
                        'rgba(33, 150, 243, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(244, 67, 54, 0.8)'
                    ],
                    borderColor: [
                        'rgba(76, 175, 80, 1)',
                        'rgba(33, 150, 243, 1)',
                        'rgba(255, 193, 7, 1)',
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
                        position: 'right',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
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
                                return context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush
