@extends('layouts.provider')

@section('title', $job->title)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Job Details</h1>
        <div>
            <a href="{{ route('provider.jobs.applications', $job->id) }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm mr-2">
                <i class="fas fa-users fa-sm text-white-50"></i> View Applications
            </a>
            <a href="{{ route('provider.jobs.edit', $job->id) }}" class="d-none d-sm-inline-block btn btn-info shadow-sm mr-2">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Job
            </a>
            <a href="{{ route('provider.jobs.index') }}" class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Jobs
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Job Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $job->title }}</h6>
                    <div>
                        @if($job->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                        
                        @if($job->is_featured)
                            <span class="badge badge-warning ml-1">Featured</span>
                        @endif
                        
                        @if($job->is_remote)
                            <span class="badge badge-info ml-1">Remote</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="mr-3">
                                    @if($job->company_logo)
                                        <img src="{{ Storage::url($job->company_logo) }}" alt="Company logo" class="img-thumbnail" style="max-height: 60px; max-width: 60px;">
                                    @else
                                        <div class="bg-light rounded p-3 text-center" style="width: 60px; height: 60px;">
                                            <i class="fas fa-building fa-2x text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $job->title }}</h5>
                                    <p class="text-gray-600 mb-0">{{ $job->location ?? 'Remote' }}</p>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <p class="mb-1"><strong>Job Type:</strong></p>
                                @switch($job->type)
                                    @case('full-time')
                                        <span class="badge badge-primary">Full Time</span>
                                        @break
                                    @case('part-time')
                                        <span class="badge badge-success">Part Time</span>
                                        @break
                                    @case('contract')
                                        <span class="badge badge-warning">Contract</span>
                                        @break
                                    @case('temporary')
                                        <span class="badge badge-info">Temporary</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">{{ $job->type }}</span>
                                @endswitch
                            </div>
                            
                            @if($job->category)
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Category:</strong></p>
                                    <span class="badge badge-secondary">{{ $job->category }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="mb-1"><strong>Salary:</strong></p>
                                @if($job->salary_min || $job->salary_max)
                                    <p class="mb-0">
                                        @if($job->salary_min && $job->salary_max)
                                            {{ $job->salary_currency }} {{ number_format($job->salary_min, 2) }} - {{ number_format($job->salary_max, 2) }} / {{ $job->salary_period }}
                                        @elseif($job->salary_min)
                                            {{ $job->salary_currency }} {{ number_format($job->salary_min, 2) }}+ / {{ $job->salary_period }}
                                        @else
                                            Up to {{ $job->salary_currency }} {{ number_format($job->salary_max, 2) }} / {{ $job->salary_period }}
                                        @endif
                                    </p>
                                @else
                                    <p class="text-muted mb-0">Not specified</p>
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <p class="mb-1"><strong>Posted:</strong></p>
                                <p class="mb-0">{{ $job->created_at->format('F d, Y') }} ({{ $job->created_at->diffForHumans() }})</p>
                            </div>
                            
                            @if($job->application_deadline)
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Application Deadline:</strong></p>
                                    <p class="mb-0">{{ $job->application_deadline->format('F d, Y') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Job Description</h5>
                        <div class="mt-3">
                            {!! $job->description !!}
                        </div>
                    </div>
                    
                    @if($job->responsibilities)
                        <div class="mb-4">
                            <h5 class="font-weight-bold">Responsibilities</h5>
                            <div class="mt-3">
                                {!! $job->responsibilities !!}
                            </div>
                        </div>
                    @endif
                    
                    @if($job->requirements)
                        <div class="mb-4">
                            <h5 class="font-weight-bold">Requirements</h5>
                            <div class="mt-3">
                                {!! $job->requirements !!}
                            </div>
                        </div>
                    @endif
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Contact Information</h5>
                        <p class="mb-1"><strong>Email:</strong> {{ $job->contact_email ?? Auth::user()->email }}</p>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('provider.jobs.edit', $job->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit fa-sm"></i> Edit Job
                        </a>
                        <a href="{{ route('jobs.show', $job->id) }}" target="_blank" class="btn btn-success">
                            <i class="fas fa-external-link-alt fa-sm"></i> View Public Listing
                        </a>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteJobModal">
                            <i class="fas fa-trash fa-sm"></i> Delete Job
                        </button>
                    </div>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteJobModal" tabindex="-1" role="dialog" aria-labelledby="deleteJobModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteJobModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the job <strong>{{ $job->title }}</strong>?</p>
                                    <p class="text-danger">This action cannot be undone. Jobs with existing applications cannot be deleted.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form action="{{ route('provider.jobs.destroy', $job->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete Job</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Job Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Job Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="mb-2"><strong>Current Status:</strong></p>
                        @if($job->is_active)
                            <div class="badge badge-success p-2 mb-2" style="font-size: 1rem;">Active</div>
                            <p class="small text-gray-800">This job is currently visible to job seekers.</p>
                        @else
                            <div class="badge badge-danger p-2 mb-2" style="font-size: 1rem;">Inactive</div>
                            <p class="small text-gray-800">This job is not visible to job seekers.</p>
                            <div class="alert alert-warning small">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Your job is currently inactive. It may be pending admin approval or was deactivated.
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <p class="mb-2"><strong>Job Statistics:</strong></p>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Views
                                <span class="badge badge-primary badge-pill">{{ $job->views_count ?? 0 }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Applications
                                <a href="{{ route('provider.jobs.applications', $job->id) }}" class="d-flex align-items-center">
                                    <span class="badge badge-primary badge-pill mr-1">{{ $job->applications_count ?? 0 }}</span>
                                    <i class="fas fa-external-link-alt fa-sm"></i>
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Posted
                                <span>{{ $job->created_at->format('M d, Y') }}</span>
                            </li>
                            @if($job->application_deadline)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Deadline
                                    <span>{{ $job->application_deadline->format('M d, Y') }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('provider.jobs.applications', $job->id) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-users fa-sm"></i> View Applications
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Quick Tips Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Tips</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-dark">Increase Visibility</h6>
                        <ul class="small text-gray-800 pl-3">
                            <li class="mb-2">Use specific job titles that clearly describe the position.</li>
                            <li class="mb-2">Include salary information to attract more qualified candidates.</li>
                            <li class="mb-2">Keep your job description detailed but concise.</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-dark">Managing Applications</h6>
                        <ul class="small text-gray-800 pl-3">
                            <li class="mb-2">Respond to applicants promptly to maintain a positive candidate experience.</li>
                            <li class="mb-2">Use the application management tools to track candidate status.</li>
                            <li class="mb-2">Download resumes for offline review.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
