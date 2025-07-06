@extends('layouts.admin')

@section('title', 'Job Applications')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Applications for: {{ $job->title }}</h1>
        <div>
            <a href="{{ route('admin.jobs.show', $job->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-eye fa-sm text-white-50"></i> View Job
            </a>
            <a href="{{ route('admin.jobs.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Jobs
            </a>
        </div>
    </div>

    @include('partials.alerts')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Applications ({{ $applications->total() }})</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filter By:</div>
                    <a class="dropdown-item" href="{{ route('admin.jobs.applications', ['job' => $job->id, 'status' => 'pending']) }}">Pending</a>
                    <a class="dropdown-item" href="{{ route('admin.jobs.applications', ['job' => $job->id, 'status' => 'approved']) }}">Approved</a>
                    <a class="dropdown-item" href="{{ route('admin.jobs.applications', ['job' => $job->id, 'status' => 'rejected']) }}">Rejected</a>
                    <a class="dropdown-item" href="{{ route('admin.jobs.applications', ['job' => $job->id, 'status' => 'withdrawn']) }}">Withdrawn</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('admin.jobs.applications', $job->id) }}">All Applications</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="applicationsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Applicant</th>
                            <th>Applied On</th>
                            <th>Resume</th>
                            <th>Status</th>
                            <th>Interview Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                        <tr>
                            <td>{{ $application->id }}</td>
                            <td>
                                <div class="font-weight-bold">{{ $application->user->name }}</div>
                                <div class="small text-muted">{{ $application->user->email }}</div>
                                @if($application->user->phone)
                                    <div class="small text-muted">{{ $application->user->phone }}</div>
                                @endif
                            </td>
                            <td>{{ $application->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($application->resume)
                                    <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-pdf"></i> View Resume
                                    </a>
                                @else
                                    <span class="text-muted">No resume</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $application->status == 'pending' ? 'warning' : 
                                    ($application->status == 'approved' ? 'success' : 
                                    ($application->status == 'rejected' ? 'danger' : 'secondary')) 
                                }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>
                                @if($application->interview_date)
                                    {{ $application->interview_date->format('M d, Y H:i') }}
                                @else
                                    <span class="text-muted">Not scheduled</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary view-application" data-toggle="modal" data-target="#applicationModal" 
                                    data-id="{{ $application->id }}"
                                    data-name="{{ $application->user->name }}"
                                    data-email="{{ $application->user->email }}"
                                    data-phone="{{ $application->user->phone ?? 'Not provided' }}"
                                    data-date="{{ $application->created_at->format('M d, Y H:i') }}"
                                    data-coverletter="{{ $application->cover_letter }}"
                                    data-status="{{ $application->status }}"
                                    data-resume="{{ $application->resume ? asset('storage/' . $application->resume) : '' }}"
                                    data-interview="{{ $application->interview_date ? $application->interview_date->format('Y-m-d\TH:i') : '' }}"
                                    data-notes="{{ $application->admin_notes }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No applications found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Application Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1" role="dialog" aria-labelledby="applicationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applicationModalLabel">Application Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Applicant Information</h6>
                        <p><strong>Name:</strong> <span id="modal-name"></span></p>
                        <p><strong>Email:</strong> <span id="modal-email"></span></p>
                        <p><strong>Phone:</strong> <span id="modal-phone"></span></p>
                        <p><strong>Applied On:</strong> <span id="modal-date"></span></p>
                        <p><strong>Status:</strong> <span id="modal-status-badge"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Resume</h6>
                        <div id="modal-resume-container">
                            <a href="#" id="modal-resume-link" target="_blank" class="btn btn-primary">
                                <i class="fas fa-file-pdf"></i> View Resume
                            </a>
                        </div>
                        <div id="modal-no-resume" class="text-muted">No resume provided</div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="font-weight-bold">Cover Letter</h6>
                    <div class="p-3 bg-light rounded" id="modal-coverletter"></div>
                </div>
                
                <form id="application-update-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="status">Update Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="interview_date">Schedule Interview</label>
                        <input type="datetime-local" class="form-control" id="interview_date" name="interview_date">
                        <small class="form-text text-muted">Leave empty to clear the interview date</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_notes">Admin Notes</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-application">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle view application button click
        $('.view-application').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            var date = $(this).data('date');
            var coverletter = $(this).data('coverletter');
            var status = $(this).data('status');
            var resume = $(this).data('resume');
            var interview = $(this).data('interview');
            var notes = $(this).data('notes');
            
            // Set form action URL
            $('#application-update-form').attr('action', '/admin/job-applications/' + id);
            
            // Populate modal fields
            $('#modal-name').text(name);
            $('#modal-email').text(email);
            $('#modal-phone').text(phone);
            $('#modal-date').text(date);
            $('#modal-coverletter').text(coverletter || 'No cover letter provided');
            
            // Set status badge
            var statusClass = 'badge badge-';
            if (status === 'pending') statusClass += 'warning';
            else if (status === 'approved') statusClass += 'success';
            else if (status === 'rejected') statusClass += 'danger';
            else statusClass += 'secondary';
            
            $('#modal-status-badge').html('<span class="' + statusClass + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>');
            
            // Set resume link or hide if not available
            if (resume) {
                $('#modal-resume-container').show();
                $('#modal-no-resume').hide();
                $('#modal-resume-link').attr('href', resume);
            } else {
                $('#modal-resume-container').hide();
                $('#modal-no-resume').show();
            }
            
            // Set form values
            $('#status').val(status);
            $('#interview_date').val(interview);
            $('#admin_notes').val(notes);
        });
        
        // Handle save button click
        $('#save-application').on('click', function() {
            $('#application-update-form').submit();
        });
    });
</script>
@endpush
