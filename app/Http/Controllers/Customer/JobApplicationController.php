<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the customer's job applications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = JobApplication::with('job')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc');
            
            // Filter by status if provided
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }
            
            $applications = $query->paginate(10);
            
            return view('customer.applications.index', compact('applications'));
        } catch (QueryException $e) {
            \Log::error('Database error fetching customer applications: ' . $e->getMessage());
            return back()->with('error', 'Database error occurred. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error fetching customer applications: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching your applications. Please try again.');
        }
    }

    /**
     * Withdraw a job application.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdraw($id, Request $request)
    {
        try {
            $application = JobApplication::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            // Check if application is already withdrawn or rejected
            if ($application->status === 'withdrawn' || $application->status === 'rejected') {
                return back()->with('error', 'This application has already been ' . $application->status . '.');
            }
            
            // Update application status to withdrawn
            $application->status = 'withdrawn';
            
            // Save withdrawal reason if provided
            if ($request->has('withdrawal_reason')) {
                $application->withdrawal_reason = $request->withdrawal_reason;
            }
            
            $application->save();
            
            // TODO: Send email notification to admin
            
            return redirect()->route('customer.applications.index')
                ->with('success', 'Your application has been withdrawn successfully.');
        } catch (QueryException $e) {
            \Log::error('Database error withdrawing application: ' . $e->getMessage());
            return back()->with('error', 'Database error occurred. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error withdrawing application: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while withdrawing your application. Please try again.');
        }
    }
    
    /**
     * View a specific job application.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $application = JobApplication::with('job')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            return view('customer.applications.show', compact('application'));
        } catch (QueryException $e) {
            \Log::error('Database error viewing application: ' . $e->getMessage());
            return back()->with('error', 'Database error occurred. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error viewing application: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while viewing your application. Please try again.');
        }
    }
}
