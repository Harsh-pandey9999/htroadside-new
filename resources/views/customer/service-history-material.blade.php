@extends('layouts.material')

@section('title', 'Service History')
@section('page_title', 'Service History')

@section('content')
<div class="md-card md-card-elevated mb-6">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-xl font-medium text-on-surface-high">Service Request History</h2>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('customer.service-history') }}" class="md-chip {{ !request('status') ? 'md-chip-filled' : 'md-chip-outlined' }}">
                    All
                </a>
                <a href="{{ route('customer.service-history', ['status' => 'active']) }}" class="md-chip {{ request('status') == 'active' ? 'md-chip-filled md-chip-primary' : 'md-chip-outlined' }}">
                    Active
                </a>
                <a href="{{ route('customer.service-history', ['status' => 'pending']) }}" class="md-chip {{ request('status') == 'pending' ? 'md-chip-filled md-chip-warning' : 'md-chip-outlined' }}">
                    Pending
                </a>
                <a href="{{ route('customer.service-history', ['status' => 'completed']) }}" class="md-chip {{ request('status') == 'completed' ? 'md-chip-filled md-chip-success' : 'md-chip-outlined' }}">
                    Completed
                </a>
                <a href="{{ route('customer.service-history', ['status' => 'cancelled']) }}" class="md-chip {{ request('status') == 'cancelled' ? 'md-chip-filled md-chip-error' : 'md-chip-outlined' }}">
                    Cancelled
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <form action="{{ route('customer.service-history') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="md-input-field flex-1">
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="md-input">
                <label for="search">Search by service type, location or provider</label>
            </div>
            
            <div class="md-input-field w-full md:w-48">
                <select id="date_range" name="date_range" class="md-select">
                    <option value="">All Time</option>
                    <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="year" {{ request('date_range') == 'year' ? 'selected' : '' }}>This Year</option>
                </select>
                <label for="date_range">Date Range</label>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="md-btn md-btn-filled">
                    <span class="material-icons mr-1">search</span>
                    Search
                </button>
                
                <a href="{{ route('customer.service-history') }}" class="md-btn md-btn-outlined">
                    <span class="material-icons mr-1">clear</span>
                    Clear
                </a>
            </div>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-surface-2 dark:bg-surface-2-dark">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Request ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Service Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Provider</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Location</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-on-surface-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-surface-1 dark:bg-surface-1-dark divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($requests as $request)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-on-surface-high">
                        #{{ $request->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-high">
                        {{ $request->service->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-high">
                        {{ $request->provider ? $request->provider->name : 'Not Assigned' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-high">
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-high">
                        {{ $request->created_at->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('customer.service-details', $request->id) }}" class="md-btn md-btn-icon md-btn-text" title="View Details">
                            <span class="material-icons">visibility</span>
                        </a>
                        
                        @if($request->status == 'pending')
                        <form action="{{ route('customer.cancel-request', $request->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="md-btn md-btn-icon md-btn-text text-error-500" title="Cancel Request" onclick="return confirm('Are you sure you want to cancel this request?')">
                                <span class="material-icons">cancel</span>
                            </button>
                        </form>
                        @endif
                        
                        @if($request->status == 'completed' && !$request->review)
                        <a href="{{ route('customer.add-review', $request->id) }}" class="md-btn md-btn-icon md-btn-text text-warning-500" title="Add Review">
                            <span class="material-icons">star</span>
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-sm text-on-surface-medium">
                        <div class="flex flex-col items-center py-6">
                            <span class="material-icons text-4xl text-on-surface-disabled mb-2">search_off</span>
                            <p class="text-on-surface-medium mb-4">No service requests found</p>
                            <a href="{{ route('customer.request-service') }}" class="md-btn md-btn-filled">Request New Service</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($requests->hasPages())
    <div class="p-6 border-t border-neutral-200 dark:border-neutral-700">
        <div class="md-pagination">
            {{ $requests->appends(request()->except('page'))->links() }}
        </div>
    </div>
    @endif
</div>

<div class="md-card md-card-elevated p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-medium text-on-surface-high">Service Usage Statistics</h2>
        
        <div class="md-input-field w-48">
            <select id="stats_period" class="md-select">
                <option value="month">This Month</option>
                <option value="quarter">This Quarter</option>
                <option value="year">This Year</option>
                <option value="all">All Time</option>
            </select>
            <label for="stats_period">Time Period</label>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="md-card p-4">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-on-surface-medium text-sm font-medium">Total Requests</p>
                    <h3 class="text-2xl font-semibold text-on-surface-high mt-1" id="stats-total">{{ $stats['total'] }}</h3>
                </div>
                <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full">
                    <span class="material-icons text-primary-600 dark:text-primary-300">assignment</span>
                </div>
            </div>
        </div>
        
        <div class="md-card p-4">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-on-surface-medium text-sm font-medium">Completed</p>
                    <h3 class="text-2xl font-semibold text-on-surface-high mt-1" id="stats-completed">{{ $stats['completed'] }}</h3>
                </div>
                <div class="bg-success-100 dark:bg-success-900 dark:bg-opacity-30 p-3 rounded-full">
                    <span class="material-icons text-success-600 dark:text-success-300">check_circle</span>
                </div>
            </div>
        </div>
        
        <div class="md-card p-4">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-on-surface-medium text-sm font-medium">Cancelled</p>
                    <h3 class="text-2xl font-semibold text-on-surface-high mt-1" id="stats-cancelled">{{ $stats['cancelled'] }}</h3>
                </div>
                <div class="bg-error-100 dark:bg-error-900 dark:bg-opacity-30 p-3 rounded-full">
                    <span class="material-icons text-error-600 dark:text-error-300">cancel</span>
                </div>
            </div>
        </div>
        
        <div class="md-card p-4">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-on-surface-medium text-sm font-medium">Average Rating</p>
                    <h3 class="text-2xl font-semibold text-on-surface-high mt-1" id="stats-rating">{{ number_format($stats['avg_rating'], 1) }}</h3>
                    <div class="flex items-center mt-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $stats['avg_rating'])
                                <span class="material-icons text-warning-500 text-sm">star</span>
                            @elseif($i - 0.5 <= $stats['avg_rating'])
                                <span class="material-icons text-warning-500 text-sm">star_half</span>
                            @else
                                <span class="material-icons text-neutral-300 text-sm">star_outline</span>
                            @endif
                        @endfor
                    </div>
                </div>
                <div class="bg-warning-100 dark:bg-warning-900 dark:bg-opacity-30 p-3 rounded-full">
                    <span class="material-icons text-warning-600 dark:text-warning-300">star</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md-card p-4">
            <h3 class="text-lg font-medium mb-4">Service Type Distribution</h3>
            <div class="h-64">
                <canvas id="serviceTypeChart"></canvas>
            </div>
        </div>
        
        <div class="md-card p-4">
            <h3 class="text-lg font-medium mb-4">Monthly Service Requests</h3>
            <div class="h-64">
                <canvas id="monthlyRequestsChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Service Type Distribution Chart
        const serviceTypeCtx = document.getElementById('serviceTypeChart').getContext('2d');
        const serviceTypeChart = new Chart(serviceTypeCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($serviceTypeStats['labels']) !!},
                datasets: [{
                    data: {!! json_encode($serviceTypeStats['data']) !!},
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
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12
                        }
                    }
                }
            }
        });
        
        // Monthly Requests Chart
        const monthlyRequestsCtx = document.getElementById('monthlyRequestsChart').getContext('2d');
        const monthlyRequestsChart = new Chart(monthlyRequestsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyStats['labels']) !!},
                datasets: [{
                    label: 'Service Requests',
                    data: {!! json_encode($monthlyStats['data']) !!},
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
        
        // Update stats based on selected period
        document.getElementById('stats_period').addEventListener('change', function() {
            const period = this.value;
            
            fetch(`{{ route('customer.service-stats') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    // Update stats
                    document.getElementById('stats-total').textContent = data.stats.total;
                    document.getElementById('stats-completed').textContent = data.stats.completed;
                    document.getElementById('stats-cancelled').textContent = data.stats.cancelled;
                    document.getElementById('stats-rating').textContent = data.stats.avg_rating.toFixed(1);
                    
                    // Update service type chart
                    serviceTypeChart.data.labels = data.serviceTypeStats.labels;
                    serviceTypeChart.data.datasets[0].data = data.serviceTypeStats.data;
                    serviceTypeChart.update();
                    
                    // Update monthly requests chart
                    monthlyRequestsChart.data.labels = data.monthlyStats.labels;
                    monthlyRequestsChart.data.datasets[0].data = data.monthlyStats.data;
                    monthlyRequestsChart.update();
                })
                .catch(error => {
                    console.error('Error fetching stats:', error);
                    showMaterialSnackbar('Error loading statistics', 'error');
                });
        });
    });
</script>
@endpush
