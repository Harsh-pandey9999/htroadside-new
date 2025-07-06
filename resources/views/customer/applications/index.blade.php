@extends('layouts.app')

@section('title', 'My Job Applications')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 mb-2">My Job Applications</h1>
            <p class="text-muted">Track and manage your job applications</p>
        </div>
        <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end">
            <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                <i class="fas fa-search"></i> Browse More Jobs
            </a>
        </div>
    </div>
    
    @include('partials.alerts')
    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Application History</h5>
                </div>
                <div class="col-auto">
                    <form action="{{ route('customer.applications.index') }}" method="GET" class="d-flex">
                        <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Under Review</option>
                            <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                            <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview Scheduled</option>
                            <option value="offered" {{ request('status') == 'offered' ? 'selected' : '' }}>Offered</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Applied On</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                            <tr>
                                <td>
                                    <a href="{{ route('jobs.show', $application->job->id) }}" class="text-decoration-none fw-bold">
                                        {{ $application->job->title }}
                                    </a>
                                    <div class="small text-muted">
                                        {{ ucfirst($application->job->type) }}
                                        @if($application->job->is_remote)
                                            <span class="badge bg-info text-white">Remote</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{ $application->job->company_name }}
                                    @if($application->job->location)
                                        <div class="small text-muted">{{ $application->job->location }}</div>
                                    @endif
                                </td>
                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                <td>
                                    @php
                                        $statusBadgeClass = [
                                            'pending' => 'bg-secondary',
                                            'reviewing' => 'bg-info',
                                            'shortlisted' => 'bg-primary',
                                            'interview' => 'bg-warning text-dark',
                                            'offered' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'withdrawn' => 'bg-dark',
                                        ][$application->status] ?? 'bg-secondary';
                                        
                                        $statusLabel = [
                                            'pending' => 'Pending',
                                            'reviewing' => 'Under Review',
                                            'shortlisted' => 'Shortlisted',
                                            'interview' => 'Interview Scheduled',
                                            'offered' => 'Offered',
                                            'rejected' => 'Rejected',
                                            'withdrawn' => 'Withdrawn',
                                        ][$application->status] ?? 'Unknown';
                                    @endphp
                                    <span class="badge {{ $statusBadgeClass }}">{{ $statusLabel }}</span>
                                    
                                    @if($application->interview_date && in_array($application->status, ['interview', 'offered']))
                                        <div class="small text-muted mt-1">
                                            <i class="fas fa-calendar-alt"></i> 
                                            {{ \Carbon\Carbon::parse($application->interview_date)->format('M d, Y g:i A') }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $application->updated_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#applicationModal{{ $application->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        @if($application->status !== 'withdrawn' && $application->status !== 'rejected')
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $application->id }}">
                                                <i class="fas fa-times"></i> Withdraw
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                        <h5>No applications found</h5>
                                        <p class="text-muted">You haven't applied to any jobs yet.</p>
                                        <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($applications->hasPages())
            <div class="card-footer">
                {{ $applications->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Application Status Guide</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center px-0">
                            <span class="badge bg-secondary me-2">Pending</span>
                            <span>Your application has been submitted but not yet reviewed.</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center px-0">
                            <span class="badge bg-info me-2">Under Review</span>
                            <span>Your application is currently being reviewed by the hiring team.</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center px-0">
                            <span class="badge bg-primary me-2">Shortlisted</span>
                            <span>You've been shortlisted and may be contacted for an interview.</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center px-0">
                            <span class="badge bg-warning text-dark me-2">Interview</span>
                            <span>An interview has been scheduled. Check your email for details.</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center px-0">
                            <span class="badge bg-success me-2">Offered</span>
                            <span>Congratulations! You've received a job offer.</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center px-0">
                            <span class="badge bg-danger me-2">Rejected</span>
                            <span>Your application was not selected for this position.</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center px-0">
                            <span class="badge bg-dark me-2">Withdrawn</span>
                            <span>You've withdrawn your application from consideration.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Application Tips</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="fas fa-file-alt text-primary me-2"></i> Resume</h6>
                        <p class="small">Keep your resume updated and tailored to each job. Highlight relevant skills and experience.</p>
                    </div>
                    <div class="mb-3">
                        <h6><i class="fas fa-envelope-open-text text-primary me-2"></i> Cover Letter</h6>
                        <p class="small">Write a personalized cover letter for each application explaining why you're a good fit.</p>
                    </div>
                    <div class="mb-3">
                        <h6><i class="fas fa-bell text-primary me-2"></i> Stay Alert</h6>
                        <p class="small">Check your email regularly for updates and interview invitations.</p>
                    </div>
                    <div>
                        <h6><i class="fas fa-comments text-primary me-2"></i> Follow Up</h6>
                        <p class="small">If you haven't heard back after a week, consider a polite follow-up email.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Detail Modals -->
@foreach($applications as $application)
    <div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1" aria-labelledby="applicationModalLabel{{ $application->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applicationModalLabel{{ $application->id }}">Application Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5 class="mb-1">{{ $application->job->title }}</h5>
                            <p class="text-muted mb-0">
                                {{ $application->job->company_name }}
                                @if($application->job->location)
                                    <span class="mx-1">•</span> {{ $application->job->location }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <span class="badge {{ $statusBadgeClass }} mb-2">{{ $statusLabel }}</span>
                            <div class="small text-muted">Applied on {{ $application->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Application Information</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span>Status:</span>
                                            <span class="badge {{ $statusBadgeClass }}">{{ $statusLabel }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span>Applied On:</span>
                                            <span>{{ $application->created_at->format('M d, Y') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span>Last Updated:</span>
                                            <span>{{ $application->updated_at->format('M d, Y') }}</span>
                                        </li>
                                        @if($application->interview_date && in_array($application->status, ['interview', 'offered']))
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Interview Date:</span>
                                                <span>{{ \Carbon\Carbon::parse($application->interview_date)->format('M d, Y g:i A') }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            
                            @if($application->resume_path)
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Submitted Resume</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="btn btn-outline-primary">
                                            <i class="fas fa-file-pdf"></i> View Resume
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Cover Letter</h6>
                                </div>
                                <div class="card-body">
                                    <div class="cover-letter-content">
                                        {!! nl2br(e($application->cover_letter)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($application->additional_information)
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Additional Information</h6>
                            </div>
                            <div class="card-body">
                                {!! nl2br(e($application->additional_information)) !!}
                            </div>
                        </div>
                    @endif
                    
                    @if($application->admin_notes && $application->status === 'rejected')
                        <div class="card mb-4 border-danger">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">Feedback</h6>
                            </div>
                            <div class="card-body">
                                {!! nl2br(e($application->admin_notes)) !!}
                            </div>
                        </div>
                    @endif
                    
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Contact Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span>Name:</span>
                                            <span>{{ auth()->user()->name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span>Email:</span>
                                            <span>{{ auth()->user()->email }}</span>
                                        </li>
                                        @if($application->phone)
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Phone:</span>
                                                <span>{{ $application->phone }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        @if($application->linkedin_profile)
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>LinkedIn:</span>
                                                <a href="{{ $application->linkedin_profile }}" target="_blank">View Profile</a>
                                            </li>
                                        @endif
                                        @if($application->portfolio_url)
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Portfolio:</span>
                                                <a href="{{ $application->portfolio_url }}" target="_blank">View Portfolio</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if($application->status !== 'withdrawn' && $application->status !== 'rejected')
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $application->id }}" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Withdraw Application
                        </button>
                    @endif
                    <a href="{{ route('jobs.show', $application->job->id) }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> View Job
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Withdraw Application Modal -->
    @if($application->status !== 'withdrawn' && $application->status !== 'rejected')
        <div class="modal fade" id="withdrawModal{{ $application->id }}" tabindex="-1" aria-labelledby="withdrawModalLabel{{ $application->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="withdrawModalLabel{{ $application->id }}">Withdraw Application</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Are you sure you want to withdraw your application for <strong>{{ $application->job->title }}</strong> at <strong>{{ $application->job->company_name }}</strong>?
                        </div>
                        <p>This action cannot be undone. Once withdrawn, you will need to submit a new application if you change your mind.</p>
                        
                        <form action="{{ route('customer.applications.withdraw', $application->id) }}" method="POST" id="withdrawForm{{ $application->id }}">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="withdrawal_reason{{ $application->id }}" class="form-label">Reason for withdrawal (optional):</label>
                                <textarea class="form-control" id="withdrawal_reason{{ $application->id }}" name="withdrawal_reason" rows="3"></textarea>
                                <div class="form-text">This information will help employers understand why you're withdrawing.</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="withdrawForm{{ $application->id }}" class="btn btn-danger">
                            <i class="fas fa-times"></i> Withdraw Application
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection
