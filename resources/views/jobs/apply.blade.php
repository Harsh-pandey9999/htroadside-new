@extends('layouts.app')

@section('title', 'Apply for ' . $job->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                    <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none text-muted me-3">
                        <i class="fas fa-arrow-left"></i> Back to Job Details
                    </a>
                </div>
                
                <h1 class="display-5 mb-2">Apply for: {{ $job->title }}</h1>
                <p class="text-muted mb-4">
                    @if($job->company_name)
                        at {{ $job->company_name }}
                    @endif
                    
                    @if($job->location)
                        <span class="mx-1">•</span> {{ $job->location }}
                    @endif
                    
                    <span class="mx-1">•</span> {{ ucfirst($job->type) }}
                    
                    @if($job->is_remote)
                        <span class="mx-1">•</span> Remote
                    @endif
                </p>
            </div>
            
            @include('partials.alerts')
            
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Application Form</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jobs.apply.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}">
                        
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Application Information</h6>
                            <p class="mb-0">You are applying as <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }}). Make sure your profile information is up to date before submitting your application.</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="resume" class="form-label">Resume/CV <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('resume') is-invalid @enderror" id="resume" name="resume" accept=".pdf,.doc,.docx">
                            @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Upload your resume in PDF, DOC, or DOCX format (max 5MB).</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="cover_letter" class="form-label">Cover Letter <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter" name="cover_letter" rows="6" required>{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Explain why you're interested in this position and why you would be a good fit.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="linkedin_profile" class="form-label">LinkedIn Profile</label>
                            <input type="url" class="form-control @error('linkedin_profile') is-invalid @enderror" id="linkedin_profile" name="linkedin_profile" value="{{ old('linkedin_profile') }}" placeholder="https://www.linkedin.com/in/yourprofile">
                            @error('linkedin_profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="portfolio_url" class="form-label">Portfolio/Website URL</label>
                            <input type="url" class="form-control @error('portfolio_url') is-invalid @enderror" id="portfolio_url" name="portfolio_url" value="{{ old('portfolio_url') }}">
                            @error('portfolio_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="additional_information" class="form-label">Additional Information</label>
                            <textarea class="form-control @error('additional_information') is-invalid @enderror" id="additional_information" name="additional_information" rows="3">{{ old('additional_information') }}</textarea>
                            @error('additional_information')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Any other information you'd like to share with the hiring team.</div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('terms_accepted') is-invalid @enderror" type="checkbox" id="terms_accepted" name="terms_accepted" value="1" required {{ old('terms_accepted') ? 'checked' : '' }}>
                                <label class="form-check-label" for="terms_accepted">
                                    I confirm that all information provided is accurate and complete. I understand that any false statements may lead to the rejection of my application or termination of employment.
                                </label>
                                @error('terms_accepted')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Application
                            </button>
                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Job Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Job Details</h6>
                            <ul class="list-unstyled">
                                <li><strong>Title:</strong> {{ $job->title }}</li>
                                <li><strong>Type:</strong> {{ ucfirst($job->type) }}</li>
                                @if($job->location)
                                    <li><strong>Location:</strong> {{ $job->location }}</li>
                                @endif
                                @if($job->is_remote)
                                    <li><strong>Remote:</strong> Yes</li>
                                @endif
                                @if($job->category)
                                    <li><strong>Category:</strong> {{ $job->category }}</li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Company Information</h6>
                            <ul class="list-unstyled">
                                @if($job->company_name)
                                    <li><strong>Company:</strong> {{ $job->company_name }}</li>
                                @endif
                                @if($job->company_website)
                                    <li><strong>Website:</strong> <a href="{{ $job->company_website }}" target="_blank">{{ $job->company_website }}</a></li>
                                @endif
                                @if($job->contact_email)
                                    <li><strong>Contact:</strong> <a href="mailto:{{ $job->contact_email }}">{{ $job->contact_email }}</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Job Description</h6>
                        <div class="job-description-preview">
                            {!! Str::limit(strip_tags($job->description), 300) !!}
                            <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
