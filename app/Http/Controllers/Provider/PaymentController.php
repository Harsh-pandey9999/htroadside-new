<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'all');
        $period = $request->get('period', 'all');
        
        $query = Payment::where('provider_id', $user->id);
        
        // Filter by status
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        // Filter by period
        if ($period === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($period === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('created_at', now()->year);
        }
        
        $payments = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        
        // Calculate totals
        $totalEarnings = $query->sum('provider_amount');
        $pendingEarnings = Payment::where('provider_id', $user->id)
            ->where('status', 'pending')
            ->sum('provider_amount');
        
        return view('provider.payments.index', compact('payments', 'status', 'period', 'totalEarnings', 'pendingEarnings'));
    }
    
    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $user = Auth::user();
        $payment = Payment::where('provider_id', $user->id)
            ->findOrFail($id);
        
        return view('provider.payments.show', compact('payment'));
    }
}
