@extends('layouts.app')

@section('title', 'Job Opportunities')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="display-4 mb-2">Job Opportunities</h1>
            <p class="lead text-muted">Find your next career opportunity with us</p>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('jobs.index') }}" method="GET" class="row">
                        <div class="col-md-4 mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Job title, skills, or keywords">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ request('location') }}" placeholder="City or remote">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="type" class="form-label">Job Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">All Types</option>
                                <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="temporary" {{ request('type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jobs.index') }}" method="GET" id="filter-form">
                        <!-- Hidden fields to preserve search params -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="location" value="{{ request('location') }}">
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        
                        <div class="mb-3">
                            <h6>Job Type</h6>
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="types[]" value="full-time" id="type-full-time" {{ in_array('full-time', request('types', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="type-full-time">Full Time</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="types[]" value="part-time" id="type-part-time" {{ in_array('part-time', request('types', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="type-part-time">Part Time</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="types[]" value="contract" id="type-contract" {{ in_array('contract', request('types', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="type-contract">Contract</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="types[]" value="temporary" id="type-temporary" {{ in_array('temporary', request('types', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="type-temporary">Temporary</label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Remote Work</h6>
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="remote" value="1" id="remote" {{ request('remote') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remote">Remote Jobs Only</label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Salary Range</h6>
                            <select class="form-control form-control-sm filter-select" name="salary_range">
                                <option value="">Any Salary</option>
                                <option value="0-30000" {{ request('salary_range') == '0-30000' ? 'selected' : '' }}>Under ₹30,000</option>
                                <option value="30000-50000" {{ request('salary_range') == '30000-50000' ? 'selected' : '' }}>₹30,000 - ₹50,000</option>
                                <option value="50000-100000" {{ request('salary_range') == '50000-100000' ? 'selected' : '' }}>₹50,000 - ₹1,00,000</option>
                                <option value="100000-0" {{ request('salary_range') == '100000-0' ? 'selected' : '' }}>Above ₹1,00,000</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Sort By</h6>
                            <select class="form-control form-control-sm filter-select" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Highest Salary</option>
                                <option value="salary_low" {{ request('sort') == 'salary_low' ? 'selected' : '' }}>Lowest Salary</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filters</button>
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">Clear All</a>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Featured Jobs</h5>
                </div>
                <div class="card-body">
                    @forelse($featuredJobs as $featuredJob)
                        <div class="mb-3">
                            <h6 class="mb-1">
                                <a href="{{ route('jobs.show', $featuredJob->id) }}" class="text-decoration-none">
                                    {{ $featuredJob->title }}
                                </a>
                            </h6>
                            <p class="small text-muted mb-1">
                                {{ $featuredJob->company_name }}
                                @if($featuredJob->location)
                                    <span class="mx-1">•</span> {{ $featuredJob->location }}
                                @endif
                            </p>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary text-white me-2">{{ ucfirst($featuredJob->type) }}</span>
                                @if($featuredJob->is_remote)
                                    <span class="badge bg-info text-white">Remote</span>
                                @endif
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-muted">No featured jobs available</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Job Listings -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="text-muted mb-0">Showing {{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs</p>
            </div>
            
            @forelse($jobs as $job)
                <div class="card shadow-sm mb-4 job-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h4 class="card-title mb-1">
                                    <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none">{{ $job->title }}</a>
                                    @if($job->is_featured)
                                        <span class="badge bg-warning text-dark">Featured</span>
                                    @endif
                                </h4>
                                <p class="text-muted mb-2">
                                    @if($job->company_name)
                                        <span class="me-2">{{ $job->company_name }}</span>
                                    @endif
                                    @if($job->location)
                                        <span class="me-2"><i class="fas fa-map-marker-alt"></i> {{ $job->location }}</span>
                                    @endif
                                    <span class="me-2"><i class="fas fa-clock"></i> {{ ucfirst($job->type) }}</span>
                                    @if($job->is_remote)
                                        <span class="badge bg-info text-white">Remote</span>
                                    @endif
                                </p>
                                <div class="mb-3">
                                    <p class="card-text">{{ Str::limit(strip_tags($job->description), 150) }}</p>
                                </div>
                                <div class="d-flex flex-wrap">
                                    @if($job->salary_min || $job->salary_max)
                                        <span class="badge bg-light text-dark me-2 mb-1">
                                            <i class="fas fa-money-bill-wave"></i>
                                            {{ $job->salary_currency }} 
                                            @if($job->salary_min && $job->salary_max)
                                                {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                            @elseif($job->salary_min)
                                                {{ number_format($job->salary_min) }}+
                                            @else
                                                Up to {{ number_format($job->salary_max) }}
                                            @endif
                                            /{{ $job->salary_period }}
                                        </span>
                                    @endif
                                    @if($job->application_deadline)
                                        <span class="badge bg-light text-dark me-2 mb-1">
                                            <i class="fas fa-calendar-alt"></i> 
                                            Apply by: {{ $job->application_deadline->format('M d, Y') }}
                                            @if($job->application_deadline->isPast())
                                                <span class="text-danger">(Expired)</span>
                                            @elseif($job->application_deadline->diffInDays(now()) <= 3)
                                                <span class="text-danger">(Closing soon)</span>
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                @if($job->company_logo)
                                    <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company_name }} Logo" class="img-fluid mb-3" style="max-height: 60px;">
                                @endif
                                <div>
                                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>
                                    @auth
                                        @if(auth()->user()->hasRole('customer'))
                                            <a href="{{ route('jobs.apply', $job->id) }}" class="btn btn-primary btn-sm w-100">Apply Now</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}?redirect_to={{ route('jobs.apply', $job->id) }}" class="btn btn-primary btn-sm w-100">Login to Apply</a>
                                    @endauth
                                </div>
                                <p class="small text-muted mt-2">Posted {{ $job->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4>No jobs found</h4>
                        <p class="text-muted">Try adjusting your search criteria or check back later for new opportunities.</p>
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary">Clear Filters</a>
                    </div>
                </div>
            @endforelse
            
            <div class="mt-4">
                {{ $jobs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-submit form when select filters change
        $('.filter-select').on('change', function() {
            $('#filter-form').submit();
        });
        
        // Auto-submit form when checkboxes change
        $('.filter-checkbox').on('change', function() {
            $('#filter-form').submit();
        });
    });
</script>
@endpush
