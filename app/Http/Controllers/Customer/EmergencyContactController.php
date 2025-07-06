<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmergencyContactController extends Controller
{
    /**
     * Display a listing of emergency contacts.
     */
    public function index()
    {
        $user = Auth::user();
        $emergencyContacts = $user->emergencyContacts()->orderBy('name')->get();
        
        return view('customer.emergency-contacts.index', compact('emergencyContacts'));
    }
    
    /**
     * Show the form for creating a new emergency contact.
     */
    public function create()
    {
        return view('customer.emergency-contacts.create');
    }
    
    /**
     * Store a newly created emergency contact.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_primary' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('customer.emergency-contacts.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        // If this is marked as primary, unmark all others
        if ($request->is_primary) {
            $user->emergencyContacts()->update(['is_primary' => false]);
        }
        
        // Create the emergency contact
        $emergencyContact = new EmergencyContact();
        $emergencyContact->user_id = $user->id;
        $emergencyContact->name = $request->name;
        $emergencyContact->relationship = $request->relationship;
        $emergencyContact->phone = $request->phone;
        $emergencyContact->email = $request->email;
        $emergencyContact->is_primary = $request->is_primary ?? false;
        $emergencyContact->save();
        
        return redirect()->route('customer.emergency-contacts.index')
            ->with('success', 'Emergency contact added successfully.');
    }
    
    /**
     * Show the form for editing the specified emergency contact.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $emergencyContact = $user->emergencyContacts()->findOrFail($id);
        
        return view('customer.emergency-contacts.edit', compact('emergencyContact'));
    }
    
    /**
     * Update the specified emergency contact.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $emergencyContact = $user->emergencyContacts()->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_primary' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('customer.emergency-contacts.edit', $emergencyContact->id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // If this is marked as primary, unmark all others
        if ($request->is_primary) {
            $user->emergencyContacts()->where('id', '!=', $emergencyContact->id)->update(['is_primary' => false]);
        }
        
        // Update the emergency contact
        $emergencyContact->name = $request->name;
        $emergencyContact->relationship = $request->relationship;
        $emergencyContact->phone = $request->phone;
        $emergencyContact->email = $request->email;
        $emergencyContact->is_primary = $request->is_primary ?? false;
        $emergencyContact->save();
        
        return redirect()->route('customer.emergency-contacts.index')
            ->with('success', 'Emergency contact updated successfully.');
    }
    
    /**
     * Remove the specified emergency contact.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $emergencyContact = $user->emergencyContacts()->findOrFail($id);
        
        // Delete the emergency contact
        $emergencyContact->delete();
        
        return redirect()->route('customer.emergency-contacts.index')
            ->with('success', 'Emergency contact deleted successfully.');
    }
    
    /**
     * Set the specified emergency contact as primary.
     */
    public function setPrimary($id)
    {
        $user = Auth::user();
        $emergencyContact = $user->emergencyContacts()->findOrFail($id);
        
        // Unmark all other contacts as primary
        $user->emergencyContacts()->where('id', '!=', $emergencyContact->id)->update(['is_primary' => false]);
        
        // Mark this contact as primary
        $emergencyContact->is_primary = true;
        $emergencyContact->save();
        
        return redirect()->route('customer.emergency-contacts.index')
            ->with('success', 'Primary emergency contact updated successfully.');
    }
}
