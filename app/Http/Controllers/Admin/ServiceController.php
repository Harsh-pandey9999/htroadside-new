<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();
        
        // Filter by active status
        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Search by name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }
        
        // Sort results
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);
        
        $services = $query->withCount('serviceRequests')->paginate(10)->withQueryString();
        
        // Determine which design version to use based on session
        $designVersion = session('design_version', 'original');
        if ($designVersion === 'material') {
            return view('admin.service-types-material', compact('services'));
        } else {
            return view('admin.services.index', compact('services'));
        }
    }
    
    public function create()
    {
        return view('admin.services.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|max:1024',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'price' => 'nullable|numeric|min:0',
            'estimated_time' => 'nullable|integer|min:1',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'featured' => 'boolean',
            'service_area' => 'nullable|string|max:255',
        ]);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle icon upload
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('service-icons', 'public');
            $validated['icon'] = $path;
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('service-images', 'public');
            $validated['image'] = $path;
        }
        
        // Convert tags to JSON
        if (isset($validated['tags'])) {
            $validated['tags'] = json_encode($validated['tags']);
        }
        
        $service = Service::create($validated);
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }
    
    public function show(Service $service)
    {
        $service->load('serviceRequests');
        return view('admin.services.show', compact('service'));
    }
    
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }
    
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|max:1024',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'price' => 'nullable|numeric|min:0',
            'estimated_time' => 'nullable|integer|min:1',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'featured' => 'boolean',
            'service_area' => 'nullable|string|max:255',
        ]);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($service->icon) {
                Storage::disk('public')->delete($service->icon);
            }
            
            $path = $request->file('icon')->store('service-icons', 'public');
            $validated['icon'] = $path;
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            
            $path = $request->file('image')->store('service-images', 'public');
            $validated['image'] = $path;
        }
        
        // Convert tags to JSON
        if (isset($validated['tags'])) {
            $validated['tags'] = json_encode($validated['tags']);
        }
        
        $service->update($validated);
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }
    
    public function destroy(Service $service)
    {
        // Check if service has any requests
        if ($service->serviceRequests()->count() > 0) {
            return redirect()->route('admin.services.index')
                ->with('error', 'Cannot delete service with existing requests.');
        }
        
        // Delete icon if exists
        if ($service->icon) {
            Storage::disk('public')->delete($service->icon);
        }
        
        // Delete image if exists
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
    
    public function toggleStatus(Service $service)
    {
        $service->update([
            'is_active' => !$service->is_active,
        ]);
        
        return redirect()->back()
            ->with('success', 'Service status updated successfully.');
    }
    
    public function toggleFeatured(Service $service)
    {
        $service->update([
            'featured' => !$service->featured,
        ]);
        
        return redirect()->back()
            ->with('success', 'Service featured status updated successfully.');
    }
    
    public function analytics(Service $service)
    {
        // Get service request stats
        $totalRequests = $service->serviceRequests()->count();
        $completedRequests = $service->serviceRequests()->where('status', 'completed')->count();
        $pendingRequests = $service->serviceRequests()->where('status', 'new')->count();
        $inProgressRequests = $service->serviceRequests()->where('status', 'in_progress')->count();
        
        // Monthly request trends
        $monthlyTrends = $service->serviceRequests()
            ->select(\DB::raw('MONTH(created_at) as month'), \DB::raw('COUNT(*) as total'))
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
        
        // Get average response time
        $avgResponseTime = $service->serviceRequests()
            ->whereNotNull('responded_at')
            ->select(\DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, responded_at)) as avg_time'))
            ->first();
        
        // Get average completion time
        $avgCompletionTime = $service->serviceRequests()
            ->where('status', 'completed')
            ->select(\DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) as avg_time'))
            ->first();
        
        return view('admin.services.analytics', compact(
            'service',
            'totalRequests',
            'completedRequests',
            'pendingRequests',
            'inProgressRequests',
            'chartData',
            'avgResponseTime',
            'avgCompletionTime'
        ));
    }
}
