<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Home') | {{ settings('site_name', 'HT Roadside Assistance') }}</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/' . settings('favicon', 'favicon.ico')) }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    
    <!-- Material Design CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet">
    <link href="{{ asset('css/material-design.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
        }
        
        .navbar {
            box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
        }
        
        .navbar-brand img {
            height: 40px;
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease-in-out;
        }
        
        .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }
        
        .btn {
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 10px 20px;
            text-transform: none;
            font-weight: 500;
        }
        
        .btn-sm {
            padding: 5px 10px;
        }
        
        .btn-floating {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.1), 0 2px 10px 0 rgba(0, 0, 0, 0.07);
            border: none;
            margin-bottom: 24px;
            overflow: hidden;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            background-color: white;
            padding: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .card-footer {
            border-radius: 0 0 10px 10px !important;
            background-color: white;
            padding: 15px 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .hero-section {
            background-color: #1266f1;
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/storage/{{ settings('hero_background', 'hero-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.2;
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .feature-card {
            height: 100%;
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 48px;
            color: #1266f1;
            margin-bottom: 20px;
        }
        
        .testimonial-card {
            height: 100%;
        }
        
        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);
        }
        
        .testimonial-quote {
            font-style: italic;
            position: relative;
            padding: 0 20px;
        }
        
        .testimonial-quote::before,
        .testimonial-quote::after {
            content: '"';
            font-size: 2rem;
            color: #1266f1;
            position: absolute;
        }
        
        .testimonial-quote::before {
            left: 0;
            top: -10px;
        }
        
        .testimonial-quote::after {
            right: 0;
            bottom: -30px;
        }
        
        .cta-section {
            background-color: #1266f1;
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        
        .footer {
            background-color: #fff;
            padding: 60px 0 30px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .footer-title {
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 20px;
            color: #333;
        }
        
        .footer-link {
            color: #6c757d;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: color 0.2s ease;
        }
        
        .footer-link:hover {
            color: #1266f1;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f8f9fa;
            color: #6c757d;
            margin-right: 10px;
            transition: all 0.2s ease;
        }
        
        .social-icon:hover {
            background-color: #1266f1;
            color: white;
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.25rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .hero-section {
                padding: 60px 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('storage/' . settings('logo', 'logo.png')) }}" alt="{{ settings('site_name', 'HT Roadside Assistance') }}">
            </a>
            
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('plans.*') ? 'active' : '' }}" href="{{ route('plans.index') }}">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->is_admin)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @elseif(Auth::user()->is_service_provider)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('provider.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i> Provider Dashboard
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i> My Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.profile') }}">
                                            <i class="fas fa-user me-2"></i> My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.service-history') }}">
                                            <i class="fas fa-history me-2"></i> Service History
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth
                    
                    <!-- Material Design Toggle -->
                    <li class="nav-item ms-2">
                        <a href="{{ route('toggle.design') }}" class="btn btn-sm btn-outline-secondary" title="Toggle Design Version">
                            @if(session('design_version', 'original') === 'material')
                                <i class="fas fa-toggle-on me-1"></i> Material
                            @else
                                <i class="fas fa-toggle-off me-1"></i> Original
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="{{ asset('storage/' . settings('logo', 'logo.png')) }}" alt="{{ settings('site_name', 'HT Roadside Assistance') }}" height="40" class="mb-4">
                    <p class="text-muted">{{ settings('site_description', 'Your reliable roadside assistance partner. We provide 24/7 emergency services to keep you moving.') }}</p>
                    
                    <div class="mt-4">
                        <a href="{{ settings('social_facebook', '#') }}" class="social-icon" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{ settings('social_twitter', '#') }}" class="social-icon" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="{{ settings('social_instagram', '#') }}" class="social-icon" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="{{ settings('social_linkedin', '#') }}" class="social-icon" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-title">Quick Links</h5>
                    <a href="{{ route('home') }}" class="footer-link">Home</a>
                    <a href="{{ route('services.index') }}" class="footer-link">Services</a>
                    <a href="{{ route('plans.index') }}" class="footer-link">Membership</a>
                    <a href="{{ route('about') }}" class="footer-link">About Us</a>
                    <a href="{{ route('contact') }}" class="footer-link">Contact</a>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-title">Services</h5>
                    <a href="{{ route('services.index') }}#towing" class="footer-link">Towing</a>
                    <a href="{{ route('services.index') }}#flat-tire" class="footer-link">Flat Tire</a>
                    <a href="{{ route('services.index') }}#battery-jump" class="footer-link">Battery Jump</a>
                    <a href="{{ route('services.index') }}#fuel-delivery" class="footer-link">Fuel Delivery</a>
                    <a href="{{ route('services.index') }}#lockout" class="footer-link">Lockout Service</a>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <h5 class="footer-title">Contact Us</h5>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i> {{ settings('address', '123 Main Street, City, Country') }}
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone me-2"></i> {{ settings('phone', '+1 (555) 123-4567') }}
                    </p>
                    <p class="mb-4">
                        <i class="fas fa-envelope me-2"></i> {{ settings('email', 'info@htroadside.com') }}
                    </p>
                    
                    <h5 class="footer-title">Emergency Service</h5>
                    <p class="mb-2">Available 24/7</p>
                    <a href="tel:{{ settings('emergency_phone', '+1 (555) 911-4567') }}" class="btn btn-danger">
                        <i class="fas fa-phone-alt me-2"></i> {{ settings('emergency_phone', '+1 (555) 911-4567') }}
                    </a>
                </div>
            </div>
            
            <div class="copyright mt-5">
                <p class="mb-0">
                    &copy; {{ date('Y') }} {{ settings('site_name', 'HT Roadside Assistance') }}. All rights reserved.
                    <span class="mx-2">|</span>
                    <a href="{{ route('privacy') }}" class="text-muted">Privacy Policy</a>
                    <span class="mx-2">|</span>
                    <a href="{{ route('terms') }}" class="text-muted">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>
    
    <!-- MDB JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
    
    <script>
        // Initialize all tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-mdb-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new mdb.Tooltip(tooltipTriggerEl);
            });
            
            // Initialize form inputs
            document.querySelectorAll('.form-outline').forEach((formOutline) => {
                new mdb.Input(formOutline).init();
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
