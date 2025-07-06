@extends('admin.layouts.app')

@section('title', 'View Job Posting')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Job Posting Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.careers.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('admin.careers.edit', $career) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('careers.show', $career->slug) }}" target="_blank" class="btn btn-success btn-sm">
                            <i class="fas fa-external-link-alt"></i> View on Website
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>{{ $career->title }}</h2>
                            <div class="mb-4">
                                <span class="badge badge-primary">{{ $career->department }}</span>
                                <span class="badge badge-info">{{ $career->location }}</span>
                                <span class="badge badge-secondary">{{ $career->type }}</span>
                                @if($career->featured)
                                    <span class="badge badge-warning">Featured</span>
                                @endif
                                @if($career->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.careers.applications', $career) }}" class="btn btn-info">
                                <i class="fas fa-users"></i> View Applications ({{ $career->applications_count ?? $career->applications()->count() }})
                            </a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Job Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <dl class="row">
                                                <dt class="col-sm-4">Created</dt>
                                                <dd class="col-sm-8">{{ $career->created_at->format('M d, Y H:i') }}</dd>
                                                
                                                <dt class="col-sm-4">Last Updated</dt>
                                                <dd class="col-sm-8">{{ $career->updated_at->format('M d, Y H:i') }}</dd>
                                                
                                                <dt class="col-sm-4">Expires</dt>
                                                <dd class="col-sm-8">
                                                    @if($career->expires_at)
                                                        {{ \Carbon\Carbon::parse($career->expires_at)->format('M d, Y') }}
                                                        @if(\Carbon\Carbon::parse($career->expires_at)->isPast())
                                                            <span class="badge badge-danger">Expired</span>
                                                        @endif
                                                    @else
                                                        No expiry date
                                                    @endif
                                                </dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-6">
                                            <dl class="row">
                                                <dt class="col-sm-4">Salary Range</dt>
                                                <dd class="col-sm-8">
                                                    @if($career->salary_min || $career->salary_max)
                                                        @if($career->salary_min && $career->salary_max)
                                                            ${{ number_format($career->salary_min) }} - ${{ number_format($career->salary_max) }}
                                                        @elseif($career->salary_min)
                                                            From ${{ number_format($career->salary_min) }}
                                                        @elseif($career->salary_max)
                                                            Up to ${{ number_format($career->salary_max) }}
                                                        @endif
                                                    @else
                                                        Not specified
                                                    @endif
                                                </dd>
                                                
                                                <dt class="col-sm-4">Slug</dt>
                                                <dd class="col-sm-8">{{ $career->slug }}</dd>
                                                
                                                <dt class="col-sm-4">Status</dt>
                                                <dd class="col-sm-8">
                                                    @if($career->is_active)
                                                        <span class="text-success"><i class="fas fa-check-circle"></i> Active</span>
                                                    @else
                                                        <span class="text-danger"><i class="fas fa-times-circle"></i> Inactive</span>
                                                    @endif
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Job Description</h3>
                                </div>
                                <div class="card-body">
                                    <p>{{ $career->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Responsibilities</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        @if(is_array($career->responsibilities))
                                            @foreach($career->responsibilities as $responsibility)
                                                <li class="list-group-item">{{ $responsibility }}</li>
                                            @endforeach
                                        @elseif(is_string($career->responsibilities))
                                            @foreach(json_decode($career->responsibilities) as $responsibility)
                                                <li class="list-group-item">{{ $responsibility }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Requirements</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        @if(is_array($career->requirements))
                                            @foreach($career->requirements as $requirement)
                                                <li class="list-group-item">{{ $requirement }}</li>
                                            @endforeach
                                        @elseif(is_string($career->requirements))
                                            @foreach(json_decode($career->requirements) as $requirement)
                                                <li class="list-group-item">{{ $requirement }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Benefits</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        @if(is_array($career->benefits))
                                            @foreach($career->benefits as $benefit)
                                                <li class="list-group-item">{{ $benefit }}</li>
                                            @endforeach
                                        @elseif(is_string($career->benefits))
                                            @foreach(json_decode($career->benefits) as $benefit)
                                                <li class="list-group-item">{{ $benefit }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('admin.careers.destroy', $career) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job posting?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Job Posting
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
