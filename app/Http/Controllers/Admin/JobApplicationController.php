<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\JobApplicationStatusUpdated;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with('user');
        
        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by position
        if ($request->has('position') && $request->position) {
            $query->where('position', $request->position);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }
        
        // Sort results
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);
        
        $applications = $query->paginate(15)->withQueryString();
        
        // Get unique positions for filter
        $positions = JobApplication::select('position')->distinct()->pluck('position');
        
        return view('admin.job-applications.index', compact('applications', 'positions'));
    }
    
    public function show(JobApplication $application)
    {
        $application->load('user');
        return view('admin.job-applications.show', compact('application'));
    }
    
    public function updateStatus(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewing,shortlisted,interview,rejected,hired',
            'admin_notes' => 'nullable|string',
            'interview_date' => 'nullable|date|after:today',
            'interview_location' => 'nullable|string|max:255',
        ]);
        
        $oldStatus = $application->status;
        $application->status = $validated['status'];
        
        if (isset($validated['admin_notes'])) {
            $application->admin_notes = $validated['admin_notes'];
        }
        
        if ($validated['status'] === 'interview' && isset($validated['interview_date'])) {
            $application->interview_date = $validated['interview_date'];
            $application->interview_location = $validated['interview_location'] ?? null;
        }
        
        $application->save();
        
        // Send notification to applicant if status changed
        if ($oldStatus !== $validated['status'] && $application->user) {
            Notification::send($application->user, new JobApplicationStatusUpdated($application));
        }
        
        return redirect()->back()
            ->with('success', 'Application status updated successfully.');
    }
    
    public function addNote(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'note' => 'required|string',
        ]);
        
        // Store notes in a JSON field
        $notes = json_decode($application->notes, true) ?: [];
        $notes[] = [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'content' => $validated['note'],
            'created_at' => now()->toIso8601String(),
        ];
        
        $application->notes = json_encode($notes);
        $application->save();
        
        return redirect()->back()
            ->with('success', 'Note added successfully.');
    }
    
    public function downloadResume(JobApplication $application)
    {
        if (!$application->resume_path) {
            return redirect()->back()
                ->with('error', 'No resume found for this application.');
        }
        
        return Storage::disk('public')->download($application->resume_path, $application->name . ' - Resume.pdf');
    }
    
    public function createServiceProvider(JobApplication $application)
    {
        // Check if application is in hired status
        if ($application->status !== 'hired') {
            return redirect()->back()
                ->with('error', 'Only hired applicants can be converted to service providers.');
        }
        
        // Check if user already exists
        $existingUser = User::where('email', $application->email)->first();
        
        if ($existingUser) {
            // Update existing user to service provider
            $existingUser->update([
                'is_service_provider' => true,
                'service_provider_type' => 'individual',
                'service_types' => json_encode([$application->position]),
                'is_verified' => true,
                'verified_at' => now(),
            ]);
            
            $user = $existingUser;
        } else {
            // Create new user
            $user = User::create([
                'name' => $application->name,
                'email' => $application->email,
                'password' => bcrypt(Str::random(10)), // Random password, user will need to reset
                'is_service_provider' => true,
                'service_provider_type' => 'individual',
                'service_types' => json_encode([$application->position]),
                'phone' => $application->phone,
                'address' => $application->address,
                'is_verified' => true,
                'verified_at' => now(),
            ]);
        }
        
        // Update application with user ID
        $application->update([
            'user_id' => $user->id,
            'converted_to_provider' => true,
            'converted_at' => now(),
        ]);
        
        // Send notification to user
        // In a real implementation, you would send an email with login instructions
        
        return redirect()->back()
            ->with('success', 'Applicant successfully converted to service provider.');
    }
    
    public function dashboard()
    {
        // Get application stats
        $totalApplications = JobApplication::count();
        $pendingApplications = JobApplication::where('status', 'pending')->count();
        $reviewingApplications = JobApplication::where('status', 'reviewing')->count();
        $shortlistedApplications = JobApplication::where('status', 'shortlisted')->count();
        $interviewApplications = JobApplication::where('status', 'interview')->count();
        $rejectedApplications = JobApplication::where('status', 'rejected')->count();
        $hiredApplications = JobApplication::where('status', 'hired')->count();
        
        // Get position distribution
        $positionDistribution = JobApplication::select('position', \DB::raw('count(*) as total'))
            ->groupBy('position')
            ->orderBy('total', 'desc')
            ->get();
        
        // Get monthly application trends
        $monthlyTrends = JobApplication::select(\DB::raw('MONTH(created_at) as month'), \DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
        
        // Fill in missing months with zero
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[$i] = $monthlyTrends[$i] ?? 0;
        }
        
        // Get recent applications
        $recentApplications = JobApplication::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Get upcoming interviews
        $upcomingInterviews = JobApplication::where('status', 'interview')
            ->whereNotNull('interview_date')
            ->where('interview_date', '>=', now())
            ->orderBy('interview_date')
            ->take(5)
            ->get();
        
        return view('admin.job-applications.dashboard', compact(
            'totalApplications',
            'pendingApplications',
            'reviewingApplications',
            'shortlistedApplications',
            'interviewApplications',
            'rejectedApplications',
            'hiredApplications',
            'positionDistribution',
            'chartData',
            'recentApplications',
            'upcomingInterviews'
        ));
    }
    
    public function exportApplications(Request $request)
    {
        $query = JobApplication::with('user');
        
        // Apply filters
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('position') && $request->position) {
            $query->where('position', $request->position);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $applications = $query->get();
        
        $csvFileName = 'job-applications-' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $columns = [
            'ID', 'Name', 'Email', 'Phone', 'Position', 
            'Experience', 'Status', 'Created At'
        ];
        
        $callback = function() use($applications, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($applications as $application) {
                fputcsv($file, [
                    $application->id,
                    $application->name,
                    $application->email,
                    $application->phone,
                    $application->position,
                    $application->experience,
                    $application->status,
                    $application->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
