<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'plan_id',
        'service_request_id',
        'razorpay_payment_id',
        'razorpay_order_id',
        'razorpay_signature',
        'amount',
        'currency',
        'status',
        'payment_data',
        'payment_method',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_postal_code',
        'invoice_number',
        'description',
        'tax_amount',
        'discount_amount',
        'refunded_amount',
        'refunded_at',
        'subscription_id',
        'payment_type' // subscription, service_request, etc.
    ];
    
    protected $casts = [
        'payment_data' => 'array',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
        'refunded_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
    
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
    
    public function scopeRefunded($query)
    {
        return $query->whereNotNull('refunded_at');
    }
    
    public function scopeByType($query, $type)
    {
        return $query->where('payment_type', $type);
    }
    
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
    
    public function getFormattedAmountAttribute()
    {
        return '$' . number_format($this->amount, 2);
    }
    
    public function getFormattedTaxAmountAttribute()
    {
        return '$' . number_format($this->tax_amount ?? 0, 2);
    }
    
    public function getFormattedDiscountAmountAttribute()
    {
        return '$' . number_format($this->discount_amount ?? 0, 2);
    }
    
    public function getFormattedRefundedAmountAttribute()
    {
        return '$' . number_format($this->refunded_amount ?? 0, 2);
    }
    
    public function getNetAmountAttribute()
    {
        $netAmount = $this->amount;
        
        if ($this->refunded_amount) {
            $netAmount -= $this->refunded_amount;
        }
        
        return max(0, $netAmount);
    }
    
    public function getFormattedNetAmountAttribute()
    {
        return '$' . number_format($this->net_amount, 2);
    }
    
    public function getFormattedStatusAttribute()
    {
        $statusMap = [
            'pending' => 'Pending',
            'success' => 'Successful',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
            'partially_refunded' => 'Partially Refunded'
        ];
        
        if ($this->refunded_amount && $this->refunded_amount >= $this->amount) {
            return $statusMap['refunded'];
        }
        
        if ($this->refunded_amount && $this->refunded_amount < $this->amount) {
            return $statusMap['partially_refunded'];
        }
        
        return $statusMap[$this->status] ?? ucfirst($this->status);
    }
    
    public function getStatusColorAttribute()
    {
        $colorMap = [
            'pending' => 'yellow',
            'success' => 'green',
            'failed' => 'red',
            'refunded' => 'purple',
            'partially_refunded' => 'indigo'
        ];
        
        if ($this->refunded_amount && $this->refunded_amount >= $this->amount) {
            return $colorMap['refunded'];
        }
        
        if ($this->refunded_amount && $this->refunded_amount < $this->amount) {
            return $colorMap['partially_refunded'];
        }
        
        return $colorMap[$this->status] ?? 'gray';
    }
    
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y h:i A');
    }
    
    public function getFormattedRefundedAtAttribute()
    {
        return $this->refunded_at ? $this->refunded_at->format('M d, Y h:i A') : 'N/A';
    }
    
    public function getFullBillingAddressAttribute()
    {
        $parts = array_filter([
            $this->billing_address,
            $this->billing_city,
            $this->billing_state,
            $this->billing_postal_code,
            $this->billing_country
        ]);
        
        return implode(', ', $parts);
    }
    
    public function isRefundable()
    {
        // Only successful payments that haven't been fully refunded can be refunded
        if ($this->status !== 'success') {
            return false;
        }
        
        // If already fully refunded
        if ($this->refunded_amount && $this->refunded_amount >= $this->amount) {
            return false;
        }
        
        // Check if payment is too old (e.g., more than 90 days)
        $refundWindow = Carbon::now()->subDays(90);
        if ($this->created_at->lt($refundWindow)) {
            return false;
        }
        
        return true;
    }
    
    public function getRefundableAmountAttribute()
    {
        if (!$this->isRefundable()) {
            return 0;
        }
        
        return $this->amount - ($this->refunded_amount ?? 0);
    }
    
    public function getFormattedRefundableAmountAttribute()
    {
        return '$' . number_format($this->refundable_amount, 2);
    }
}
