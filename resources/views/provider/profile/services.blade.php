@extends('layouts.app')

@section('title', 'Manage Services')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Manage Services</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-900/30 dark:text-green-300" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 dark:bg-red-900/30 dark:text-red-300" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Services Offered</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Select the services you can provide to customers</p>
        </div>
        
        <form action="{{ route('provider.profile.update-services') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="service_{{ $service->id }}" name="services[]" type="checkbox" value="{{ $service->id }}" 
                                    {{ in_array($service->id, $providerServices) ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="service_{{ $service->id }}" class="font-medium text-gray-700 dark:text-gray-300">{{ $service->name }}</label>
                                <p class="text-gray-500 dark:text-gray-400">{{ $service->description }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Base rate: ${{ number_format($service->base_price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Service Area</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="service_radius" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Service Radius (miles)
                            </label>
                            <input type="number" id="service_radius" name="service_radius" min="1" max="100" value="{{ old('service_radius', $provider->service_radius) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('service_radius')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="service_zip_codes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Service Zip Codes (comma separated)
                            </label>
                            <input type="text" id="service_zip_codes" name="service_zip_codes" value="{{ old('service_zip_codes', $provider->service_zip_codes) }}" placeholder="e.g. 10001, 10002, 10003" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('service_zip_codes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Enter zip codes where you provide service, separated by commas
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Custom Rates</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        You can set custom rates for your services. Leave blank to use the default system rates.
                    </p>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Default Rate</th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Your Custom Rate</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($services as $service)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $service->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${{ number_format($service->base_price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" step="0.01" min="0" name="custom_rates[{{ $service->id }}]" value="{{ old('custom_rates.' . $service->id, $customRates[$service->id] ?? '') }}" class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" placeholder="{{ number_format($service->base_price, 2) }}">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 text-right">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
