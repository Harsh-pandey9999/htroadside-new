<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - HT Roadside Assistance</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-primary-800 text-white w-64 py-4 flex-shrink-0 hidden md:block">
            <div class="px-4">
                <div class="flex items-center justify-center mb-8">
                    <a href="{{ route('admin.dashboard') }}" class="text-white text-xl font-bold">
                        HT Roadside Admin
                    </a>
                </div>
                
                <nav class="mt-8">
                    <div class="px-4 mb-3 text-xs font-semibold text-primary-200 uppercase tracking-wider">
                        Main
                    </div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt w-5 text-center mr-2"></i> Dashboard
                    </a>
                    
                    <a href="{{ route('admin.service-requests.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.service-requests.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                        <i class="fas fa-truck w-5 text-center mr-2"></i> Service Requests
                    </a>
                    
                    <div class="px-4 mb-3 mt-6 text-xs font-semibold text-primary-200 uppercase tracking-wider">
                        Blog Management
                    </div>
                    
                    <a href="{{ route('admin.blog.posts.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.blog.posts.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                        <i class="fas fa-file-alt w-5 text-center mr-2"></i> Posts
                    </a>
                    
                    <a href="{{ route('admin.blog.categories.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.blog.categories.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                        <i class="fas fa-folder w-5 text-center mr-2"></i> Categories
                    </a>
                    
                    <a href="{{ route('admin.blog.tags.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.blog.tags.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                        <i class="fas fa-tags w-5 text-center mr-2"></i> Tags
                    </a>
                    
                    <a href="{{ route('admin.blog.comments.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.blog.comments.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                        <i class="fas fa-comments w-5 text-center mr-2"></i> Comments
                    </a>
                    
                    <div class="px-4 mb-3 mt-6 text-xs font-semibold text-primary-200 uppercase tracking-wider">
                        Settings
                    </div>
                    
                    <a href="{{ route('admin.api-settings.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.api-settings.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                        <i class="fas fa-key w-5 text-center mr-2"></i> API Settings
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.users.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                        <i class="fas fa-users w-5 text-center mr-2"></i> Users
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between h-16 px-4">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="md:hidden text-gray-500 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Search -->
                    <div class="relative flex-1 max-w-xs ml-4 md:ml-0">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" placeholder="Search..." class="form-input w-full pl-10 py-2 rounded-lg text-sm">
                    </div>
                    
                    <!-- Right Side -->
                    <div class="flex items-center">
                        <!-- Notifications -->
                        <div class="relative mr-4">
                            <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                            </button>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center focus:outline-none">
                                <img src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full mr-2">
                                <span class="hidden md:block text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down ml-2 text-xs text-gray-400"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a>
                                <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Mobile Sidebar (Hidden by default) -->
            <div id="mobile-sidebar" class="fixed inset-0 z-40 hidden">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
                <div class="fixed inset-y-0 left-0 max-w-xs w-full bg-primary-800 text-white">
                    <div class="flex items-center justify-between h-16 px-4 border-b border-primary-700">
                        <div class="text-xl font-bold">HT Roadside Admin</div>
                        <button id="close-mobile-menu" class="text-white focus:outline-none">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="overflow-y-auto h-full pb-16">
                        <nav class="mt-4 px-2">
                            <div class="px-4 mb-3 text-xs font-semibold text-primary-200 uppercase tracking-wider">
                                Main
                            </div>
                            
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                                <i class="fas fa-tachometer-alt w-5 text-center mr-2"></i> Dashboard
                            </a>
                            
                            <a href="{{ route('admin.service-requests.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.service-requests.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                                <i class="fas fa-truck w-5 text-center mr-2"></i> Service Requests
                            </a>
                            
                            <div class="px-4 mb-3 mt-6 text-xs font-semibold text-primary-200 uppercase tracking-wider">
                                Blog Management
                            </div>
                            
                            <a href="{{ route('admin.blog.posts.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.blog.posts.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                                <i class="fas fa-file-alt w-5 text-center mr-2"></i> Posts
                            </a>
                            
                            <a href="{{ route('admin.blog.categories.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.blog.categories.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                                <i class="fas fa-folder w-5 text-center mr-2"></i> Categories
                            </a>
                            
                            <a href="{{ route('admin.blog.tags.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.blog.tags.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                                <i class="fas fa-tags w-5 text-center mr-2"></i> Tags
                            </a>
                            
                            <a href="{{ route('admin.blog.comments.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.blog.comments.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                                <i class="fas fa-comments w-5 text-center mr-2"></i> Comments
                            </a>
                            
                            <div class="px-4 mb-3 mt-6 text-xs font-semibold text-primary-200 uppercase tracking-wider">
                                Settings
                            </div>
                            
                            <a href="{{ route('admin.api-settings.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.api-settings.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                                <i class="fas fa-key w-5 text-center mr-2"></i> API Settings
                            </a>
                            
                            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.users.*') ? 'bg-primary-700 text-white' : 'text-primary-200 hover:bg-primary-700 hover:text-white' }}">
                                <i class="fas fa-users w-5 text-center mr-2"></i> Users
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <!-- Page Heading -->
                <div class="bg-white shadow-sm">
                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            @yield('header', 'Dashboard')
                        </h1>
                        @yield('breadcrumbs')
                    </div>
                </div>
                
                <!-- Page Content -->
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm">{{ session('success') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button class="inline-flex bg-green-100 text-green-500 rounded-md p-1.5 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <span class="sr-only">Dismiss</span>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm">{{ session('error') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button class="inline-flex bg-red-100 text-red-500 rounded-md p-1.5 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <span class="sr-only">Dismiss</span>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('modals')
    
    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMobileMenuButton = document.getElementById('close-mobile-menu');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            
            if (mobileMenuButton && mobileSidebar && closeMobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileSidebar.classList.remove('hidden');
                });
                
                closeMobileMenuButton.addEventListener('click', function() {
                    mobileSidebar.classList.add('hidden');
                });
            }
            
            // Alert dismissal
            const alertDismissButtons = document.querySelectorAll('[role="alert"] button');
            alertDismissButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const alert = this.closest('[role="alert"]');
                    alert.remove();
                });
            });
        });
    </script>
</body>
</html>
