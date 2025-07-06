@extends('layouts.admin')

@section('title', 'Create New Job')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Job</h1>
        <a href="{{ route('admin.jobs.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Jobs
        </a>
    </div>

    @include('partials.alerts')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Job Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jobs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Job Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Job Type <span class="text-danger">*</span></label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Job Type</option>
                                <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="temporary" {{ old('type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Job Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Provide a detailed description of the job role and responsibilities.</small>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="requirements">Requirements</label>
                            <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" rows="4">{{ old('requirements') }}</textarea>
                            @error('requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">List the qualifications, skills, and experience required for this position.</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="responsibilities">Responsibilities</label>
                            <textarea class="form-control @error('responsibilities') is-invalid @enderror" id="responsibilities" name="responsibilities" rows="4">{{ old('responsibilities') }}</textarea>
                            @error('responsibilities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">List the key responsibilities and duties for this role.</small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">E.g., Engineering, Marketing, Customer Service, etc.</small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="salary_min">Minimum Salary</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('salary_min') is-invalid @enderror" id="salary_min" name="salary_min" value="{{ old('salary_min') }}">
                            @error('salary_min')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="salary_max">Maximum Salary</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('salary_max') is-invalid @enderror" id="salary_max" name="salary_max" value="{{ old('salary_max') }}">
                            @error('salary_max')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="salary_currency">Currency <span class="text-danger">*</span></label>
                            <select class="form-control @error('salary_currency') is-invalid @enderror" id="salary_currency" name="salary_currency" required>
                                <option value="INR" {{ old('salary_currency', 'INR') == 'INR' ? 'selected' : '' }}>INR</option>
                                <option value="USD" {{ old('salary_currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ old('salary_currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ old('salary_currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                            </select>
                            @error('salary_currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="salary_period">Salary Period <span class="text-danger">*</span></label>
                            <select class="form-control @error('salary_period') is-invalid @enderror" id="salary_period" name="salary_period" required>
                                <option value="monthly" {{ old('salary_period', 'monthly') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ old('salary_period') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                <option value="weekly" {{ old('salary_period') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="daily" {{ old('salary_period') == 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="hourly" {{ old('salary_period') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                            </select>
                            @error('salary_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="application_deadline">Application Deadline</label>
                            <input type="date" class="form-control @error('application_deadline') is-invalid @enderror" id="application_deadline" name="application_deadline" value="{{ old('application_deadline') }}">
                            @error('application_deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave blank for no deadline.</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_email">Contact Email</label>
                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email') }}">
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') }}">
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_website">Company Website</label>
                            <input type="url" class="form-control @error('company_website') is-invalid @enderror" id="company_website" name="company_website" value="{{ old('company_website') }}">
                            @error('company_website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="company_logo">Company Logo</label>
                    <input type="file" class="form-control-file @error('company_logo') is-invalid @enderror" id="company_logo" name="company_logo">
                    @error('company_logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Upload a company logo (max 2MB, recommended size: 200x200px).</small>
                </div>
                
                <div class="form-group">
                    <label for="application_url">External Application URL</label>
                    <input type="url" class="form-control @error('application_url') is-invalid @enderror" id="application_url" name="application_url" value="{{ old('application_url') }}">
                    @error('application_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">If provided, applicants will be redirected to this URL instead of using the internal application system.</small>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_remote" name="is_remote" value="1" {{ old('is_remote') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_remote">Remote Job</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_featured">Featured Job</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active Job</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Create Job</button>
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Add rich text editor to description, requirements, and responsibilities
        if (typeof ClassicEditor !== 'undefined') {
            ClassicEditor.create(document.querySelector('#description')).catch(error => {
                console.error(error);
            });
            
            ClassicEditor.create(document.querySelector('#requirements')).catch(error => {
                console.error(error);
            });
            
            ClassicEditor.create(document.querySelector('#responsibilities')).catch(error => {
                console.error(error);
            });
        }
    });
</script>
@endpush
