<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Plan;
use Razorpay\Api\Api;

class PaymentsController extends Controller
{
    protected $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function index()
    {
        $payments = Payment::with(['user', 'plan'])->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id'
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        
        try {
            $paymentOptions = $this->razorpay->paymentLink->create([
                'amount' => $plan->price * 100, // Convert to paisa
                'currency' => 'INR',
                'accept_partial' => false,
                'customer' => [
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'notify' => [
                    'sms' => true,
                    'email' => true
                ],
                'callback_url' => route('payments.process'),
                'callback_method' => 'get'
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $paymentOptions['short_url']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function process(Request $request)
    {
        if ($request->has('payment_id') && $request->has('order_id')) {
            try {
                // Verify payment signature
                $signatureData = $request->only('payment_id', 'order_id', 'signature');
                
                $attributes = array(
                    'razorpay_order_id' => $request->order_id,
                    'razorpay_payment_id' => $request->payment_id,
                    'razorpay_signature' => $request->signature
                );
                
                $this->razorpay->utility->verifyPaymentSignature($attributes);
                
                // Get order details
                $order = $this->razorpay->order->fetch($request->order_id);
                
                // Find the plan based on amount
                $plan = Plan::where('price', $order['amount'] / 100)->firstOrFail();
                
                // Create payment record
                $payment = Payment::create([
                    'user_id' => auth()->id(),
                    'plan_id' => $plan->id,
                    'razorpay_payment_id' => $request->payment_id,
                    'razorpay_order_id' => $request->order_id,
                    'razorpay_signature' => $request->signature,
                    'amount' => $order['amount'] / 100,
                    'currency' => $order['currency'],
                    'status' => 'success',
                    'payment_data' => json_encode($order)
                ]);
                
                return view('pages.payment-success', compact('payment'));
            } catch (\Exception $e) {
                // Store failed payment
                Payment::create([
                    'user_id' => auth()->id(),
                    'plan_id' => Plan::where('price', $request->amount / 100)->first()->id,
                    'razorpay_payment_id' => $request->payment_id,
                    'razorpay_order_id' => $request->order_id,
                    'razorpay_signature' => $request->signature,
                    'amount' => $request->amount / 100,
                    'currency' => 'INR',
                    'status' => 'failed',
                    'payment_data' => json_encode(['error' => $e->getMessage()])
                ]);
                
                return view('pages.payment-failure', ['error' => $e->getMessage()]);
            }
        }
        
        return redirect()->route('plans.index')->with('error', 'Payment failed');
    }

    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }
}
