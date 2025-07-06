<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'HT Roadside'))</title>
    <meta name="description" content="@yield('meta_description', 'HT Roadside Assistance - 24/7 emergency roadside services')">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/material.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/material.js') }}" defer></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Drawer Overlay -->
        <div class="md-drawer-overlay"></div>
        
        <!-- Navigation Drawer -->
        @if(auth()->check())
            <aside class="md-drawer">
                <div class="md-drawer-header">
                    <img src="{{ asset('images/logo.png') }}" alt="HT Roadside" class="h-8 mr-3">
                    <h1 class="md-card-title">HT Roadside</h1>
                </div>
                <div class="md-drawer-content">
                    <ul class="md-list">
                        @if(auth()->user()->hasRole('admin'))
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">dashboard</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('admin.dashboard') }}" class="md-list-item-primary">Dashboard</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">people</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('admin.users') }}" class="md-list-item-primary">Users</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">build</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('admin.services') }}" class="md-list-item-primary">Services</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">receipt</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('admin.payments') }}" class="md-list-item-primary">Payments</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">settings</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('admin.settings') }}" class="md-list-item-primary">Settings</a>
                                </div>
                            </li>
                        @elseif(auth()->user()->hasRole('provider'))
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">dashboard</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('provider.dashboard') }}" class="md-list-item-primary">Dashboard</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">assignment</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('provider.requests') }}" class="md-list-item-primary">Service Requests</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">star</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('provider.reviews') }}" class="md-list-item-primary">Reviews</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">account_balance_wallet</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('provider.earnings') }}" class="md-list-item-primary">Earnings</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">person</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('provider.profile') }}" class="md-list-item-primary">Profile</a>
                                </div>
                            </li>
                        @elseif(auth()->user()->hasRole('customer'))
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">dashboard</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('customer.dashboard') }}" class="md-list-item-primary">Dashboard</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">directions_car</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('customer.request-service') }}" class="md-list-item-primary">Request Service</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">history</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('customer.service-history') }}" class="md-list-item-primary">Service History</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">credit_card</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('customer.payment-methods') }}" class="md-list-item-primary">Payment Methods</a>
                                </div>
                            </li>
                            <li class="md-list-item">
                                <i class="material-icons md-list-item-icon">person</i>
                                <div class="md-list-item-text">
                                    <a href="{{ route('customer.profile') }}" class="md-list-item-primary">Profile</a>
                                </div>
                            </li>
                        @endif
                        <li class="md-list-item">
                            <i class="material-icons md-list-item-icon">exit_to_app</i>
                            <div class="md-list-item-text">
                                <a href="{{ route('logout') }}" class="md-list-item-primary" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </aside>
        @endif
        
        <!-- Main Content -->
        <div class="flex flex-col flex-1 h-screen overflow-y-auto">
            <!-- App Bar -->
            @if(auth()->check())
                <header class="md-app-bar">
                    <button id="drawer-toggle" class="md-btn md-btn-icon">
                        <i class="material-icons">menu</i>
                    </button>
                    <h1 class="md-app-bar-title">@yield('page_title', 'Dashboard')</h1>
                    <div class="md-app-bar-actions">
                        <button id="theme-toggle" class="md-btn md-btn-icon" title="Toggle Theme">
                            <i class="material-icons">dark_mode</i>
                        </button>
                        <div class="relative ml-3">
                            <button id="user-menu-button" class="md-btn md-btn-icon" title="User Menu">
                                <i class="material-icons">account_circle</i>
                            </button>
                            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <div class="px-4 py-2 text-sm text-gray-700">
                                    <div class="font-medium">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                                <hr class="my-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </header>
            @endif
            
            <!-- Page Content -->
            <main class="flex-1 p-4">
                @if(session('success'))
                    <div class="md-card md-bg-success mb-4 p-4 text-white rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="md-card md-bg-error mb-4 p-4 text-white rounded">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="md-card md-bg-warning mb-4 p-4 rounded">
                        {{ session('warning') }}
                    </div>
                @endif
                
                @if(session('info'))
                    <div class="md-card md-bg-info mb-4 p-4 rounded">
                        {{ session('info') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="p-4 border-t border-gray-200 text-center text-sm text-gray-600">
                &copy; {{ date('Y') }} HT Roadside Assistance. All rights reserved.
            </footer>
        </div>
    </div>
    
    @stack('scripts')
    
    <script>
        // Initialize user dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');
            
            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function() {
                    userDropdown.classList.add('hidden');
                });
                
                userDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>
</html>
