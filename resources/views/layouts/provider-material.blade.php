<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme', 'light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HT Roadside Assistance') }} - Service Provider</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('styles')
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col bg-surface-3">
        <!-- Drawer Overlay (Mobile Only) -->
        <div class="md-drawer-overlay fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden" id="drawer-overlay"></div>
        
        <!-- Navigation Drawer -->
        <aside class="md-drawer md:translate-x-0" id="main-drawer">
            <div class="md-drawer-header flex items-center p-4 h-16 border-b border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                    <h1 class="text-lg font-medium text-on-surface-high">HT Roadside</h1>
                </div>
                <button class="md-drawer-close md:hidden ml-auto text-on-surface-medium hover:text-on-surface-high">
                    <span class="material-icons">close</span>
                </button>
            </div>
            
            <div class="md-drawer-content overflow-y-auto h-[calc(100vh-4rem)]">
                <nav class="py-2">
                    <div class="px-4 py-2 text-xs uppercase text-on-surface-medium font-medium tracking-wider">
                        Main
                    </div>
                    
                    <a href="{{ route('provider.dashboard') }}" class="md-drawer-item {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}">
                        <span class="material-icons-outlined mr-3">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('provider.requests.index') }}" class="md-drawer-item {{ request()->routeIs('provider.requests.*') ? 'active' : '' }}">
                        <span class="material-icons-outlined mr-3">assignment</span>
                        <span>Service Requests</span>
                    </a>
                    
                    <a href="{{ route('provider.schedule') }}" class="md-drawer-item {{ request()->routeIs('provider.schedule') ? 'active' : '' }}">
                        <span class="material-icons-outlined mr-3">event</span>
                        <span>Schedule</span>
                    </a>
                    
                    <a href="{{ route('provider.map') }}" class="md-drawer-item {{ request()->routeIs('provider.map') ? 'active' : '' }}">
                        <span class="material-icons-outlined mr-3">map</span>
                        <span>Service Map</span>
                    </a>
                    
                    <div class="px-4 py-2 mt-4 text-xs uppercase text-on-surface-medium font-medium tracking-wider">
                        Finance
                    </div>
                    
                    <a href="{{ route('provider.earnings') }}" class="md-drawer-item {{ request()->routeIs('provider.earnings') ? 'active' : '' }}">
                        <span class="material-icons-outlined mr-3">payments</span>
                        <span>Earnings</span>
                    </a>
                    
                    <a href="{{ route('provider.invoices') }}" class="md-drawer-item {{ request()->routeIs('provider.invoices') ? 'active' : '' }}">
                        <span class="material-icons-outlined mr-3">receipt</span>
                        <span>Invoices</span>
                    </a>
                    
                    <div class="px-4 py-2 mt-4 text-xs uppercase text-on-surface-medium font-medium tracking-wider">
                        Account
                    </div>
                    
                    <a href="{{ route('provider.profile') }}" class="md-drawer-item {{ request()->routeIs('provider.profile') ? 'active' : '' }}">
                        <span class="material-icons-outlined mr-3">account_circle</span>
                        <span>Profile</span>
                    </a>
                    
                    <a href="{{ route('provider.services') }}" class="md-drawer-item {{ request()->routeIs('provider.services') ? 'active' : '' }}">
                        <span class="material-icons-outlined mr-3">build</span>
                        <span>My Services</span>
                    </a>
                    
                    <a href="{{ route('provider.settings') }}" class="md-drawer-item {{ request()->routeIs('provider.settings') ? 'active' : '' }}">
                        <span class="material-icons-outlined mr-3">settings</span>
                        <span>Settings</span>
                    </a>
                </nav>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64">
            <!-- App Bar -->
            <header class="md-app-bar bg-primary-600 text-white">
                <button class="md-drawer-toggle md:hidden" aria-label="Menu">
                    <span class="material-icons">menu</span>
                </button>
                
                <h1 class="md-app-bar-title">@yield('title', 'Dashboard')</h1>
                
                <div class="md-app-bar-actions">
                    <!-- Availability Toggle -->
                    <div class="flex items-center mr-4">
                        <span class="mr-2 hidden md:inline-block">Availability</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-white bg-opacity-20 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-white peer-focus:ring-opacity-20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-success-500"></div>
                        </label>
                    </div>
                    
                    <!-- Notifications -->
                    <div class="relative mx-2">
                        <button class="p-2 rounded-full hover:bg-white hover:bg-opacity-10 relative" aria-label="Notifications" data-tooltip="Notifications">
                            <span class="material-icons">notifications</span>
                            <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 rounded-full text-xs flex items-center justify-center">5</span>
                        </button>
                    </div>
                    
                    <!-- Theme Toggle -->
                    <button class="md-theme-toggle p-2 mx-2 rounded-full hover:bg-white hover:bg-opacity-10" aria-label="Toggle theme" data-tooltip="Toggle dark mode">
                        <span class="material-icons dark:hidden">dark_mode</span>
                        <span class="material-icons hidden dark:block">light_mode</span>
                    </button>
                    
                    <!-- User Menu -->
                    <div class="relative ml-2" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 p-1 rounded-full hover:bg-white hover:bg-opacity-10 focus:outline-none" aria-label="User menu">
                            <img src="{{ asset('images/avatar.jpg') }}" alt="User Avatar" class="h-8 w-8 rounded-full object-cover">
                            <span class="hidden md:block">{{ Auth::user()->name }}</span>
                            <span class="material-icons text-sm">arrow_drop_down</span>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-surface-1 rounded-md shadow-md z-50">
                            <div class="py-1">
                                <a href="{{ route('provider.profile') }}" class="block px-4 py-2 text-on-surface-high hover:bg-surface-3">
                                    <span class="material-icons-outlined text-sm mr-2">account_circle</span>
                                    Profile
                                </a>
                                <a href="{{ route('provider.settings') }}" class="block px-4 py-2 text-on-surface-high hover:bg-surface-3">
                                    <span class="material-icons-outlined text-sm mr-2">settings</span>
                                    Settings
                                </a>
                                <div class="border-t border-neutral-200 dark:border-neutral-700 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-on-surface-high hover:bg-surface-3">
                                        <span class="material-icons-outlined text-sm mr-2">logout</span>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6">
                <!-- Page Heading -->
                <div class="mb-6">
                    <h1 class="text-2xl font-medium text-on-surface-high">@yield('page-heading', 'Dashboard')</h1>
                    <p class="text-on-surface-medium">@yield('page-subheading')</p>
                </div>
                
                <!-- Content -->
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="py-4 px-6 border-t border-neutral-200 dark:border-neutral-700 bg-surface-1 text-on-surface-medium text-sm">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>
                        &copy; {{ date('Y') }} HT Roadside Assistance. All rights reserved.
                    </div>
                    <div class="mt-2 md:mt-0">
                        <a href="#" class="hover:text-primary-600 mr-4">Privacy Policy</a>
                        <a href="#" class="hover:text-primary-600 mr-4">Terms of Service</a>
                        <a href="#" class="hover:text-primary-600">Contact</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    @stack('modals')
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
    
    <script>
        // Initialize drawer for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const drawer = document.getElementById('main-drawer');
            const drawerToggle = document.querySelector('.md-drawer-toggle');
            const drawerClose = document.querySelector('.md-drawer-close');
            const overlay = document.getElementById('drawer-overlay');
            
            if (drawerToggle && drawer && overlay) {
                drawerToggle.addEventListener('click', function() {
                    drawer.classList.toggle('translate-x-0');
                    drawer.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                });
                
                if (drawerClose) {
                    drawerClose.addEventListener('click', function() {
                        drawer.classList.remove('translate-x-0');
                        drawer.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                    });
                }
                
                overlay.addEventListener('click', function() {
                    drawer.classList.remove('translate-x-0');
                    drawer.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }
            
            // Theme toggle
            const themeToggle = document.querySelector('.md-theme-toggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    document.documentElement.classList.toggle('dark');
                    const theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                    localStorage.setItem('theme', theme);
                    
                    // Send theme preference to server
                    fetch('/set-theme', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ theme })
                    });
                });
            }
        });
    </script>
</body>
</html>
