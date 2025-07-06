@extends('admin.layouts.app')

@section('title', 'View Application')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Application Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.careers.applications', $application->career) }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Applications
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <h2>{{ $application->name }}</h2>
                            <p class="lead">Application for: <a href="{{ route('admin.careers.show', $application->career) }}">{{ $application->career->title }}</a></p>
                        </div>
                        <div class="col-md-4 text-right">
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'reviewing' => 'info',
                                    'interview' => 'primary',
                                    'selected' => 'success',
                                    'rejected' => 'danger'
                                ];
                                $statusColor = $statusColors[$application->status] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $statusColor }} p-2" style="font-size: 1rem;">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Applicant Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <dl class="row">
                                                <dt class="col-sm-4">Full Name</dt>
                                                <dd class="col-sm-8">{{ $application->name }}</dd>
                                                
                                                <dt class="col-sm-4">Email Address</dt>
                                                <dd class="col-sm-8">
                                                    <a href="mailto:{{ $application->email }}">{{ $application->email }}</a>
                                                </dd>
                                                
                                                <dt class="col-sm-4">Phone Number</dt>
                                                <dd class="col-sm-8">
                                                    <a href="tel:{{ $application->phone }}">{{ $application->phone }}</a>
                                                </dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-6">
                                            <dl class="row">
                                                <dt class="col-sm-4">Date Applied</dt>
                                                <dd class="col-sm-8">{{ $application->created_at->format('F j, Y \a\t g:i a') }}</dd>
                                                
                                                <dt class="col-sm-4">Resume/CV</dt>
                                                <dd class="col-sm-8">
                                                    <a href="{{ asset('storage/' . $application->resume_path) }}" class="btn btn-sm btn-primary" target="_blank">
                                                        <i class="fas fa-download"></i> Download Resume
                                                    </a>
                                                </dd>
                                                
                                                <dt class="col-sm-4">Viewed</dt>
                                                <dd class="col-sm-8">
                                                    @if($application->viewed)
                                                        <span class="text-success">Yes</span> ({{ $application->viewed_at ? $application->viewed_at->format('M d, Y H:i') : 'Unknown date' }})
                                                    @else
                                                        <span class="text-danger">No</span>
                                                    @endif
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($application->cover_letter)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Cover Letter</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="p-3 bg-light rounded">
                                            {!! nl2br(e($application->cover_letter)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Update Application Status</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.careers.update-application-status', $application) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select name="status" id="status" class="form-control">
                                                        @foreach(\App\Models\CareerApplication::getStatuses() as $statusKey => $statusName)
                                                            <option value="{{ $statusKey }}" {{ $application->status === $statusKey ? 'selected' : '' }}>
                                                                {{ $statusName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="notes">Internal Notes</label>
                                                    <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Add internal notes about this applicant">{{ $application->notes }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="mailto:{{ $application->email }}" class="btn btn-info">
                                <i class="fas fa-envelope"></i> Email Applicant
                            </a>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('admin.careers.applications', $application->career) }}" class="btn btn-default">
                                Back to All Applications
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
