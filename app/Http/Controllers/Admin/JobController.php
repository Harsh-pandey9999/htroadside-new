<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $jobs = Job::orderBy('created_at', 'desc')->paginate(10);
            return view('admin.jobs.index', compact('jobs'));
        } catch (\Exception $e) {
            \Log::error('Error fetching jobs: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch jobs. Please try again later.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
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
                'is_featured' => 'boolean',
                'is_active' => 'boolean',
                'application_deadline' => 'nullable|date|after:today',
                'company_name' => 'nullable|string|max:255',
                'company_website' => 'nullable|url|max:255',
                'company_logo' => 'nullable|image|max:2048', // 2MB max
                'contact_email' => 'nullable|email|max:255',
                'application_url' => 'nullable|url|max:255',
            ]);

            // Handle company logo upload
            if ($request->hasFile('company_logo')) {
                $path = $request->file('company_logo')->store('company_logos', 'public');
                $validated['company_logo'] = $path;
            }

            // Set posted_by to current admin user
            $validated['posted_by'] = Auth::id();

            // Create the job
            $job = Job::create($validated);

            return redirect()->route('admin.jobs.index')
                ->with('success', 'Job created successfully.');
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $job = Job::findOrFail($id);
            return view('admin.jobs.show', compact('job'));
        } catch (\Exception $e) {
            \Log::error('Error showing job: ' . $e->getMessage());
            return back()->with('error', 'Unable to find the requested job.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $job = Job::findOrFail($id);
            return view('admin.jobs.edit', compact('job'));
        } catch (\Exception $e) {
            \Log::error('Error editing job: ' . $e->getMessage());
            return back()->with('error', 'Unable to find the requested job.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $job = Job::findOrFail($id);
            
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
                'is_featured' => 'boolean',
                'is_active' => 'boolean',
                'application_deadline' => 'nullable|date',
                'company_name' => 'nullable|string|max:255',
                'company_website' => 'nullable|url|max:255',
                'company_logo' => 'nullable|image|max:2048', // 2MB max
                'contact_email' => 'nullable|email|max:255',
                'application_url' => 'nullable|url|max:255',
            ]);

            // Handle company logo upload
            if ($request->hasFile('company_logo')) {
                // Delete old logo if it exists
                if ($job->company_logo) {
                    Storage::disk('public')->delete($job->company_logo);
                }
                
                $path = $request->file('company_logo')->store('company_logos', 'public');
                $validated['company_logo'] = $path;
            }

            // Update the job
            $job->update($validated);

            return redirect()->route('admin.jobs.index')
                ->with('success', 'Job updated successfully.');
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $job = Job::findOrFail($id);
            
            // Delete company logo if it exists
            if ($job->company_logo) {
                Storage::disk('public')->delete($job->company_logo);
            }
            
            // Delete the job
            $job->delete();

            return redirect()->route('admin.jobs.index')
                ->with('success', 'Job deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting job: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the job. Please try again.');
        }
    }
    
    /**
     * Toggle the active status of a job.
     */
    public function toggleActive(string $id)
    {
        try {
            $job = Job::findOrFail($id);
            $job->is_active = !$job->is_active;
            $job->save();
            
            $status = $job->is_active ? 'activated' : 'deactivated';
            return back()->with('success', "Job {$status} successfully.");
        } catch (\Exception $e) {
            \Log::error('Error toggling job status: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the job status.');
        }
    }
    
    /**
     * Toggle the featured status of a job.
     */
    public function toggleFeatured(string $id)
    {
        try {
            $job = Job::findOrFail($id);
            $job->is_featured = !$job->is_featured;
            $job->save();
            
            $status = $job->is_featured ? 'featured' : 'unfeatured';
            return back()->with('success', "Job {$status} successfully.");
        } catch (\Exception $e) {
            \Log::error('Error toggling job featured status: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the job featured status.');
        }
    }
    
    /**
     * View applications for a specific job.
     */
    public function applications(string $id)
    {
        try {
            $job = Job::with('applications.user')->findOrFail($id);
            return view('admin.jobs.applications', compact('job'));
        } catch (\Exception $e) {
            \Log::error('Error viewing job applications: ' . $e->getMessage());
            return back()->with('error', 'Unable to view applications for this job.');
        }
    }
}
