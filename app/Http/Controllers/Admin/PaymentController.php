<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'plan']);
        
        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by plan
        if ($request->has('plan_id') && $request->plan_id) {
            $query->where('plan_id', $request->plan_id);
        }
        
        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Filter by amount range
        if ($request->has('amount_min') && $request->amount_min) {
            $query->where('amount', '>=', $request->amount_min);
        }
        
        if ($request->has('amount_max') && $request->amount_max) {
            $query->where('amount', '<=', $request->amount_max);
        }
        
        // Search by payment ID or user email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('razorpay_payment_id', 'like', "%{$search}%")
                  ->orWhere('razorpay_order_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('email', 'like', "%{$search}%")
                                ->orWhere('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Sort results
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);
        
        $payments = $query->paginate(15)->withQueryString();
        $plans = Plan::all();
        
        return view('admin.payments.index', compact('payments', 'plans'));
    }
    
    public function show(Payment $payment)
    {
        $payment->load(['user', 'plan']);
        return view('admin.payments.show', compact('payment'));
    }
    
    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,success,failed',
            'admin_notes' => 'nullable|string',
        ]);
        
        $payment->status = $validated['status'];
        
        if (isset($validated['admin_notes'])) {
            // Store admin notes in payment_data JSON field
            $paymentData = json_decode($payment->payment_data, true) ?: [];
            $paymentData['admin_notes'] = $validated['admin_notes'];
            $payment->payment_data = json_encode($paymentData);
        }
        
        $payment->save();
        
        return redirect()->back()
            ->with('success', 'Payment status updated successfully.');
    }
    
    public function refund(Request $request, Payment $payment)
    {
        // Only allow refunds for successful payments
        if ($payment->status !== 'success') {
            return redirect()->back()
                ->with('error', 'Only successful payments can be refunded.');
        }
        
        $validated = $request->validate([
            'refund_amount' => 'required|numeric|min:1|max:' . $payment->amount,
            'refund_reason' => 'required|string|max:255',
        ]);
        
        try {
            // In a real implementation, you would integrate with Razorpay API here
            // For now, we'll just simulate a refund
            
            // Update payment data with refund information
            $paymentData = json_decode($payment->payment_data, true) ?: [];
            $paymentData['refunds'] = $paymentData['refunds'] ?? [];
            $paymentData['refunds'][] = [
                'amount' => $validated['refund_amount'],
                'reason' => $validated['refund_reason'],
                'refunded_at' => now()->toIso8601String(),
                'refunded_by' => auth()->id(),
                'status' => 'success',
            ];
            
            $payment->payment_data = json_encode($paymentData);
            
            // If full refund, update payment status
            if ($validated['refund_amount'] == $payment->amount) {
                $payment->status = 'refunded';
            } else {
                $payment->status = 'partially_refunded';
            }
            
            $payment->save();
            
            return redirect()->back()
                ->with('success', 'Payment refunded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Refund failed: ' . $e->getMessage());
        }
    }
    
    public function dashboard()
    {
        // Get payment stats
        $totalPayments = Payment::count();
        $successfulPayments = Payment::where('status', 'success')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $failedPayments = Payment::where('status', 'failed')->count();
        $totalRevenue = Payment::where('status', 'success')->sum('amount');
        
        // Get monthly revenue data
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
        
        // Get plan distribution
        $planDistribution = Payment::where('status', 'success')
            ->with('plan')
            ->select('plan_id', DB::raw('count(*) as total'), DB::raw('sum(amount) as revenue'))
            ->groupBy('plan_id')
            ->orderBy('revenue', 'desc')
            ->get();
        
        // Get recent payments
        $recentPayments = Payment::with(['user', 'plan'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.payments.dashboard', compact(
            'totalPayments',
            'successfulPayments',
            'pendingPayments',
            'failedPayments',
            'totalRevenue',
            'chartData',
            'planDistribution',
            'recentPayments'
        ));
    }
    
    public function exportPayments(Request $request)
    {
        $query = Payment::with(['user', 'plan']);
        
        // Apply filters
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('plan_id') && $request->plan_id) {
            $query->where('plan_id', $request->plan_id);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $payments = $query->get();
        
        $csvFileName = 'payments-' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $columns = [
            'ID', 'User', 'Email', 'Plan', 'Amount', 'Currency', 
            'Payment ID', 'Order ID', 'Status', 'Created At'
        ];
        
        $callback = function() use($payments, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->user->name ?? 'N/A',
                    $payment->user->email ?? 'N/A',
                    $payment->plan->name ?? 'N/A',
                    $payment->amount,
                    $payment->currency,
                    $payment->razorpay_payment_id,
                    $payment->razorpay_order_id,
                    $payment->status,
                    $payment->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function generateInvoice(Payment $payment)
    {
        $payment->load(['user', 'plan']);
        
        // In a real implementation, you would generate a PDF invoice here
        // For now, we'll just return a view
        
        return view('admin.payments.invoice', compact('payment'));
    }
}
