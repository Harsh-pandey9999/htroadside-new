<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ServiceRequestStatusUpdated;
use App\Notifications\ServiceRequestAssigned;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['service', 'user', 'assignedProvider']);
        
        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by service
        if ($request->has('service_id') && $request->service_id) {
            $query->where('service_id', $request->service_id);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Search by name, email, or vehicle number
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('vehicle_number', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        // Sort results
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);
        
        $serviceRequests = $query->paginate(15)->withQueryString();
        $services = Service::all();
        
        // Determine which design version to use based on session
        $designVersion = session('design_version', 'original');
        if ($designVersion === 'material') {
            return view('admin.service-requests-material', compact('serviceRequests', 'services'));
        } else {
            return view('admin.service-requests.index', compact('serviceRequests', 'services'));
        }
    }
    
    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['service', 'user', 'assignedProvider', 'notes', 'attachments']);
        $availableProviders = User::where('is_service_provider', true)
                                ->where('is_verified', true)
                                ->get();
        
        // Determine which design version to use based on session
        $designVersion = session('design_version', 'original');
        if ($designVersion === 'material') {
            return view('admin.service-request-details-material', compact('serviceRequest', 'availableProviders'));
        } else {
            return view('admin.service-requests.show', compact('serviceRequest', 'availableProviders'));
        }
    }
    
    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,assigned,in_progress,completed,cancelled',
            'admin_notes' => 'nullable|string',
        ]);
        
        $oldStatus = $serviceRequest->status;
        $serviceRequest->status = $validated['status'];
        
        if ($validated['status'] === 'assigned' && !$serviceRequest->responded_at) {
            $serviceRequest->responded_at = now();
        }
        
        if ($validated['status'] === 'completed' && !$serviceRequest->completed_at) {
            $serviceRequest->completed_at = now();
        }
        
        if (isset($validated['admin_notes']) && $validated['admin_notes']) {
            $serviceRequest->admin_notes = $validated['admin_notes'];
        }
        
        $serviceRequest->save();
        
        // Send notification to user if status changed
        if ($oldStatus !== $validated['status'] && $serviceRequest->user) {
            Notification::send($serviceRequest->user, new ServiceRequestStatusUpdated($serviceRequest));
        }
        
        return redirect()->back()
            ->with('success', 'Service request status updated successfully.');
    }
    
    public function assignProvider(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:users,id',
            'admin_notes' => 'nullable|string',
        ]);
        
        $provider = User::findOrFail($validated['provider_id']);
        
        // Check if provider is a verified service provider
        if (!$provider->is_service_provider || !$provider->is_verified) {
            return redirect()->back()
                ->with('error', 'Selected user is not a verified service provider.');
        }
        
        $serviceRequest->provider_id = $validated['provider_id'];
        $serviceRequest->status = 'assigned';
        $serviceRequest->responded_at = now();
        
        if (isset($validated['admin_notes']) && $validated['admin_notes']) {
            $serviceRequest->admin_notes = $validated['admin_notes'];
        }
        
        $serviceRequest->save();
        
        // Send notification to provider
        Notification::send($provider, new ServiceRequestAssigned($serviceRequest));
        
        // Send notification to user
        if ($serviceRequest->user) {
            Notification::send($serviceRequest->user, new ServiceRequestStatusUpdated($serviceRequest));
        }
        
        return redirect()->back()
            ->with('success', 'Service provider assigned successfully.');
    }
    
    public function addNote(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'note' => 'required|string',
            'is_private' => 'boolean',
        ]);
        
        $serviceRequest->notes()->create([
            'user_id' => auth()->id(),
            'content' => $validated['note'],
            'is_private' => $validated['is_private'] ?? false,
        ]);
        
        return redirect()->back()
            ->with('success', 'Note added successfully.');
    }
    
    public function addAttachment(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'attachment' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:255',
        ]);
        
        $path = $request->file('attachment')->store('service-request-attachments', 'public');
        
        $serviceRequest->attachments()->create([
            'user_id' => auth()->id(),
            'file_path' => $path,
            'file_name' => $request->file('attachment')->getClientOriginalName(),
            'file_size' => $request->file('attachment')->getSize(),
            'file_type' => $request->file('attachment')->getMimeType(),
            'description' => $validated['description'] ?? null,
        ]);
        
        return redirect()->back()
            ->with('success', 'Attachment added successfully.');
    }
    
    public function exportServiceRequests(Request $request)
    {
        $query = ServiceRequest::with(['service', 'user', 'assignedProvider']);
        
        // Apply filters
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('service_id') && $request->service_id) {
            $query->where('service_id', $request->service_id);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $serviceRequests = $query->get();
        
        $csvFileName = 'service-requests-' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $columns = [
            'ID', 'Service', 'Name', 'Email', 'Phone', 'Vehicle Number', 
            'Location', 'Status', 'Provider', 'Created At', 'Responded At', 'Completed At'
        ];
        
        $callback = function() use($serviceRequests, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($serviceRequests as $request) {
                fputcsv($file, [
                    $request->id,
                    $request->service->name ?? 'N/A',
                    $request->name,
                    $request->email,
                    $request->phone,
                    $request->vehicle_number,
                    $request->location,
                    $request->status,
                    $request->assignedProvider->name ?? 'N/A',
                    $request->created_at->format('Y-m-d H:i:s'),
                    $request->responded_at ? $request->responded_at->format('Y-m-d H:i:s') : 'N/A',
                    $request->completed_at ? $request->completed_at->format('Y-m-d H:i:s') : 'N/A',
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function dashboard()
    {
        // Get service request stats
        $totalRequests = ServiceRequest::count();
        $newRequests = ServiceRequest::where('status', 'new')->count();
        $assignedRequests = ServiceRequest::where('status', 'assigned')->count();
        $inProgressRequests = ServiceRequest::where('status', 'in_progress')->count();
        $completedRequests = ServiceRequest::where('status', 'completed')->count();
        $cancelledRequests = ServiceRequest::where('status', 'cancelled')->count();
        
        // Get average response and resolution times
        $avgResponseTime = ServiceRequest::whereNotNull('responded_at')
            ->select(\DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, responded_at)) as avg_time'))
            ->first();
        
        $avgResolutionTime = ServiceRequest::where('status', 'completed')
            ->select(\DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, completed_at)) as avg_time'))
            ->first();
        
        // Get service distribution
        $serviceDistribution = ServiceRequest::with('service')
            ->select('service_id', \DB::raw('count(*) as total'))
            ->groupBy('service_id')
            ->orderBy('total', 'desc')
            ->get();
        
        // Get recent requests
        $recentRequests = ServiceRequest::with(['service', 'user', 'assignedProvider'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.service-requests.dashboard', compact(
            'totalRequests',
            'newRequests',
            'assignedRequests',
            'inProgressRequests',
            'completedRequests',
            'cancelledRequests',
            'avgResponseTime',
            'avgResolutionTime',
            'serviceDistribution',
            'recentRequests'
        ));
    }
}
