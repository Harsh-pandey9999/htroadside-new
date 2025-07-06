@extends('admin.layouts.material')

@section('title', 'Service Request Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Service Request Details Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Request #{{ $serviceRequest->id }} Details</h5>
                <span class="badge {{ $serviceRequest->status_color }}">{{ $serviceRequest->status }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-1">Service Type</h6>
                        <p class="mb-3 fw-bold">{{ $serviceRequest->service->name }}</p>
                        
                        <h6 class="text-muted mb-1">Customer</h6>
                        <p class="mb-3">
                            <strong>{{ $serviceRequest->user->name }}</strong><br>
                            {{ $serviceRequest->user->email }}<br>
                            {{ $serviceRequest->user->phone }}
                        </p>
                        
                        <h6 class="text-muted mb-1">Vehicle Information</h6>
                        <p class="mb-3">
                            <strong>{{ $serviceRequest->vehicle_make }} {{ $serviceRequest->vehicle_model }} ({{ $serviceRequest->vehicle_year }})</strong><br>
                            Color: {{ $serviceRequest->vehicle_color }}<br>
                            License: {{ $serviceRequest->vehicle_license }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-1">Request Date</h6>
                        <p class="mb-3">{{ $serviceRequest->created_at->format('M d, Y h:i A') }}</p>
                        
                        <h6 class="text-muted mb-1">Location</h6>
                        <p class="mb-3">
                            {{ $serviceRequest->location }}<br>
                            <small class="text-muted">
                                Lat: {{ $serviceRequest->latitude }}, 
                                Lng: {{ $serviceRequest->longitude }}
                            </small>
                        </p>
                        
                        <h6 class="text-muted mb-1">Assigned Provider</h6>
                        @if($serviceRequest->assignedProvider)
                            <p class="mb-3">
                                <strong>{{ $serviceRequest->assignedProvider->name }}</strong><br>
                                {{ $serviceRequest->assignedProvider->email }}<br>
                                {{ $serviceRequest->assignedProvider->phone }}
                            </p>
                        @else
                            <p class="mb-3 text-warning">
                                <i class="material-icons-outlined me-1" style="font-size: 16px; vertical-align: text-bottom;">warning</i>
                                Not yet assigned
                            </p>
                        @endif
                    </div>
                </div>
                
                <h6 class="text-muted mb-2">Description</h6>
                <p class="mb-4">{{ $serviceRequest->description ?: 'No description provided.' }}</p>
                
                <div class="divider my-4"></div>
                
                <!-- Status Update Form -->
                <h6 class="text-muted mb-3">Update Status</h6>
                <form action="{{ route('admin.service-requests.update-status', $serviceRequest) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-outline">
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending" {{ $serviceRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $serviceRequest->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="assigned" {{ $serviceRequest->status == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                    <option value="in_progress" {{ $serviceRequest->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $serviceRequest->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $serviceRequest->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <label class="form-label" for="status">Status</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </div>
                    </div>
                </form>
                
                <!-- Assign Provider Form -->
                <h6 class="text-muted mb-3">Assign Service Provider</h6>
                <form action="{{ route('admin.service-requests.assign-provider', $serviceRequest) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-outline">
                                <select class="form-select" id="provider_id" name="provider_id" required>
                                    <option value="">Select Provider</option>
                                    @foreach($availableProviders as $provider)
                                        <option value="{{ $provider->id }}" {{ $serviceRequest->provider_id == $provider->id ? 'selected' : '' }}>
                                            {{ $provider->name }} ({{ $provider->phone }})
                                        </option>
                                    @endforeach
                                </select>
                                <label class="form-label" for="provider_id">Service Provider</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100">Assign Provider</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Notes Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Notes & Updates</h5>
            </div>
            <div class="card-body">
                @if($serviceRequest->notes && $serviceRequest->notes->count() > 0)
                    <div class="timeline">
                        @foreach($serviceRequest->notes->sortByDesc('created_at') as $note)
                            <div class="timeline-item mb-4 pb-4 border-bottom">
                                <div class="d-flex mb-2">
                                    <div class="me-3">
                                        @if($note->user && $note->user->profile_photo)
                                            <img src="{{ asset('storage/' . $note->user->profile_photo) }}" alt="{{ $note->user->name }}" class="avatar">
                                        @else
                                            <div class="avatar bg-primary d-flex align-items-center justify-content-center text-white">
                                                {{ $note->user ? strtoupper(substr($note->user->name, 0, 1)) : 'S' }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $note->user ? $note->user->name : 'System' }}</h6>
                                        <small class="text-muted">{{ $note->created_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                </div>
                                <div class="ms-5 ps-2">
                                    <p class="mb-0">{{ $note->content }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="material-icons-outlined text-muted" style="font-size: 48px;">comment</i>
                        <p class="text-muted mt-2">No notes available for this service request.</p>
                    </div>
                @endif
                
                <!-- Add Note Form -->
                <form action="{{ route('admin.service-requests.add-note', $serviceRequest) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="form-outline mb-3">
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                        <label class="form-label" for="content">Add a note</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Note</button>
                </form>
            </div>
        </div>
        
        <!-- Attachments Card -->
        @if($serviceRequest->attachments && $serviceRequest->attachments->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Attachments</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($serviceRequest->attachments as $attachment)
                            <div class="col-md-4">
                                <div class="card h-100">
                                    @if(in_array(pathinfo($attachment->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $attachment->file_path) }}" class="card-img-top" alt="Attachment">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                                            <i class="material-icons-outlined text-muted" style="font-size: 48px;">description</i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title text-truncate">{{ $attachment->file_name }}</h6>
                                        <p class="card-text small text-muted">
                                            Added: {{ $attachment->created_at->format('M d, Y') }}
                                        </p>
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                            <i class="material-icons-outlined me-1" style="font-size: 16px; vertical-align: text-bottom;">download</i>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <!-- Map Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Location</h5>
            </div>
            <div class="card-body p-0">
                <div id="map" style="height: 300px;"></div>
            </div>
        </div>
        
        <!-- Customer Info Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Customer Information</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    @if($serviceRequest->user->profile_photo)
                        <img src="{{ asset('storage/' . $serviceRequest->user->profile_photo) }}" alt="{{ $serviceRequest->user->name }}" class="avatar me-3">
                    @else
                        <div class="avatar bg-primary d-flex align-items-center justify-content-center text-white me-3">
                            {{ strtoupper(substr($serviceRequest->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h6 class="mb-0">{{ $serviceRequest->user->name }}</h6>
                        <small class="text-muted">Customer since {{ $serviceRequest->user->created_at->format('M Y') }}</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-muted mb-1">Contact Information</h6>
                    <p class="mb-1">
                        <i class="material-icons-outlined me-2" style="font-size: 16px; vertical-align: text-bottom;">email</i>
                        {{ $serviceRequest->user->email }}
                    </p>
                    <p class="mb-0">
                        <i class="material-icons-outlined me-2" style="font-size: 16px; vertical-align: text-bottom;">phone</i>
                        {{ $serviceRequest->user->phone }}
                    </p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-muted mb-1">Membership</h6>
                    @if($serviceRequest->user->activeMembership)
                        <div class="chip bg-success text-white">
                            <i class="material-icons-outlined me-1" style="font-size: 16px; vertical-align: text-bottom;">verified</i>
                            {{ $serviceRequest->user->activeMembership->plan->name }}
                        </div>
                        <p class="small text-muted mt-1">
                            Expires: {{ $serviceRequest->user->activeMembership->expires_at->format('M d, Y') }}
                        </p>
                    @else
                        <div class="chip bg-light">
                            <i class="material-icons-outlined me-1" style="font-size: 16px; vertical-align: text-bottom;">not_interested</i>
                            No active membership
                        </div>
                    @endif
                </div>
                
                <div>
                    <h6 class="text-muted mb-1">Service History</h6>
                    <p class="mb-0">
                        <span class="fw-bold">{{ $serviceRequest->user->serviceRequests->count() }}</span> total requests
                        (<span class="fw-bold">{{ $serviceRequest->user->serviceRequests->where('status', 'completed')->count() }}</span> completed)
                    </p>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.users.show', $serviceRequest->user) }}" class="btn btn-outline-primary btn-sm">
                        <i class="material-icons-outlined me-1" style="font-size: 16px; vertical-align: text-bottom;">person</i>
                        View Full Profile
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Service Provider Info Card -->
        @if($serviceRequest->assignedProvider)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Assigned Provider</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($serviceRequest->assignedProvider->profile_photo)
                            <img src="{{ asset('storage/' . $serviceRequest->assignedProvider->profile_photo) }}" alt="{{ $serviceRequest->assignedProvider->name }}" class="avatar me-3">
                        @else
                            <div class="avatar bg-info d-flex align-items-center justify-content-center text-white me-3">
                                {{ strtoupper(substr($serviceRequest->assignedProvider->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $serviceRequest->assignedProvider->name }}</h6>
                            <small class="text-muted">Provider since {{ $serviceRequest->assignedProvider->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Contact Information</h6>
                        <p class="mb-1">
                            <i class="material-icons-outlined me-2" style="font-size: 16px; vertical-align: text-bottom;">email</i>
                            {{ $serviceRequest->assignedProvider->email }}
                        </p>
                        <p class="mb-0">
                            <i class="material-icons-outlined me-2" style="font-size: 16px; vertical-align: text-bottom;">phone</i>
                            {{ $serviceRequest->assignedProvider->phone }}
                        </p>
                    </div>
                    
                    <div>
                        <h6 class="text-muted mb-1">Service Stats</h6>
                        <p class="mb-0">
                            <span class="fw-bold">{{ $serviceRequest->assignedProvider->assignedServiceRequests->count() }}</span> total assignments
                            (<span class="fw-bold">{{ $serviceRequest->assignedProvider->assignedServiceRequests->where('status', 'completed')->count() }}</span> completed)
                        </p>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('admin.users.show', $serviceRequest->assignedProvider) }}" class="btn btn-outline-primary btn-sm">
                            <i class="material-icons-outlined me-1" style="font-size: 16px; vertical-align: text-bottom;">engineering</i>
                            View Full Profile
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap" async defer></script>
<script>
    function initMap() {
        const location = {
            lat: {{ $serviceRequest->latitude }},
            lng: {{ $serviceRequest->longitude }}
        };
        
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: location,
        });
        
        const marker = new google.maps.Marker({
            position: location,
            map: map,
            title: '{{ $serviceRequest->location }}'
        });
        
        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="padding: 10px;">
                    <h6 style="margin: 0 0 5px 0;">{{ $serviceRequest->service->name }}</h6>
                    <p style="margin: 0;">{{ $serviceRequest->location }}</p>
                </div>
            `
        });
        
        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });
        
        // Open info window by default
        infoWindow.open(map, marker);
    }
    
    // Initialize MDB form elements
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.form-outline').forEach((formOutline) => {
            new mdb.Input(formOutline).init();
        });
    });
</script>
@endpush
