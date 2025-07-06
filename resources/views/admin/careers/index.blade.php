@extends('admin.layouts.app')

@section('title', 'Manage Careers')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Job Postings</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.careers.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Job
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
                                    <th>Title</th>
                                    <th>Department</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Applications</th>
                                    <th>Status</th>
                                    <th>Expires</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($careers as $career)
                                    <tr>
                                        <td>
                                            {{ $career->title }}
                                            @if($career->featured)
                                                <span class="badge badge-warning">Featured</span>
                                            @endif
                                        </td>
                                        <td>{{ $career->department }}</td>
                                        <td>{{ $career->location }}</td>
                                        <td>{{ $career->type }}</td>
                                        <td>
                                            <a href="{{ route('admin.careers.applications', $career) }}" class="btn btn-info btn-sm">
                                                {{ $career->applications_count ?? $career->applications()->count() }} Applications
                                            </a>
                                        </td>
                                        <td>
                                            @if($career->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($career->expires_at)
                                                {{ \Carbon\Carbon::parse($career->expires_at)->format('M d, Y') }}
                                                @if(\Carbon\Carbon::parse($career->expires_at)->isPast())
                                                    <span class="badge badge-danger">Expired</span>
                                                @endif
                                            @else
                                                No expiry
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.careers.edit', $career) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.careers.show', $career) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('careers.show', $career->slug) }}" target="_blank" class="btn btn-success btn-sm">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                                <form action="{{ route('admin.careers.destroy', $career) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job posting?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No job postings found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $careers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
