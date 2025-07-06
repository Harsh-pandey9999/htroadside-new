<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Home') | HT Roadside Assistance</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/' . settings('favicon', 'favicon.ico')) }}">
    
    <!-- Meta Tags -->
    <meta name="description" content="{{ settings('meta_description', 'HT Roadside Assistance - Professional roadside services you can trust 24/7. Fast response times and expert assistance when you need it most.') }}">
    <meta name="keywords" content="{{ settings('meta_keywords', 'roadside assistance, towing, car repair, emergency service, 24/7 help, vehicle breakdown, flat tire, battery jump, lockout service') }}">
    <meta name="author" content="HT Roadside Assistance">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Home') | HT Roadside Assistance">
    <meta property="og:description" content="{{ settings('og_description', settings('meta_description', 'HT Roadside Assistance - Professional roadside services you can trust 24/7. Fast response times and expert assistance when you need it most.')) }}">
    <meta property="og:image" content="{{ asset('storage/' . settings('og_image', 'images/og-image.jpg')) }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ settings('twitter_card', 'summary_large_image') }}">
    <meta name="twitter:title" content="@yield('title', 'Home') | HT Roadside Assistance">
    <meta name="twitter:description" content="{{ settings('twitter_description', settings('meta_description', 'HT Roadside Assistance - Professional roadside services you can trust 24/7. Fast response times and expert assistance when you need it most.')) }}">
    <meta name="twitter:image" content="{{ asset('storage/' . settings('twitter_image', settings('og_image', 'images/og-image.jpg'))) }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
                        dark: {
                            100: '#1E293B',
                            200: '#0F172A',
                            300: '#0D1424',
                            400: '#0B101E'
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        heading: ['Montserrat', 'sans-serif'],
                    },
                    backgroundImage: {
                        'hero-pattern': "url('/images/hero-bg.jpg')",
                    }
                },
            },
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS - Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        html {
            scroll-behavior: smooth;
        }
        
        .btn {
            @apply inline-flex items-center justify-center px-6 py-3 rounded-lg text-base font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2;
        }
        
        .btn-primary {
            @apply bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500 shadow-lg hover:shadow-xl btn-hover-effect;
        }
        
        .btn-secondary {
            @apply bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary-500 shadow-lg hover:shadow-xl btn-hover-effect;
        }
        
        .btn-outline {
            @apply border-2 border-primary-600 text-primary-600 hover:bg-primary-50 focus:ring-primary-500 btn-hover-effect;
        }
        
        .btn-white {
            @apply bg-white text-primary-600 hover:bg-gray-100 focus:ring-white shadow-lg hover:shadow-xl btn-hover-effect;
        }
        
        .nav-link {
            @apply text-gray-700 hover:text-primary-600 font-medium transition-colors dark:text-gray-300 dark:hover:text-primary-300;
        }
        
        .nav-link.active {
            @apply text-primary-600 font-semibold dark:text-primary-400;
        }
        
        .card {
            @apply bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden dark:bg-dark-100 dark:shadow-gray-900;
        }
        
        .section-title {
            @apply text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-heading dark:text-white;
        }
        
        .section-subtitle {
            @apply text-xl text-gray-600 mb-8 max-w-3xl mx-auto dark:text-gray-300;
        }
        
        .form-input {
            @apply w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-700 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:bg-dark-100 dark:border-gray-700 dark:text-gray-200;
        }
        
        .form-select {
            @apply w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-700 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:bg-dark-100 dark:border-gray-700 dark:text-gray-200;
        }
        
        .form-checkbox {
            @apply rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-dark-200;
        }
        
        .form-radio {
            @apply border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-dark-200;
        }
        
        /* Dark mode specific styles */
        .dark body {
            @apply bg-dark-200 text-gray-100;
        }
        
        .dark .bg-white {
            @apply bg-dark-100;
        }
        
        .dark .text-gray-900 {
            @apply text-white;
        }
        
        .dark .text-gray-800 {
            @apply text-gray-100;
        }
        
        .dark .text-gray-700 {
            @apply text-gray-200;
        }
        
        .dark .text-gray-600 {
            @apply text-gray-300;
        }
        
        .dark .text-gray-500 {
            @apply text-gray-400;
        }
        
        .dark .border-gray-200 {
            @apply border-gray-700;
        }
        
        .dark .border-gray-300 {
            @apply border-gray-700;
        }
        
        .dark .shadow-sm {
            @apply shadow-gray-900;
        }
        
        .dark .shadow-md {
            @apply shadow-gray-900;
        }
        
        .dark .shadow-lg {
            @apply shadow-gray-900;
        }
    </style>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <!-- Header -->
    <header x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow-sm sticky top-0 z-50">
        <!-- Top Bar -->
        <div class="bg-primary-900 text-white py-2">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-phone-alt mr-2"></i>
                            <span>{{ settings('contact_phone', '1-800-123-4567') }}</span>
                        </div>
                        <div class="hidden md:flex items-center text-sm">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>{{ settings('contact_email', 'info@htroadside.com') }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ settings('social_facebook', '#') }}" class="text-white hover:text-primary-200" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{ settings('social_twitter', '#') }}" class="text-white hover:text-primary-200" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="{{ settings('social_instagram', '#') }}" class="text-white hover:text-primary-200" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="{{ settings('social_linkedin', '#') }}" class="text-white hover:text-primary-200" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <div class="theme-switch-wrapper ml-3 pl-3 border-l border-primary-700">
                            <label class="theme-switch" for="theme-toggle">
                                <input type="checkbox" id="theme-toggle" />
                                <span class="slider round"></span>
                            </label>
                            <span class="ml-2 text-xs hidden md:inline-block">Dark Mode</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('storage/' . settings('logo', 'logo.png')) }}" alt="{{ settings('site_name', 'HT Roadside') }}" class="h-10">
                        <span class="ml-3 text-xl font-bold text-gray-900">{{ settings('site_name', 'HT Roadside') }}</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services*') ? 'active' : '' }}">Services</a>
                    <a href="{{ route('plans.index') }}" class="nav-link {{ request()->routeIs('plans*') ? 'active' : '' }}">Plans</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                    <a href="{{ route('work-with-us') }}" class="nav-link {{ request()->routeIs('work-with-us') ? 'active' : '' }}">Careers</a>
                </nav>
                
                <!-- Desktop User Menu -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 focus:outline-none">
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full">
                                <span>{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                @php
                                    $dashboardRoute = 'home';
                                    $serviceRequestsRoute = 'home';
                                    $paymentsRoute = 'home';
                                    $profileRoute = 'profile.show';
                                    
                                    if (auth()->check()) {
                                        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')) {
                                            $dashboardRoute = 'admin.dashboard';
                                            $serviceRequestsRoute = 'admin.service-requests.index';
                                            $paymentsRoute = 'admin.payments.index';
                                            $profileRoute = 'profile.show';
                                        } elseif (auth()->user()->hasRole('service-provider')) {
                                            $dashboardRoute = 'provider.dashboard';
                                            $serviceRequestsRoute = 'provider.service-requests.index';
                                            $paymentsRoute = 'provider.payments.index';
                                            $profileRoute = 'provider.profile.edit';
                                        } elseif (auth()->user()->hasRole('customer')) {
                                            $dashboardRoute = 'customer.dashboard';
                                            $serviceRequestsRoute = 'customer.service-requests.index';
                                            $paymentsRoute = 'customer.payments.index';
                                            $profileRoute = 'profile.show';
                                        }
                                    }
                                @endphp
                                <a href="{{ route($dashboardRoute) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                </a>
                                <a href="{{ route($profileRoute) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a>
                                <a href="{{ route($serviceRequestsRoute) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-wrench mr-2"></i> Service Requests
                                </a>
                                <a href="{{ route($paymentsRoute) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-credit-card mr-2"></i> Payments
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
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600 font-medium">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-primary py-2 px-4">Sign up</a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-primary-600 focus:outline-none">
                        <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden py-3 border-t border-gray-200">
                <nav class="flex flex-col space-y-3 pb-3 border-b border-gray-200">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services*') ? 'active' : '' }}">Services</a>
                    <a href="{{ route('plans.index') }}" class="nav-link {{ request()->routeIs('plans*') ? 'active' : '' }}">Plans</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                    <a href="{{ route('work-with-us') }}" class="nav-link {{ request()->routeIs('work-with-us') ? 'active' : '' }}">Careers</a>
                </nav>
                
                <div class="pt-3">
                    @auth
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full">
                                <span class="ml-2 font-medium">{{ auth()->user()->name }}</span>
                            </div>
                            <button @click="userMenuOpen = !userMenuOpen" class="text-gray-500 focus:outline-none">
                                <i class="fas" :class="userMenuOpen ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                        </div>
                        
                        <div x-show="userMenuOpen" x-transition class="mt-3 space-y-3">
                            <a href="{{ route($dashboardRoute) }}" class="block text-gray-700 hover:text-primary-600">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                            <a href="{{ route($profileRoute) }}" class="block text-gray-700 hover:text-primary-600">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <a href="{{ route($serviceRequestsRoute) }}" class="block text-gray-700 hover:text-primary-600">
                                <i class="fas fa-wrench mr-2"></i> Service Requests
                            </a>
                            <a href="{{ route($paymentsRoute) }}" class="block text-gray-700 hover:text-primary-600">
                                <i class="fas fa-credit-card mr-2"></i> Payments
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left text-red-600 hover:text-red-800">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex flex-col space-y-3">
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600 font-medium">Log in</a>
                            <a href="{{ route('register') }}" class="btn btn-primary w-full text-center">Sign up</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-6">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('storage/' . settings('logo', 'logo-white.png')) }}" alt="{{ settings('site_name', 'HT Roadside') }}" class="h-10">
                        <span class="ml-3 text-xl font-bold">{{ settings('site_name', 'HT Roadside') }}</span>
                    </div>
                    <p class="text-gray-400 mb-4">{{ settings('site_description', 'Your reliable partner on the road. We provide 24/7 roadside assistance services to keep you moving.') }}</p>
                    <div class="flex space-x-4">
                        <a href="{{ settings('social_facebook', '#') }}" class="text-gray-400 hover:text-white transition-colors" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{ settings('social_twitter', '#') }}" class="text-gray-400 hover:text-white transition-colors" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="{{ settings('social_instagram', '#') }}" class="text-gray-400 hover:text-white transition-colors" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="{{ settings('social_linkedin', '#') }}" class="text-gray-400 hover:text-white transition-colors" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('services.index') }}" class="text-gray-400 hover:text-white transition-colors">Services</a></li>
                        <li><a href="{{ route('plans.index') }}" class="text-gray-400 hover:text-white transition-colors">Plans</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="{{ route('careers.index') }}" class="text-gray-400 hover:text-white transition-colors">Careers</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Our Services</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('services.show', 'towing') }}" class="text-gray-400 hover:text-white transition-colors">Towing</a></li>
                        <li><a href="{{ route('services.show', 'jump-start') }}" class="text-gray-400 hover:text-white transition-colors">Jump Start</a></li>
                        <li><a href="{{ route('services.show', 'flat-tire') }}" class="text-gray-400 hover:text-white transition-colors">Flat Tire</a></li>
                        <li><a href="{{ route('services.show', 'fuel-delivery') }}" class="text-gray-400 hover:text-white transition-colors">Fuel Delivery</a></li>
                        <li><a href="{{ route('services.show', 'lockout') }}" class="text-gray-400 hover:text-white transition-colors">Lockout Service</a></li>
                        <li><a href="{{ route('services.show', 'battery-replacement') }}" class="text-gray-400 hover:text-white transition-colors">Battery Replacement</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary-500"></i>
                            <span class="text-gray-400">{{ settings('address', '123 Roadside Ave, City, State 12345') }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-primary-500"></i>
                            <span class="text-gray-400">{{ settings('contact_phone', '1-800-123-4567') }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary-500"></i>
                            <span class="text-gray-400">{{ settings('contact_email', 'info@htroadside.com') }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-primary-500"></i>
                            <span class="text-gray-400">24/7 Emergency Service</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-400 mb-4 md:mb-0">
                        &copy; {{ date('Y') }} {{ settings('site_name', 'HT Roadside') }}. All rights reserved.
                    </div>
                    <div class="flex space-x-6">
                        <a href="{{ route('terms') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                        <a href="{{ route('privacy') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                        <a href="{{ route('cookies') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Emergency Call Button (Fixed) -->
    <div class="fixed bottom-6 right-6 z-40">
        <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '18001234567')) }}" class="flex items-center bg-red-600 text-white rounded-full px-4 py-3 shadow-lg hover:bg-red-700 transition-colors">
            <i class="fas fa-phone-alt mr-2"></i>
            <span class="font-medium">Emergency</span>
        </a>
    </div>
    
    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-6 left-6 z-40 bg-primary-600 text-white rounded-full p-3 shadow-lg hover:bg-primary-700 transition-colors opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Scripts -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Back to Top Button
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                    backToTopButton.classList.add('opacity-100', 'visible');
                } else {
                    backToTopButton.classList.remove('opacity-100', 'visible');
                    backToTopButton.classList.add('opacity-0', 'invisible');
                }
            });
            
            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
    
    @stack('scripts')
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>
</body>
</html>
