<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the subscription plans.
     */
    public function index()
    {
        $user = Auth::user();
        $plans = SubscriptionPlan::where('is_active', true)->get();
        $activeSubscription = $user->activeSubscription;
        $subscriptionHistory = Subscription::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        return view('customer.subscriptions.index', compact('plans', 'activeSubscription', 'subscriptionHistory'));
    }
    
    /**
     * Show the form for subscribing to a plan.
     */
    public function subscribe($planId)
    {
        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($planId);
        
        // Check if user already has an active subscription
        $activeSubscription = $user->activeSubscription;
        
        return view('customer.subscriptions.subscribe', compact('plan', 'activeSubscription'));
    }
    
    /**
     * Process a new subscription.
     */
    public function process(Request $request, $planId)
    {
        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($planId);
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string|in:card,wallet',
            'card_number' => 'required_if:payment_method,card|string|max:19',
            'card_expiry' => 'required_if:payment_method,card|string|max:7',
            'card_cvv' => 'required_if:payment_method,card|string|max:4',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('customer.subscriptions.subscribe', $plan->id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Check if user already has an active subscription
        $activeSubscription = $user->activeSubscription;
        if ($activeSubscription) {
            // Cancel the current subscription
            $activeSubscription->status = 'cancelled';
            $activeSubscription->cancelled_at = now();
            $activeSubscription->save();
        }
        
        // Create a new subscription
        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->plan_id = $plan->id;
        $subscription->plan_name = $plan->name;
        $subscription->plan_description = $plan->description;
        $subscription->price = $plan->price;
        $subscription->billing_cycle = $plan->billing_cycle;
        $subscription->features = $plan->features;
        $subscription->status = 'active';
        $subscription->start_date = now();
        
        // Calculate end date based on billing cycle
        if ($plan->billing_cycle === 'monthly') {
            $subscription->end_date = now()->addMonth();
        } elseif ($plan->billing_cycle === 'quarterly') {
            $subscription->end_date = now()->addMonths(3);
        } elseif ($plan->billing_cycle === 'yearly') {
            $subscription->end_date = now()->addYear();
        }
        
        $subscription->save();
        
        // Create payment record
        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->subscription_id = $subscription->id;
        $payment->amount = $plan->price;
        $payment->platform_fee = $plan->price; // All subscription fees go to the platform
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
            
            return redirect()->route('customer.subscriptions.index')
                ->with('success', 'Subscription activated successfully.');
        } catch (\Exception $e) {
            // Handle payment failure
            $payment->status = 'failed';
            $payment->failure_reason = $e->getMessage();
            $payment->save();
            
            // Cancel the subscription
            $subscription->status = 'cancelled';
            $subscription->cancelled_at = now();
            $subscription->save();
            
            return redirect()->route('customer.subscriptions.subscribe', $plan->id)
                ->with('error', 'Subscription payment failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Cancel the current subscription.
     */
    public function cancel()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        
        if (!$subscription) {
            return redirect()->route('customer.subscriptions.index')
                ->with('error', 'You do not have an active subscription to cancel.');
        }
        
        // Cancel the subscription
        $subscription->status = 'cancelled';
        $subscription->cancelled_at = now();
        $subscription->save();
        
        return redirect()->route('customer.subscriptions.index')
            ->with('success', 'Your subscription has been cancelled. You will still have access until the end of your current billing period.');
    }
}
