@extends('layouts.admin')

@section('title', 'Manage Jobs')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Jobs</h1>
        <a href="{{ route('admin.jobs.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New Job
        </a>
    </div>

    @include('partials.alerts')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Jobs</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filter By:</div>
                    <a class="dropdown-item" href="{{ route('admin.jobs.index', ['status' => 'active']) }}">Active Jobs</a>
                    <a class="dropdown-item" href="{{ route('admin.jobs.index', ['status' => 'inactive']) }}">Inactive Jobs</a>
                    <a class="dropdown-item" href="{{ route('admin.jobs.index', ['featured' => 'yes']) }}">Featured Jobs</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('admin.jobs.index') }}">All Jobs</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="jobsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Applications</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Deadline</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                        <tr>
                            <td>{{ $job->id }}</td>
                            <td>
                                <a href="{{ route('admin.jobs.show', $job->id) }}">{{ $job->title }}</a>
                                @if($job->is_remote)
                                    <span class="badge badge-info">Remote</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($job->type) }}</td>
                            <td>{{ $job->location ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.jobs.applications', $job->id) }}" class="btn btn-sm btn-info">
                                    {{ $job->applications_count }} Applications
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.jobs.toggle-active', $job->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $job->is_active ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $job->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.jobs.toggle-featured', $job->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $job->is_featured ? 'btn-warning' : 'btn-light' }}">
                                        {{ $job->is_featured ? 'Featured' : 'Not Featured' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                @if($job->application_deadline)
                                    {{ $job->application_deadline->format('M d, Y') }}
                                    @if($job->application_deadline->isPast())
                                        <span class="badge badge-danger">Expired</span>
                                    @endif
                                @else
                                    No Deadline
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.jobs.show', $job->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No jobs found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Confirm delete
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this job? This action cannot be undone.')) {
                this.submit();
            }
        });
    });
</script>
@endpush
