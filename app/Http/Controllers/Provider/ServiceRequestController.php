<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestNote;
use App\Models\ServiceRequestStatusUpdate;
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
        
        $query = ServiceRequest::where('provider_id', $user->id);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $serviceRequests = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        
        return view('provider.service-requests.index', compact('serviceRequests', 'status'));
    }
    
    /**
     * Display the specified service request.
     */
    public function show($id)
    {
        $user = Auth::user();
        $serviceRequest = ServiceRequest::where('provider_id', $user->id)
            ->findOrFail($id);
        
        $statusUpdates = $serviceRequest->statusUpdates()
            ->orderBy('created_at', 'desc')
            ->get();
        
        $notes = $serviceRequest->notes()
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('provider.service-requests.show', compact('serviceRequest', 'statusUpdates', 'notes'));
    }
    
    /**
     * Accept a service request.
     */
    public function accept($id)
    {
        $user = Auth::user();
        $serviceRequest = ServiceRequest::findOrFail($id);
        
        // Check if the request is already assigned
        if ($serviceRequest->provider_id !== null && $serviceRequest->provider_id !== $user->id) {
            return redirect()->route('provider.service-requests.index')
                ->with('error', 'This service request has already been assigned to another provider.');
        }
        
        // Check if the request is in a state that can be accepted
        if ($serviceRequest->status !== 'pending') {
            return redirect()->route('provider.service-requests.index')
                ->with('error', 'This service request cannot be accepted.');
        }
        
        // Update the service request
        $serviceRequest->provider_id = $user->id;
        $serviceRequest->status = 'accepted';
        $serviceRequest->accepted_at = now();
        $serviceRequest->save();
        
        // Create status update
        ServiceRequestStatusUpdate::create([
            'service_request_id' => $serviceRequest->id,
            'status' => 'accepted',
            'notes' => 'Service request accepted by provider.',
            'user_id' => $user->id
        ]);
        
        // Notify the customer
        // TODO: Implement notification
        
        return redirect()->route('provider.service-requests.show', $serviceRequest->id)
            ->with('success', 'Service request accepted successfully.');
    }
    
    /**
     * Mark a service request as complete.
     */
    public function complete(Request $request, $id)
    {
        $user = Auth::user();
        $serviceRequest = ServiceRequest::where('provider_id', $user->id)
            ->findOrFail($id);
        
        // Check if the request is in a state that can be completed
        if (!in_array($serviceRequest->status, ['accepted', 'in_progress'])) {
            return redirect()->route('provider.service-requests.show', $serviceRequest->id)
                ->with('error', 'This service request cannot be marked as complete.');
        }
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'completion_notes' => 'required|string|max:500',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('provider.service-requests.show', $serviceRequest->id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update the service request
        $serviceRequest->status = 'completed';
        $serviceRequest->completed_at = now();
        $serviceRequest->save();
        
        // Create status update
        ServiceRequestStatusUpdate::create([
            'service_request_id' => $serviceRequest->id,
            'status' => 'completed',
            'notes' => $request->completion_notes,
            'user_id' => $user->id
        ]);
        
        // Create note
        ServiceRequestNote::create([
            'service_request_id' => $serviceRequest->id,
            'user_id' => $user->id,
            'content' => $request->completion_notes,
            'is_private' => false
        ]);
        
        // Notify the customer
        // TODO: Implement notification
        
        return redirect()->route('provider.service-requests.show', $serviceRequest->id)
            ->with('success', 'Service request marked as complete successfully.');
    }
    
    /**
     * Cancel a service request.
     */
    public function cancel(Request $request, $id)
    {
        $user = Auth::user();
        $serviceRequest = ServiceRequest::where('provider_id', $user->id)
            ->findOrFail($id);
        
        // Check if the request is in a state that can be cancelled
        if (!in_array($serviceRequest->status, ['accepted', 'in_progress'])) {
            return redirect()->route('provider.service-requests.show', $serviceRequest->id)
                ->with('error', 'This service request cannot be cancelled.');
        }
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'required|string|max:500',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('provider.service-requests.show', $serviceRequest->id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update the service request
        $serviceRequest->status = 'cancelled';
        $serviceRequest->cancelled_at = now();
        $serviceRequest->cancellation_reason = $request->cancellation_reason;
        $serviceRequest->cancelled_by = 'provider';
        $serviceRequest->save();
        
        // Create status update
        ServiceRequestStatusUpdate::create([
            'service_request_id' => $serviceRequest->id,
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
        
        // Notify the customer
        // TODO: Implement notification
        
        return redirect()->route('provider.service-requests.index')
            ->with('success', 'Service request cancelled successfully.');
    }
    
    /**
     * Update provider location for a service request.
     */
    public function updateLocation(Request $request, $id)
    {
        $user = Auth::user();
        $serviceRequest = ServiceRequest::where('provider_id', $user->id)
            ->findOrFail($id);
        
        // Check if the request is in a state that can be updated
        if (!in_array($serviceRequest->status, ['accepted', 'in_progress'])) {
            return response()->json([
                'success' => false,
                'message' => 'This service request cannot be updated.'
            ], 400);
        }
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid location data.',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Update the provider's location
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();
        
        // If status is 'accepted', change to 'in_progress' for the first location update
        if ($serviceRequest->status === 'accepted') {
            $serviceRequest->status = 'in_progress';
            $serviceRequest->started_at = now();
            $serviceRequest->save();
            
            // Create status update
            ServiceRequestStatusUpdate::create([
                'service_request_id' => $serviceRequest->id,
                'status' => 'in_progress',
                'notes' => 'Provider is on the way.',
                'user_id' => $user->id
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully.'
        ]);
    }
    
    /**
     * Add a note to a service request.
     */
    public function addNote(Request $request, $id)
    {
        $user = Auth::user();
        $serviceRequest = ServiceRequest::where('provider_id', $user->id)
            ->findOrFail($id);
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:500',
            'is_private' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('provider.service-requests.show', $serviceRequest->id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Create the note
        ServiceRequestNote::create([
            'service_request_id' => $serviceRequest->id,
            'user_id' => $user->id,
            'content' => $request->content,
            'is_private' => $request->is_private ?? false
        ]);
        
        return redirect()->route('provider.service-requests.show', $serviceRequest->id)
            ->with('success', 'Note added successfully.');
    }
}
