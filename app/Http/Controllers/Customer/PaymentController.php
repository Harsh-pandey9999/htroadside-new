<?php

namespace App\Http\Controllers\Customer;

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
        
        $query = Payment::where('user_id', $user->id);
        
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
        $totalSpent = $query->sum('amount');
        $pendingPayments = Payment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');
        
        return view('customer.payments.index', compact('payments', 'status', 'period', 'totalSpent', 'pendingPayments'));
    }
    
    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $user = Auth::user();
        $payment = Payment::where('user_id', $user->id)
            ->findOrFail($id);
        
        return view('customer.payments.show', compact('payment'));
    }
    
    /**
     * Process a new payment.
     */
    public function process(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'service_request_id' => 'required|exists:service_requests,id',
            'payment_method' => 'required|string|in:card,wallet',
            'card_number' => 'required_if:payment_method,card|string|max:19',
            'card_expiry' => 'required_if:payment_method,card|string|max:7',
            'card_cvv' => 'required_if:payment_method,card|string|max:4',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $serviceRequest = \App\Models\ServiceRequest::findOrFail($request->service_request_id);
        
        // Check if the service request belongs to the user
        if ($serviceRequest->user_id !== $user->id) {
            return redirect()->route('customer.service-requests.index')
                ->with('error', 'You are not authorized to make this payment.');
        }
        
        // Check if the service request is completed
        if ($serviceRequest->status !== 'completed') {
            return redirect()->route('customer.service-requests.show', $serviceRequest->id)
                ->with('error', 'Payment can only be made for completed service requests.');
        }
        
        // Check if payment already exists
        if (Payment::where('service_request_id', $serviceRequest->id)->where('status', '!=', 'failed')->exists()) {
            return redirect()->route('customer.service-requests.show', $serviceRequest->id)
                ->with('error', 'Payment has already been processed for this service request.');
        }
        
        // Calculate amount (this would typically come from a service or be stored in the service request)
        $amount = $serviceRequest->calculateAmount();
        $providerAmount = $amount * 0.8; // 80% goes to the provider
        $platformFee = $amount * 0.2; // 20% platform fee
        
        // Create payment record
        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->provider_id = $serviceRequest->provider_id;
        $payment->service_request_id = $serviceRequest->id;
        $payment->amount = $amount;
        $payment->provider_amount = $providerAmount;
        $payment->platform_fee = $platformFee;
        $payment->payment_method = $request->payment_method;
        $payment->status = 'pending';
        $payment->payment_date = now();
        $payment->save();
        
        // Process payment with payment gateway (e.g., Stripe, Razorpay)
        // This is a placeholder for actual payment processing
        try {
            // Simulate payment processing
            // In a real application, you would integrate with a payment gateway here
            
            // Update payment status
            $payment->status = 'completed';
            $payment->transaction_id = 'TR' . time() . rand(1000, 9999);
            $payment->save();
            
            return redirect()->route('customer.payments.show', $payment->id)
                ->with('success', 'Payment processed successfully.');
        } catch (\Exception $e) {
            // Handle payment failure
            $payment->status = 'failed';
            $payment->failure_reason = $e->getMessage();
            $payment->save();
            
            return redirect()->route('customer.service-requests.show', $serviceRequest->id)
                ->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }
}
