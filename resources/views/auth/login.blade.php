@extends('layouts.app')

@section('title', 'Login - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', 'Login to your account to access your dashboard and manage your roadside assistance services.')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="py-4 px-6 bg-primary-700 text-white text-center">
                <h2 class="text-2xl font-bold">Login to Your Account</h2>
            </div>
            
            <div class="p-6">
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                        <p>{{ session('warning') }}</p>
                    </div>
                @endif
                
                <!-- Login Type Tabs -->
                <div class="mb-6 border-b">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="loginTabs" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-primary-600 hover:border-primary-300 active" 
                                id="user-tab" data-tabs-target="#user-tab-content" type="button" role="tab" 
                                aria-controls="user-tab-content" aria-selected="true">
                                Customer Login
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-primary-600 hover:border-primary-300" 
                                id="vendor-tab" data-tabs-target="#vendor-tab-content" type="button" role="tab" 
                                aria-controls="vendor-tab-content" aria-selected="false">
                                Service Provider Login
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div id="loginTabContent">
                    <!-- Customer Login Tab -->
                    <div class="active" id="user-tab-content" role="tabpanel" aria-labelledby="user-tab">
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="login_type" value="customer">
                            
                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                                    placeholder="your.email@example.com">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Remember me
                                </label>
                            </div>
                            
                            <div>
                                <button type="submit" class="w-full btn btn-primary">
                                    Login as Customer
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-500">
                                        Forgot your password?
                                    </a>
                                @endif
                                
                                <a href="{{ route('register') }}" class="text-sm text-primary-600 hover:text-primary-500">
                                    Don't have an account? Register
                                </a>
                            </div>
                            
                            <div class="text-center border-t pt-4">
                                <p class="text-sm text-gray-600 mb-2">Or login with</p>
                                <a href="{{ route('login.otp') }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                                    <i class="fas fa-mobile-alt mr-2"></i> OTP Login
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Vendor Login Tab -->
                    <div class="hidden" id="vendor-tab-content" role="tabpanel" aria-labelledby="vendor-tab">
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="login_type" value="vendor">
                            
                            <div>
                                <label for="vendor_email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                                <input type="email" name="email" id="vendor_email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                                    placeholder="your.business@example.com">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="vendor_password" class="block text-gray-700 font-medium mb-2">Password</label>
                                <input type="password" name="password" id="vendor_password" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="vendor_remember" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="vendor_remember" class="ml-2 block text-sm text-gray-700">
                                    Remember me
                                </label>
                            </div>
                            
                            <div>
                                <button type="submit" class="w-full btn btn-primary">
                                    Login as Service Provider
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-500">
                                        Forgot your password?
                                    </a>
                                @endif
                                
                                <a href="{{ route('vendor.register') }}" class="text-sm text-primary-600 hover:text-primary-500">
                                    Register as Service Provider
                                </a>
                            </div>
                            
                            <div class="text-center border-t pt-4">
                                <p class="text-sm text-gray-600 mb-2">Or login with</p>
                                <a href="{{ route('login.otp') }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                                    <i class="fas fa-mobile-alt mr-2"></i> OTP Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('[data-tabs-target]');
        const tabContents = document.querySelectorAll('#loginTabContent > div');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = document.querySelector(tab.dataset.tabsTarget);
                
                tabContents.forEach(tabContent => {
                    tabContent.classList.add('hidden');
                    tabContent.classList.remove('active');
                });
                
                tabs.forEach(t => {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', false);
                    t.classList.remove('border-primary-600');
                    t.classList.add('border-transparent');
                });
                
                tab.classList.add('active');
                tab.setAttribute('aria-selected', true);
                tab.classList.remove('border-transparent');
                tab.classList.add('border-primary-600');
                
                target.classList.remove('hidden');
                target.classList.add('active');
            });
        });
    });
</script>
@endsection
