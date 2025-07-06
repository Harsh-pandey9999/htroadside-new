@extends('layouts.admin')

@section('title', $job->title)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $job->title }}</h1>
        <div>
            <a href="{{ route('admin.jobs.applications', $job->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-users fa-sm text-white-50"></i> View Applications ({{ $job->applications_count }})
            </a>
            <a href="{{ route('admin.jobs.edit', $job->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Job
            </a>
            <a href="{{ route('admin.jobs.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Jobs
            </a>
        </div>
    </div>

    @include('partials.alerts')

    <div class="row">
        <div class="col-lg-8">
            <!-- Job Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Job Details</h6>
                    <div>
                        <span class="badge badge-{{ $job->is_active ? 'success' : 'secondary' }} mr-1">
                            {{ $job->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($job->is_featured)
                            <span class="badge badge-warning">Featured</span>
                        @endif
                        @if($job->is_remote)
                            <span class="badge badge-info">Remote</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Description</h5>
                        <div class="border-left-primary pl-3">
                            {!! $job->description !!}
                        </div>
                    </div>
                    
                    @if($job->requirements)
                    <div class="mb-4">
                        <h5>Requirements</h5>
                        <div class="border-left-info pl-3">
                            {!! $job->requirements !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($job->responsibilities)
                    <div class="mb-4">
                        <h5>Responsibilities</h5>
                        <div class="border-left-success pl-3">
                            {!! $job->responsibilities !!}
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Job Details</h5>
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th width="40%">Job Type</th>
                                        <td>{{ ucfirst($job->type) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location</th>
                                        <td>{{ $job->location ?? 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ $job->category ?? 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Salary</th>
                                        <td>
                                            @if($job->salary_min || $job->salary_max)
                                                {{ $job->salary_currency }} 
                                                @if($job->salary_min && $job->salary_max)
                                                    {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                                @elseif($job->salary_min)
                                                    {{ number_format($job->salary_min) }}+
                                                @else
                                                    Up to {{ number_format($job->salary_max) }}
                                                @endif
                                                per {{ $job->salary_period }}
                                            @else
                                                Not specified
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Application Deadline</th>
                                        <td>
                                            @if($job->application_deadline)
                                                {{ $job->application_deadline->format('M d, Y') }}
                                                @if($job->application_deadline->isPast())
                                                    <span class="badge badge-danger">Expired</span>
                                                @endif
                                            @else
                                                No deadline
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Company Information</h5>
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th width="40%">Company</th>
                                        <td>{{ $job->company_name ?? 'Not specified' }}</td>
                                    </tr>
                                    @if($job->company_website)
                                    <tr>
                                        <th>Website</th>
                                        <td><a href="{{ $job->company_website }}" target="_blank">{{ $job->company_website }}</a></td>
                                    </tr>
                                    @endif
                                    @if($job->contact_email)
                                    <tr>
                                        <th>Contact Email</th>
                                        <td><a href="mailto:{{ $job->contact_email }}">{{ $job->contact_email }}</a></td>
                                    </tr>
                                    @endif
                                    @if($job->application_url)
                                    <tr>
                                        <th>External Application</th>
                                        <td><a href="{{ $job->application_url }}" target="_blank">Apply Here</a></td>
                                    </tr>
                                    @endif
                                    @if($job->company_logo)
                                    <tr>
                                        <th>Logo</th>
                                        <td>
                                            <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company_name }} Logo" class="img-thumbnail" style="max-height: 100px;">
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Job Stats Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Job Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Views</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $job->views_count }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Applications</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $job->applications_count }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Job Status</h6>
                        <form action="{{ route('admin.jobs.toggle-active', $job->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $job->is_active ? 'btn-success' : 'btn-secondary' }} mb-2 mr-2">
                                <i class="fas {{ $job->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                {{ $job->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.jobs.toggle-featured', $job->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $job->is_featured ? 'btn-warning' : 'btn-light' }} mb-2">
                                <i class="fas {{ $job->is_featured ? 'fa-star' : 'fa-star' }}"></i>
                                {{ $job->is_featured ? 'Featured' : 'Not Featured' }}
                            </button>
                        </form>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Created By</h6>
                        <p>{{ $job->admin->name ?? 'Unknown' }}</p>
                        <p class="small text-muted">
                            Created: {{ $job->created_at->format('M d, Y H:i') }}<br>
                            Last Updated: {{ $job->updated_at->format('M d, Y H:i') }}
                        </p>
                    </div>
                    
                    <div class="text-center mt-4">
                        <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Job
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Recent Applications Card -->
            @if($job->applications->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Applications</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($job->applications->take(5) as $application)
                        <a href="{{ route('admin.jobs.applications', $job->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $application->user->name }}</h6>
                                <small>{{ $application->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($application->cover_letter, 50) }}</p>
                            <small class="text-muted">
                                Status: <span class="badge badge-{{ $application->status == 'pending' ? 'warning' : ($application->status == 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </small>
                        </a>
                        @endforeach
                    </div>
                    
                    @if($job->applications->count() > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.jobs.applications', $job->id) }}" class="btn btn-sm btn-primary">
                            View All Applications
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Confirm delete
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this job? This will also delete all associated applications. This action cannot be undone.')) {
                this.submit();
            }
        });
    });
</script>
@endpush
