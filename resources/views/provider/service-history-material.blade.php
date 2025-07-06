@extends('layouts.material')

@section('title', 'Service History')
@section('page_title', 'Service History')

@section('content')
<div class="md-card md-card-elevated mb-6">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-xl font-medium text-on-surface-high">Service History</h2>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('provider.service-history') }}" class="md-chip {{ !request('status') ? 'md-chip-filled' : 'md-chip-outlined' }}">
                    All
                </a>
                <a href="{{ route('provider.service-history', ['status' => 'completed']) }}" class="md-chip {{ request('status') == 'completed' ? 'md-chip-filled md-chip-success' : 'md-chip-outlined' }}">
                    Completed
                </a>
                <a href="{{ route('provider.service-history', ['status' => 'cancelled']) }}" class="md-chip {{ request('status') == 'cancelled' ? 'md-chip-filled md-chip-error' : 'md-chip-outlined' }}">
                    Cancelled
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <form action="{{ route('provider.service-history') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="md-input-field flex-1">
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="md-input">
                <label for="search">Search by customer name, service type or location</label>
            </div>
            
            <div class="md-input-field w-full md:w-48">
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="md-input">
                <label for="date_from">From Date</label>
            </div>
            
            <div class="md-input-field w-full md:w-48">
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="md-input">
                <label for="date_to">To Date</label>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="md-btn md-btn-filled">
                    <span class="material-icons mr-1">search</span>
                    Search
                </button>
                
                <a href="{{ route('provider.service-history') }}" class="md-btn md-btn-outlined">
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Customer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Service Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Location</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Amount</th>
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
                        {{ $request->customer->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-high">
                        {{ $request->service->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-high">
                        {{ Str::limit($request->location, 30) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($request->status == 'completed')
                            <span class="md-chip md-chip-success">Completed</span>
                        @elseif($request->status == 'cancelled')
                            <span class="md-chip md-chip-error">Cancelled</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-high">
                        {{ $request->created_at->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-high">
                        ${{ number_format($request->total_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('provider.requests.view', $request->id) }}" class="md-btn md-btn-icon md-btn-text" title="View Details">
                            <span class="material-icons">visibility</span>
                        </a>
                        
                        @if($request->status == 'completed' && !$request->invoice)
                            <a href="{{ route('provider.generate-invoice', $request->id) }}" class="md-btn md-btn-icon md-btn-text text-primary-500" title="Generate Invoice">
                                <span class="material-icons">receipt</span>
                            </a>
                        @endif
                        
                        @if($request->invoice)
                            <a href="{{ route('provider.download-invoice', $request->id) }}" class="md-btn md-btn-icon md-btn-text text-primary-500" title="Download Invoice">
                                <span class="material-icons">download</span>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-sm text-on-surface-medium">
                        <div class="flex flex-col items-center py-6">
                            <span class="material-icons text-4xl text-on-surface-disabled mb-2">history</span>
                            <p class="text-on-surface-medium mb-4">No service history found</p>
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

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Service Statistics -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium text-on-surface-high">Service Statistics</h2>
                
                <div class="md-input-field w-48">
                    <select id="stats_period" class="md-select">
                        <option value="week">This Week</option>
                        <option value="month" selected>This Month</option>
                        <option value="quarter">This Quarter</option>
                        <option value="year">This Year</option>
                        <option value="all">All Time</option>
                    </select>
                    <label for="stats_period">Time Period</label>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="md-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface-medium text-sm font-medium">Completed Services</p>
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
                            <p class="text-on-surface-medium text-sm font-medium">Total Earnings</p>
                            <h3 class="text-2xl font-semibold text-on-surface-high mt-1" id="stats-earnings">${{ number_format($stats['earnings'], 2) }}</h3>
                        </div>
                        <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-primary-600 dark:text-primary-300">payments</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="h-64 mb-6">
                <canvas id="earningsChart"></canvas>
            </div>
            
            <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                <h3 class="text-sm font-medium text-on-surface-medium mb-2">Average Ratings</h3>
                
                <div class="flex items-center mb-2">
                    <div class="flex mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $stats['avg_rating'])
                                <span class="material-icons text-warning-500">star</span>
                            @elseif($i - 0.5 <= $stats['avg_rating'])
                                <span class="material-icons text-warning-500">star_half</span>
                            @else
                                <span class="material-icons text-neutral-300 dark:text-neutral-600">star_outline</span>
                            @endif
                        @endfor
                    </div>
                    <span class="text-on-surface-high font-medium">{{ number_format($stats['avg_rating'], 1) }}</span>
                </div>
                
                <p class="text-on-surface-medium text-sm">Based on {{ $stats['rating_count'] }} customer reviews</p>
            </div>
        </div>
    </div>
    
    <!-- Service Type Distribution -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-lg font-medium text-on-surface-high">Service Type Distribution</h2>
        </div>
        
        <div class="p-6">
            <div class="h-64 mb-6">
                <canvas id="serviceTypeChart"></canvas>
            </div>
            
            <div class="space-y-3">
                @foreach($serviceTypeStats as $stat)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-on-surface-high">{{ $stat['name'] }}</span>
                        <span class="text-sm text-on-surface-high">{{ $stat['count'] }} ({{ $stat['percentage'] }}%)</span>
                    </div>
                    <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2">
                        <div class="h-2 rounded-full" style="width: {{ $stat['percentage'] }}%; background-color: {{ $stat['color'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Customer Reviews -->
<div class="md-card md-card-elevated mb-6">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <h2 class="text-lg font-medium text-on-surface-high">Recent Customer Reviews</h2>
    </div>
    
    <div class="p-6">
        @if(count($reviews) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($reviews as $review)
                <div class="md-card p-4">
                    <div class="flex items-start mb-3">
                        <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-3">
                            @if($review->customer->profile_image)
                                <img src="{{ asset('storage/' . $review->customer->profile_image) }}" alt="{{ $review->customer->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <span class="material-icons text-primary-500 dark:text-primary-400">person</span>
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="font-medium text-on-surface-high">{{ $review->customer->name }}</h3>
                            <p class="text-on-surface-medium text-xs">{{ $review->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <span class="material-icons text-warning-500">star</span>
                            @else
                                <span class="material-icons text-neutral-300 dark:text-neutral-600">star_outline</span>
                            @endif
                        @endfor
                    </div>
                    
                    <p class="text-on-surface-high mb-2">{{ $review->comment }}</p>
                    
                    <div class="flex justify-between items-center text-xs text-on-surface-medium">
                        <span>Service: {{ $review->request->service->name }}</span>
                        <a href="{{ route('provider.requests.view', $review->request_id) }}" class="text-primary-600 dark:text-primary-400">View Service Details</a>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if(count($reviews) > 6)
                <div class="mt-6 text-center">
                    <a href="{{ route('provider.reviews') }}" class="md-btn md-btn-outlined">
                        View All Reviews
                    </a>
                </div>
            @endif
        @else
            <div class="flex flex-col items-center py-6">
                <span class="material-icons text-4xl text-on-surface-disabled mb-2">rate_review</span>
                <p class="text-on-surface-medium mb-4">No customer reviews yet</p>
                <p class="text-on-surface-medium text-sm text-center max-w-md">Complete more service requests to receive customer reviews and build your reputation.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Earnings Chart
        const earningsCtx = document.getElementById('earningsChart').getContext('2d');
        const earningsChart = new Chart(earningsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($earningsChart['labels']) !!},
                datasets: [{
                    label: 'Earnings',
                    data: {!! json_encode($earningsChart['data']) !!},
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
                        callbacks: {
                            label: function(context) {
                                return '$' + context.raw.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
        
        // Service Type Chart
        const serviceTypeCtx = document.getElementById('serviceTypeChart').getContext('2d');
        const serviceTypeChart = new Chart(serviceTypeCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_column($serviceTypeStats, 'name')) !!},
                datasets: [{
                    data: {!! json_encode(array_column($serviceTypeStats, 'count')) !!},
                    backgroundColor: {!! json_encode(array_column($serviceTypeStats, 'color')) !!},
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                },
                cutout: '70%'
            }
        });
        
        // Update stats based on selected period
        document.getElementById('stats_period').addEventListener('change', function() {
            const period = this.value;
            
            fetch(`{{ route('provider.service-stats') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    // Update stats
                    document.getElementById('stats-completed').textContent = data.stats.completed;
                    document.getElementById('stats-earnings').textContent = '$' + parseFloat(data.stats.earnings).toFixed(2);
                    
                    // Update earnings chart
                    earningsChart.data.labels = data.earningsChart.labels;
                    earningsChart.data.datasets[0].data = data.earningsChart.data;
                    earningsChart.update();
                })
                .catch(error => {
                    console.error('Error fetching stats:', error);
                    showMaterialSnackbar('Error loading statistics', 'error');
                });
        });
    });
</script>
@endpush
