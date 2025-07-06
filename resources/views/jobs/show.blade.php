@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Job Header -->
            <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                    <a href="{{ route('jobs.index') }}" class="text-decoration-none text-muted me-3">
                        <i class="fas fa-arrow-left"></i> Back to Jobs
                    </a>
                    @if($job->is_featured)
                        <span class="badge bg-warning text-dark">Featured</span>
                    @endif
                </div>
                
                <h1 class="display-5 mb-2">{{ $job->title }}</h1>
                
                <div class="d-flex flex-wrap align-items-center text-muted mb-3">
                    @if($job->company_name)
                        <span class="me-3 mb-2">
                            <i class="fas fa-building"></i> {{ $job->company_name }}
                        </span>
                    @endif
                    
                    @if($job->location)
                        <span class="me-3 mb-2">
                            <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                        </span>
                    @endif
                    
                    <span class="me-3 mb-2">
                        <i class="fas fa-briefcase"></i> {{ ucfirst($job->type) }}
                    </span>
                    
                    @if($job->is_remote)
                        <span class="badge bg-info text-white me-3 mb-2">Remote</span>
                    @endif
                    
                    <span class="me-3 mb-2">
                        <i class="fas fa-calendar-alt"></i> Posted {{ $job->created_at->format('M d, Y') }}
                    </span>
                </div>
                
                <div class="d-flex flex-wrap mb-4">
                    @if($job->salary_min || $job->salary_max)
                        <div class="me-4 mb-2">
                            <strong>Salary:</strong>
                            <span>
                                {{ $job->salary_currency }} 
                                @if($job->salary_min && $job->salary_max)
                                    {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                @elseif($job->salary_min)
                                    {{ number_format($job->salary_min) }}+
                                @else
                                    Up to {{ number_format($job->salary_max) }}
                                @endif
                                per {{ $job->salary_period }}
                            </span>
                        </div>
                    @endif
                    
                    @if($job->application_deadline)
                        <div class="mb-2">
                            <strong>Apply by:</strong>
                            <span>
                                {{ $job->application_deadline->format('M d, Y') }}
                                @if($job->application_deadline->isPast())
                                    <span class="text-danger">(Expired)</span>
                                @elseif($job->application_deadline->diffInDays(now()) <= 3)
                                    <span class="text-danger">(Closing soon)</span>
                                @endif
                            </span>
                        </div>
                    @endif
                </div>
                
                <div class="d-grid gap-2 d-md-block mb-4">
                    @if(!$job->application_deadline || !$job->application_deadline->isPast())
                        @auth
                            @if(auth()->user()->hasRole('customer'))
                                @if($hasApplied)
                                    <button class="btn btn-success" disabled>
                                        <i class="fas fa-check"></i> Applied
                                    </button>
                                @else
                                    <a href="{{ route('jobs.apply', $job->id) }}" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Apply Now
                                    </a>
                                @endif
                            @else
                                <button class="btn btn-secondary" disabled>
                                    Customer account required to apply
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}?redirect_to={{ route('jobs.apply', $job->id) }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Login to Apply
                            </a>
                        @endauth
                        
                        @if($job->application_url)
                            <a href="{{ $job->application_url }}" target="_blank" class="btn btn-outline-primary ms-md-2">
                                <i class="fas fa-external-link-alt"></i> Apply on Company Website
                            </a>
                        @endif
                    @else
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-clock"></i> Application Deadline Passed
                        </button>
                    @endif
                    
                    <button class="btn btn-outline-secondary ms-md-2" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    
                    <button class="btn btn-outline-secondary ms-md-2" data-bs-toggle="modal" data-bs-target="#shareJobModal">
                        <i class="fas fa-share-alt"></i> Share
                    </button>
                </div>
            </div>
            
            <!-- Job Description -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Job Description</h5>
                </div>
                <div class="card-body">
                    <div class="job-description">
                        {!! $job->description !!}
                    </div>
                </div>
            </div>
            
            <!-- Job Requirements -->
            @if($job->requirements)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Requirements</h5>
                </div>
                <div class="card-body">
                    <div class="job-requirements">
                        {!! $job->requirements !!}
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Job Responsibilities -->
            @if($job->responsibilities)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Responsibilities</h5>
                </div>
                <div class="card-body">
                    <div class="job-responsibilities">
                        {!! $job->responsibilities !!}
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Similar Jobs -->
            @if(count($similarJobs) > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Similar Jobs</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($similarJobs as $similarJob)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('jobs.show', $similarJob->id) }}" class="text-decoration-none">
                                            {{ $similarJob->title }}
                                        </a>
                                    </h6>
                                    <p class="card-text small text-muted mb-2">
                                        {{ $similarJob->company_name }}
                                        @if($similarJob->location)
                                            <span class="mx-1">•</span> {{ $similarJob->location }}
                                        @endif
                                    </p>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-primary text-white me-2">{{ ucfirst($similarJob->type) }}</span>
                                        @if($similarJob->is_remote)
                                            <span class="badge bg-info text-white">Remote</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('jobs.show', $similarJob->id) }}" class="btn btn-sm btn-outline-primary">View Job</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Company Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Company Information</h5>
                </div>
                <div class="card-body">
                    @if($job->company_logo)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company_name }} Logo" class="img-fluid" style="max-height: 100px;">
                    </div>
                    @endif
                    
                    <h5 class="mb-3">{{ $job->company_name ?? 'Company Name Not Provided' }}</h5>
                    
                    @if($job->company_website)
                    <div class="mb-3">
                        <strong><i class="fas fa-globe"></i> Website:</strong>
                        <a href="{{ $job->company_website }}" target="_blank" class="text-decoration-none">
                            {{ $job->company_website }}
                        </a>
                    </div>
                    @endif
                    
                    @if($job->contact_email)
                    <div class="mb-3">
                        <strong><i class="fas fa-envelope"></i> Contact:</strong>
                        <a href="mailto:{{ $job->contact_email }}" class="text-decoration-none">
                            {{ $job->contact_email }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Job Summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Job Summary</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-briefcase"></i> Job Type</span>
                            <span class="badge bg-primary rounded-pill">{{ ucfirst($job->type) }}</span>
                        </li>
                        
                        @if($job->location)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-map-marker-alt"></i> Location</span>
                            <span>{{ $job->location }}</span>
                        </li>
                        @endif
                        
                        @if($job->category)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-tag"></i> Category</span>
                            <span>{{ $job->category }}</span>
                        </li>
                        @endif
                        
                        @if($job->salary_min || $job->salary_max)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-money-bill-wave"></i> Salary</span>
                            <span>
                                {{ $job->salary_currency }} 
                                @if($job->salary_min && $job->salary_max)
                                    {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                @elseif($job->salary_min)
                                    {{ number_format($job->salary_min) }}+
                                @else
                                    Up to {{ number_format($job->salary_max) }}
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-calendar"></i> Salary Period</span>
                            <span>{{ ucfirst($job->salary_period) }}</span>
                        </li>
                        @endif
                        
                        @if($job->application_deadline)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-hourglass-end"></i> Application Deadline</span>
                            <span>
                                {{ $job->application_deadline->format('M d, Y') }}
                                @if($job->application_deadline->isPast())
                                    <span class="text-danger">(Expired)</span>
                                @elseif($job->application_deadline->diffInDays(now()) <= 3)
                                    <span class="text-danger">(Closing soon)</span>
                                @endif
                            </span>
                        </li>
                        @endif
                        
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-calendar-alt"></i> Posted Date</span>
                            <span>{{ $job->created_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Apply Now CTA -->
            @if(!$job->application_deadline || !$job->application_deadline->isPast())
            <div class="card shadow-sm mb-4 bg-primary text-white">
                <div class="card-body text-center py-4">
                    <h5 class="card-title">Interested in this job?</h5>
                    <p class="card-text">Submit your application now and take the next step in your career.</p>
                    
                    @auth
                        @if(auth()->user()->hasRole('customer'))
                            @if($hasApplied)
                                <button class="btn btn-light" disabled>
                                    <i class="fas fa-check"></i> You've Already Applied
                                </button>
                            @else
                                <a href="{{ route('jobs.apply', $job->id) }}" class="btn btn-light">
                                    <i class="fas fa-paper-plane"></i> Apply Now
                                </a>
                            @endif
                        @else
                            <button class="btn btn-light" disabled>
                                Customer account required to apply
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}?redirect_to={{ route('jobs.apply', $job->id) }}" class="btn btn-light">
                            <i class="fas fa-sign-in-alt"></i> Login to Apply
                        </a>
                    @endauth
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Share Job Modal -->
<div class="modal fade" id="shareJobModal" tabindex="-1" aria-labelledby="shareJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareJobModalLabel">Share This Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Share this job opportunity with your network:</p>
                
                <div class="d-grid gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('jobs.show', $job->id)) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fab fa-facebook-f"></i> Share on Facebook
                    </a>
                    
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode('Check out this job: ' . $job->title) }}&url={{ urlencode(route('jobs.show', $job->id)) }}" target="_blank" class="btn btn-outline-info">
                        <i class="fab fa-twitter"></i> Share on Twitter
                    </a>
                    
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('jobs.show', $job->id)) }}" target="_blank" class="btn btn-outline-secondary">
                        <i class="fab fa-linkedin-in"></i> Share on LinkedIn
                    </a>
                    
                    <a href="mailto:?subject={{ urlencode('Job Opportunity: ' . $job->title) }}&body={{ urlencode('I thought you might be interested in this job: ' . $job->title . ' at ' . ($job->company_name ?? 'our company') . '. Check it out: ' . route('jobs.show', $job->id)) }}" class="btn btn-outline-dark">
                        <i class="fas fa-envelope"></i> Share via Email
                    </a>
                </div>
                
                <div class="mt-3">
                    <label for="job-url" class="form-label">Or copy this link:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="job-url" value="{{ route('jobs.show', $job->id) }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyJobUrl()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyJobUrl() {
        var copyText = document.getElementById("job-url");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        
        // Show copied message
        var button = copyText.nextElementSibling;
        var originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> Copied!';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-secondary');
        
        setTimeout(function() {
            button.innerHTML = originalHtml;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    }
</script>
@endpush
