@extends('layouts.app')

@section('title', 'Login - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', 'Login to your account to access your dashboard and manage your roadside assistance services.')

@section('content')
<div class="bg-surface-3 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto md-card md-card-elevated overflow-hidden">
            <div class="py-6 px-6 bg-primary-600 text-white text-center">
                <h2 class="text-2xl font-medium">Login to Your Account</h2>
            </div>
            
            <div class="p-6">
                @if(session('error'))
                    <div class="bg-error-50 border-l-4 border-error-500 text-error-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-success-50 border-l-4 border-success-500 text-success-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="bg-warning-50 border-l-4 border-warning-500 text-warning-700 p-4 mb-6" role="alert">
                        <p>{{ session('warning') }}</p>
                    </div>
                @endif
                
                <!-- Login Type Tabs -->
                <div class="mb-6 border-b border-neutral-200 dark:border-neutral-700">
                    <div class="md-tabs">
                        <button class="md-tab active" id="user-tab" data-tab-target="user-tab-content">
                            <span class="material-icons mr-2">person</span>
                            Customer Login
                        </button>
                        <button class="md-tab" id="vendor-tab" data-tab-target="vendor-tab-content">
                            <span class="material-icons mr-2">business</span>
                            Service Provider Login
                        </button>
                        <span class="md-tab-indicator"></span>
                    </div>
                </div>
                
                <div id="loginTabContent">
                    <!-- Customer Login Tab -->
                    <div class="md-tab-content active" id="user-tab-content">
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="login_type" value="customer">
                            
                            <div class="md-input-field">
                                <div class="md-input-container">
                                    <span class="md-input-icon material-icons">email</span>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                        class="md-input @error('email') md-input-error @enderror"
                                        placeholder="your.email@example.com">
                                    <label for="email" class="md-input-label">Email Address</label>
                                </div>
                                @error('email')
                                    <p class="md-input-helper-text error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md-input-field">
                                <div class="md-input-container">
                                    <span class="md-input-icon material-icons">lock</span>
                                    <input type="password" name="password" id="password" required
                                        class="md-input @error('password') md-input-error @enderror"
                                        placeholder="••••••••">
                                    <label for="password" class="md-input-label">Password</label>
                                </div>
                                @error('password')
                                    <p class="md-input-helper-text error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center">
                                <div class="md-checkbox">
                                    <input type="checkbox" name="remember" id="remember">
                                    <label for="remember">Remember me</label>
                                </div>
                            </div>
                            
                            <div>
                                <button type="submit" class="md-btn md-btn-filled w-full">
                                    Login as Customer
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-800">
                                        Forgot your password?
                                    </a>
                                @endif
                                
                                <a href="{{ route('register') }}" class="text-sm text-primary-600 hover:text-primary-800">
                                    Don't have an account? Register
                                </a>
                            </div>
                            
                            <div class="text-center border-t border-neutral-200 dark:border-neutral-700 pt-4">
                                <p class="text-sm text-on-surface-medium mb-2">Or login with</p>
                                <a href="{{ route('login.otp') }}" class="md-btn md-btn-outlined">
                                    <span class="material-icons mr-2">phone_android</span> OTP Login
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Vendor Login Tab -->
                    <div class="md-tab-content" id="vendor-tab-content">
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="login_type" value="vendor">
                            
                            <div class="md-input-field">
                                <div class="md-input-container">
                                    <span class="md-input-icon material-icons">email</span>
                                    <input type="email" name="email" id="vendor_email" value="{{ old('email') }}" required
                                        class="md-input @error('email') md-input-error @enderror"
                                        placeholder="your.business@example.com">
                                    <label for="vendor_email" class="md-input-label">Email Address</label>
                                </div>
                                @error('email')
                                    <p class="md-input-helper-text error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md-input-field">
                                <div class="md-input-container">
                                    <span class="md-input-icon material-icons">lock</span>
                                    <input type="password" name="password" id="vendor_password" required
                                        class="md-input @error('password') md-input-error @enderror"
                                        placeholder="••••••••">
                                    <label for="vendor_password" class="md-input-label">Password</label>
                                </div>
                                @error('password')
                                    <p class="md-input-helper-text error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center">
                                <div class="md-checkbox">
                                    <input type="checkbox" name="remember" id="vendor_remember">
                                    <label for="vendor_remember">Remember me</label>
                                </div>
                            </div>
                            
                            <div>
                                <button type="submit" class="md-btn md-btn-filled w-full">
                                    Login as Service Provider
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-800">
                                        Forgot your password?
                                    </a>
                                @endif
                                
                                <a href="{{ route('vendor.register') }}" class="text-sm text-primary-600 hover:text-primary-800">
                                    Register as Service Provider
                                </a>
                            </div>
                            
                            <div class="text-center border-t border-neutral-200 dark:border-neutral-700 pt-4">
                                <p class="text-sm text-on-surface-medium mb-2">Or login with</p>
                                <a href="{{ route('login.otp') }}" class="md-btn md-btn-outlined">
                                    <span class="material-icons mr-2">phone_android</span> OTP Login
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
    // Material Design tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.md-tab');
        const tabContents = document.querySelectorAll('.md-tab-content');
        const indicator = document.querySelector('.md-tab-indicator');
        
        // Set initial indicator position
        if (indicator && tabs.length > 0) {
            const activeTab = document.querySelector('.md-tab.active');
            if (activeTab) {
                updateIndicator(activeTab);
            }
        }
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetId = tab.getAttribute('data-tab-target');
                const target = document.getElementById(targetId);
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });
                
                // Deactivate all tabs
                tabs.forEach(t => {
                    t.classList.remove('active');
                });
                
                // Activate clicked tab and content
                tab.classList.add('active');
                target.classList.add('active');
                
                // Update indicator position
                updateIndicator(tab);
            });
        });
        
        function updateIndicator(tab) {
            indicator.style.left = `${tab.offsetLeft}px`;
            indicator.style.width = `${tab.offsetWidth}px`;
        }
    });
</script>
@endsection
