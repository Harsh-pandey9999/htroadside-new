<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestNote;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of service requests.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'all');
        
        $query = ServiceRequest::where('user_id', $user->id);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $serviceRequests = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        
        return view('customer.service-requests.index', compact('serviceRequests', 'status'));
    }
    
    /**
     * Display the specified service request.
     */
    public function show($id)
    {
        $user = Auth::user();
        $serviceRequest = ServiceRequest::where('user_id', $user->id)
            ->findOrFail($id);
        
        $statusUpdates = $serviceRequest->statusUpdates()
            ->orderBy('created_at', 'desc')
            ->get();
        
        $notes = $serviceRequest->notes()
            ->where('is_private', false)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('customer.service-requests.show', compact('serviceRequest', 'statusUpdates', 'notes'));
    }
    
    /**
     * Show the form for creating a new service request.
     */
    public function create()
    {
        $services = Service::all();
        return view('customer.service-requests.create', compact('services'));
    }
    
    /**
     * Store a newly created service request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'location_address' => 'required|string|max:255',
            'location_city' => 'required|string|max:100',
            'location_state' => 'required|string|max:100',
            'location_country' => 'required|string|max:100',
            'location_postal_code' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'vehicle_make' => 'required|string|max:100',
            'vehicle_model' => 'required|string|max:100',
            'vehicle_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'vehicle_color' => 'required|string|max:50',
            'vehicle_license_plate' => 'required|string|max:20',
            'attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'is_emergency' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('customer.service-requests.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Create the service request
        $serviceRequest = new ServiceRequest();
        $serviceRequest->user_id = $user->id;
        $serviceRequest->service_id = $request->service_id;
        $serviceRequest->title = $request->title;
        $serviceRequest->description = $request->description;
        $serviceRequest->location_address = $request->location_address;
        $serviceRequest->location_city = $request->location_city;
        $serviceRequest->location_state = $request->location_state;
        $serviceRequest->location_country = $request->location_country;
        $serviceRequest->location_postal_code = $request->location_postal_code;
        $serviceRequest->latitude = $request->latitude;
        $serviceRequest->longitude = $request->longitude;
        $serviceRequest->vehicle_make = $request->vehicle_make;
        $serviceRequest->vehicle_model = $request->vehicle_model;
        $serviceRequest->vehicle_year = $request->vehicle_year;
        $serviceRequest->vehicle_color = $request->vehicle_color;
        $serviceRequest->vehicle_license_plate = $request->vehicle_license_plate;
        $serviceRequest->is_emergency = $request->is_emergency ?? false;
        $serviceRequest->status = 'pending';
        $serviceRequest->save();
        
        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('service-request-attachments', 'public');
                
                $serviceRequest->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'file_type' => $file->getMimeType(),
                ]);
            }
        }
        
        // Create initial status update
        $serviceRequest->statusUpdates()->create([
            'status' => 'pending',
            'notes' => 'Service request created.',
            'user_id' => $user->id
        ]);
        
        return redirect()->route('customer.service-requests.show', $serviceRequest->id)
            ->with('success', 'Service request created successfully.');
    }
    
    /**
     * Cancel a service request.
     */
    public function cancel(Request $request, $id)
    {
        $user = Auth::user();
        $serviceRequest = ServiceRequest::where('user_id', $user->id)
            ->findOrFail($id);
        
        // Check if the request is in a state that can be cancelled
        if (!in_array($serviceRequest->status, ['pending', 'accepted'])) {
            return redirect()->route('customer.service-requests.show', $serviceRequest->id)
                ->with('error', 'This service request cannot be cancelled.');
        }
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'required|string|max:500',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('customer.service-requests.show', $serviceRequest->id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update the service request
        $serviceRequest->status = 'cancelled';
        $serviceRequest->cancelled_at = now();
        $serviceRequest->cancellation_reason = $request->cancellation_reason;
        $serviceRequest->cancelled_by = 'customer';
        $serviceRequest->save();
        
        // Create status update
        $serviceRequest->statusUpdates()->create([
            'status' => 'cancelled',
            'notes' => $request->cancellation_reason,
            'user_id' => $user->id
        ]);
        
        // Create note
        ServiceRequestNote::create([
            'service_request_id' => $serviceRequest->id,
            'user_id' => $user->id,
            'content' => 'Request cancelled: ' . $request->cancellation_reason,
            'is_private' => false
        ]);
        
        return redirect()->route('customer.service-requests.index')
            ->with('success', 'Service request cancelled successfully.');
    }
    
    /**
     * Add a note to a service request.
     */
    public function addNote(Request $request, $id)
    {
        $user = Auth::user();
        $serviceRequest = ServiceRequest::where('user_id', $user->id)
            ->findOrFail($id);
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:500',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('customer.service-requests.show', $serviceRequest->id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Create the note
        ServiceRequestNote::create([
            'service_request_id' => $serviceRequest->id,
            'user_id' => $user->id,
            'content' => $request->content,
            'is_private' => false
        ]);
        
        return redirect()->route('customer.service-requests.show', $serviceRequest->id)
            ->with('success', 'Note added successfully.');
    }
}
