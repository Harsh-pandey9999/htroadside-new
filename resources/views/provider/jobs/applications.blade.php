@extends('layouts.provider')

@section('title', 'Job Applications')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Applications for {{ $job->title }}</h1>
        <div>
            <a href="{{ route('provider.jobs.show', $job->id) }}" class="d-none d-sm-inline-block btn btn-info shadow-sm mr-2">
                <i class="fas fa-eye fa-sm text-white-50"></i> View Job
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

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Applications</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('provider.jobs.applications', $job->id) }}" method="GET" class="row">
                <div class="col-md-3 mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                        <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                        <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="search">Search</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search by name or email" value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="sort">Sort By</label>
                    <select name="sort" id="sort" class="form-control">
                        <option value="created_at-desc" {{ request('sort') == 'created_at-desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="created_at-asc" {{ request('sort') == 'created_at-asc' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Applications List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Applications ({{ $applications->total() }})</h6>
        </div>
        <div class="card-body">
            @if($applications->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('img/empty-applications.svg') }}" alt="No applications found" class="img-fluid mb-3" style="max-height: 150px;">
                    <h5 class="text-gray-500">No applications found</h5>
                    <p class="text-gray-500">There are no applications for this job yet or none match your filter criteria.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Status</th>
                                <th>Applied</th>
                                <th>Resume</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $application)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $application->user->name }}</strong>
                                            <div class="small text-gray-600">{{ $application->user->email }}</div>
                                            @if($application->phone)
                                                <div class="small text-gray-600">{{ $application->phone }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @switch($application->status)
                                            @case('pending')
                                                <span class="badge badge-secondary">Pending</span>
                                                @break
                                            @case('reviewing')
                                                <span class="badge badge-info">Reviewing</span>
                                                @break
                                            @case('shortlisted')
                                                <span class="badge badge-primary">Shortlisted</span>
                                                @break
                                            @case('interview')
                                                <span class="badge badge-warning">Interview</span>
                                                @break
                                            @case('hired')
                                                <span class="badge badge-success">Hired</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                                @break
                                            @case('withdrawn')
                                                <span class="badge badge-dark">Withdrawn</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $application->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($application->resume_path)
                                            <a href="{{ Storage::url($application->resume_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf"></i> View
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#viewApplicationModal{{ $application->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#updateStatusModal{{ $application->id }}">
                                            <i class="fas fa-sync-alt"></i> Status
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- View Application Modal -->
                                <div class="modal fade" id="viewApplicationModal{{ $application->id }}" tabindex="-1" role="dialog" aria-labelledby="viewApplicationModalLabel{{ $application->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewApplicationModalLabel{{ $application->id }}">Application Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <h6 class="font-weight-bold">Applicant Information</h6>
                                                        <p class="mb-1"><strong>Name:</strong> {{ $application->user->name }}</p>
                                                        <p class="mb-1"><strong>Email:</strong> {{ $application->user->email }}</p>
                                                        @if($application->phone)
                                                            <p class="mb-1"><strong>Phone:</strong> {{ $application->phone }}</p>
                                                        @endif
                                                        <p class="mb-1"><strong>Applied:</strong> {{ $application->created_at->format('F d, Y') }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="font-weight-bold">Application Status</h6>
                                                        <p class="mb-1">
                                                            <strong>Current Status:</strong> 
                                                            @switch($application->status)
                                                                @case('pending')
                                                                    <span class="badge badge-secondary">Pending</span>
                                                                    @break
                                                                @case('reviewing')
                                                                    <span class="badge badge-info">Reviewing</span>
                                                                    @break
                                                                @case('shortlisted')
                                                                    <span class="badge badge-primary">Shortlisted</span>
                                                                    @break
                                                                @case('interview')
                                                                    <span class="badge badge-warning">Interview</span>
                                                                    @break
                                                                @case('hired')
                                                                    <span class="badge badge-success">Hired</span>
                                                                    @break
                                                                @case('rejected')
                                                                    <span class="badge badge-danger">Rejected</span>
                                                                    @break
                                                                @case('withdrawn')
                                                                    <span class="badge badge-dark">Withdrawn</span>
                                                                    @break
                                                                @default
                                                                    <span class="badge badge-secondary">{{ $application->status }}</span>
                                                            @endswitch
                                                        </p>
                                                        @if($application->status_updated_at)
                                                            <p class="mb-1"><strong>Last Updated:</strong> {{ $application->status_updated_at->format('F d, Y') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <hr>
                                                
                                                <div class="mb-4">
                                                    <h6 class="font-weight-bold">Cover Letter / Additional Information</h6>
                                                    <div class="p-3 bg-light rounded">
                                                        {!! nl2br(e($application->cover_letter ?? $application->additional_info ?? 'No cover letter provided.')) !!}
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <h6 class="font-weight-bold">Resume</h6>
                                                        @if($application->resume_path)
                                                            <a href="{{ Storage::url($application->resume_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-file-pdf mr-1"></i> View Resume
                                                            </a>
                                                        @else
                                                            <p class="text-muted">No resume uploaded</p>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-3">
                                                        <h6 class="font-weight-bold">External Links</h6>
                                                        @if($application->linkedin_profile)
                                                            <p class="mb-1">
                                                                <a href="{{ $application->linkedin_profile }}" target="_blank">
                                                                    <i class="fab fa-linkedin mr-1"></i> LinkedIn Profile
                                                                </a>
                                                            </p>
                                                        @endif
                                                        
                                                        @if($application->portfolio_url)
                                                            <p class="mb-1">
                                                                <a href="{{ $application->portfolio_url }}" target="_blank">
                                                                    <i class="fas fa-globe mr-1"></i> Portfolio
                                                                </a>
                                                            </p>
                                                        @endif
                                                        
                                                        @if(!$application->linkedin_profile && !$application->portfolio_url)
                                                            <p class="text-muted">No external links provided</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#updateStatusModal{{ $application->id }}">
                                                    Update Status
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Update Status Modal -->
                                <div class="modal fade" id="updateStatusModal{{ $application->id }}" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel{{ $application->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateStatusModalLabel{{ $application->id }}">Update Application Status</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('provider.applications.update-status', $application->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <p>Update status for <strong>{{ $application->user->name }}</strong>'s application.</p>
                                                    
                                                    <div class="form-group">
                                                        <label for="status{{ $application->id }}" class="font-weight-bold">Status</label>
                                                        <select class="form-control" id="status{{ $application->id }}" name="status" required>
                                                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="reviewing" {{ $application->status == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                                            <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                                            <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Interview</option>
                                                            <option value="hired" {{ $application->status == 'hired' ? 'selected' : '' }}>Hired</option>
                                                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="notes{{ $application->id }}">Notes (Optional)</label>
                                                        <textarea class="form-control" id="notes{{ $application->id }}" name="notes" rows="3" placeholder="Add private notes about this applicant">{{ $application->notes }}</textarea>
                                                        <small class="form-text text-muted">These notes are only visible to you and not to the applicant.</small>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="notify_applicant{{ $application->id }}" name="notify_applicant" value="1" checked>
                                                            <label class="custom-control-label" for="notify_applicant{{ $application->id }}">Notify applicant about status change</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <!-- Application Management Tips -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Application Management Tips</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Respond Promptly</div>
                                    <div class="small mb-0">Keep candidates engaged by updating application statuses promptly. This creates a positive candidate experience.</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card border-left-success h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Use Status Updates</div>
                                    <div class="small mb-0">Keep applicants informed about where they stand in the hiring process by regularly updating their application status.</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-sync-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-left-info h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Take Notes</div>
                                    <div class="small mb-0">Use the notes feature to record important details about candidates to help with your decision-making process.</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-sticky-note fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
