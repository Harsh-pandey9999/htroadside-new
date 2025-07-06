<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get dashboard stats
        $totalServices = \App\Models\Service::count();
        $totalRequests = \App\Models\ServiceRequest::count();
        $totalPayments = \App\Models\Payment::where('status', 'success')->count();
        $totalApplications = \App\Models\JobApplication::count();
        $recentRequests = \App\Models\ServiceRequest::with('service')->latest()->take(5)->get();
        $recentApplications = \App\Models\JobApplication::latest()->take(5)->get();
        
        return view('admin.dashboard', 
            compact('totalServices', 
                    'totalRequests', 
                    'totalPayments', 
                    'totalApplications', 
                    'recentRequests', 
                    'recentApplications'));
    }
}
