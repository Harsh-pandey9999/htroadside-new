@extends('layouts.material')

@section('title', 'Profile & Settings')
@section('page_title', 'Profile & Settings')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Profile Information -->
    <div class="lg:col-span-2">
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-medium text-on-surface-high">Profile Information</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('provider.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex flex-col md:flex-row gap-6 mb-6">
                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-4 overflow-hidden">
                                @if($provider->profile_image)
                                    <img src="{{ asset('storage/' . $provider->profile_image) }}" alt="{{ $provider->name }}" class="w-32 h-32 object-cover">
                                @else
                                    <span class="material-icons text-6xl text-primary-500 dark:text-primary-400">person</span>
                                @endif
                            </div>
                            
                            <div class="md-input-field w-full">
                                <input type="file" id="profile_image" name="profile_image" class="md-input" accept="image/*">
                                <label for="profile_image">Change Profile Image</label>
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="md-input-field">
                                    <input type="text" id="name" name="name" value="{{ old('name', $provider->name) }}" class="md-input" required>
                                    <label for="name">Full Name</label>
                                    @error('name')
                                        <span class="text-error-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="md-input-field">
                                    <input type="email" id="email" name="email" value="{{ old('email', $provider->email) }}" class="md-input" required>
                                    <label for="email">Email Address</label>
                                    @error('email')
                                        <span class="text-error-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="md-input-field">
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $provider->phone) }}" class="md-input" required>
                                    <label for="phone">Phone Number</label>
                                    @error('phone')
                                        <span class="text-error-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="md-input-field">
                                    <select id="service_area" name="service_area" class="md-select" required>
                                        <option value="">Select Service Area</option>
                                        @foreach($serviceAreas as $area)
                                            <option value="{{ $area->id }}" {{ old('service_area', $provider->service_area_id) == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="service_area">Service Area</label>
                                    @error('service_area')
                                        <span class="text-error-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="md-input-field mb-4">
                                <textarea id="bio" name="bio" class="md-input" rows="3">{{ old('bio', $provider->bio) }}</textarea>
                                <label for="bio">Bio / Description</label>
                                @error('bio')
                                    <span class="text-error-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="md-input-field">
                                <input type="text" id="address" name="address" value="{{ old('address', $provider->address) }}" class="md-input" required>
                                <label for="address">Address</label>
                                @error('address')
                                    <span class="text-error-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">save</span>
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-medium text-on-surface-high">Business Information</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('provider.business.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="md-input-field">
                            <input type="text" id="business_name" name="business_name" value="{{ old('business_name', $provider->business_name) }}" class="md-input" required>
                            <label for="business_name">Business Name</label>
                            @error('business_name')
                                <span class="text-error-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="md-input-field">
                            <input type="text" id="tax_id" name="tax_id" value="{{ old('tax_id', $provider->tax_id) }}" class="md-input">
                            <label for="tax_id">Tax ID / EIN</label>
                            @error('tax_id')
                                <span class="text-error-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="md-input-field">
                            <input type="text" id="website" name="website" value="{{ old('website', $provider->website) }}" class="md-input">
                            <label for="website">Website</label>
                            @error('website')
                                <span class="text-error-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="md-input-field">
                            <input type="text" id="years_in_business" name="years_in_business" value="{{ old('years_in_business', $provider->years_in_business) }}" class="md-input">
                            <label for="years_in_business">Years in Business</label>
                            @error('years_in_business')
                                <span class="text-error-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-on-surface-medium mb-2">Business Logo</label>
                        
                        @if($provider->business_logo)
                            <div class="mb-2 flex items-center">
                                <img src="{{ asset('storage/' . $provider->business_logo) }}" alt="Business Logo" class="h-16 object-contain mr-2">
                                <div class="md-checkbox">
                                    <input type="checkbox" id="remove_logo" name="remove_logo" value="1">
                                    <label for="remove_logo">Remove current logo</label>
                                </div>
                            </div>
                        @endif
                        
                        <div class="md-input-field">
                            <input type="file" id="business_logo" name="business_logo" class="md-input" accept="image/*">
                            <label for="business_logo">Upload New Logo</label>
                            @error('business_logo')
                                <span class="text-error-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="md-input-field mb-4">
                        <textarea id="business_description" name="business_description" class="md-input" rows="3">{{ old('business_description', $provider->business_description) }}</textarea>
                        <label for="business_description">Business Description</label>
                        @error('business_description')
                            <span class="text-error-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">business</span>
                            Update Business Info
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-medium text-on-surface-high">Services Offered</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('provider.services.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        @foreach($services as $service)
                            <div class="md-card p-4">
                                <div class="md-checkbox">
                                    <input type="checkbox" id="service_{{ $service->id }}" name="services[]" value="{{ $service->id }}" 
                                        {{ in_array($service->id, $providerServices) ? 'checked' : '' }}>
                                    <label for="service_{{ $service->id }}">{{ $service->name }}</label>
                                </div>
                                
                                <p class="text-on-surface-medium text-sm mt-1 ml-7">{{ $service->description }}</p>
                                
                                <div class="md-input-field mt-2 ml-7">
                                    <input type="number" id="service_price_{{ $service->id }}" name="service_prices[{{ $service->id }}]" 
                                        value="{{ old('service_prices.' . $service->id, $servicePrices[$service->id] ?? $service->base_price) }}" 
                                        class="md-input" step="0.01" min="0" {{ !in_array($service->id, $providerServices) ? 'disabled' : '' }}>
                                    <label for="service_price_{{ $service->id }}">Your Price ($)</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">build</span>
                            Update Services
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-medium text-on-surface-high">Change Password</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('provider.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="md-input-field">
                            <input type="password" id="current_password" name="current_password" class="md-input" required>
                            <label for="current_password">Current Password</label>
                            @error('current_password')
                                <span class="text-error-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div></div>
                        
                        <div class="md-input-field">
                            <input type="password" id="password" name="password" class="md-input" required>
                            <label for="password">New Password</label>
                            @error('password')
                                <span class="text-error-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="md-input-field">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="md-input" required>
                            <label for="password_confirmation">Confirm New Password</label>
                        </div>
                    </div>
                    
                    <div class="md-card p-4 bg-info-50 dark:bg-info-900 dark:bg-opacity-30 border-l-4 border-info-500 dark:border-info-400 mb-4">
                        <div class="flex items-start">
                            <span class="material-icons mr-2 text-info-600 dark:text-info-400">info</span>
                            <div>
                                <h3 class="font-medium text-info-700 dark:text-info-300">Password Requirements</h3>
                                <p class="text-info-700 dark:text-info-300 opacity-80">Password must be at least 8 characters long and include uppercase, lowercase, numbers, and special characters.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">lock</span>
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Account Status -->
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Account Status</h2>
            </div>
            
            <div class="p-6">
                <div class="flex items-center mb-4">
                    @if($provider->is_verified)
                        <div class="w-12 h-12 bg-success-100 dark:bg-success-900 rounded-full flex items-center justify-center mr-4">
                            <span class="material-icons text-success-600 dark:text-success-400">verified</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-on-surface-high">Verified Provider</h3>
                            <p class="text-on-surface-medium text-sm">Your account is fully verified</p>
                        </div>
                    @else
                        <div class="w-12 h-12 bg-warning-100 dark:bg-warning-900 rounded-full flex items-center justify-center mr-4">
                            <span class="material-icons text-warning-600 dark:text-warning-400">pending</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-on-surface-high">Verification Pending</h3>
                            <p class="text-on-surface-medium text-sm">Your account is under review</p>
                        </div>
                    @endif
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-medium">Member Since</span>
                        <span class="text-on-surface-high">{{ $provider->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-medium">Account Status</span>
                        @if($provider->is_active)
                            <span class="md-chip md-chip-success">Active</span>
                        @else
                            <span class="md-chip md-chip-error">Inactive</span>
                        @endif
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-medium">Completed Services</span>
                        <span class="text-on-surface-high">{{ $stats['completed_services'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-medium">Average Rating</span>
                        <div class="flex items-center">
                            <span class="material-icons text-warning-500 mr-1">star</span>
                            <span class="text-on-surface-high">{{ number_format($stats['avg_rating'], 1) }}</span>
                        </div>
                    </div>
                </div>
                
                @if(!$provider->is_verified)
                    <div class="mt-6">
                        <a href="{{ route('provider.verification') }}" class="md-btn md-btn-filled w-full">
                            <span class="material-icons mr-1">verified</span>
                            Complete Verification
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Service Area -->
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Service Area</h2>
            </div>
            
            <div class="p-6">
                <div class="w-full h-64 rounded-md overflow-hidden mb-4" id="service-area-map"></div>
                
                <form action="{{ route('provider.service-radius.update') }}" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="md-input-field mb-4">
                        <input type="number" id="service_radius" name="service_radius" value="{{ old('service_radius', $provider->service_radius) }}" class="md-input" min="1" max="100" required>
                        <label for="service_radius">Service Radius (km)</label>
                        @error('service_radius')
                            <span class="text-error-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">edit_location</span>
                            Update Radius
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Notification Settings -->
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Notification Settings</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('provider.notifications.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div class="md-checkbox">
                            <input type="checkbox" id="email_notifications" name="email_notifications" value="1" {{ $provider->email_notifications ? 'checked' : '' }}>
                            <label for="email_notifications">Email Notifications</label>
                        </div>
                        
                        <div class="md-checkbox">
                            <input type="checkbox" id="sms_notifications" name="sms_notifications" value="1" {{ $provider->sms_notifications ? 'checked' : '' }}>
                            <label for="sms_notifications">SMS Notifications</label>
                        </div>
                        
                        <div class="md-checkbox">
                            <input type="checkbox" id="push_notifications" name="push_notifications" value="1" {{ $provider->push_notifications ? 'checked' : '' }}>
                            <label for="push_notifications">Push Notifications</label>
                        </div>
                        
                        <div class="md-checkbox">
                            <input type="checkbox" id="new_request_alert" name="new_request_alert" value="1" {{ $provider->new_request_alert ? 'checked' : '' }}>
                            <label for="new_request_alert">New Request Alerts</label>
                        </div>
                        
                        <div class="md-checkbox">
                            <input type="checkbox" id="marketing_emails" name="marketing_emails" value="1" {{ $provider->marketing_emails ? 'checked' : '' }}>
                            <label for="marketing_emails">Marketing Emails</label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">notifications</span>
                            Save Preferences
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Account Actions -->
        <div class="md-card md-card-elevated">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Account Actions</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-3">
                    @if($provider->is_active)
                        <form action="{{ route('provider.account.toggle-status') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="0">
                            <button type="submit" class="md-btn md-btn-outlined md-btn-warning w-full" onclick="return confirm('Are you sure you want to deactivate your account? You won\'t receive new service requests while inactive.')">
                                <span class="material-icons mr-1">pause_circle</span>
                                Temporarily Deactivate Account
                            </button>
                        </form>
                    @else
                        <form action="{{ route('provider.account.toggle-status') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="1">
                            <button type="submit" class="md-btn md-btn-filled md-btn-success w-full">
                                <span class="material-icons mr-1">play_circle</span>
                                Reactivate Account
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('provider.account.download-data') }}" class="md-btn md-btn-outlined w-full">
                        <span class="material-icons mr-1">download</span>
                        Download My Data
                    </a>
                    
                    <form action="{{ route('provider.account.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="md-btn md-btn-outlined md-btn-error w-full" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                            <span class="material-icons mr-1">delete_forever</span>
                            Delete Account
                        </button>
                    </form>
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
        // Initialize service area map
        const providerLocation = {
            lat: {{ $provider->latitude ?? 37.7749 }},
            lng: {{ $provider->longitude ?? -122.4194 }}
        };
        
        const map = new google.maps.Map(document.getElementById('service-area-map'), {
            center: providerLocation,
            zoom: 11,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false
        });
        
        const marker = new google.maps.Marker({
            position: providerLocation,
            map: map,
            title: 'Your Location',
            draggable: true
        });
        
        const circle = new google.maps.Circle({
            strokeColor: '#1E88E5',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#1E88E5',
            fillOpacity: 0.1,
            map: map,
            center: providerLocation,
            radius: {{ $provider->service_radius * 1000 }} // Convert km to meters
        });
        
        // Update circle when radius input changes
        document.getElementById('service_radius').addEventListener('input', function() {
            const radius = parseInt(this.value) * 1000; // Convert km to meters
            circle.setRadius(radius);
        });
        
        // Update marker and circle when marker is dragged
        marker.addListener('dragend', function() {
            const position = marker.getPosition();
            circle.setCenter(position);
            
            // Update hidden inputs for lat/lng
            document.getElementById('latitude').value = position.lat();
            document.getElementById('longitude').value = position.lng();
            
            // Reverse geocode to get address
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: position }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    document.getElementById('address').value = results[0].formatted_address;
                }
            });
        });
        
        // Toggle service checkbox and price input
        document.querySelectorAll('[id^="service_"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const serviceId = this.id.replace('service_', '');
                const priceInput = document.getElementById('service_price_' + serviceId);
                
                if (priceInput) {
                    priceInput.disabled = !this.checked;
                }
            });
        });
    });
</script>
@endpush
