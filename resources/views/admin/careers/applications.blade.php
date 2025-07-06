@extends('admin.layouts.app')

@section('title', 'Job Applications - ' . $career->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Applications for: {{ $career->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.careers.show', $career) }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Job
                        </a>
                        <a href="{{ route('admin.careers.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-list"></i> All Jobs
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Date Applied</th>
                                    <th>Status</th>
                                    <th>Viewed</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $application)
                                    <tr class="{{ $application->viewed ? '' : 'bg-light font-weight-bold' }}">
                                        <td>{{ $application->name }}</td>
                                        <td>
                                            <a href="mailto:{{ $application->email }}">{{ $application->email }}</a>
                                        </td>
                                        <td>{{ $application->phone }}</td>
                                        <td>{{ $application->created_at->format('M d, Y H:i') }}</td>
                                        <td>
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
                                            <span class="badge badge-{{ $statusColor }}">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($application->viewed)
                                                <span class="text-success"><i class="fas fa-check"></i></span>
                                            @else
                                                <span class="text-danger"><i class="fas fa-times"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.careers.show-application', $application) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <h6 class="dropdown-header">Change Status</h6>
                                                    @foreach(\App\Models\CareerApplication::getStatuses() as $statusKey => $statusName)
                                                        <form action="{{ route('admin.careers.update-application-status', $application) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="{{ $statusKey }}">
                                                            <button type="submit" class="dropdown-item {{ $application->status === $statusKey ? 'active' : '' }}">
                                                                {{ $statusName }}
                                                            </button>
                                                        </form>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No applications found for this job.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $applications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
