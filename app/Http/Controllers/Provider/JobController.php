<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class JobController extends Controller
{
    /**
     * Display a listing of jobs posted by the service provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Job::where('posted_by', Auth::id())
                ->orderBy('created_at', 'desc');
            
            // Filter by status
            if ($request->has('status')) {
                if ($request->status === 'active') {
                    $query->where('is_active', true);
                } elseif ($request->status === 'inactive') {
                    $query->where('is_active', false);
                }
            }
            
            // Filter by job type
            if ($request->has('type') && $request->type) {
                $query->where('type', $request->type);
            }
            
            // Search by title or location
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }
            
            $jobs = $query->paginate(10)->withQueryString();
            
            return view('provider.jobs.index', compact('jobs'));
        } catch (QueryException $e) {
            \Log::error('Database error fetching provider jobs: ' . $e->getMessage());
            return back()->with('error', 'Database error occurred. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error fetching provider jobs: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching your jobs. Please try again.');
        }
    }

    /**
     * Show the form for creating a new job.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('provider.jobs.create');
    }

    /**
     * Store a newly created job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'requirements' => 'nullable|string',
                'responsibilities' => 'nullable|string',
                'location' => 'nullable|string|max:255',
                'type' => 'required|string|in:full-time,part-time,contract,temporary',
                'category' => 'nullable|string|max:255',
                'salary_min' => 'nullable|numeric|min:0',
                'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
                'salary_currency' => 'required|string|size:3',
                'salary_period' => 'required|string|in:hourly,daily,weekly,monthly,yearly',
                'is_remote' => 'boolean',
                'application_deadline' => 'nullable|date|after:today',
                'company_logo' => 'nullable|image|max:2048', // 2MB max
                'contact_email' => 'nullable|email|max:255',
            ]);

            // Handle company logo upload
            if ($request->hasFile('company_logo')) {
                $path = $request->file('company_logo')->store('company_logos', 'public');
                $validated['company_logo'] = $path;
            }

            // Set posted_by to current service provider user
            $validated['posted_by'] = Auth::id();
            
            // Set company name from user's profile
            $validated['company_name'] = Auth::user()->company_name ?? Auth::user()->name;
            
            // Set company website from user's profile
            $validated['company_website'] = Auth::user()->company_website ?? null;
            
            // Set job as inactive by default (requires admin approval)
            $validated['is_active'] = false;
            $validated['is_featured'] = false;

            // Create the job
            $job = Job::create($validated);

            return redirect()->route('provider.jobs.index')
                ->with('success', 'Job posted successfully and is pending admin approval.');
        } catch (QueryException $e) {
            \Log::error('Database error creating job: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Database error occurred. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error creating job: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while creating the job. Please try again.');
        }
    }

    /**
     * Display the specified job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $job = Job::where('id', $id)
                ->where('posted_by', Auth::id())
                ->firstOrFail();
            
            return view('provider.jobs.show', compact('job'));
        } catch (\Exception $e) {
            \Log::error('Error showing job: ' . $e->getMessage());
            return back()->with('error', 'Unable to find the requested job.');
        }
    }

    /**
     * Show the form for editing the specified job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $job = Job::where('id', $id)
                ->where('posted_by', Auth::id())
                ->firstOrFail();
            
            return view('provider.jobs.edit', compact('job'));
        } catch (\Exception $e) {
            \Log::error('Error editing job: ' . $e->getMessage());
            return back()->with('error', 'Unable to find the requested job.');
        }
    }

    /**
     * Update the specified job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $job = Job::where('id', $id)
                ->where('posted_by', Auth::id())
                ->firstOrFail();
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'requirements' => 'nullable|string',
                'responsibilities' => 'nullable|string',
                'location' => 'nullable|string|max:255',
                'type' => 'required|string|in:full-time,part-time,contract,temporary',
                'category' => 'nullable|string|max:255',
                'salary_min' => 'nullable|numeric|min:0',
                'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
                'salary_currency' => 'required|string|size:3',
                'salary_period' => 'required|string|in:hourly,daily,weekly,monthly,yearly',
                'is_remote' => 'boolean',
                'application_deadline' => 'nullable|date|after:today',
                'company_logo' => 'nullable|image|max:2048', // 2MB max
                'contact_email' => 'nullable|email|max:255',
            ]);

            // Handle company logo upload
            if ($request->hasFile('company_logo')) {
                // Delete old logo if it exists
                if ($job->company_logo) {
                    \Storage::disk('public')->delete($job->company_logo);
                }
                
                $path = $request->file('company_logo')->store('company_logos', 'public');
                $validated['company_logo'] = $path;
            }
            
            // Set job as inactive after update (requires admin re-approval)
            $validated['is_active'] = false;

            // Update the job
            $job->update($validated);

            return redirect()->route('provider.jobs.index')
                ->with('success', 'Job updated successfully and is pending admin approval.');
        } catch (QueryException $e) {
            \Log::error('Database error updating job: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Database error occurred. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error updating job: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while updating the job. Please try again.');
        }
    }

    /**
     * Remove the specified job from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $job = Job::where('id', $id)
                ->where('posted_by', Auth::id())
                ->firstOrFail();
            
            // Check if job has applications
            if ($job->applications()->count() > 0) {
                return back()->with('error', 'Cannot delete job with existing applications.');
            }
            
            // Delete company logo if it exists
            if ($job->company_logo) {
                \Storage::disk('public')->delete($job->company_logo);
            }
            
            // Delete the job
            $job->delete();

            return redirect()->route('provider.jobs.index')
                ->with('success', 'Job deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting job: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the job. Please try again.');
        }
    }
    
    /**
     * View applications for a specific job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function applications($id)
    {
        try {
            $job = Job::where('id', $id)
                ->where('posted_by', Auth::id())
                ->firstOrFail();
            
            $applications = JobApplication::where('job_id', $job->id)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            return view('provider.jobs.applications', compact('job', 'applications'));
        } catch (\Exception $e) {
            \Log::error('Error viewing job applications: ' . $e->getMessage());
            return back()->with('error', 'Unable to view applications for this job.');
        }
    }
    
    /**
     * Update the status of a job application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $jobId
     * @param  int  $applicationId
     * @return \Illuminate\Http\Response
     */
    public function updateApplicationStatus(Request $request, $jobId, $applicationId)
    {
        try {
            $job = Job::where('id', $jobId)
                ->where('posted_by', Auth::id())
                ->firstOrFail();
            
            $application = JobApplication::where('id', $applicationId)
                ->where('job_id', $job->id)
                ->firstOrFail();
            
            $validated = $request->validate([
                'status' => 'required|in:reviewing,shortlisted,interview,offered,rejected',
                'notes' => 'nullable|string',
                'interview_date' => 'nullable|required_if:status,interview|date',
                'interview_location' => 'nullable|required_if:status,interview|string|max:255',
            ]);
            
            $application->status = $validated['status'];
            
            if (isset($validated['notes'])) {
                $application->admin_notes = $validated['notes'];
            }
            
            if ($validated['status'] === 'interview') {
                $application->interview_date = $validated['interview_date'];
                $application->interview_location = $validated['interview_location'];
            }
            
            $application->save();
            
            // TODO: Send notification to applicant
            
            return redirect()->route('provider.jobs.applications', $job->id)
                ->with('success', 'Application status updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating application status: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the application status.');
        }
    }
}
