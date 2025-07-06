<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class JobApplicationController extends Controller
{
    /**
     * Constructor to apply auth middleware except for index and show
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('role:customer')->except(['index', 'show']);
    }
    
    /**
     * Display a listing of available jobs.
     */
    public function index(Request $request)
    {
        try {
            $query = Job::where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('application_deadline')
                      ->orWhere('application_deadline', '>=', now());
                });
            
            // Apply filters if provided
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }
            
            if ($request->filled('location')) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }
            
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }
            
            if ($request->boolean('remote_only')) {
                $query->where('is_remote', true);
            }
            
            // Sort options
            $sortField = $request->get('sort', 'created_at');
            $sortDirection = $request->get('direction', 'desc');
            
            // Validate sort field to prevent SQL injection
            $allowedSortFields = ['created_at', 'title', 'location', 'salary_min'];
            if (!in_array($sortField, $allowedSortFields)) {
                $sortField = 'created_at';
            }
            
            $jobs = $query->orderBy($sortField, $sortDirection)
                ->paginate(10)
                ->withQueryString();
            
            // Get unique categories and locations for filters
            $categories = Job::where('is_active', true)->distinct()->pluck('category');
            $locations = Job::where('is_active', true)->distinct()->pluck('location');
            $types = ['full-time', 'part-time', 'contract', 'temporary'];
            
            return view('jobs.index', compact('jobs', 'categories', 'locations', 'types'));
        } catch (\Exception $e) {
            \Log::error('Error fetching jobs: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch jobs. Please try again later.');
        }
    }

    /**
     * Show the form for applying to a job.
     */
    public function create(Request $request)
    {
        try {
            $jobId = $request->job_id;
            if (!$jobId) {
                return redirect()->route('jobs.index')
                    ->with('error', 'No job specified for application.');
            }
            
            $job = Job::where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('application_deadline')
                      ->orWhere('application_deadline', '>=', now());
                })
                ->findOrFail($jobId);
            
            // Check if user has already applied for this job
            $hasApplied = JobApplication::where('user_id', Auth::id())
                ->where('job_id', $job->id)
                ->exists();
                
            if ($hasApplied) {
                return redirect()->route('jobs.show', $job->id)
                    ->with('warning', 'You have already applied for this job.');
            }
            
            return view('jobs.apply', compact('job'));
        } catch (\Exception $e) {
            \Log::error('Error creating job application: ' . $e->getMessage());
            return redirect()->route('jobs.index')
                ->with('error', 'Unable to find the requested job or it is no longer available.');
        }
    }

    /**
     * Store a newly created job application.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'job_id' => 'required|exists:jobs,id',
                'cover_letter' => 'nullable|string',
                'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // 2MB max
                'experience' => 'nullable|string',
            ]);
            
            // Check if the job is still active and available
            $job = Job::where('id', $validated['job_id'])
                ->where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('application_deadline')
                      ->orWhere('application_deadline', '>=', now());
                })
                ->firstOrFail();
            
            // Check if user has already applied
            $hasApplied = JobApplication::where('user_id', Auth::id())
                ->where('job_id', $job->id)
                ->exists();
                
            if ($hasApplied) {
                return redirect()->route('jobs.show', $job->id)
                    ->with('warning', 'You have already applied for this job.');
            }
            
            // Handle resume upload
            if ($request->hasFile('resume')) {
                $path = $request->file('resume')->store('resumes', 'public');
                $validated['resume'] = $path;
            }
            
            // Add user information
            $user = Auth::user();
            $validated['user_id'] = $user->id;
            $validated['name'] = $user->name;
            $validated['email'] = $user->email;
            $validated['phone'] = $user->phone;
            $validated['status'] = 'pending';
            
            // Create the application
            $application = JobApplication::create($validated);
            
            // Increment the applications count for the job
            $job->increment('applications_count');
            
            return redirect()->route('customer.applications')
                ->with('success', 'Your application has been submitted successfully.');
        } catch (QueryException $e) {
            \Log::error('Database error submitting application: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Database error occurred. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error submitting application: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while submitting your application. Please try again.');
        }
    }

    /**
     * Display the specified job.
     */
    public function show(string $id)
    {
        try {
            $job = Job::where('is_active', true)->findOrFail($id);
            
            // Increment view count
            $job->increment('views_count');
            
            // Check if user has already applied (if logged in)
            $hasApplied = false;
            if (Auth::check()) {
                $hasApplied = JobApplication::where('user_id', Auth::id())
                    ->where('job_id', $job->id)
                    ->exists();
            }
            
            // Get similar jobs
            $similarJobs = Job::where('id', '!=', $job->id)
                ->where('is_active', true)
                ->where(function($q) use ($job) {
                    $q->where('category', $job->category)
                      ->orWhere('type', $job->type);
                })
                ->where(function($q) {
                    $q->whereNull('application_deadline')
                      ->orWhere('application_deadline', '>=', now());
                })
                ->limit(3)
                ->get();
            
            return view('jobs.show', compact('job', 'hasApplied', 'similarJobs'));
        } catch (\Exception $e) {
            \Log::error('Error showing job: ' . $e->getMessage());
            return redirect()->route('jobs.index')
                ->with('error', 'Unable to find the requested job.');
        }
    }

    /**
     * Display user's job applications.
     */
    public function myApplications()
    {
        try {
            $applications = JobApplication::with('job')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);
                
            return view('customer.applications', compact('applications'));
        } catch (\Exception $e) {
            \Log::error('Error fetching user applications: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch your applications. Please try again later.');
        }
    }
    
    /**
     * Withdraw a job application.
     */
    public function withdraw(string $id)
    {
        try {
            $application = JobApplication::where('user_id', Auth::id())
                ->findOrFail($id);
            
            // Only allow withdrawal if status is still pending
            if ($application->status !== 'pending') {
                return back()->with('error', 'This application cannot be withdrawn as it has already been processed.');
            }
            
            // Delete resume file if it exists
            if ($application->resume) {
                Storage::disk('public')->delete($application->resume);
            }
            
            // Get job ID before deleting application
            $jobId = $application->job_id;
            
            // Delete the application
            $application->delete();
            
            // Decrement the applications count for the job
            $job = Job::find($jobId);
            if ($job) {
                $job->decrement('applications_count');
            }
            
            return redirect()->route('customer.applications')
                ->with('success', 'Your application has been withdrawn successfully.');
        } catch (\Exception $e) {
            \Log::error('Error withdrawing application: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while withdrawing your application. Please try again.');
        }
    }
}
