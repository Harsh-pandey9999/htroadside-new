<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the provider dashboard.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Get recent service requests
            $recentRequests = ServiceRequest::where('provider_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            // Get pending service requests
            $pendingRequests = ServiceRequest::where('provider_id', $user->id)
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Get statistics
            $stats = [
                'total_requests' => ServiceRequest::where('provider_id', $user->id)->count(),
                'completed_requests' => ServiceRequest::where('provider_id', $user->id)->where('status', 'completed')->count(),
                'total_earnings' => Payment::where('provider_id', $user->id)->where('status', 'completed')->sum('amount'),
                'avg_rating' => Review::where('provider_id', $user->id)->avg('rating') ?: 0,
                'total_reviews' => Review::where('provider_id', $user->id)->count(),
                'account_age' => Carbon::parse($user->created_at)->diffForHumans(),
                'completion_rate' => $this->calculateCompletionRate($user->id),
                'response_time' => $this->calculateAverageResponseTime($user->id),
            ];
            
            // Get monthly earnings for chart
            $monthlyEarnings = Payment::where('provider_id', $user->id)
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
                if (!isset($monthlyEarnings[$i])) {
                    $monthlyEarnings[$i] = 0;
                }
            }
            
            // Sort by month
            ksort($monthlyEarnings);
            
            // Get upcoming service requests
            $upcomingRequests = ServiceRequest::where('provider_id', $user->id)
                ->whereIn('status', ['accepted', 'in_progress'])
                ->orderBy('scheduled_date', 'asc')
                ->limit(3)
                ->get();
                
            // Get service request types breakdown
            $serviceTypeBreakdown = ServiceRequest::where('provider_id', $user->id)
                ->where('status', 'completed')
                ->join('services', 'service_requests.service_type_id', '=', 'services.id')
                ->selectRaw('services.name, COUNT(*) as count')
                ->groupBy('services.name')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get();
                
            // Get recent reviews
            $recentReviews = Review::where('provider_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
                
            // Determine which design version to use based on session
            $designVersion = session('design_version', 'material');
            $view = $designVersion === 'material' ? 'provider.dashboard.index-material' : 'provider.dashboard.index';
            
            return view($view, compact(
                'recentRequests', 
                'pendingRequests', 
                'stats', 
                'monthlyEarnings',
                'upcomingRequests',
                'serviceTypeBreakdown',
                'recentReviews'
            ));
        } catch (QueryException $e) {
            \Log::error('Database error in provider dashboard: ' . $e->getMessage());
            $designVersion = session('design_version', 'material');
            $view = $designVersion === 'material' ? 'provider.dashboard.index-material' : 'provider.dashboard.index';
            return view($view)->with('warning', 'Some dashboard data may not be available due to database connection issues.');
        } catch (\Exception $e) {
            \Log::error('Error in provider dashboard: ' . $e->getMessage());
            $designVersion = session('design_version', 'material');
            $view = $designVersion === 'material' ? 'provider.dashboard.index-material' : 'provider.dashboard.index';
            return view($view)->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Calculate the completion rate for a provider.
     *
     * @param int $providerId
     * @return float
     */
    private function calculateCompletionRate($providerId)
    {
        try {
            $totalRequests = ServiceRequest::where('provider_id', $providerId)
                ->whereIn('status', ['completed', 'cancelled', 'rejected'])
                ->count();
                
            if ($totalRequests === 0) {
                return 0;
            }
            
            $completedRequests = ServiceRequest::where('provider_id', $providerId)
                ->where('status', 'completed')
                ->count();
                
            return round(($completedRequests / $totalRequests) * 100, 1);
        } catch (\Exception $e) {
            \Log::error('Error calculating completion rate: ' . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Calculate the average response time for a provider in minutes.
     *
     * @param int $providerId
     * @return int
     */
    private function calculateAverageResponseTime($providerId)
    {
        try {
            $requests = ServiceRequest::where('provider_id', $providerId)
                ->whereNotNull('accepted_at')
                ->whereNotNull('created_at')
                ->select(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, accepted_at) as response_time'))
                ->get();
                
            if ($requests->isEmpty()) {
                return 0;
            }
            
            return round($requests->avg('response_time'));
        } catch (\Exception $e) {
            \Log::error('Error calculating average response time: ' . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Display the provider analytics.
     *
     * @return \Illuminate\View\View
     */
    public function analytics()
    {
        try {
            $user = Auth::user();
            
            // Get service request count by status
            $requestsByStatus = ServiceRequest::where('provider_id', $user->id)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
                ->toArray();
                
            // Get service request count by month
            $requestsByMonth = ServiceRequest::where('provider_id', $user->id)
                ->whereYear('created_at', now()->year)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
                
            // Fill in missing months with zero
            for ($i = 1; $i <= 12; $i++) {
                if (!isset($requestsByMonth[$i])) {
                    $requestsByMonth[$i] = 0;
                }
            }
            
            // Sort by month
            ksort($requestsByMonth);
            
            // Get earnings by service type
            $earningsByService = Payment::where('provider_id', $user->id)
                ->where('status', 'completed')
                ->join('service_requests', 'payments.service_request_id', '=', 'service_requests.id')
                ->join('services', 'service_requests.service_type_id', '=', 'services.id')
                ->select('services.name', DB::raw('SUM(payments.amount) as total'))
                ->groupBy('services.name')
                ->orderBy('total', 'desc')
                ->get();
                
            // Get customer retention data
            $customerRetention = ServiceRequest::where('provider_id', $user->id)
                ->select('user_id', DB::raw('count(*) as request_count'))
                ->groupBy('user_id')
                ->having('request_count', '>', 1)
                ->count();
                
            $totalCustomers = ServiceRequest::where('provider_id', $user->id)
                ->distinct('user_id')
                ->count('user_id');
                
            $retentionRate = $totalCustomers > 0 ? round(($customerRetention / $totalCustomers) * 100, 1) : 0;
            
            return view('provider.analytics', compact(
                'requestsByStatus', 
                'requestsByMonth', 
                'earningsByService', 
                'retentionRate'
            ));
        } catch (QueryException $e) {
            \Log::error('Database error in provider analytics: ' . $e->getMessage());
            return back()->with('warning', 'Analytics data may not be available due to database connection issues.');
        } catch (\Exception $e) {
            \Log::error('Error in provider analytics: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Display the provider notifications.
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        try {
            $user = Auth::user();
            $notifications = $user->notifications()->paginate(15);
            
            return view('provider.notifications', compact('notifications'));
        } catch (QueryException $e) {
            \Log::error('Database error in provider notifications: ' . $e->getMessage());
            return back()->with('warning', 'Notifications may not be available due to database connection issues.');
        } catch (\Exception $e) {
            \Log::error('Error in provider notifications: ' . $e->getMessage());
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
