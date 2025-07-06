<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Get recent service requests
            $recentRequests = ServiceRequest::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            // Get active service requests
            $activeRequests = ServiceRequest::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'accepted', 'in_progress'])
                ->orderBy('updated_at', 'desc')
                ->get();
            
            // Get active subscription
            $activeSubscription = $user->activeSubscription;
            
            // Get statistics
            $stats = [
                'total_requests' => ServiceRequest::where('user_id', $user->id)->count(),
                'completed_requests' => ServiceRequest::where('user_id', $user->id)->where('status', 'completed')->count(),
                'total_spent' => Payment::where('user_id', $user->id)->where('status', 'completed')->sum('amount'),
                'emergency_contacts' => $user->emergencyContacts()->count(),
                'reviews_given' => Review::where('user_id', $user->id)->count(),
                'account_age' => Carbon::parse($user->created_at)->diffForHumans(),
            ];
            
            // Get monthly spending data for chart
            $monthlySpending = Payment::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereYear('created_at', now()->year)
                ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->keyBy('month')
                ->map(function ($item) {
                    return $item->total;
                });
            
            // Fill in missing months with zero
            for ($i = 1; $i <= 12; $i++) {
                if (!isset($monthlySpending[$i])) {
                    $monthlySpending[$i] = 0;
                }
            }
            
            // Sort by month
            ksort($monthlySpending);
            
            // Get upcoming service requests
            $upcomingRequests = ServiceRequest::where('user_id', $user->id)
                ->whereIn('status', ['accepted', 'in_progress'])
                ->orderBy('scheduled_date', 'asc')
                ->limit(3)
                ->get();
                
            // Get recommended services based on user's previous requests
            $recommendedServices = $this->getRecommendedServices($user->id);
            
            // Determine which design version to use based on session
            $designVersion = session('design_version', 'material');
            $view = $designVersion === 'material' ? 'customer.dashboard.index-material' : 'customer.dashboard.index';
            
            return view($view, compact(
                'recentRequests', 
                'activeRequests', 
                'activeSubscription', 
                'stats', 
                'monthlySpending', 
                'upcomingRequests', 
                'recommendedServices'
            ));
        } catch (QueryException $e) {
            \Log::error('Database error in customer dashboard: ' . $e->getMessage());
            $designVersion = session('design_version', 'material');
            $view = $designVersion === 'material' ? 'customer.dashboard.index-material' : 'customer.dashboard.index';
            return view($view)->with('warning', 'Some dashboard data may not be available due to database connection issues.');
        } catch (\Exception $e) {
            \Log::error('Error in customer dashboard: ' . $e->getMessage());
            $designVersion = session('design_version', 'material');
            $view = $designVersion === 'material' ? 'customer.dashboard.index-material' : 'customer.dashboard.index';
            return view($view)->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Get recommended services based on user's previous requests.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecommendedServices($userId)
    {
        try {
            // Get service types the user has previously requested
            $userServiceTypes = ServiceRequest::where('user_id', $userId)
                ->pluck('service_type_id')
                ->toArray();
            
            // If user has no previous requests, get popular services
            if (empty($userServiceTypes)) {
                return Service::withCount('requests')
                    ->orderBy('requests_count', 'desc')
                    ->limit(3)
                    ->get();
            }
            
            // Get related services that the user hasn't used yet
            return Service::whereNotIn('id', $userServiceTypes)
                ->withCount(['requests' => function ($query) use ($userServiceTypes) {
                    $query->whereIn('service_type_id', $userServiceTypes);
                }])
                ->orderBy('requests_count', 'desc')
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            \Log::error('Error getting recommended services: ' . $e->getMessage());
            return collect(); // Return empty collection on error
        }
    }
    
    /**
     * Display the customer activity history.
     *
     * @return \Illuminate\View\View
     */
    public function activityHistory()
    {
        try {
            $user = Auth::user();
            
            // Get all service requests with pagination
            $serviceRequests = ServiceRequest::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Get all payments with pagination
            $payments = Payment::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Get all reviews with pagination
            $reviews = Review::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            return view('customer.activity-history', compact('serviceRequests', 'payments', 'reviews'));
        } catch (QueryException $e) {
            \Log::error('Database error in customer activity history: ' . $e->getMessage());
            return back()->with('warning', 'Activity history may not be available due to database connection issues.');
        } catch (\Exception $e) {
            \Log::error('Error in customer activity history: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Display the customer notifications.
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        try {
            $user = Auth::user();
            $notifications = $user->notifications()->paginate(15);
            
            return view('customer.notifications', compact('notifications'));
        } catch (QueryException $e) {
            \Log::error('Database error in customer notifications: ' . $e->getMessage());
            return back()->with('warning', 'Notifications may not be available due to database connection issues.');
        } catch (\Exception $e) {
            \Log::error('Error in customer notifications: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Mark notification as read.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markNotificationAsRead(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications()->where('id', $id)->first();
            
            if ($notification) {
                $notification->markAsRead();
                return back()->with('success', 'Notification marked as read.');
            }
            
            return back()->with('error', 'Notification not found.');
        } catch (\Exception $e) {
            \Log::error('Error marking notification as read: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
