<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;

class JobApplicationsController extends Controller
{
    public function index()
    {
        $jobApplications = JobApplication::paginate(10);
        return view('admin.job_applications.index', compact('jobApplications'));
    }

    public function create()
    {
        return view('pages.work-with-us');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'experience' => 'required|string',
            'cover_letter' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $data = $request->except('resume');
        
        // Handle resume upload
        if ($request->hasFile('resume')) {
            $filename = time() . '_' . $request->resume->getClientOriginalName();
            $request->resume->move(public_path('uploads/resumes'), $filename);
            $data['resume'] = 'uploads/resumes/' . $filename;
        }

        JobApplication::create($data);

        return redirect()->back()->with('success', 'Application submitted successfully');
    }

    public function show(JobApplication $jobApplication)
    {
        return view('admin.job_applications.show', compact('jobApplication'));
    }

    public function updateStatus(Request $request, JobApplication $jobApplication)
    {
        $request->validate([
            'status' => 'required|in:received,reviewing,accepted,rejected'
        ]);

        $jobApplication->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
