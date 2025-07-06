<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $query = Plan::query();
        
        // Filter by active status
        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Search by name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sort results
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);
        
        $plans = $query->withCount('payments')->paginate(10)->withQueryString();
        
        return view('admin.plans.index', compact('plans'));
    }
    
    public function create()
    {
        return view('admin.plans.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'features' => 'nullable|array',
            'max_service_requests' => 'nullable|integer|min:0',
            'priority_support' => 'boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'recommended' => 'boolean',
        ]);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Convert features to JSON
        if (isset($validated['features'])) {
            $validated['features'] = json_encode($validated['features']);
        }
        
        $plan = Plan::create($validated);
        
        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan created successfully.');
    }
    
    public function show(Plan $plan)
    {
        $plan->load('payments');
        
        // Get subscription stats
        $totalSubscribers = $plan->payments()->where('status', 'success')->count();
        $activeSubscribers = $plan->payments()
            ->where('status', 'success')
            ->whereRaw('DATE_ADD(created_at, INTERVAL duration_days DAY) >= NOW()')
            ->count();
        $totalRevenue = $plan->payments()->where('status', 'success')->sum('amount');
        
        // Get monthly subscription data
        $monthlySubscriptions = $plan->payments()
            ->where('status', 'success')
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
            $chartData[$i] = $monthlySubscriptions[$i] ?? 0;
        }
        
        return view('admin.plans.show', compact(
            'plan',
            'totalSubscribers',
            'activeSubscribers',
            'totalRevenue',
            'chartData'
        ));
    }
    
    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }
    
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'features' => 'nullable|array',
            'max_service_requests' => 'nullable|integer|min:0',
            'priority_support' => 'boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'recommended' => 'boolean',
        ]);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Convert features to JSON
        if (isset($validated['features'])) {
            $validated['features'] = json_encode($validated['features']);
        }
        
        $plan->update($validated);
        
        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan updated successfully.');
    }
    
    public function destroy(Plan $plan)
    {
        // Check if plan has any payments
        if ($plan->payments()->count() > 0) {
            return redirect()->route('admin.plans.index')
                ->with('error', 'Cannot delete plan with existing payments.');
        }
        
        $plan->delete();
        
        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan deleted successfully.');
    }
    
    public function toggleStatus(Plan $plan)
    {
        $plan->update([
            'is_active' => !$plan->is_active,
        ]);
        
        return redirect()->back()
            ->with('success', 'Plan status updated successfully.');
    }
    
    public function toggleRecommended(Plan $plan)
    {
        // First, remove recommended status from all plans
        if ($plan->recommended == false) {
            Plan::where('recommended', true)->update(['recommended' => false]);
        }
        
        $plan->update([
            'recommended' => !$plan->recommended,
        ]);
        
        return redirect()->back()
            ->with('success', 'Plan recommended status updated successfully.');
    }
    
    public function comparePlans()
    {
        $plans = Plan::where('is_active', true)->orderBy('price')->get();
        return view('admin.plans.compare', compact('plans'));
    }
}
