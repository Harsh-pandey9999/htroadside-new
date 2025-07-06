@extends('layouts.material')

@section('title', 'Service Requests')
@section('page_title', 'Service Requests')

@section('content')
<div class="md-card md-card-elevated mb-6">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-xl font-medium text-on-surface-high">Service Requests</h2>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('provider.requests') }}" class="md-chip {{ !request('status') ? 'md-chip-filled' : 'md-chip-outlined' }}">
                    All
                </a>
                <a href="{{ route('provider.requests', ['status' => 'pending']) }}" class="md-chip {{ request('status') == 'pending' ? 'md-chip-filled md-chip-warning' : 'md-chip-outlined' }}">
                    Pending
                </a>
                <a href="{{ route('provider.requests', ['status' => 'accepted']) }}" class="md-chip {{ request('status') == 'accepted' ? 'md-chip-filled md-chip-info' : 'md-chip-outlined' }}">
                    Accepted
                </a>
                <a href="{{ route('provider.requests', ['status' => 'in_progress']) }}" class="md-chip {{ request('status') == 'in_progress' ? 'md-chip-filled md-chip-primary' : 'md-chip-outlined' }}">
                    In Progress
                </a>
                <a href="{{ route('provider.requests', ['status' => 'completed']) }}" class="md-chip {{ request('status') == 'completed' ? 'md-chip-filled md-chip-success' : 'md-chip-outlined' }}">
                    Completed
                </a>
                <a href="{{ route('provider.requests', ['status' => 'cancelled']) }}" class="md-chip {{ request('status') == 'cancelled' ? 'md-chip-filled md-chip-error' : 'md-chip-outlined' }}">
                    Cancelled
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <form action="{{ route('provider.requests') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="md-input-field flex-1">
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="md-input">
                <label for="search">Search by customer name, service type or location</label>
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
                
                <a href="{{ route('provider.requests') }}" class="md-btn md-btn-outlined">
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
                        <a href="{{ route('provider.requests.view', $request->id) }}" class="md-btn md-btn-icon md-btn-text" title="View Details">
                            <span class="material-icons">visibility</span>
                        </a>
                        
                        @if($request->status == 'pending')
                            <form action="{{ route('provider.requests.accept', $request->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="md-btn md-btn-icon md-btn-text text-success-500" title="Accept Request">
                                    <span class="material-icons">check_circle</span>
                                </button>
                            </form>
                            
                            <form action="{{ route('provider.requests.reject', $request->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="md-btn md-btn-icon md-btn-text text-error-500" title="Reject Request" onclick="return confirm('Are you sure you want to reject this request?')">
                                    <span class="material-icons">cancel</span>
                                </button>
                            </form>
                        @endif
                        
                        @if($request->status == 'accepted')
                            <form action="{{ route('provider.requests.start', $request->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="md-btn md-btn-icon md-btn-text text-primary-500" title="Start Service">
                                    <span class="material-icons">play_circle</span>
                                </button>
                            </form>
                        @endif
                        
                        @if($request->status == 'in_progress')
                            <form action="{{ route('provider.requests.complete', $request->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="md-btn md-btn-icon md-btn-text text-success-500" title="Complete Service">
                                    <span class="material-icons">task_alt</span>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-sm text-on-surface-medium">
                        <div class="flex flex-col items-center py-6">
                            <span class="material-icons text-4xl text-on-surface-disabled mb-2">search_off</span>
                            <p class="text-on-surface-medium mb-4">No service requests found</p>
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
    <!-- Pending Requests Map -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-lg font-medium text-on-surface-high">Nearby Service Requests</h2>
        </div>
        
        <div class="p-6">
            <div class="w-full h-96 rounded-md overflow-hidden mb-4" id="requests-map"></div>
            
            <div class="md-card p-4 bg-primary-50 dark:bg-primary-900 dark:bg-opacity-30 border-l-4 border-primary-500 dark:border-primary-400">
                <div class="flex items-start">
                    <span class="material-icons mr-2 text-primary-600 dark:text-primary-400">info</span>
                    <div>
                        <h3 class="font-medium text-primary-700 dark:text-primary-300">Service Request Map</h3>
                        <p class="text-primary-700 dark:text-primary-300 opacity-80">This map shows pending service requests in your service area. Click on a marker to view details and accept a request.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Request Statistics -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium text-on-surface-high">Request Statistics</h2>
                
                <div class="md-input-field w-48">
                    <select id="stats_period" class="md-select">
                        <option value="week">This Week</option>
                        <option value="month" selected>This Month</option>
                        <option value="quarter">This Quarter</option>
                        <option value="year">This Year</option>
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
                            <p class="text-on-surface-medium text-sm font-medium">Acceptance Rate</p>
                            <h3 class="text-2xl font-semibold text-on-surface-high mt-1" id="stats-acceptance">{{ $stats['acceptance_rate'] }}%</h3>
                        </div>
                        <div class="bg-success-100 dark:bg-success-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-success-600 dark:text-success-300">thumb_up</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="h-64 mb-6">
                <canvas id="requestsChart"></canvas>
            </div>
            
            <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                <h3 class="text-sm font-medium text-on-surface-medium mb-2">Service Type Distribution</h3>
                
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
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map with pending requests
        const map = new google.maps.Map(document.getElementById('requests-map'), {
            center: {lat: {{ $providerLocation['lat'] ?? 37.7749 }}, lng: {{ $providerLocation['lng'] ?? -122.4194 }}},
            zoom: 11,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false
        });
        
        // Add provider marker
        const providerMarker = new google.maps.Marker({
            position: {lat: {{ $providerLocation['lat'] ?? 37.7749 }}, lng: {{ $providerLocation['lng'] ?? -122.4194 }}},
            map: map,
            title: 'Your Location',
            icon: {
                url: "{{ asset('images/provider-marker.png') }}",
                scaledSize: new google.maps.Size(40, 40)
            },
            zIndex: 999
        });
        
        // Add service radius circle
        const serviceRadius = new google.maps.Circle({
            strokeColor: '#1E88E5',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#1E88E5',
            fillOpacity: 0.1,
            map: map,
            center: {lat: {{ $providerLocation['lat'] ?? 37.7749 }}, lng: {{ $providerLocation['lng'] ?? -122.4194 }}},
            radius: {{ $serviceRadius ?? 10000 }} // in meters
        });
        
        // Add pending request markers
        const pendingRequests = {!! json_encode($pendingRequestsMap) !!};
        const infoWindow = new google.maps.InfoWindow();
        
        pendingRequests.forEach(request => {
            const marker = new google.maps.Marker({
                position: {lat: request.latitude, lng: request.longitude},
                map: map,
                title: request.service_name,
                icon: {
                    url: "{{ asset('images/customer-marker.png') }}",
                    scaledSize: new google.maps.Size(32, 32)
                }
            });
            
            marker.addListener('click', function() {
                const content = `
                    <div class="p-2">
                        <h3 class="font-medium mb-1">${request.service_name}</h3>
                        <p class="text-sm mb-1">${request.customer_name}</p>
                        <p class="text-sm mb-2">${request.location}</p>
                        <a href="${request.view_url}" class="text-primary-600 text-sm font-medium mr-3">View Details</a>
                        <a href="${request.accept_url}" class="text-success-600 text-sm font-medium">Accept Request</a>
                    </div>
                `;
                
                infoWindow.setContent(content);
                infoWindow.open(map, marker);
            });
        });
        
        // Request Statistics Chart
        const ctx = document.getElementById('requestsChart').getContext('2d');
        const requestsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartStats['labels']) !!},
                datasets: [{
                    label: 'Completed',
                    data: {!! json_encode($chartStats['completed']) !!},
                    backgroundColor: 'rgba(76, 175, 80, 0.8)',
                    borderColor: 'rgba(76, 175, 80, 1)',
                    borderWidth: 1
                }, {
                    label: 'Pending/In Progress',
                    data: {!! json_encode($chartStats['pending']) !!},
                    backgroundColor: 'rgba(255, 193, 7, 0.8)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }, {
                    label: 'Cancelled',
                    data: {!! json_encode($chartStats['cancelled']) !!},
                    backgroundColor: 'rgba(244, 67, 54, 0.8)',
                    borderColor: 'rgba(244, 67, 54, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Update stats based on selected period
        document.getElementById('stats_period').addEventListener('change', function() {
            const period = this.value;
            
            fetch(`{{ route('provider.request-stats') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    // Update stats
                    document.getElementById('stats-total').textContent = data.stats.total;
                    document.getElementById('stats-acceptance').textContent = data.stats.acceptance_rate + '%';
                    
                    // Update chart
                    requestsChart.data.labels = data.chartStats.labels;
                    requestsChart.data.datasets[0].data = data.chartStats.completed;
                    requestsChart.data.datasets[1].data = data.chartStats.pending;
                    requestsChart.data.datasets[2].data = data.chartStats.cancelled;
                    requestsChart.update();
                })
                .catch(error => {
                    console.error('Error fetching stats:', error);
                    showMaterialSnackbar('Error loading statistics', 'error');
                });
        });
    });
</script>
@endpush
