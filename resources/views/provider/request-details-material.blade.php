@extends('layouts.material')

@section('title', 'Service Request Details')
@section('page_title', 'Service Request Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Service Request Details -->
    <div class="lg:col-span-2">
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-medium text-on-surface-high">Request #{{ $request->id }}</h2>
                    <span class="md-chip {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-on-surface-medium mb-2">Service Type</h3>
                        <p class="text-on-surface-high font-medium">{{ $request->service->name }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-on-surface-medium mb-2">Status</h3>
                        <div class="flex items-center">
                            <span class="material-icons mr-2 {{ $statusIconClass }}">{{ $statusIcon }}</span>
                            <span class="text-on-surface-high font-medium">{{ $statusLabel }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-on-surface-medium mb-2">Requested On</h3>
                        <p class="text-on-surface-high font-medium">{{ $request->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-on-surface-medium mb-2">Last Updated</h3>
                        <p class="text-on-surface-high font-medium">{{ $request->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-on-surface-medium mb-2">Vehicle</h3>
                        <p class="text-on-surface-high font-medium">{{ $request->vehicle->year }} {{ $request->vehicle->make }} {{ $request->vehicle->model }}</p>
                        <p class="text-on-surface-medium text-sm">{{ $request->vehicle->color }} • {{ $request->vehicle->license_plate }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-on-surface-medium mb-2">Customer</h3>
                        <p class="text-on-surface-high font-medium">{{ $request->customer->name }}</p>
                        <p class="text-on-surface-medium text-sm">{{ $request->customer->phone }}</p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-on-surface-medium mb-2">Location</h3>
                    <p class="text-on-surface-high font-medium mb-2">{{ $request->location }}</p>
                    
                    <div class="w-full h-64 rounded-md overflow-hidden mb-2" id="map"></div>
                    
                    @if($request->location_notes)
                        <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark mt-2">
                            <h4 class="text-sm font-medium text-on-surface-medium mb-1">Location Notes</h4>
                            <p class="text-on-surface-high">{{ $request->location_notes }}</p>
                        </div>
                    @endif
                </div>
                
                @if($request->service_notes)
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-on-surface-medium mb-2">Service Notes</h3>
                        <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                            <p class="text-on-surface-high">{{ $request->service_notes }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-on-surface-medium mb-2">Payment Information</h3>
                    <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-on-surface-medium">Service Fee</span>
                            <span class="text-on-surface-high font-medium">${{ number_format($request->service->price, 2) }}</span>
                        </div>
                        
                        @if($request->status == 'completed' || $request->status == 'in_progress')
                            <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                                <h4 class="text-sm font-medium text-on-surface-medium mb-2">Additional Charges</h4>
                                
                                @if($request->status == 'in_progress')
                                    <form action="{{ route('provider.add-charges', $request->id) }}" method="POST" class="mb-4">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div class="md-input-field md:col-span-2">
                                                <input type="text" id="charge_description" name="charge_description" class="md-input" required>
                                                <label for="charge_description">Description</label>
                                            </div>
                                            <div class="md-input-field">
                                                <input type="number" id="charge_amount" name="charge_amount" step="0.01" min="0" class="md-input" required>
                                                <label for="charge_amount">Amount ($)</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="md-btn md-btn-filled mt-2">Add Charge</button>
                                    </form>
                                @endif
                                
                                <div class="space-y-2">
                                    @forelse($request->additionalCharges as $charge)
                                        <div class="flex justify-between items-center">
                                            <span class="text-on-surface-medium">{{ $charge->description }}</span>
                                            <span class="text-on-surface-high font-medium">${{ number_format($charge->amount, 2) }}</span>
                                        </div>
                                    @empty
                                        <p class="text-on-surface-medium text-sm italic">No additional charges</p>
                                    @endforelse
                                </div>
                            </div>
                        @endif
                        
                        <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                            <div class="flex justify-between items-center">
                                <span class="text-on-surface-high font-medium">Total</span>
                                <span class="text-on-surface-high font-bold">${{ number_format($request->total_amount, 2) }}</span>
                            </div>
                            
                            @if($request->payment_status)
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-on-surface-medium">Payment Status</span>
                                    @if($request->payment_status == 'paid')
                                        <span class="md-chip md-chip-success">Paid</span>
                                    @elseif($request->payment_status == 'pending')
                                        <span class="md-chip md-chip-warning">Pending</span>
                                    @else
                                        <span class="md-chip md-chip-error">Failed</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    @if($request->status == 'pending')
                        <form action="{{ route('provider.requests.accept', $request->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="md-btn md-btn-filled md-btn-success">
                                <span class="material-icons mr-1">check_circle</span>
                                Accept Request
                            </button>
                        </form>
                        
                        <form action="{{ route('provider.requests.reject', $request->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="md-btn md-btn-outlined md-btn-error" onclick="return confirm('Are you sure you want to reject this request?')">
                                <span class="material-icons mr-1">cancel</span>
                                Reject Request
                            </button>
                        </form>
                    @endif
                    
                    @if($request->status == 'accepted')
                        <form action="{{ route('provider.requests.start', $request->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="md-btn md-btn-filled md-btn-primary">
                                <span class="material-icons mr-1">play_circle</span>
                                Start Service
                            </button>
                        </form>
                    @endif
                    
                    @if($request->status == 'in_progress')
                        <form action="{{ route('provider.requests.complete', $request->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="md-btn md-btn-filled md-btn-success">
                                <span class="material-icons mr-1">task_alt</span>
                                Complete Service
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('provider.requests') }}" class="md-btn md-btn-outlined">
                        <span class="material-icons mr-1">arrow_back</span>
                        Back to Requests
                    </a>
                </div>
            </div>
        </div>
        
        @if($request->status == 'in_progress')
            <div class="md-card md-card-elevated mb-6">
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                    <h2 class="text-xl font-medium text-on-surface-high">Service Navigation</h2>
                </div>
                
                <div class="p-6">
                    <div class="w-full h-96 rounded-md overflow-hidden mb-4" id="navigation-map"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                            <h3 class="text-sm font-medium text-on-surface-medium mb-2">Distance</h3>
                            <div class="flex items-center">
                                <span class="material-icons mr-2 text-primary-600 dark:text-primary-400">directions_car</span>
                                <span class="text-on-surface-high font-medium" id="distance">Calculating...</span>
                            </div>
                        </div>
                        
                        <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                            <h3 class="text-sm font-medium text-on-surface-medium mb-2">Estimated Arrival</h3>
                            <div class="flex items-center">
                                <span class="material-icons mr-2 text-primary-600 dark:text-primary-400">schedule</span>
                                <span class="text-on-surface-high font-medium" id="eta">Calculating...</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="#" id="start-navigation" class="md-btn md-btn-filled md-btn-primary">
                            <span class="material-icons mr-1">navigation</span>
                            Start Navigation
                        </a>
                        
                        <a href="#" id="share-location" class="md-btn md-btn-outlined">
                            <span class="material-icons mr-1">share_location</span>
                            Share Location with Customer
                        </a>
                    </div>
                </div>
            </div>
        @endif
        
        @if($request->status == 'completed' && $request->review)
            <div class="md-card md-card-elevated mb-6">
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                    <h2 class="text-xl font-medium text-on-surface-high">Customer Review</h2>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <div class="flex mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $request->review->rating)
                                    <span class="material-icons text-warning-500">star</span>
                                @else
                                    <span class="material-icons text-neutral-300 dark:text-neutral-600">star_outline</span>
                                @endif
                            @endfor
                        </div>
                        <span class="text-on-surface-high font-medium">{{ $request->review->rating }}.0</span>
                    </div>
                    
                    <p class="text-on-surface-high mb-2">{{ $request->review->comment }}</p>
                    
                    <p class="text-on-surface-medium text-sm">Reviewed on {{ $request->review->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Customer Info -->
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Customer Information</h2>
            </div>
            
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                        @if($request->customer->profile_image)
                            <img src="{{ asset('storage/' . $request->customer->profile_image) }}" alt="{{ $request->customer->name }}" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <span class="material-icons text-3xl text-primary-500 dark:text-primary-400">person</span>
                        @endif
                    </div>
                    
                    <div>
                        <h3 class="font-medium text-on-surface-high">{{ $request->customer->name }}</h3>
                        <p class="text-on-surface-medium text-sm">Customer since {{ $request->customer->created_at->format('M Y') }}</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center">
                        <span class="material-icons text-on-surface-medium mr-2">phone</span>
                        <a href="tel:{{ $request->customer->phone }}" class="text-primary-600 dark:text-primary-400">{{ $request->customer->phone }}</a>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="material-icons text-on-surface-medium mr-2">email</span>
                        <a href="mailto:{{ $request->customer->email }}" class="text-primary-600 dark:text-primary-400">{{ $request->customer->email }}</a>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="tel:{{ $request->customer->phone }}" class="md-btn md-btn-filled w-full mb-2">
                        <span class="material-icons mr-1">call</span>
                        Call Customer
                    </a>
                    
                    <a href="sms:{{ $request->customer->phone }}" class="md-btn md-btn-outlined w-full">
                        <span class="material-icons mr-1">message</span>
                        Send Message
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Vehicle Info -->
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Vehicle Information</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-on-surface-medium mb-1">Vehicle</h3>
                        <p class="text-on-surface-high font-medium">{{ $request->vehicle->year }} {{ $request->vehicle->make }} {{ $request->vehicle->model }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-on-surface-medium mb-1">Color</h3>
                        <p class="text-on-surface-high">{{ $request->vehicle->color }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-on-surface-medium mb-1">License Plate</h3>
                        <p class="text-on-surface-high">{{ $request->vehicle->license_plate }}</p>
                    </div>
                    
                    @if($request->vehicle->vin)
                        <div>
                            <h3 class="text-sm font-medium text-on-surface-medium mb-1">VIN</h3>
                            <p class="text-on-surface-high">{{ $request->vehicle->vin }}</p>
                        </div>
                    @endif
                </div>
                
                @if($request->vehicle->notes)
                    <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-sm font-medium text-on-surface-medium mb-1">Vehicle Notes</h3>
                        <p class="text-on-surface-high">{{ $request->vehicle->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Service Checklist -->
        @if($request->status == 'in_progress')
            <div class="md-card md-card-elevated mb-6">
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                    <h2 class="text-lg font-medium text-on-surface-high">Service Checklist</h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('provider.update-checklist', $request->id) }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            @foreach($serviceChecklist as $item)
                                <div class="md-checkbox">
                                    <input type="checkbox" id="checklist_{{ $item['id'] }}" name="checklist[]" value="{{ $item['id'] }}" {{ $item['completed'] ? 'checked' : '' }}>
                                    <label for="checklist_{{ $item['id'] }}">{{ $item['description'] }}</label>
                                </div>
                            @endforeach
                        </div>
                        
                        <button type="submit" class="md-btn md-btn-filled mt-4">Update Checklist</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map with request location
        const requestLocation = {
            lat: {{ $request->latitude ?? 37.7749 }},
            lng: {{ $request->longitude ?? -122.4194 }}
        };
        
        const map = new google.maps.Map(document.getElementById('map'), {
            center: requestLocation,
            zoom: 15,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false
        });
        
        const marker = new google.maps.Marker({
            position: requestLocation,
            map: map,
            title: 'Customer Location',
            animation: google.maps.Animation.DROP
        });
        
        // Initialize navigation map if request is in progress
        @if($request->status == 'in_progress')
            const navigationMap = new google.maps.Map(document.getElementById('navigation-map'), {
                center: requestLocation,
                zoom: 12,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false
            });
            
            const customerMarker = new google.maps.Marker({
                position: requestLocation,
                map: navigationMap,
                title: 'Customer Location',
                icon: {
                    url: "{{ asset('images/customer-marker.png') }}",
                    scaledSize: new google.maps.Size(40, 40)
                }
            });
            
            // Provider location (using geolocation)
            let providerMarker;
            let directionsService;
            let directionsRenderer;
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const providerLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    
                    providerMarker = new google.maps.Marker({
                        position: providerLocation,
                        map: navigationMap,
                        title: 'Your Location',
                        icon: {
                            url: "{{ asset('images/provider-marker.png') }}",
                            scaledSize: new google.maps.Size(40, 40)
                        }
                    });
                    
                    // Draw route between provider and customer
                    directionsService = new google.maps.DirectionsService();
                    directionsRenderer = new google.maps.DirectionsRenderer({
                        map: navigationMap,
                        suppressMarkers: true,
                        polylineOptions: {
                            strokeColor: '#1E88E5',
                            strokeWeight: 5
                        }
                    });
                    
                    calculateRoute(providerLocation, requestLocation);
                    
                    // Watch position for real-time updates
                    navigator.geolocation.watchPosition(function(position) {
                        const updatedLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        providerMarker.setPosition(updatedLocation);
                        calculateRoute(updatedLocation, requestLocation);
                    });
                }, function() {
                    showMaterialSnackbar('Error: The Geolocation service failed.', 'error');
                });
            } else {
                showMaterialSnackbar('Error: Your browser doesn\'t support geolocation.', 'error');
            }
            
            function calculateRoute(origin, destination) {
                const request = {
                    origin: origin,
                    destination: destination,
                    travelMode: google.maps.TravelMode.DRIVING
                };
                
                directionsService.route(request, function(result, status) {
                    if (status == 'OK') {
                        directionsRenderer.setDirections(result);
                        
                        // Update ETA and distance
                        const route = result.routes[0];
                        if (route && route.legs.length > 0) {
                            const leg = route.legs[0];
                            document.getElementById('eta').textContent = leg.duration.text;
                            document.getElementById('distance').textContent = leg.distance.text;
                        }
                    }
                });
            }
            
            // Start Navigation button
            document.getElementById('start-navigation').addEventListener('click', function(e) {
                e.preventDefault();
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const url = `https://www.google.com/maps/dir/?api=1&origin=${position.coords.latitude},${position.coords.longitude}&destination=${requestLocation.lat},${requestLocation.lng}&travelmode=driving`;
                        window.open(url, '_blank');
                    });
                }
            });
            
            // Share Location button
            document.getElementById('share-location').addEventListener('click', function(e) {
                e.preventDefault();
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const locationUrl = `https://maps.google.com/?q=${position.coords.latitude},${position.coords.longitude}`;
                        
                        // Send location to customer (simulated)
                        fetch("{{ route('provider.share-location', $request->id) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                                locationUrl: locationUrl
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showMaterialSnackbar('Location shared with customer', 'success');
                            } else {
                                showMaterialSnackbar('Failed to share location', 'error');
                            }
                        })
                        .catch(error => {
                            showMaterialSnackbar('Error sharing location', 'error');
                        });
                    });
                }
            });
        @endif
    });
</script>
@endpush
