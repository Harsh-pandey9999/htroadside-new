<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class RequestServiceController extends Controller
{
    public function index()
    {
        $serviceRequests = ServiceRequest::with('service')->paginate(10);
        return view('admin.service_requests.index', compact('serviceRequests'));
    }

    public function create()
    {
        $services = \App\Models\Service::where('is_active', true)->get();
        return view('pages.request-service', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'vehicle_number' => 'required|string|max:20',
            'location' => 'required|string',
            'message' => 'required|string',
            'service_id' => 'required|exists:services,id'
        ]);

        ServiceRequest::create($request->all());

        return redirect()->back()->with('success', 'Service request submitted successfully');
    }

    public function show(ServiceRequest $serviceRequest)
    {
        return view('admin.service_requests.show', compact('serviceRequest'));
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,completed'
        ]);

        $serviceRequest->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
