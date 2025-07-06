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
                        <h3 class="text-sm font-medium text-on-surface-medium mb-2">Service Provider</h3>
                        @if($request->provider)
                            <p class="text-on-surface-high font-medium">{{ $request->provider->name }}</p>
                            <p class="text-on-surface-medium text-sm">{{ $request->provider->phone }}</p>
                        @else
                            <p class="text-on-surface-medium italic">Not assigned yet</p>
                        @endif
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
                        
                        @if($request->additional_charges > 0)
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-on-surface-medium">Additional Charges</span>
                                <span class="text-on-surface-high font-medium">${{ number_format($request->additional_charges, 2) }}</span>
                            </div>
                        @endif
                        
                        @if($request->discount > 0)
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-on-surface-medium">Discount</span>
                                <span class="text-success-500 font-medium">-${{ number_format($request->discount, 2) }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center pt-2 border-t border-neutral-200 dark:border-neutral-700">
                            <span class="text-on-surface-high font-medium">Total</span>
                            <span class="text-on-surface-high font-bold">${{ number_format($request->total_amount, 2) }}</span>
                        </div>
                        
                        @if($request->payment_status)
                            <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                                <div class="flex justify-between items-center">
                                    <span class="text-on-surface-medium">Payment Status</span>
                                    @if($request->payment_status == 'paid')
                                        <span class="md-chip md-chip-success">Paid</span>
                                    @elseif($request->payment_status == 'pending')
                                        <span class="md-chip md-chip-warning">Pending</span>
                                    @else
                                        <span class="md-chip md-chip-error">Failed</span>
                                    @endif
                                </div>
                                
                                @if($request->payment_method)
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-on-surface-medium">Payment Method</span>
                                        <div class="flex items-center">
                                            @if(strpos($request->payment_method, 'card') !== false)
                                                <span class="material-icons mr-1 text-on-surface-medium">credit_card</span>
                                            @elseif(strpos($request->payment_method, 'paypal') !== false)
                                                <span class="material-icons mr-1 text-on-surface-medium">account_balance_wallet</span>
                                            @endif
                                            <span class="text-on-surface-high">{{ $request->payment_method }}</span>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($request->payment_date)
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-on-surface-medium">Payment Date</span>
                                        <span class="text-on-surface-high">{{ $request->payment_date->format('M d, Y h:i A') }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    @if($request->status == 'pending')
                        <form action="{{ route('customer.cancel-request', $request->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="md-btn md-btn-outlined md-btn-error" onclick="return confirm('Are you sure you want to cancel this request?')">
                                <span class="material-icons mr-1">cancel</span>
                                Cancel Request
                            </button>
                        </form>
                    @endif
                    
                    @if($request->status == 'completed' && !$request->review)
                        <a href="{{ route('customer.add-review', $request->id) }}" class="md-btn md-btn-filled md-btn-primary">
                            <span class="material-icons mr-1">star</span>
                            Add Review
                        </a>
                    @endif
                    
                    @if($request->status == 'completed' && $request->payment_status != 'paid')
                        <a href="{{ route('customer.make-payment', $request->id) }}" class="md-btn md-btn-filled md-btn-success">
                            <span class="material-icons mr-1">payment</span>
                            Make Payment
                        </a>
                    @endif
                    
                    <a href="{{ route('customer.service-history') }}" class="md-btn md-btn-outlined">
                        <span class="material-icons mr-1">arrow_back</span>
                        Back to History
                    </a>
                </div>
            </div>
        </div>
        
        @if($request->status == 'in_progress')
            <div class="md-card md-card-elevated mb-6">
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                    <h2 class="text-xl font-medium text-on-surface-high">Live Tracking</h2>
                </div>
                
                <div class="p-6">
                    <div class="w-full h-96 rounded-md overflow-hidden mb-4" id="tracking-map"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                            <h3 class="text-sm font-medium text-on-surface-medium mb-2">Estimated Arrival</h3>
                            <div class="flex items-center">
                                <span class="material-icons mr-2 text-primary-600 dark:text-primary-400">schedule</span>
                                <span class="text-on-surface-high font-medium" id="eta">Calculating...</span>
                            </div>
                        </div>
                        
                        <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                            <h3 class="text-sm font-medium text-on-surface-medium mb-2">Distance</h3>
                            <div class="flex items-center">
                                <span class="material-icons mr-2 text-primary-600 dark:text-primary-400">directions_car</span>
                                <span class="text-on-surface-high font-medium" id="distance">Calculating...</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md-card p-4 bg-primary-50 dark:bg-primary-900 dark:bg-opacity-30 border-l-4 border-primary-500 dark:border-primary-400">
                        <div class="flex items-start">
                            <span class="material-icons mr-2 text-primary-600 dark:text-primary-400">info</span>
                            <div>
                                <h3 class="font-medium text-primary-700 dark:text-primary-300">Service Provider En Route</h3>
                                <p class="text-primary-700 dark:text-primary-300 opacity-80">Your service provider is on the way. You can contact them directly if needed.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        @if($request->status == 'completed' && $request->review)
            <div class="md-card md-card-elevated mb-6">
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                    <h2 class="text-xl font-medium text-on-surface-high">Your Review</h2>
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
        <!-- Service Provider Info -->
        @if($request->provider)
            <div class="md-card md-card-elevated mb-6">
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                    <h2 class="text-lg font-medium text-on-surface-high">Service Provider</h2>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                            @if($request->provider->profile_image)
                                <img src="{{ asset('storage/' . $request->provider->profile_image) }}" alt="{{ $request->provider->name }}" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <span class="material-icons text-3xl text-primary-500 dark:text-primary-400">person</span>
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="font-medium text-on-surface-high">{{ $request->provider->name }}</h3>
                            <div class="flex items-center">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $request->provider->average_rating)
                                            <span class="material-icons text-warning-500 text-sm">star</span>
                                        @elseif($i - 0.5 <= $request->provider->average_rating)
                                            <span class="material-icons text-warning-500 text-sm">star_half</span>
                                        @else
                                            <span class="material-icons text-neutral-300 dark:text-neutral-600 text-sm">star_outline</span>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-on-surface-medium text-sm ml-1">({{ $request->provider->reviews_count }})</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="material-icons text-on-surface-medium mr-2">phone</span>
                            <a href="tel:{{ $request->provider->phone }}" class="text-primary-600 dark:text-primary-400">{{ $request->provider->phone }}</a>
                        </div>
                        
                        <div class="flex items-center">
                            <span class="material-icons text-on-surface-medium mr-2">email</span>
                            <a href="mailto:{{ $request->provider->email }}" class="text-primary-600 dark:text-primary-400">{{ $request->provider->email }}</a>
                        </div>
                        
                        @if($request->provider->company_name)
                            <div class="flex items-center">
                                <span class="material-icons text-on-surface-medium mr-2">business</span>
                                <span class="text-on-surface-high">{{ $request->provider->company_name }}</span>
                            </div>
                        @endif
                    </div>
                    
                    @if($request->status == 'in_progress' || $request->status == 'accepted')
                        <div class="mt-6">
                            <a href="tel:{{ $request->provider->phone }}" class="md-btn md-btn-filled w-full mb-2">
                                <span class="material-icons mr-1">call</span>
                                Call Provider
                            </a>
                            
                            <a href="sms:{{ $request->provider->phone }}" class="md-btn md-btn-outlined w-full">
                                <span class="material-icons mr-1">message</span>
                                Send Message
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Request Timeline -->
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Request Timeline</h2>
            </div>
            
            <div class="p-6">
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-neutral-200 dark:bg-neutral-700"></div>
                    
                    <div class="space-y-6">
                        @foreach($timeline as $event)
                            <div class="flex">
                                <div class="flex-shrink-0 relative z-10">
                                    <div class="w-8 h-8 rounded-full {{ $event['iconBg'] }} flex items-center justify-center">
                                        <span class="material-icons text-sm {{ $event['iconColor'] }}">{{ $event['icon'] }}</span>
                                    </div>
                                </div>
                                
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-on-surface-high">{{ $event['title'] }}</h3>
                                    <p class="text-on-surface-medium text-sm">{{ $event['description'] }}</p>
                                    <p class="text-on-surface-medium text-xs mt-1">{{ $event['time'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Help & Support -->
        <div class="md-card md-card-elevated">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Help & Support</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <a href="{{ route('customer.support') }}" class="md-card p-4 hover:bg-surface-2 transition-colors flex items-center">
                        <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full mr-4">
                            <span class="material-icons text-primary-600 dark:text-primary-400">help</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-on-surface-high">Contact Support</h4>
                            <p class="text-sm text-on-surface-medium">Get help with your request</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('customer.faq') }}" class="md-card p-4 hover:bg-surface-2 transition-colors flex items-center">
                        <div class="bg-secondary-100 dark:bg-secondary-900 dark:bg-opacity-30 p-3 rounded-full mr-4">
                            <span class="material-icons text-secondary-600 dark:text-secondary-400">question_answer</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-on-surface-high">FAQ</h4>
                            <p class="text-sm text-on-surface-medium">Frequently asked questions</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('customer.emergency') }}" class="md-card p-4 hover:bg-surface-2 transition-colors flex items-center">
                        <div class="bg-error-100 dark:bg-error-900 dark:bg-opacity-30 p-3 rounded-full mr-4">
                            <span class="material-icons text-error-600 dark:text-error-400">emergency</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-on-surface-high">Emergency Contact</h4>
                            <p class="text-sm text-on-surface-medium">Call emergency services</p>
                        </div>
                    </a>
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
            title: 'Your Location',
            animation: google.maps.Animation.DROP
        });
        
        // Initialize tracking map if request is in progress
        @if($request->status == 'in_progress')
            const trackingMap = new google.maps.Map(document.getElementById('tracking-map'), {
                center: requestLocation,
                zoom: 12,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false
            });
            
            const customerMarker = new google.maps.Marker({
                position: requestLocation,
                map: trackingMap,
                title: 'Your Location',
                icon: {
                    url: "{{ asset('images/customer-marker.png') }}",
                    scaledSize: new google.maps.Size(40, 40)
                }
            });
            
            // Provider location (simulated for demo)
            const providerLocation = {
                lat: {{ $request->latitude ?? 37.7749 }} - 0.02,
                lng: {{ $request->longitude ?? -122.4194 }} - 0.01
            };
            
            const providerMarker = new google.maps.Marker({
                position: providerLocation,
                map: trackingMap,
                title: 'Service Provider',
                icon: {
                    url: "{{ asset('images/provider-marker.png') }}",
                    scaledSize: new google.maps.Size(40, 40)
                }
            });
            
            // Draw route between provider and customer
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({
                map: trackingMap,
                suppressMarkers: true,
                polylineOptions: {
                    strokeColor: '#1E88E5',
                    strokeWeight: 5
                }
            });
            
            const request = {
                origin: providerLocation,
                destination: requestLocation,
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
            
            // Simulate provider movement (for demo purposes)
            let step = 0;
            const numSteps = 20;
            const stepDelay = 3000; // 3 seconds
            
            function moveProvider() {
                if (step < numSteps) {
                    const lat = providerLocation.lat + (requestLocation.lat - providerLocation.lat) * (step / numSteps);
                    const lng = providerLocation.lng + (requestLocation.lng - providerLocation.lng) * (step / numSteps);
                    
                    providerMarker.setPosition({ lat, lng });
                    
                    // Recalculate route
                    const updatedRequest = {
                        origin: { lat, lng },
                        destination: requestLocation,
                        travelMode: google.maps.TravelMode.DRIVING
                    };
                    
                    directionsService.route(updatedRequest, function(result, status) {
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
                    
                    step++;
                    setTimeout(moveProvider, stepDelay);
                }
            }
            
            // Start movement after a short delay
            setTimeout(moveProvider, 2000);
        @endif
    });
</script>
@endpush
