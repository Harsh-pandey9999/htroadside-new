@extends('admin.layouts.material')

@section('title', 'Service Requests')
@section('page_title', 'Service Requests')

@section('content')
<div class="md-card md-card-elevated mb-6">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-xl font-medium text-on-surface-high">Service Requests</h2>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.service-requests') }}" class="md-chip {{ !request('status') ? 'md-chip-filled' : 'md-chip-outlined' }}">
                    All
                </a>
                <a href="{{ route('admin.service-requests', ['status' => 'pending']) }}" class="md-chip {{ request('status') == 'pending' ? 'md-chip-filled md-chip-warning' : 'md-chip-outlined' }}">
                    Pending
                </a>
                <a href="{{ route('admin.service-requests', ['status' => 'accepted']) }}" class="md-chip {{ request('status') == 'accepted' ? 'md-chip-filled md-chip-info' : 'md-chip-outlined' }}">
                    Accepted
                </a>
                <a href="{{ route('admin.service-requests', ['status' => 'in_progress']) }}" class="md-chip {{ request('status') == 'in_progress' ? 'md-chip-filled md-chip-primary' : 'md-chip-outlined' }}">
                    In Progress
                </a>
                <a href="{{ route('admin.service-requests', ['status' => 'completed']) }}" class="md-chip {{ request('status') == 'completed' ? 'md-chip-filled md-chip-success' : 'md-chip-outlined' }}">
                    Completed
                </a>
                <a href="{{ route('admin.service-requests', ['status' => 'cancelled']) }}" class="md-chip {{ request('status') == 'cancelled' ? 'md-chip-filled md-chip-error' : 'md-chip-outlined' }}">
                    Cancelled
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <form action="{{ route('admin.service-requests') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="md-input-field flex-1">
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="md-input">
                <label for="search">Search by ID, customer name, or provider name</label>
            </div>
            
            <div class="md-input-field w-full md:w-48">
                <select id="service_type" name="service_type" class="md-select">
                    <option value="">All Service Types</option>
                    @foreach($serviceTypes as $type)
                        <option value="{{ $type->id }}" {{ request('service_type') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                <label for="service_type">Service Type</label>
            </div>
            
            <div class="md-input-field w-full md:w-48">
                <select id="service_area" name="service_area" class="md-select">
                    <option value="">All Service Areas</option>
                    @foreach($serviceAreas as $area)
                        <option value="{{ $area->id }}" {{ request('service_area') == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
                <label for="service_area">Service Area</label>
            </div>
            
            <div class="md-input-field w-full md:w-48">
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="md-input">
                <label for="date_from">Date From</label>
            </div>
            
            <div class="md-input-field w-full md:w-48">
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="md-input">
                <label for="date_to">Date To</label>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="md-btn md-btn-filled">
                    <span class="material-icons mr-1">search</span>
                    Search
                </button>
                
                <a href="{{ route('admin.service-requests') }}" class="md-btn md-btn-outlined">
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Provider</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Service</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Location</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-on-surface-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-surface-1 dark:bg-surface-1-dark divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($serviceRequests as $request)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-on-surface-high">#{{ $request->id }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center overflow-hidden">
                                @if($request->customer->profile_image)
                                    <img src="{{ asset('storage/' . $request->customer->profile_image) }}" alt="{{ $request->customer->name }}" class="h-8 w-8 rounded-full object-cover">
                                @else
                                    <span class="material-icons text-sm text-primary-500 dark:text-primary-400">person</span>
                                @endif
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-on-surface-high">{{ $request->customer->name }}</div>
                                <div class="text-xs text-on-surface-medium">{{ $request->customer->phone }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($request->provider)
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center overflow-hidden">
                                    @if($request->provider->profile_image)
                                        <img src="{{ asset('storage/' . $request->provider->profile_image) }}" alt="{{ $request->provider->name }}" class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        <span class="material-icons text-sm text-primary-500 dark:text-primary-400">business</span>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-on-surface-high">{{ $request->provider->name }}</div>
                                    <div class="text-xs text-on-surface-medium">{{ $request->provider->business_name }}</div>
                                </div>
                            </div>
                        @else
                            <span class="text-sm text-on-surface-medium">Not assigned</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-on-surface-high">{{ $request->serviceType->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-on-surface-high">{{ Str::limit($request->location_address, 30) }}</div>
                        <div class="text-xs text-on-surface-medium">{{ $request->serviceArea->name ?? 'Unknown Area' }}</div>
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
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-on-surface-high">{{ $request->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-on-surface-medium">{{ $request->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.service-requests.view', $request->id) }}" class="md-btn md-btn-icon md-btn-text" title="View Details">
                            <span class="material-icons">visibility</span>
                        </a>
                        
                        @if($request->status == 'pending')
                            <a href="{{ route('admin.service-requests.assign', $request->id) }}" class="md-btn md-btn-icon md-btn-text text-info-500" title="Assign Provider">
                                <span class="material-icons">assignment_ind</span>
                            </a>
                        @endif
                        
                        @if($request->status == 'pending')
                            <form action="{{ route('admin.service-requests.cancel', $request->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="md-btn md-btn-icon md-btn-text text-error-500" title="Cancel Request" onclick="return confirm('Are you sure you want to cancel this service request?')">
                                    <span class="material-icons">cancel</span>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-sm text-on-surface-medium">
                        <div class="flex flex-col items-center py-6">
                            <span class="material-icons text-4xl text-on-surface-disabled mb-2">support</span>
                            <p class="text-on-surface-medium mb-4">No service requests found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($serviceRequests->hasPages())
    <div class="p-6 border-t border-neutral-200 dark:border-neutral-700">
        <div class="md-pagination">
            {{ $serviceRequests->appends(request()->except('page'))->links() }}
        </div>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Request Statistics -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-lg font-medium text-on-surface-high">Request Statistics</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="md-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface-medium text-sm font-medium">Total Requests</p>
                            <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-primary-600 dark:text-primary-300">support</span>
                        </div>
                    </div>
                </div>
                
                <div class="md-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface-medium text-sm font-medium">Pending</p>
                            <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $stats['pending'] }}</h3>
                        </div>
                        <div class="bg-warning-100 dark:bg-warning-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-warning-600 dark:text-warning-300">pending</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="h-64 mb-6">
                <canvas id="requestsChart"></canvas>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="md-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface-medium text-sm font-medium">Completion Rate</p>
                            <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $stats['completion_rate'] }}%</h3>
                        </div>
                        <div class="bg-success-100 dark:bg-success-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-success-600 dark:text-success-300">check_circle</span>
                        </div>
                    </div>
                </div>
                
                <div class="md-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface-medium text-sm font-medium">Avg. Response Time</p>
                            <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $stats['avg_response_time'] }} min</h3>
                        </div>
                        <div class="bg-info-100 dark:bg-info-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-info-600 dark:text-info-300">timer</span>
                        </div>
                    </div>
                </div>
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
            
            <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                <h3 class="text-sm font-medium text-on-surface-medium mb-2">Top Service Types</h3>
                
                <div class="space-y-3">
                    @foreach($serviceTypeStats as $stat)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-on-surface-high">{{ $stat['name'] }}</span>
                            <span class="text-sm text-on-surface-high">{{ $stat['count'] }} requests</span>
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
    
    <!-- Recent Activity -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-lg font-medium text-on-surface-high">Recent Activity</h2>
        </div>
        
        <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
            @forelse($recentActivity as $activity)
                <div class="p-4">
                    <div class="flex items-start">
                        <span class="material-icons text-on-surface-medium mr-3">{{ $activity->icon }}</span>
                        <div>
                            <p class="text-on-surface-high">{{ $activity->description }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs text-on-surface-medium">{{ $activity->created_at->diffForHumans() }}</span>
                                @if($activity->request_id)
                                    <span class="mx-2 text-on-surface-disabled">•</span>
                                    <a href="{{ route('admin.service-requests.view', $activity->request_id) }}" class="text-xs text-primary-600 dark:text-primary-400">
                                        View Request #{{ $activity->request_id }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center">
                    <span class="material-icons text-4xl text-on-surface-disabled mb-2">history</span>
                    <p class="text-on-surface-medium">No recent activity</p>
                </div>
            @endforelse
        </div>
        
        @if(count($recentActivity) > 0)
            <div class="p-4 border-t border-neutral-200 dark:border-neutral-700 text-center">
                <a href="{{ route('admin.activity-log') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium">
                    View All Activity
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Request Map -->
<div class="md-card md-card-elevated mb-6">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <h2 class="text-lg font-medium text-on-surface-high">Service Request Map</h2>
    </div>
    
    <div class="p-6">
        <div class="w-full h-96 rounded-md overflow-hidden" id="request-map"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Request Statistics Chart
        const requestsCtx = document.getElementById('requestsChart').getContext('2d');
        const requestsChart = new Chart(requestsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($requestTrend['labels']) !!},
                datasets: [{
                    label: 'Service Requests',
                    data: {!! json_encode($requestTrend['data']) !!},
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
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Service Type Distribution Chart
        const serviceTypeCtx = document.getElementById('serviceTypeChart').getContext('2d');
        const serviceTypeChart = new Chart(serviceTypeCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_column($serviceTypeStats, 'name')) !!},
                datasets: [{
                    data: {!! json_encode(array_column($serviceTypeStats, 'count')) !!},
                    backgroundColor: {!! json_encode(array_column($serviceTypeStats, 'color')) !!},
                    borderColor: '#FFFFFF',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
        
        // Request Map
        const map = new google.maps.Map(document.getElementById('request-map'), {
            center: {lat: {{ $mapCenter['lat'] ?? 37.7749 }}, lng: {{ $mapCenter['lng'] ?? -122.4194 }}},
            zoom: 10,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true
        });
        
        // Add request markers
        const requests = {!! json_encode($mapRequests) !!};
        const infoWindow = new google.maps.InfoWindow();
        
        requests.forEach(request => {
            // Set marker icon based on status
            let iconColor;
            switch(request.status) {
                case 'pending':
                    iconColor = '#FFC107'; // warning
                    break;
                case 'accepted':
                    iconColor = '#03A9F4'; // info
                    break;
                case 'in_progress':
                    iconColor = '#3F51B5'; // primary
                    break;
                case 'completed':
                    iconColor = '#4CAF50'; // success
                    break;
                case 'cancelled':
                    iconColor = '#F44336'; // error
                    break;
                default:
                    iconColor = '#9E9E9E'; // neutral
            }
            
            const marker = new google.maps.Marker({
                position: {lat: request.lat, lng: request.lng},
                map: map,
                title: `Request #${request.id}`,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 10,
                    fillColor: iconColor,
                    fillOpacity: 0.8,
                    strokeWeight: 1,
                    strokeColor: '#FFFFFF'
                }
            });
            
            // Add info window content
            const content = `
                <div class="p-2">
                    <h3 class="font-medium mb-1">Request #${request.id}</h3>
                    <p class="text-sm mb-1">${request.service_type}</p>
                    <p class="text-sm mb-1">${request.customer_name}</p>
                    <p class="text-sm mb-2">${request.address}</p>
                    <div class="flex items-center mb-2">
                        <span class="inline-block w-2 h-2 rounded-full mr-1" style="background-color: ${iconColor}"></span>
                        <span class="text-sm">${request.status_text}</span>
                    </div>
                    <a href="${request.view_url}" class="text-primary-600 text-sm font-medium">View Details</a>
                </div>
            `;
            
            marker.addListener('click', function() {
                infoWindow.setContent(content);
                infoWindow.open(map, marker);
            });
        });
        
        // Add service area boundaries if available
        const serviceAreas = {!! json_encode($serviceAreaBoundaries ?? []) !!};
        
        serviceAreas.forEach(area => {
            const circle = new google.maps.Circle({
                strokeColor: area.color,
                strokeOpacity: 0.5,
                strokeWeight: 1,
                fillColor: area.color,
                fillOpacity: 0.1,
                map: map,
                center: {lat: area.lat, lng: area.lng},
                radius: area.radius * 1000 // Convert km to meters
            });
            
            // Add area label
            const areaLabel = new google.maps.Marker({
                position: {lat: area.lat, lng: area.lng},
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 0
                },
                label: {
                    text: area.name,
                    color: '#FFFFFF',
                    fontSize: '12px',
                    fontWeight: 'bold',
                    className: 'map-label'
                }
            });
        });
    });
</script>
@endpush
