<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard stats
        $totalUsers = User::count();
        $totalServiceProviders = User::where('is_service_provider', true)->count();
        $totalServices = Service::count();
        $totalRequests = ServiceRequest::count();
        $totalPayments = Payment::where('status', 'success')->count();
        $totalRevenue = Payment::where('status', 'success')->sum('amount');
        $totalApplications = JobApplication::count();
        
        // Recent service requests
        $recentRequests = ServiceRequest::with(['service', 'user'])
            ->latest()
            ->take(5)
            ->get();
        
        // Recent job applications
        $recentApplications = JobApplication::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Recent payments
        $recentPayments = Payment::with(['user', 'plan'])
            ->where('status', 'success')
            ->latest()
            ->take(5)
            ->get();
        
        // Monthly revenue chart data
        $monthlyRevenue = Payment::where('status', 'success')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
        
        // Fill in missing months with zero
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[$i] = $monthlyRevenue[$i] ?? 0;
        }
        
        // Service request status distribution
        $requestStatusDistribution = ServiceRequest::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();
        
        // Service provider performance
        $topServiceProviders = User::where('is_service_provider', true)
            ->orderBy('rating', 'desc')
            ->take(5)
            ->get();
        
        // Get user growth data
        $userGrowth = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->take(6)
            ->get()
            ->pluck('total', 'month')
            ->toArray();
        
        // Determine which design version to use based on session
        $designVersion = session('design_version', 'material');
        $view = $designVersion === 'material' ? 'admin.dashboard-material' : 'admin.dashboard';
        
        return view($view, compact(
            'totalUsers',
            'totalServiceProviders',
            'totalServices',
            'totalRequests',
            'totalPayments',
            'totalRevenue',
            'totalApplications',
            'recentRequests',
            'recentApplications',
            'recentPayments',
            'chartData',
            'requestStatusDistribution',
            'topServiceProviders',
            'userGrowth'
        ));
    }
    
    public function analytics()
    {
        // Service popularity
        $servicePopularity = ServiceRequest::select('service_id', DB::raw('count(*) as total'))
            ->with('service')
            ->groupBy('service_id')
            ->orderBy('total', 'desc')
            ->get();
        
        // User demographics
        $usersByCountry = User::select('country', DB::raw('count(*) as total'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('total', 'desc')
            ->get();
        
        // Service request time distribution
        $requestsByHour = ServiceRequest::select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as total'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('total', 'hour')
            ->toArray();
        
        // Fill in missing hours with zero
        $hourlyData = [];
        for ($i = 0; $i < 24; $i++) {
            $hourlyData[$i] = $requestsByHour[$i] ?? 0;
        }
        
        // Average response time
        $avgResponseTime = ServiceRequest::whereNotNull('responded_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, responded_at)) as avg_time'))
            ->first();
        
        // Average resolution time
        $avgResolutionTime = ServiceRequest::where('status', 'completed')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) as avg_time'))
            ->first();
        
        return view('admin.analytics', compact(
            'servicePopularity',
            'usersByCountry',
            'hourlyData',
            'avgResponseTime',
            'avgResolutionTime'
        ));
    }
}
