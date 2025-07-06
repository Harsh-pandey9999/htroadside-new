@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('provider.payments.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left mr-2"></i> Back to Payments
        </a>
    </div>
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Payment #{{ $payment->id }}
            </h1>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Payment Details -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Payment Details</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Amount</p>
                            <p class="font-medium text-gray-900 dark:text-white">${{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <p class="font-medium">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $payment->status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                       ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                       'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Payment Method</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst($payment->payment_method) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Transaction ID</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $payment->transaction_id ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Date</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $payment->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @if($payment->paid_at)
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Paid On</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $payment->paid_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Customer Details -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Customer Details</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $payment->customer->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $payment->customer->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $payment->customer->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Service Request Details</h2>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Service Request ID</p>
                            <a href="{{ route('provider.service-requests.show', $payment->service_request_id) }}" class="font-medium text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                #{{ $payment->service_request_id }}
                            </a>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Service Type</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $payment->serviceRequest->service->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Date</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $payment->serviceRequest->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $payment->serviceRequest->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                   ($payment->serviceRequest->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                                   ($payment->serviceRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                   'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200')) }}">
                                {{ ucfirst(str_replace('_', ' ', $payment->serviceRequest->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Payment Breakdown</h2>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <p class="text-gray-700 dark:text-gray-300">Service Fee</p>
                            <p class="font-medium text-gray-900 dark:text-white">${{ number_format($payment->service_fee, 2) }}</p>
                        </div>
                        @if($payment->additional_charges > 0)
                        <div class="flex justify-between">
                            <p class="text-gray-700 dark:text-gray-300">Additional Charges</p>
                            <p class="font-medium text-gray-900 dark:text-white">${{ number_format($payment->additional_charges, 2) }}</p>
                        </div>
                        @endif
                        @if($payment->discount > 0)
                        <div class="flex justify-between">
                            <p class="text-gray-700 dark:text-gray-300">Discount</p>
                            <p class="font-medium text-green-600 dark:text-green-400">-${{ number_format($payment->discount, 2) }}</p>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <p class="text-gray-700 dark:text-gray-300">Platform Fee</p>
                            <p class="font-medium text-gray-900 dark:text-white">-${{ number_format($payment->platform_fee, 2) }}</p>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 dark:border-gray-600 pt-3">
                            <p class="font-semibold text-gray-900 dark:text-white">Your Earnings</p>
                            <p class="font-semibold text-gray-900 dark:text-white">${{ number_format($payment->provider_amount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if($payment->notes)
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Notes</h3>
            <p class="text-gray-600 dark:text-gray-400">{{ $payment->notes }}</p>
        </div>
        @endif
    </div>
    
    <!-- Payment Receipt -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Payment Receipt</h2>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                <i class="fas fa-print mr-2"></i> Print Receipt
            </button>
        </div>
        
        <div class="p-6">
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <img src="{{ asset('images/logo.png') }}" alt="HT Roadside Assistance" class="h-12">
                        <p class="text-gray-600 dark:text-gray-400 mt-2">HT Roadside Assistance</p>
                        <p class="text-gray-600 dark:text-gray-400">123 Main Street</p>
                        <p class="text-gray-600 dark:text-gray-400">New York, NY 10001</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">RECEIPT</h2>
                        <p class="text-gray-600 dark:text-gray-400">Receipt #: {{ $payment->id }}</p>
                        <p class="text-gray-600 dark:text-gray-400">Date: {{ $payment->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Provider:</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ auth()->user()->name }}</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ auth()->user()->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Customer:</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $payment->customer->name }}</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $payment->customer->email }}</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $payment->customer->phone ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-8">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left font-semibold text-gray-800 dark:text-white pb-3">Description</th>
                                <th class="text-right font-semibold text-gray-800 dark:text-white pb-3">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-gray-200 dark:border-gray-700">
                            <tr>
                                <td class="py-3 text-gray-600 dark:text-gray-400">
                                    {{ $payment->serviceRequest->service->name }} - Service Request #{{ $payment->service_request_id }}
                                </td>
                                <td class="py-3 text-gray-600 dark:text-gray-400 text-right">
                                    ${{ number_format($payment->service_fee, 2) }}
                                </td>
                            </tr>
                            @if($payment->additional_charges > 0)
                            <tr>
                                <td class="py-3 text-gray-600 dark:text-gray-400">Additional Charges</td>
                                <td class="py-3 text-gray-600 dark:text-gray-400 text-right">${{ number_format($payment->additional_charges, 2) }}</td>
                            </tr>
                            @endif
                            @if($payment->discount > 0)
                            <tr>
                                <td class="py-3 text-gray-600 dark:text-gray-400">Discount</td>
                                <td class="py-3 text-green-600 dark:text-green-400 text-right">-${{ number_format($payment->discount, 2) }}</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="py-3 font-semibold text-gray-800 dark:text-white">Total</td>
                                <td class="py-3 font-semibold text-gray-800 dark:text-white text-right">${{ number_format($payment->amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Payment Method: {{ ucfirst($payment->payment_method) }}</p>
                    @if($payment->transaction_id)
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Transaction ID: {{ $payment->transaction_id }}</p>
                    @endif
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-4">Thank you for using HT Roadside Assistance!</p>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
        }
        .shadow-md {
            box-shadow: none !important;
        }
        button {
            display: none !important;
        }
        a {
            text-decoration: none !important;
            color: #000 !important;
        }
    }
</style>
@endsection
@endsection
