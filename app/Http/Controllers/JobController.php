<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Job::where('is_active', true);
            
            // Search
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('requirements', 'like', "%{$search}%")
                      ->orWhere('responsibilities', 'like', "%{$search}%")
                      ->orWhere('company_name', 'like', "%{$search}%");
                });
            }
            
            // Location
            if ($request->has('location') && $request->location) {
                $location = $request->location;
                if (strtolower($location) === 'remote') {
                    $query->where('is_remote', true);
                } else {
                    $query->where('location', 'like', "%{$location}%");
                }
            }
            
            // Job Type
            if ($request->has('type') && $request->type) {
                $query->where('type', $request->type);
            }
            
            // Multiple Job Types (from checkboxes)
            if ($request->has('types') && is_array($request->types)) {
                $query->whereIn('type', $request->types);
            }
            
            // Remote Only
            if ($request->has('remote') && $request->remote) {
                $query->where('is_remote', true);
            }
            
            // Salary Range
            if ($request->has('salary_range') && $request->salary_range) {
                list($min, $max) = explode('-', $request->salary_range);
                
                if ($min > 0 && $max > 0) {
                    // Between min and max
                    $query->where(function($q) use ($min, $max) {
                        $q->whereBetween('salary_min', [$min, $max])
                          ->orWhereBetween('salary_max', [$min, $max])
                          ->orWhere(function($q2) use ($min, $max) {
                              $q2->where('salary_min', '<=', $min)
                                 ->where('salary_max', '>=', $max);
                          });
                    });
                } elseif ($min > 0 && $max == 0) {
                    // Above min
                    $query->where(function($q) use ($min) {
                        $q->where('salary_min', '>=', $min)
                          ->orWhere('salary_max', '>=', $min);
                    });
                } elseif ($min == 0 && $max > 0) {
                    // Below max
                    $query->where(function($q) use ($max) {
                        $q->where('salary_min', '<=', $max)
                          ->orWhere('salary_max', '<=', $max);
                    });
                }
            }
            
            // Sorting
            if ($request->has('sort')) {
                switch ($request->sort) {
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'salary_high':
                        $query->orderBy('salary_max', 'desc')->orderBy('salary_min', 'desc');
                        break;
                    case 'salary_low':
                        $query->orderBy('salary_min', 'asc')->orderBy('salary_max', 'asc');
                        break;
                    default:
                        $query->orderBy('created_at', 'desc');
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }
            
            // Get featured jobs for sidebar
            $featuredJobs = Job::where('is_active', true)
                              ->where('is_featured', true)
                              ->orderBy('created_at', 'desc')
                              ->take(5)
                              ->get();
            
            // Paginate results
            $jobs = $query->paginate(10);
            
            return view('jobs.index', compact('jobs', 'featuredJobs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while loading jobs: ' . $e->getMessage());
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
            $job = Job::findOrFail($id);
            
            // Check if user has applied to this job
            $hasApplied = false;
            if (Auth::check() && Auth::user()->hasRole('customer')) {
                $hasApplied = JobApplication::where('job_id', $job->id)
                                ->where('user_id', Auth::id())
                                ->exists();
            }
            
            // Get similar jobs
            $similarJobs = Job::where('id', '!=', $job->id)
                            ->where('is_active', true)
                            ->where(function($query) use ($job) {
                                $query->where('category', $job->category)
                                    ->orWhere('type', $job->type)
                                    ->orWhere('location', 'like', "%{$job->location}%");
                            })
                            ->orderBy('created_at', 'desc')
                            ->take(4)
                            ->get();
            
            return view('jobs.show', compact('job', 'hasApplied', 'similarJobs'));
        } catch (\Exception $e) {
            return redirect()->route('jobs.index')->with('error', 'Job not found or an error occurred.');
        }
    }

    /**
     * Show the form for applying to a job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function apply($id)
    {
        try {
            // Check if user is logged in and is a customer
            if (!Auth::check()) {
                return redirect()->route('login', ['redirect_to' => route('jobs.apply', $id)]);
            }
            
            if (!Auth::user()->hasRole('customer')) {
                return redirect()->route('jobs.show', $id)->with('error', 'Only customers can apply for jobs.');
            }
            
            $job = Job::findOrFail($id);
            
            // Check if job is active
            if (!$job->is_active) {
                return redirect()->route('jobs.show', $id)->with('error', 'This job is no longer accepting applications.');
            }
            
            // Check if application deadline has passed
            if ($job->application_deadline && Carbon::parse($job->application_deadline)->isPast()) {
                return redirect()->route('jobs.show', $id)->with('error', 'The application deadline for this job has passed.');
            }
            
            // Check if user has already applied
            $hasApplied = JobApplication::where('job_id', $job->id)
                            ->where('user_id', Auth::id())
                            ->exists();
            
            if ($hasApplied) {
                return redirect()->route('jobs.show', $id)->with('error', 'You have already applied for this job.');
            }
            
            return view('jobs.apply', compact('job'));
        } catch (\Exception $e) {
            return redirect()->route('jobs.index')->with('error', 'Job not found or an error occurred.');
        }
    }

    /**
     * Store a job application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeApplication(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'job_id' => 'required|exists:jobs,id',
                'resume' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
                'cover_letter' => 'required|string',
                'phone' => 'nullable|string|max:20',
                'linkedin_profile' => 'nullable|url',
                'portfolio_url' => 'nullable|url',
                'additional_information' => 'nullable|string',
                'terms_accepted' => 'required|accepted',
            ]);
            
            $job = Job::findOrFail($request->job_id);
            
            // Check if job is active
            if (!$job->is_active) {
                return redirect()->route('jobs.show', $job->id)->with('error', 'This job is no longer accepting applications.');
            }
            
            // Check if application deadline has passed
            if ($job->application_deadline && Carbon::parse($job->application_deadline)->isPast()) {
                return redirect()->route('jobs.show', $job->id)->with('error', 'The application deadline for this job has passed.');
            }
            
            // Check if user has already applied
            $hasApplied = JobApplication::where('job_id', $job->id)
                            ->where('user_id', Auth::id())
                            ->exists();
            
            if ($hasApplied) {
                return redirect()->route('jobs.show', $job->id)->with('error', 'You have already applied for this job.');
            }
            
            // Handle resume upload
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
            }
            
            // Create the application
            $application = new JobApplication();
            $application->job_id = $job->id;
            $application->user_id = Auth::id();
            $application->status = 'pending';
            $application->cover_letter = $request->cover_letter;
            $application->resume_path = $resumePath;
            $application->phone = $request->phone;
            $application->linkedin_profile = $request->linkedin_profile;
            $application->portfolio_url = $request->portfolio_url;
            $application->additional_information = $request->additional_information;
            $application->save();
            
            // Increment application count for the job
            $job->increment('application_count');
            
            // TODO: Send email notifications
            
            return redirect()->route('customer.applications.index')->with('success', 'Your application has been submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An error occurred while submitting your application: ' . $e->getMessage());
        }
    }
}
