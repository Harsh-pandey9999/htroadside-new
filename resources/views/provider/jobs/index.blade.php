@extends('layouts.provider')

@section('title', 'Manage Jobs')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Jobs</h1>
        <a href="{{ route('provider.jobs.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Post New Job
        </a>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Jobs</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('provider.jobs.index') }}" method="GET" class="row">
                <div class="col-md-3 mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="type">Job Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">All Types</option>
                        <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="temporary" {{ request('type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="search">Search</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search by title or location" value="{{ request('search') }}">
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Jobs List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Your Jobs</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Job Actions:</div>
                    <a class="dropdown-item" href="{{ route('provider.jobs.create') }}">Post New Job</a>
                    <a class="dropdown-item" href="{{ route('jobs.index') }}" target="_blank">View Public Job Listings</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($jobs->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('img/empty-jobs.svg') }}" alt="No jobs found" class="img-fluid mb-3" style="max-height: 150px;">
                    <h5 class="text-gray-500">No jobs found</h5>
                    <p class="text-gray-500">You haven't posted any jobs yet or none match your filter criteria.</p>
                    <a href="{{ route('provider.jobs.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus fa-sm"></i> Post Your First Job
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Applications</th>
                                <th>Status</th>
                                <th>Posted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $job)
                                <tr>
                                    <td>
                                        <a href="{{ route('provider.jobs.show', $job->id) }}">{{ $job->title }}</a>
                                        @if($job->is_featured)
                                            <span class="badge badge-warning ml-2">Featured</span>
                                        @endif
                                        @if($job->is_remote)
                                            <span class="badge badge-info ml-2">Remote</span>
                                        @endif
                                    </td>
                                    <td>{{ $job->location ?? 'Remote' }}</td>
                                    <td>
                                        @switch($job->type)
                                            @case('full-time')
                                                <span class="badge badge-primary">Full Time</span>
                                                @break
                                            @case('part-time')
                                                <span class="badge badge-success">Part Time</span>
                                                @break
                                            @case('contract')
                                                <span class="badge badge-warning">Contract</span>
                                                @break
                                            @case('temporary')
                                                <span class="badge badge-info">Temporary</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $job->type }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('provider.jobs.applications', $job->id) }}">
                                            {{ $job->applications_count ?? 0 }} 
                                            <i class="fas fa-external-link-alt fa-sm ml-1"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($job->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $job->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('provider.jobs.edit', $job->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('provider.jobs.show', $job->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('jobs.show', $job->id) }}" target="_blank" class="btn btn-sm btn-success">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteJobModal{{ $job->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteJobModal{{ $job->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteJobModalLabel{{ $job->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteJobModalLabel{{ $job->id }}">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete the job <strong>{{ $job->title }}</strong>?</p>
                                                        <p class="text-danger">This action cannot be undone. Jobs with existing applications cannot be deleted.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('provider.jobs.destroy', $job->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete Job</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <!-- Job Posting Tips -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Job Posting Tips</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Write Clear Job Titles</div>
                                    <div class="small mb-0">Use specific job titles that clearly describe the position. Avoid vague terms or internal titles that may not be recognized by job seekers.</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-heading fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card border-left-success h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Be Detailed</div>
                                    <div class="small mb-0">Include comprehensive information about responsibilities, requirements, and benefits. The more details you provide, the more qualified candidates you'll attract.</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-ul fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-left-info h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Salary Transparency</div>
                                    <div class="small mb-0">Including salary information increases application rates by up to 30%. Be transparent about compensation to attract more qualified candidates.</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
