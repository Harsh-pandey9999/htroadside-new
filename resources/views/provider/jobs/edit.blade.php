@extends('layouts.provider')

@section('title', 'Edit Job')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .note-editor .dropdown-toggle::after {
        display: none;
    }
    .required-label::after {
        content: " *";
        color: red;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Job</h1>
        <div>
            <a href="{{ route('provider.jobs.show', $job->id) }}" class="d-none d-sm-inline-block btn btn-info shadow-sm mr-2">
                <i class="fas fa-eye fa-sm text-white-50"></i> View Job
            </a>
            <a href="{{ route('provider.jobs.index') }}" class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Jobs
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Job Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Job Details</h6>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('provider.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="title" class="required-label">Job Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $job->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Be specific with your job title (e.g., "Senior Roadside Assistance Technician" instead of just "Technician")</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="required-label">Job Description</label>
                            <textarea class="form-control summernote @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description', $job->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Provide a comprehensive overview of the position, including day-to-day responsibilities and company information.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="requirements">Requirements</label>
                            <textarea class="form-control summernote @error('requirements') is-invalid @enderror" id="requirements" name="requirements" rows="4">{{ old('requirements', $job->requirements) }}</textarea>
                            @error('requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">List qualifications, skills, experience, and education needed for the role.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="responsibilities">Responsibilities</label>
                            <textarea class="form-control summernote @error('responsibilities') is-invalid @enderror" id="responsibilities" name="responsibilities" rows="4">{{ old('responsibilities', $job->responsibilities) }}</textarea>
                            @error('responsibilities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Detail the specific duties and tasks the candidate will be responsible for.</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $job->location) }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Specify the city, state, or region. Leave blank if fully remote.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class="required-label">Job Type</label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Select Job Type</option>
                                        <option value="full-time" {{ old('type', $job->type) == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="part-time" {{ old('type', $job->type) == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                        <option value="contract" {{ old('type', $job->type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="temporary" {{ old('type', $job->type) == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Job Category</label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category', $job->category) }}">
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">E.g., Roadside Assistance, Mechanic, Customer Service, etc.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="application_deadline">Application Deadline</label>
                                    <input type="date" class="form-control @error('application_deadline') is-invalid @enderror" id="application_deadline" name="application_deadline" value="{{ old('application_deadline', $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}">
                                    @error('application_deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Leave blank if there's no specific deadline.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_remote" name="is_remote" value="1" {{ old('is_remote', $job->is_remote) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_remote">This is a remote position</label>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <h5 class="mb-3">Salary Information</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="salary_min">Minimum Salary</label>
                                    <input type="number" step="0.01" class="form-control @error('salary_min') is-invalid @enderror" id="salary_min" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}">
                                    @error('salary_min')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="salary_max">Maximum Salary</label>
                                    <input type="number" step="0.01" class="form-control @error('salary_max') is-invalid @enderror" id="salary_max" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}">
                                    @error('salary_max')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="salary_currency" class="required-label">Currency</label>
                                    <select class="form-control @error('salary_currency') is-invalid @enderror" id="salary_currency" name="salary_currency" required>
                                        <option value="USD" {{ old('salary_currency', $job->salary_currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="EUR" {{ old('salary_currency', $job->salary_currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                        <option value="GBP" {{ old('salary_currency', $job->salary_currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                                        <option value="CAD" {{ old('salary_currency', $job->salary_currency) == 'CAD' ? 'selected' : '' }}>CAD</option>
                                        <option value="AUD" {{ old('salary_currency', $job->salary_currency) == 'AUD' ? 'selected' : '' }}>AUD</option>
                                        <option value="INR" {{ old('salary_currency', $job->salary_currency) == 'INR' ? 'selected' : '' }}>INR</option>
                                    </select>
                                    @error('salary_currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="salary_period" class="required-label">Period</label>
                                    <select class="form-control @error('salary_period') is-invalid @enderror" id="salary_period" name="salary_period" required>
                                        <option value="hourly" {{ old('salary_period', $job->salary_period) == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                        <option value="daily" {{ old('salary_period', $job->salary_period) == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ old('salary_period', $job->salary_period) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="monthly" {{ old('salary_period', $job->salary_period) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="yearly" {{ old('salary_period', $job->salary_period) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                    </select>
                                    @error('salary_period')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <h5 class="mb-3">Contact Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_email">Contact Email</label>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email', $job->contact_email) }}">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Email where applicants can contact you with questions (different from where applications are sent).</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_logo">Company Logo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('company_logo') is-invalid @enderror" id="company_logo" name="company_logo">
                                        <label class="custom-file-label" for="company_logo">Choose file</label>
                                        @error('company_logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Recommended size: 200x200px, max 2MB. PNG or JPG format.</small>
                                    
                                    @if($job->company_logo)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($job->company_logo) }}" alt="Current company logo" class="img-thumbnail" style="max-height: 100px;">
                                            <p class="small text-muted mt-1">Current logo. Upload a new one to replace it.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Editing this job will require admin approval before it becomes visible to job seekers again.
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Job</button>
                            <a href="{{ route('provider.jobs.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
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
                                <span class="badge badge-primary badge-pill">{{ $job->applications_count ?? 0 }}</span>
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
                    
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle mr-1"></i> Fields marked with <span class="text-danger">*</span> are required.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        
        // Update file input label with selected filename
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@endsection
