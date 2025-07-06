<?php

namespace App\Services;

use App\Models\ApiSetting;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class PaymentService
{
    protected $razorpay;
    protected $keyId;
    protected $keySecret;
    protected $isTestMode;

    /**
     * Create a new PaymentService instance.
     */
    public function __construct()
    {
        $this->keyId = ApiSetting::getSetting('razorpay', 'key_id');
        $this->keySecret = ApiSetting::getSetting('razorpay', 'key_secret');
        $this->isTestMode = ApiSetting::getSetting('razorpay', 'environment') === 'test';

        if ($this->keyId && $this->keySecret) {
            $this->razorpay = new Api($this->keyId, $this->keySecret);
        }
    }

    /**
     * Check if Razorpay is configured.
     *
     * @return bool
     */
    public function isConfigured()
    {
        return !empty($this->keyId) && !empty($this->keySecret);
    }

    /**
     * Create a new order in Razorpay.
     *
     * @param float $amount Amount in rupees
     * @param string $receiptId Receipt ID (usually your internal order ID)
     * @param array $notes Additional notes for the order
     * @return array
     */
    public function createOrder($amount, $receiptId, $notes = [])
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Razorpay is not configured properly'
            ];
        }

        try {
            // Amount should be in paise (1 rupee = 100 paise)
            $amountInPaise = $amount * 100;

            $orderData = [
                'receipt' => $receiptId,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'notes' => $notes,
            ];

            $order = $this->razorpay->order->create($orderData);

            return [
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $order
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed: ' . $e->getMessage(), [
                'amount' => $amount,
                'receipt_id' => $receiptId,
                'notes' => $notes,
                'exception' => $e
            ]);

            return [
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify payment signature.
     *
     * @param string $paymentId Razorpay Payment ID
     * @param string $orderId Razorpay Order ID
     * @param string $signature Razorpay Signature
     * @return bool
     */
    public function verifyPaymentSignature($paymentId, $orderId, $signature)
    {
        if (!$this->isConfigured()) {
            return false;
        }

        try {
            $attributes = [
                'razorpay_payment_id' => $paymentId,
                'razorpay_order_id' => $orderId,
                'razorpay_signature' => $signature
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $e) {
            Log::error('Razorpay signature verification failed: ' . $e->getMessage(), [
                'payment_id' => $paymentId,
                'order_id' => $orderId,
                'exception' => $e
            ]);

            return false;
        }
    }

    /**
     * Fetch payment details from Razorpay.
     *
     * @param string $paymentId Razorpay Payment ID
     * @return array
     */
    public function fetchPayment($paymentId)
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Razorpay is not configured properly'
            ];
        }

        try {
            $payment = $this->razorpay->payment->fetch($paymentId);

            return [
                'success' => true,
                'message' => 'Payment details fetched successfully',
                'data' => $payment
            ];
        } catch (\Exception $e) {
            Log::error('Failed to fetch payment details: ' . $e->getMessage(), [
                'payment_id' => $paymentId,
                'exception' => $e
            ]);

            return [
                'success' => false,
                'message' => 'Failed to fetch payment details: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Capture an authorized payment.
     *
     * @param string $paymentId Razorpay Payment ID
     * @param float $amount Amount to capture (in rupees)
     * @return array
     */
    public function capturePayment($paymentId, $amount)
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Razorpay is not configured properly'
            ];
        }

        try {
            // Amount should be in paise (1 rupee = 100 paise)
            $amountInPaise = $amount * 100;

            $payment = $this->razorpay->payment->fetch($paymentId)->capture([
                'amount' => $amountInPaise,
                'currency' => 'INR'
            ]);

            return [
                'success' => true,
                'message' => 'Payment captured successfully',
                'data' => $payment
            ];
        } catch (\Exception $e) {
            Log::error('Failed to capture payment: ' . $e->getMessage(), [
                'payment_id' => $paymentId,
                'amount' => $amount,
                'exception' => $e
            ]);

            return [
                'success' => false,
                'message' => 'Failed to capture payment: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create a refund for a payment.
     *
     * @param string $paymentId Razorpay Payment ID
     * @param float|null $amount Amount to refund (in rupees), null for full refund
     * @param string|null $notes Notes for the refund
     * @return array
     */
    public function createRefund($paymentId, $amount = null, $notes = null)
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Razorpay is not configured properly'
            ];
        }

        try {
            $refundData = [];

            if ($amount !== null) {
                // Amount should be in paise (1 rupee = 100 paise)
                $refundData['amount'] = $amount * 100;
            }

            if ($notes !== null) {
                $refundData['notes'] = ['reason' => $notes];
            }

            $refund = $this->razorpay->payment->fetch($paymentId)->refund($refundData);

            return [
                'success' => true,
                'message' => 'Refund initiated successfully',
                'data' => $refund
            ];
        } catch (\Exception $e) {
            Log::error('Failed to create refund: ' . $e->getMessage(), [
                'payment_id' => $paymentId,
                'amount' => $amount,
                'notes' => $notes,
                'exception' => $e
            ]);

            return [
                'success' => false,
                'message' => 'Failed to create refund: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Fetch refund details.
     *
     * @param string $refundId Razorpay Refund ID
     * @return array
     */
    public function fetchRefund($refundId)
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Razorpay is not configured properly'
            ];
        }

        try {
            $refund = $this->razorpay->refund->fetch($refundId);

            return [
                'success' => true,
                'message' => 'Refund details fetched successfully',
                'data' => $refund
            ];
        } catch (\Exception $e) {
            Log::error('Failed to fetch refund details: ' . $e->getMessage(), [
                'refund_id' => $refundId,
                'exception' => $e
            ]);

            return [
                'success' => false,
                'message' => 'Failed to fetch refund details: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get Razorpay checkout options for the frontend.
     *
     * @param string $orderId Razorpay Order ID
     * @param array $options Additional options
     * @return array
     */
    public function getCheckoutOptions($orderId, $options = [])
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Razorpay is not configured properly'
            ];
        }

        $defaultOptions = [
            'key' => $this->keyId,
            'amount' => 0, // Will be set by the order
            'currency' => 'INR',
            'name' => config('app.name', 'HT Roadside'),
            'description' => 'Payment for services',
            'order_id' => $orderId,
            'prefill' => [
                'name' => '',
                'email' => '',
                'contact' => ''
            ],
            'theme' => [
                'color' => '#0284c7' // Primary color from our Tailwind config
            ]
        ];

        // Merge default options with provided options
        $checkoutOptions = array_merge($defaultOptions, $options);

        return [
            'success' => true,
            'message' => 'Checkout options generated successfully',
            'data' => $checkoutOptions
        ];
    }
}
