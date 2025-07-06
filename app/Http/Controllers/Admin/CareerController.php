<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Career;
use App\Models\CareerApplication;
use Illuminate\Support\Str;

class CareerController extends Controller
{
    /**
     * Display a listing of the careers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $careers = Career::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.careers.index', compact('careers'));
    }

    /**
     * Show the form for creating a new career.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.careers.create');
    }

    /**
     * Store a newly created career in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'responsibilities' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'required|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'expires_at' => 'nullable|date|after:today',
            'is_active' => 'boolean',
            'featured' => 'boolean',
        ]);

        // Process the responsibilities, requirements, and benefits from textarea to array
        $responsibilities = array_filter(explode("\n", $request->responsibilities));
        $requirements = array_filter(explode("\n", $request->requirements));
        $benefits = array_filter(explode("\n", $request->benefits));

        // Create the career
        $career = new Career([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'department' => $request->department,
            'location' => $request->location,
            'type' => $request->type,
            'description' => $request->description,
            'responsibilities' => $responsibilities,
            'requirements' => $requirements,
            'benefits' => $benefits,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
            'featured' => $request->has('featured'),
        ]);

        $career->save();

        return redirect()->route('admin.careers.index')
            ->with('success', 'Job posting created successfully.');
    }

    /**
     * Display the specified career.
     *
     * @param  \App\Models\Career  $career
     * @return \Illuminate\View\View
     */
    public function show(Career $career)
    {
        return view('admin.careers.show', compact('career'));
    }

    /**
     * Show the form for editing the specified career.
     *
     * @param  \App\Models\Career  $career
     * @return \Illuminate\View\View
     */
    public function edit(Career $career)
    {
        return view('admin.careers.edit', compact('career'));
    }

    /**
     * Update the specified career in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Career  $career
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Career $career)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'responsibilities' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'required|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
            'featured' => 'boolean',
        ]);

        // Process the responsibilities, requirements, and benefits from textarea to array
        $responsibilities = array_filter(explode("\n", $request->responsibilities));
        $requirements = array_filter(explode("\n", $request->requirements));
        $benefits = array_filter(explode("\n", $request->benefits));

        // Update the career
        $career->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'department' => $request->department,
            'location' => $request->location,
            'type' => $request->type,
            'description' => $request->description,
            'responsibilities' => $responsibilities,
            'requirements' => $requirements,
            'benefits' => $benefits,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
            'featured' => $request->has('featured'),
        ]);

        return redirect()->route('admin.careers.index')
            ->with('success', 'Job posting updated successfully.');
    }

    /**
     * Remove the specified career from storage.
     *
     * @param  \App\Models\Career  $career
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Career $career)
    {
        $career->delete();

        return redirect()->route('admin.careers.index')
            ->with('success', 'Job posting deleted successfully.');
    }

    /**
     * Display a listing of applications for a specific career.
     *
     * @param  \App\Models\Career  $career
     * @return \Illuminate\View\View
     */
    public function applications(Career $career)
    {
        $applications = $career->applications()->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.careers.applications', compact('career', 'applications'));
    }

    /**
     * Display all applications across all careers.
     *
     * @return \Illuminate\View\View
     */
    public function allApplications()
    {
        $applications = CareerApplication::with('career')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.careers.all-applications', compact('applications'));
    }

    /**
     * Show a specific application.
     *
     * @param  \App\Models\CareerApplication  $application
     * @return \Illuminate\View\View
     */
    public function showApplication(CareerApplication $application)
    {
        // Mark as viewed if not already
        if (!$application->viewed) {
            $application->markAsViewed();
        }

        return view('admin.careers.show-application', compact('application'));
    }

    /**
     * Update the status of an application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CareerApplication  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateApplicationStatus(Request $request, CareerApplication $application)
    {
        $request->validate([
            'status' => 'required|string|in:' . implode(',', array_keys(CareerApplication::getStatuses())),
            'notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Application status updated successfully.');
    }
}
