@extends('admin.layouts.material')

@section('title', 'Service Providers')
@section('page_title', 'Service Providers')

@section('content')
<div class="md-card md-card-elevated mb-6">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-xl font-medium text-on-surface-high">Service Providers</h2>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.providers') }}" class="md-chip {{ !request('status') ? 'md-chip-filled' : 'md-chip-outlined' }}">
                    All
                </a>
                <a href="{{ route('admin.providers', ['status' => 'active']) }}" class="md-chip {{ request('status') == 'active' ? 'md-chip-filled md-chip-success' : 'md-chip-outlined' }}">
                    Active
                </a>
                <a href="{{ route('admin.providers', ['status' => 'pending']) }}" class="md-chip {{ request('status') == 'pending' ? 'md-chip-filled md-chip-warning' : 'md-chip-outlined' }}">
                    Pending
                </a>
                <a href="{{ route('admin.providers', ['status' => 'inactive']) }}" class="md-chip {{ request('status') == 'inactive' ? 'md-chip-filled md-chip-error' : 'md-chip-outlined' }}">
                    Inactive
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <form action="{{ route('admin.providers') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="md-input-field flex-1">
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="md-input">
                <label for="search">Search by name, email, phone or business name</label>
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
            
            <div class="flex gap-2">
                <button type="submit" class="md-btn md-btn-filled">
                    <span class="material-icons mr-1">search</span>
                    Search
                </button>
                
                <a href="{{ route('admin.providers') }}" class="md-btn md-btn-outlined">
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Provider</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Business Info</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Service Area</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Performance</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-on-surface-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-surface-1 dark:bg-surface-1-dark divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($providers as $provider)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center overflow-hidden">
                                @if($provider->profile_image)
                                    <img src="{{ asset('storage/' . $provider->profile_image) }}" alt="{{ $provider->name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <span class="material-icons text-primary-500 dark:text-primary-400">person</span>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-on-surface-high">{{ $provider->name }}</div>
                                <div class="text-sm text-on-surface-medium">{{ $provider->email }}</div>
                                <div class="text-sm text-on-surface-medium">{{ $provider->phone }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-on-surface-high">{{ $provider->business_name }}</div>
                        <div class="text-sm text-on-surface-medium">Tax ID: {{ $provider->tax_id ?? 'Not provided' }}</div>
                        <div class="text-sm text-on-surface-medium">
                            @if($provider->is_verified)
                                <span class="inline-flex items-center text-success-600 dark:text-success-400">
                                    <span class="material-icons text-sm mr-1">verified</span> Verified
                                </span>
                            @else
                                <span class="text-warning-600 dark:text-warning-400">Verification Pending</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-on-surface-high">{{ $provider->serviceArea->name ?? 'Not assigned' }}</div>
                        <div class="text-sm text-on-surface-medium">{{ $provider->service_radius ?? '0' }} km radius</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($provider->is_active && $provider->is_verified)
                            <span class="md-chip md-chip-success">Active</span>
                        @elseif($provider->is_active && !$provider->is_verified)
                            <span class="md-chip md-chip-warning">Pending Verification</span>
                        @else
                            <span class="md-chip md-chip-error">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center text-sm text-on-surface-high mb-1">
                            <span class="material-icons text-warning-500 mr-1">star</span>
                            {{ number_format($provider->avg_rating, 1) }} ({{ $provider->rating_count }} reviews)
                        </div>
                        <div class="text-sm text-on-surface-medium">{{ $provider->completed_services }} completed services</div>
                        <div class="text-sm text-on-surface-medium">{{ number_format($provider->acceptance_rate, 0) }}% acceptance rate</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.providers.view', $provider->id) }}" class="md-btn md-btn-icon md-btn-text" title="View Details">
                            <span class="material-icons">visibility</span>
                        </a>
                        
                        <a href="{{ route('admin.providers.edit', $provider->id) }}" class="md-btn md-btn-icon md-btn-text" title="Edit Provider">
                            <span class="material-icons">edit</span>
                        </a>
                        
                        @if(!$provider->is_verified)
                            <form action="{{ route('admin.providers.verify', $provider->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="md-btn md-btn-icon md-btn-text text-success-500" title="Verify Provider">
                                    <span class="material-icons">verified</span>
                                </button>
                            </form>
                        @endif
                        
                        @if($provider->is_active)
                            <form action="{{ route('admin.providers.toggle-status', $provider->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="0">
                                <button type="submit" class="md-btn md-btn-icon md-btn-text text-error-500" title="Deactivate Provider" onclick="return confirm('Are you sure you want to deactivate this provider?')">
                                    <span class="material-icons">block</span>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.providers.toggle-status', $provider->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="1">
                                <button type="submit" class="md-btn md-btn-icon md-btn-text text-success-500" title="Activate Provider">
                                    <span class="material-icons">check_circle</span>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-on-surface-medium">
                        <div class="flex flex-col items-center py-6">
                            <span class="material-icons text-4xl text-on-surface-disabled mb-2">business</span>
                            <p class="text-on-surface-medium mb-4">No service providers found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($providers->hasPages())
    <div class="p-6 border-t border-neutral-200 dark:border-neutral-700">
        <div class="md-pagination">
            {{ $providers->appends(request()->except('page'))->links() }}
        </div>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Provider Statistics -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-lg font-medium text-on-surface-high">Provider Statistics</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="md-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface-medium text-sm font-medium">Total Providers</p>
                            <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-primary-600 dark:text-primary-300">business</span>
                        </div>
                    </div>
                </div>
                
                <div class="md-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface-medium text-sm font-medium">Active Providers</p>
                            <h3 class="text-2xl font-semibold text-on-surface-high mt-1">{{ $stats['active'] }}</h3>
                        </div>
                        <div class="bg-success-100 dark:bg-success-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-success-600 dark:text-success-300">check_circle</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="h-64 mb-6">
                <canvas id="providersChart"></canvas>
            </div>
            
            <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                <h3 class="text-sm font-medium text-on-surface-medium mb-2">Top Performing Providers</h3>
                
                <div class="space-y-3">
                    @foreach($topProviders as $provider)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center overflow-hidden mr-2">
                                @if($provider->profile_image)
                                    <img src="{{ asset('storage/' . $provider->profile_image) }}" alt="{{ $provider->name }}" class="h-8 w-8 rounded-full object-cover">
                                @else
                                    <span class="material-icons text-sm text-primary-500 dark:text-primary-400">person</span>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-medium text-on-surface-high">{{ $provider->name }}</div>
                                <div class="text-xs text-on-surface-medium">{{ $provider->serviceArea->name ?? 'Not assigned' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="material-icons text-warning-500 mr-1">star</span>
                            <span class="text-sm text-on-surface-high">{{ number_format($provider->avg_rating, 1) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Service Area Coverage -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-lg font-medium text-on-surface-high">Service Area Coverage</h2>
        </div>
        
        <div class="p-6">
            <div class="w-full h-96 rounded-md overflow-hidden mb-4" id="coverage-map"></div>
            
            <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                <h3 class="text-sm font-medium text-on-surface-medium mb-2">Coverage by Area</h3>
                
                <div class="space-y-3">
                    @foreach($coverageStats as $stat)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-on-surface-high">{{ $stat['name'] }}</span>
                            <span class="text-sm text-on-surface-high">{{ $stat['count'] }} providers</span>
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

<!-- Add New Provider -->
<div class="md-card md-card-elevated mb-6">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <h2 class="text-lg font-medium text-on-surface-high">Add New Service Provider</h2>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.providers.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md-input-field">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="md-input" required>
                    <label for="name">Full Name</label>
                    @error('name')
                        <span class="text-error-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="md-input-field">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="md-input" required>
                    <label for="email">Email Address</label>
                    @error('email')
                        <span class="text-error-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="md-input-field">
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="md-input" required>
                    <label for="phone">Phone Number</label>
                    @error('phone')
                        <span class="text-error-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="md-input-field">
                    <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}" class="md-input" required>
                    <label for="business_name">Business Name</label>
                    @error('business_name')
                        <span class="text-error-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="md-input-field">
                    <input type="text" id="tax_id" name="tax_id" value="{{ old('tax_id') }}" class="md-input">
                    <label for="tax_id">Tax ID / EIN</label>
                    @error('tax_id')
                        <span class="text-error-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="md-input-field">
                    <select id="service_area_id" name="service_area_id" class="md-select" required>
                        <option value="">Select Service Area</option>
                        @foreach($serviceAreas as $area)
                            <option value="{{ $area->id }}" {{ old('service_area_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                    <label for="service_area_id">Service Area</label>
                    @error('service_area_id')
                        <span class="text-error-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="md-input-field">
                    <input type="password" id="password" name="password" class="md-input" required>
                    <label for="password">Password</label>
                    @error('password')
                        <span class="text-error-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="md-input-field">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="md-input" required>
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                
                <div class="md-input-field">
                    <select id="is_verified" name="is_verified" class="md-select">
                        <option value="0" {{ old('is_verified') == '0' ? 'selected' : '' }}>Pending Verification</option>
                        <option value="1" {{ old('is_verified') == '1' ? 'selected' : '' }}>Verified</option>
                    </select>
                    <label for="is_verified">Verification Status</label>
                </div>
            </div>
            
            <div class="md-card p-4 bg-info-50 dark:bg-info-900 dark:bg-opacity-30 border-l-4 border-info-500 dark:border-info-400">
                <div class="flex items-start">
                    <span class="material-icons mr-2 text-info-600 dark:text-info-400">info</span>
                    <div>
                        <h3 class="font-medium text-info-700 dark:text-info-300">Provider Account Creation</h3>
                        <p class="text-info-700 dark:text-info-300 opacity-80">An email will be sent to the provider with their login credentials. They will be prompted to complete their profile and add service details upon first login.</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="md-btn md-btn-filled">
                    <span class="material-icons mr-1">add_business</span>
                    Add Service Provider
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Provider Statistics Chart
        const providersCtx = document.getElementById('providersChart').getContext('2d');
        const providersChart = new Chart(providersCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($providerGrowth['labels']) !!},
                datasets: [{
                    label: 'New Providers',
                    data: {!! json_encode($providerGrowth['data']) !!},
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
        
        // Coverage Map
        const map = new google.maps.Map(document.getElementById('coverage-map'), {
            center: {lat: {{ $mapCenter['lat'] ?? 37.7749 }}, lng: {{ $mapCenter['lng'] ?? -122.4194 }}},
            zoom: 9,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false
        });
        
        // Add service area coverage
        const coverageData = {!! json_encode($coverageMap) !!};
        
        coverageData.forEach(area => {
            // Create circle for each service area
            const circle = new google.maps.Circle({
                strokeColor: area.color,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: area.color,
                fillOpacity: 0.1,
                map: map,
                center: {lat: area.lat, lng: area.lng},
                radius: area.radius * 1000 // Convert km to meters
            });
            
            // Add provider markers
            area.providers.forEach(provider => {
                const marker = new google.maps.Marker({
                    position: {lat: provider.lat, lng: provider.lng},
                    map: map,
                    title: provider.name,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: area.color,
                        fillOpacity: 0.8,
                        strokeWeight: 1,
                        strokeColor: '#FFFFFF'
                    }
                });
                
                // Add info window
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div class="p-2">
                            <h3 class="font-medium mb-1">${provider.name}</h3>
                            <p class="text-sm mb-1">${provider.business_name}</p>
                            <p class="text-sm mb-2">Service Radius: ${provider.service_radius} km</p>
                            <a href="${provider.view_url}" class="text-primary-600 text-sm font-medium">View Details</a>
                        </div>
                    `
                });
                
                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
            });
        });
    });
</script>
@endpush
