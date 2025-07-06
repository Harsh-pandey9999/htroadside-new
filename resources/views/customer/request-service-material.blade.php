@extends('layouts.material')

@section('title', 'Request Roadside Assistance')
@section('page_title', 'Request Roadside Assistance')

@section('content')
<div class="md-card md-card-elevated p-6 mb-6">
    <div class="mb-6">
        <h2 class="text-xl font-medium text-on-surface-high">Request Roadside Assistance</h2>
        <p class="text-on-surface-medium mt-1">Fill in the details below to request immediate roadside assistance</p>
    </div>

    <form action="{{ route('customer.submit-service-request') }}" method="POST" class="md-form">
        @csrf
        
        <div class="md-stepper mb-8">
            <div class="md-stepper-header">
                <div class="md-step active" data-step="1">
                    <div class="md-step-circle">
                        <span class="material-icons">directions_car</span>
                    </div>
                    <div class="md-step-label">Vehicle</div>
                </div>
                <div class="md-step-connector"></div>
                <div class="md-step" data-step="2">
                    <div class="md-step-circle">
                        <span class="material-icons">location_on</span>
                    </div>
                    <div class="md-step-label">Location</div>
                </div>
                <div class="md-step-connector"></div>
                <div class="md-step" data-step="3">
                    <div class="md-step-circle">
                        <span class="material-icons">build</span>
                    </div>
                    <div class="md-step-label">Service</div>
                </div>
                <div class="md-step-connector"></div>
                <div class="md-step" data-step="4">
                    <div class="md-step-circle">
                        <span class="material-icons">check_circle</span>
                    </div>
                    <div class="md-step-label">Confirm</div>
                </div>
            </div>
            
            <div class="md-stepper-content mt-8">
                <!-- Step 1: Vehicle Selection -->
                <div class="md-step-panel active" data-step="1">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">Select Your Vehicle</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            @forelse($vehicles as $vehicle)
                            <div class="md-card p-4 cursor-pointer hover:bg-surface-2 transition-colors vehicle-card" data-vehicle-id="{{ $vehicle->id }}">
                                <div class="flex items-center">
                                    <div class="md-radio mr-4">
                                        <input type="radio" name="vehicle_id" id="vehicle_{{ $vehicle->id }}" value="{{ $vehicle->id }}" class="vehicle-radio">
                                        <label for="vehicle_{{ $vehicle->id }}"></label>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</h4>
                                        <p class="text-sm text-on-surface-medium">{{ $vehicle->color }} • {{ $vehicle->license_plate }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-2">
                                <div class="md-card p-6 text-center">
                                    <span class="material-icons text-4xl text-neutral-400 mb-2">directions_car_off</span>
                                    <p class="text-on-surface-medium mb-4">You don't have any vehicles registered yet.</p>
                                    <a href="{{ route('customer.vehicles.create') }}" class="md-btn md-btn-filled">Add a Vehicle</a>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <a href="{{ route('customer.vehicles.create') }}" class="md-btn md-btn-text flex items-center">
                                <span class="material-icons mr-1">add</span>
                                Add New Vehicle
                            </a>
                            <button type="button" class="md-btn md-btn-filled next-step" data-next="2" disabled>Next</button>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2: Location -->
                <div class="md-step-panel" data-step="2">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">Your Location</h3>
                        
                        <div class="mb-6">
                            <div class="md-input-field mb-4">
                                <button type="button" id="use-current-location" class="md-btn md-btn-outlined w-full flex items-center justify-center">
                                    <span class="material-icons mr-2">my_location</span>
                                    Use My Current Location
                                </button>
                            </div>
                            
                            <div class="md-card p-4 mb-4">
                                <div id="map" class="w-full h-64 rounded-md"></div>
                            </div>
                            
                            <div class="md-input-field mb-4">
                                <input type="text" id="address" name="address" class="md-input" required>
                                <label for="address">Street Address</label>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="md-input-field">
                                    <input type="text" id="city" name="city" class="md-input" required>
                                    <label for="city">City</label>
                                </div>
                                <div class="md-input-field">
                                    <input type="text" id="state" name="state" class="md-input" required>
                                    <label for="state">State</label>
                                </div>
                            </div>
                            
                            <div class="md-input-field mb-4">
                                <input type="text" id="zip" name="zip" class="md-input" required>
                                <label for="zip">ZIP Code</label>
                            </div>
                            
                            <div class="md-input-field">
                                <textarea id="location_notes" name="location_notes" class="md-input" rows="3"></textarea>
                                <label for="location_notes">Additional Location Details (Optional)</label>
                                <div class="md-helper-text">E.g., landmarks, parking lot section, or other details to help the service provider find you</div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between">
                            <button type="button" class="md-btn md-btn-outlined prev-step" data-prev="1">Back</button>
                            <button type="button" class="md-btn md-btn-filled next-step" data-next="3">Next</button>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3: Service Type -->
                <div class="md-step-panel" data-step="3">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">Select Service Type</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            @foreach($services as $service)
                            <div class="md-card p-4 cursor-pointer hover:bg-surface-2 transition-colors service-card" data-service-id="{{ $service->id }}">
                                <div class="flex items-center">
                                    <div class="md-radio mr-4">
                                        <input type="radio" name="service_id" id="service_{{ $service->id }}" value="{{ $service->id }}" class="service-radio">
                                        <label for="service_{{ $service->id }}"></label>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium">{{ $service->name }}</h4>
                                        <p class="text-sm text-on-surface-medium">{{ $service->description }}</p>
                                        <p class="text-sm font-medium text-primary-600 mt-1">${{ number_format($service->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="md-input-field mb-6">
                            <textarea id="service_notes" name="service_notes" class="md-input" rows="3"></textarea>
                            <label for="service_notes">Additional Service Details (Optional)</label>
                            <div class="md-helper-text">Describe your issue in more detail to help the service provider</div>
                        </div>
                        
                        <div class="flex justify-between">
                            <button type="button" class="md-btn md-btn-outlined prev-step" data-prev="2">Back</button>
                            <button type="button" class="md-btn md-btn-filled next-step" data-next="4">Next</button>
                        </div>
                    </div>
                </div>
                
                <!-- Step 4: Confirmation -->
                <div class="md-step-panel" data-step="4">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">Confirm Your Request</h3>
                        
                        <div class="md-card p-6 mb-6">
                            <h4 class="font-medium mb-4">Request Summary</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h5 class="text-sm font-medium text-on-surface-medium mb-2">Vehicle</h5>
                                    <p id="summary-vehicle" class="font-medium"></p>
                                </div>
                                
                                <div>
                                    <h5 class="text-sm font-medium text-on-surface-medium mb-2">Service Type</h5>
                                    <p id="summary-service" class="font-medium"></p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <h5 class="text-sm font-medium text-on-surface-medium mb-2">Location</h5>
                                    <p id="summary-location" class="font-medium"></p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <h5 class="text-sm font-medium text-on-surface-medium mb-2">Additional Notes</h5>
                                    <p id="summary-notes" class="font-medium text-on-surface-medium"></p>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-6 border-t border-neutral-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-on-surface-high font-medium">Estimated Price:</span>
                                    <span id="summary-price" class="text-xl font-semibold text-primary-600"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md-checkbox mb-6">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">I agree to the <a href="{{ route('terms') }}" class="text-primary-600" target="_blank">Terms of Service</a> and <a href="{{ route('privacy') }}" class="text-primary-600" target="_blank">Privacy Policy</a></label>
                        </div>
                        
                        <div class="flex justify-between">
                            <button type="button" class="md-btn md-btn-outlined prev-step" data-prev="3">Back</button>
                            <button type="submit" class="md-btn md-btn-filled" id="submit-request" disabled>Submit Request</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let map, marker;
        let currentStep = 1;
        let selectedVehicle = null;
        let selectedService = null;
        let userLocation = null;
        
        // Initialize map
        function initMap() {
            const defaultLocation = {lat: 37.7749, lng: -122.4194}; // Default to San Francisco
            
            map = new google.maps.Map(document.getElementById('map'), {
                center: defaultLocation,
                zoom: 13,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false
            });
            
            marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP
            });
            
            // Update address fields when marker is dragged
            google.maps.event.addListener(marker, 'dragend', function() {
                const position = marker.getPosition();
                reverseGeocode(position.lat(), position.lng());
            });
        }
        
        // Get current location
        document.getElementById('use-current-location').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    
                    map.setCenter(pos);
                    marker.setPosition(pos);
                    userLocation = pos;
                    
                    reverseGeocode(pos.lat, pos.lng);
                }, function() {
                    showSnackbar('Error: The Geolocation service failed.', 'error');
                });
            } else {
                showSnackbar('Error: Your browser doesn\'t support geolocation.', 'error');
            }
        });
        
        // Reverse geocode to get address from coordinates
        function reverseGeocode(lat, lng) {
            const geocoder = new google.maps.Geocoder();
            const latlng = {lat: lat, lng: lng};
            
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        const addressComponents = results[0].address_components;
                        let street = '', city = '', state = '', zip = '';
                        
                        for (let i = 0; i < addressComponents.length; i++) {
                            const component = addressComponents[i];
                            const types = component.types;
                            
                            if (types.includes('street_number')) {
                                street = component.long_name + ' ';
                            } else if (types.includes('route')) {
                                street += component.long_name;
                            } else if (types.includes('locality')) {
                                city = component.long_name;
                            } else if (types.includes('administrative_area_level_1')) {
                                state = component.short_name;
                            } else if (types.includes('postal_code')) {
                                zip = component.long_name;
                            }
                        }
                        
                        document.getElementById('address').value = street;
                        document.getElementById('city').value = city;
                        document.getElementById('state').value = state;
                        document.getElementById('zip').value = zip;
                        
                        // Trigger input events to activate floating labels
                        document.querySelectorAll('.md-input').forEach(input => {
                            if (input.value) {
                                input.classList.add('has-value');
                            }
                        });
                    }
                }
            });
        }
        
        // Initialize map when step 2 becomes active
        function checkAndInitMap() {
            if (currentStep === 2 && !map) {
                setTimeout(initMap, 100); // Small delay to ensure the map container is visible
            }
        }
        
        // Vehicle selection
        document.querySelectorAll('.vehicle-card').forEach(card => {
            card.addEventListener('click', function() {
                const vehicleId = this.dataset.vehicleId;
                const radio = document.getElementById('vehicle_' + vehicleId);
                
                radio.checked = true;
                
                document.querySelectorAll('.vehicle-card').forEach(c => {
                    c.classList.remove('border-primary-500', 'border-2');
                });
                
                this.classList.add('border-primary-500', 'border-2');
                
                selectedVehicle = {
                    id: vehicleId,
                    name: this.querySelector('h4').textContent
                };
                
                document.querySelector('.next-step[data-next="2"]').disabled = false;
            });
        });
        
        // Service selection
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function() {
                const serviceId = this.dataset.serviceId;
                const radio = document.getElementById('service_' + serviceId);
                
                radio.checked = true;
                
                document.querySelectorAll('.service-card').forEach(c => {
                    c.classList.remove('border-primary-500', 'border-2');
                });
                
                this.classList.add('border-primary-500', 'border-2');
                
                selectedService = {
                    id: serviceId,
                    name: this.querySelector('h4').textContent,
                    price: this.querySelector('.text-primary-600').textContent
                };
                
                document.querySelector('.next-step[data-next="4"]').disabled = false;
            });
        });
        
        // Stepper navigation
        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', function() {
                const nextStep = parseInt(this.dataset.next);
                
                // Validate current step
                if (currentStep === 1 && !selectedVehicle) {
                    showSnackbar('Please select a vehicle', 'error');
                    return;
                }
                
                if (currentStep === 2) {
                    const address = document.getElementById('address').value;
                    const city = document.getElementById('city').value;
                    const state = document.getElementById('state').value;
                    const zip = document.getElementById('zip').value;
                    
                    if (!address || !city || !state || !zip) {
                        showSnackbar('Please complete all location fields', 'error');
                        return;
                    }
                }
                
                if (currentStep === 3 && !selectedService) {
                    showSnackbar('Please select a service type', 'error');
                    return;
                }
                
                // Update stepper
                document.querySelector(`.md-step[data-step="${currentStep}"]`).classList.remove('active');
                document.querySelector(`.md-step[data-step="${nextStep}"]`).classList.add('active');
                
                // Hide current panel, show next panel
                document.querySelector(`.md-step-panel[data-step="${currentStep}"]`).classList.remove('active');
                document.querySelector(`.md-step-panel[data-step="${nextStep}"]`).classList.add('active');
                
                currentStep = nextStep;
                
                // Initialize map if needed
                checkAndInitMap();
                
                // Update summary if on confirmation step
                if (currentStep === 4) {
                    updateSummary();
                }
            });
        });
        
        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', function() {
                const prevStep = parseInt(this.dataset.prev);
                
                // Update stepper
                document.querySelector(`.md-step[data-step="${currentStep}"]`).classList.remove('active');
                document.querySelector(`.md-step[data-step="${prevStep}"]`).classList.add('active');
                
                // Hide current panel, show previous panel
                document.querySelector(`.md-step-panel[data-step="${currentStep}"]`).classList.remove('active');
                document.querySelector(`.md-step-panel[data-step="${prevStep}"]`).classList.add('active');
                
                currentStep = prevStep;
            });
        });
        
        // Update summary
        function updateSummary() {
            if (selectedVehicle) {
                document.getElementById('summary-vehicle').textContent = selectedVehicle.name;
            }
            
            if (selectedService) {
                document.getElementById('summary-service').textContent = selectedService.name;
                document.getElementById('summary-price').textContent = selectedService.price;
            }
            
            const address = document.getElementById('address').value;
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const zip = document.getElementById('zip').value;
            const locationNotes = document.getElementById('location_notes').value;
            
            document.getElementById('summary-location').textContent = `${address}, ${city}, ${state} ${zip}`;
            
            const serviceNotes = document.getElementById('service_notes').value;
            const notes = [];
            
            if (locationNotes) notes.push(`Location: ${locationNotes}`);
            if (serviceNotes) notes.push(`Service: ${serviceNotes}`);
            
            document.getElementById('summary-notes').textContent = notes.length > 0 ? notes.join('\n') : 'None provided';
        }
        
        // Terms checkbox
        document.getElementById('terms').addEventListener('change', function() {
            document.getElementById('submit-request').disabled = !this.checked;
        });
        
        // Show snackbar message
        function showSnackbar(message, type = 'info') {
            // Use Material.js snackbar function if available
            if (typeof showMaterialSnackbar === 'function') {
                showMaterialSnackbar(message, type);
            } else {
                alert(message);
            }
        }
    });
</script>
@endpush
