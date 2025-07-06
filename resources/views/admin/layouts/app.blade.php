<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard') | HT Roadside Assistance</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/' . settings('favicon', 'favicon.ico')) }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#082f49',
                        },
                        secondary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                            950: '#2e1065',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        .sidebar-item {
            @apply flex items-center gap-3 px-4 py-3 text-gray-600 transition-colors rounded-lg hover:bg-primary-50 hover:text-primary-700;
        }
        
        .sidebar-item.active {
            @apply bg-primary-50 text-primary-700 font-medium;
        }
        
        .sidebar-item i {
            @apply text-lg;
        }
        
        .card {
            @apply bg-white rounded-xl shadow-sm border border-gray-100 p-6;
        }
        
        .btn {
            @apply px-4 py-2 rounded-lg text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2;
        }
        
        .btn-primary {
            @apply bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500;
        }
        
        .btn-secondary {
            @apply bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary-500;
        }
        
        .btn-success {
            @apply bg-green-600 text-white hover:bg-green-700 focus:ring-green-500;
        }
        
        .btn-danger {
            @apply bg-red-600 text-white hover:bg-red-700 focus:ring-red-500;
        }
        
        .btn-warning {
            @apply bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-400;
        }
        
        .btn-info {
            @apply bg-sky-500 text-white hover:bg-sky-600 focus:ring-sky-400;
        }
        
        .btn-light {
            @apply bg-gray-200 text-gray-800 hover:bg-gray-300 focus:ring-gray-100;
        }
        
        .btn-dark {
            @apply bg-gray-800 text-white hover:bg-gray-900 focus:ring-gray-700;
        }
        
        .btn-outline {
            @apply border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-gray-200;
        }
        
        .form-input {
            @apply w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500;
        }
        
        .form-select {
            @apply w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500;
        }
        
        .form-checkbox {
            @apply rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50;
        }
        
        .form-radio {
            @apply border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50;
        }
        
        .badge {
            @apply inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium;
        }
        
        .badge-blue {
            @apply bg-blue-100 text-blue-800;
        }
        
        .badge-green {
            @apply bg-green-100 text-green-800;
        }
        
        .badge-red {
            @apply bg-red-100 text-red-800;
        }
        
        .badge-yellow {
            @apply bg-yellow-100 text-yellow-800;
        }
        
        .badge-purple {
            @apply bg-purple-100 text-purple-800;
        }
        
        .badge-indigo {
            @apply bg-indigo-100 text-indigo-800;
        }
        
        .badge-gray {
            @apply bg-gray-100 text-gray-800;
        }
        
        .table-responsive {
            @apply overflow-x-auto;
        }
        
        .table {
            @apply min-w-full divide-y divide-gray-200;
        }
        
        .table thead {
            @apply bg-gray-50;
        }
        
        .table th {
            @apply px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
        }
        
        .table tbody {
            @apply divide-y divide-gray-200 bg-white;
        }
        
        .table td {
            @apply px-6 py-4 whitespace-nowrap text-sm text-gray-500;
        }
    </style>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 shadow-sm transform transition-transform duration-300 lg:translate-x-0"
               :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 border-b border-gray-200">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('storage/' . settings('logo', 'logo.png')) }}" alt="Logo" class="h-8">
                        <span class="text-xl font-bold text-gray-900">HT Roadside</span>
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                    
                    <a href="{{ route('admin.service-requests.index') }}" class="sidebar-item {{ request()->routeIs('admin.service-requests.*') ? 'active' : '' }}">
                        <i class="fas fa-wrench"></i>
                        <span>Service Requests</span>
                    </a>
                    
                    <a href="{{ route('admin.services.index') }}" class="sidebar-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i>
                        <span>Services</span>
                    </a>
                    
                    <a href="{{ route('admin.plans.index') }}" class="sidebar-item {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Plans</span>
                    </a>
                    
                    <a href="{{ route('admin.payments.index') }}" class="sidebar-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                        <i class="fas fa-credit-card"></i>
                        <span>Payments</span>
                    </a>
                    
                    <a href="{{ route('admin.job-applications.index') }}" class="sidebar-item {{ request()->routeIs('admin.job-applications.*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i>
                        <span>Job Applications</span>
                    </a>
                    
                    <div x-data="{ openCareers: {{ request()->routeIs('admin.careers.*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="openCareers = !openCareers" class="sidebar-item w-full flex justify-between {{ request()->routeIs('admin.careers.*') ? 'active' : '' }}">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-building"></i>
                                <span>Careers</span>
                            </div>
                            <i class="fas" :class="openCareers ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                        </button>
                        <div x-show="openCareers" class="pl-10 space-y-1 mt-1">
                            <a href="{{ route('admin.careers.index') }}" class="sidebar-item {{ request()->routeIs('admin.careers.index') ? 'active' : '' }}">
                                <i class="fas fa-list"></i>
                                <span>All Job Postings</span>
                            </a>
                            <a href="{{ route('admin.careers.create') }}" class="sidebar-item {{ request()->routeIs('admin.careers.create') ? 'active' : '' }}">
                                <i class="fas fa-plus"></i>
                                <span>Add New Job</span>
                            </a>
                            <a href="{{ route('admin.careers.all-applications') }}" class="sidebar-item {{ request()->routeIs('admin.careers.all-applications') ? 'active' : '' }}">
                                <i class="fas fa-file-alt"></i>
                                <span>All Applications</span>
                            </a>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="space-y-1">
                        <button @click="open = !open" class="sidebar-item w-full flex justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-chart-bar"></i>
                                <span>Reports</span>
                            </div>
                            <i class="fas" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                        </button>
                        
                        <div x-show="open" x-collapse class="pl-10 space-y-1">
                            <a href="{{ route('admin.reports.sales') }}" class="sidebar-item {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                                <span>Sales Report</span>
                            </a>
                            <a href="{{ route('admin.reports.services') }}" class="sidebar-item {{ request()->routeIs('admin.reports.services') ? 'active' : '' }}">
                                <span>Services Report</span>
                            </a>
                            <a href="{{ route('admin.reports.providers') }}" class="sidebar-item {{ request()->routeIs('admin.reports.providers') ? 'active' : '' }}">
                                <span>Providers Report</span>
                            </a>
                            <a href="{{ route('admin.reports.customers') }}" class="sidebar-item {{ request()->routeIs('admin.reports.customers') ? 'active' : '' }}">
                                <span>Customers Report</span>
                            </a>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="space-y-1">
                        <button @click="open = !open" class="sidebar-item w-full flex justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </div>
                            <i class="fas" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                        </button>
                        
                        <div x-show="open" x-collapse class="pl-10 space-y-1">
                            <a href="{{ route('admin.settings.index') }}" class="sidebar-item {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                                <span>General</span>
                            </a>
                            <a href="{{ route('admin.settings.seo') }}" class="sidebar-item {{ request()->routeIs('admin.settings.seo') ? 'active' : '' }}">
                                <span>SEO</span>
                            </a>
                            <a href="{{ route('admin.settings.email') }}" class="sidebar-item {{ request()->routeIs('admin.settings.email') ? 'active' : '' }}">
                                <span>Email</span>
                            </a>
                            <a href="{{ route('admin.settings.payment') }}" class="sidebar-item {{ request()->routeIs('admin.settings.payment') ? 'active' : '' }}">
                                <span>Payment</span>
                            </a>
                            <a href="{{ route('admin.settings.notifications') }}" class="sidebar-item {{ request()->routeIs('admin.settings.notifications') ? 'active' : '' }}">
                                <span>Notifications</span>
                            </a>
                            <a href="{{ route('admin.settings.backup') }}" class="sidebar-item {{ request()->routeIs('admin.settings.backup') ? 'active' : '' }}">
                                <span>Backup</span>
                            </a>
                        </div>
                    </div>
                </nav>
                
                <!-- User Menu -->
                <div class="p-4 border-t border-gray-200">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center w-full space-x-3 text-left">
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition class="absolute bottom-full left-0 right-0 mb-2 bg-white border border-gray-200 rounded-lg shadow-lg">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Bar -->
            <header class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 lg:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-md ml-4 lg:ml-0">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" placeholder="Search..." class="w-full py-2 pl-10 pr-4 text-sm bg-gray-100 border-none rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:bg-white">
                        </div>
                    </div>
                    
                    <!-- Right Side Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Material Design Toggle -->
                        <a href="{{ route('toggle.design') }}" class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none" title="Toggle Design Version">
                            <span class="sr-only">Toggle Design</span>
                            @if(session('design_version', 'original') === 'material')
                                <i class="fas fa-toggle-on text-primary-600"></i>
                                <span class="text-xs font-medium ml-1">Material</span>
                            @else
                                <i class="fas fa-toggle-off text-gray-400"></i>
                                <span class="text-xs font-medium ml-1">Original</span>
                            @endif
                        </a>
                        
                        <!-- Notifications -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                                <span class="sr-only">Notifications</span>
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 w-80 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg">
                                <div class="p-3 border-b border-gray-200">
                                    <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <a href="#" class="block p-4 border-b border-gray-100 hover:bg-gray-50">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 pt-0.5">
                                                <i class="fas fa-wrench text-primary-500"></i>
                                            </div>
                                            <div class="ml-3 w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900">New service request</p>
                                                <p class="text-xs text-gray-500">John Doe requested a towing service</p>
                                                <p class="mt-1 text-xs text-gray-400">5 minutes ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block p-4 border-b border-gray-100 hover:bg-gray-50">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 pt-0.5">
                                                <i class="fas fa-credit-card text-green-500"></i>
                                            </div>
                                            <div class="ml-3 w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900">Payment received</p>
                                                <p class="text-xs text-gray-500">$150.00 for Premium Plan</p>
                                                <p class="mt-1 text-xs text-gray-400">1 hour ago</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-t border-gray-200">
                                    <a href="#" class="block px-4 py-2 text-xs font-medium text-center text-primary-600 hover:text-primary-800">
                                        View all notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                                <span class="sr-only">Quick Actions</span>
                                <i class="fas fa-plus"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 w-48 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg">
                                <a href="{{ route('admin.service-requests.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-wrench mr-2"></i> New Service Request
                                </a>
                                <a href="{{ route('admin.users.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-plus mr-2"></i> Add User
                                </a>
                                <a href="{{ route('admin.services.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Add Service
                                </a>
                                <a href="{{ route('admin.plans.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tag mr-2"></i> Add Plan
                                </a>
                            </div>
                        </div>
                        
                        <!-- Help -->
                        <a href="#" class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                            <span class="sr-only">Help</span>
                            <i class="fas fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Page Heading -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
                    @if(isset($breadcrumbs))
                        <nav class="flex mt-1" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-home mr-1"></i> Home
                                    </a>
                                </li>
                                @foreach($breadcrumbs as $breadcrumb)
                                    <li>
                                        <div class="flex items-center">
                                            <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                                            @if(isset($breadcrumb['url']))
                                                <a href="{{ $breadcrumb['url'] }}" class="text-sm text-gray-500 hover:text-gray-700">
                                                    {{ $breadcrumb['name'] }}
                                                </a>
                                            @else
                                                <span class="text-sm text-gray-700">{{ $breadcrumb['name'] }}</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </nav>
                    @endif
                </div>
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-green-800">{{ session('success') }}</span>
                            <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <span class="text-red-800">{{ session('error') }}</span>
                            <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if(session('warning'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                            <span class="text-yellow-800">{{ session('warning') }}</span>
                            <button @click="show = false" class="ml-auto text-yellow-500 hover:text-yellow-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if(session('info'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                            <span class="text-blue-800">{{ session('info') }}</span>
                            <button @click="show = false" class="ml-auto text-blue-500 hover:text-blue-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                <!-- Content -->
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} HT Roadside Assistance. All rights reserved.
                    </div>
                    <div class="mt-2 md:mt-0 text-sm text-gray-500">
                        Version 1.0.0 | <a href="#" class="text-primary-600 hover:text-primary-800">Documentation</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
