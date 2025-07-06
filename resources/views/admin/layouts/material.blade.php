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
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Roboto', sans-serif;
        }
        
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
            z-index: 1040;
            background-color: #fff;
            transition: all 0.3s ease;
        }
        
        .sidebar-collapsed {
            transform: translateX(-280px);
        }
        
        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
        }
        
        .main-content-expanded {
            margin-left: 0;
        }
        
        .nav-link {
            border-radius: 5px;
            margin: 5px 10px;
            color: #4f4f4f !important;
            font-weight: 400;
        }
        
        .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        .nav-link.active {
            background-color: #1266f1;
            color: white !important;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);
        }
        
        .nav-link i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .dropdown-menu {
            border-radius: 5px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            border: none;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.1), 0 2px 10px 0 rgba(0, 0, 0, 0.07);
            border: none;
            margin-bottom: 24px;
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
        
        .chip {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 500;
            margin-right: 5px;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .form-outline .form-control:focus ~ .form-label {
            color: #1266f1;
        }
        
        .form-outline .form-control:focus ~ .form-notch .form-notch-leading,
        .form-outline .form-control:focus ~ .form-notch .form-notch-middle,
        .form-outline .form-control:focus ~ .form-notch .form-notch-trailing {
            border-color: #1266f1;
            border-width: 2px;
        }
        
        .form-outline .form-control.active ~ .form-notch .form-notch-leading,
        .form-outline .form-control.active ~ .form-notch .form-notch-middle,
        .form-outline .form-control.active ~ .form-notch .form-notch-trailing {
            border-color: #1266f1;
            border-width: 2px;
        }
        
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #4f4f4f;
            font-weight: 500;
            padding: 15px 20px;
        }
        
        .nav-tabs .nav-link.active {
            border-bottom: 2px solid #1266f1;
            color: #1266f1;
            background-color: transparent;
            box-shadow: none;
        }
        
        .progress {
            height: 6px;
            border-radius: 3px;
        }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
        }
        
        .dropdown-toggle::after {
            display: none;
        }
        
        .page-header {
            margin-bottom: 24px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }
        
        .page-subtitle {
            font-size: 14px;
            color: #6c757d;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            padding: 3px 6px;
            border-radius: 50%;
            background-color: #f93154;
            color: white;
            font-size: 10px;
            font-weight: 500;
        }
        
        .divider {
            height: 1px;
            background-color: rgba(0, 0, 0, 0.1);
            margin: 15px 0;
        }
        
        .text-primary {
            color: #1266f1 !important;
        }
        
        .bg-primary {
            background-color: #1266f1 !important;
        }
        
        .text-success {
            color: #00b74a !important;
        }
        
        .bg-success {
            background-color: #00b74a !important;
        }
        
        .text-danger {
            color: #f93154 !important;
        }
        
        .bg-danger {
            background-color: #f93154 !important;
        }
        
        .text-warning {
            color: #ffa900 !important;
        }
        
        .bg-warning {
            background-color: #ffa900 !important;
        }
        
        .text-info {
            color: #39c0ed !important;
        }
        
        .bg-info {
            background-color: #39c0ed !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="sidebar" :class="{ 'sidebar-collapsed': !sidebarOpen }">
            <div class="d-flex flex-column h-100">
                <!-- Logo -->
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <img src="{{ asset('storage/' . settings('logo', 'logo.png')) }}" alt="Logo" class="me-2" height="40">
                        <span class="h5 mb-0 text-dark">Admin Panel</span>
                    </a>
                    <button @click="sidebarOpen = !sidebarOpen" class="btn btn-sm btn-outline-secondary d-lg-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Admin Info -->
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Admin" class="avatar me-3">
                        @else
                            <div class="avatar me-3 bg-primary d-flex align-items-center justify-content-center text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ Auth::user()->is_super_admin ? 'Super Admin' : 'Admin' }}</small>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="p-3 flex-grow-1 overflow-auto">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="material-icons-outlined">dashboard</i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.profile.show') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">person</i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.service-requests.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.service-requests.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">build</i>
                                <span>Service Requests</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}?role=service_provider" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.users.*') && request()->query('role') == 'service_provider' ? 'active' : '' }}">
                                <i class="material-icons-outlined">engineering</i>
                                <span>Service Providers</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.services.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">category</i>
                                <span>Service Types</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}?role=customer" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.users.*') && request()->query('role') == 'customer' ? 'active' : '' }}">
                                <i class="material-icons-outlined">people</i>
                                <span>Customers</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.plans.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">card_membership</i>
                                <span>Membership Plans</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.payments.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">payments</i>
                                <span>Payments</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.blog.posts.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">article</i>
                                <span>Blog</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.jobs.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">work</i>
                                <span>Jobs</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.job-applications.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.job-applications.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">description</i>
                                <span>Job Applications</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.edit') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">settings</i>
                                <span>Settings</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.api-settings.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.api-settings.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">api</i>
                                <span>API Settings</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.sales') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                                <i class="material-icons-outlined">bar_chart</i>
                                <span>Reports</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Logout -->
                <div class="p-3 border-top">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                            <i class="material-icons-outlined me-2">logout</i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content" :class="{ 'main-content-expanded': !sidebarOpen }">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm sticky-top">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between py-3">
                        <!-- Toggle Sidebar Button -->
                        <button @click="sidebarOpen = !sidebarOpen" class="btn btn-sm btn-outline-secondary d-none d-lg-block">
                            <i class="fas" :class="sidebarOpen ? 'fa-outdent' : 'fa-indent'"></i>
                        </button>
                        <button @click="sidebarOpen = !sidebarOpen" class="btn btn-sm btn-outline-secondary d-lg-none">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <!-- Right Side Actions -->
                        <div class="d-flex align-items-center">
                            <!-- Material Design Toggle -->
                            <a href="{{ route('toggle.design') }}" class="btn btn-sm btn-outline-primary me-3" title="Toggle Design Version">
                                @if(session('design_version', 'original') === 'material')
                                    <i class="fas fa-toggle-on me-2"></i> Material Design
                                @else
                                    <i class="fas fa-toggle-off me-2"></i> Original Design
                                @endif
                            </a>
                            
                            <!-- Notifications -->
                            <div class="dropdown me-3">
                                <a class="btn btn-sm btn-outline-secondary position-relative" href="#" role="button" id="notificationsDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons-outlined">notifications</i>
                                    <span class="notification-badge">3</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notificationsDropdown" style="width: 320px;">
                                    <li><h6 class="dropdown-header">Notifications</h6></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item p-2 rounded" href="#">
                                            <div class="d-flex">
                                                <div class="bg-primary rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="material-icons-outlined text-white">person_add</i>
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-bold">New provider registration</p>
                                                    <p class="text-muted mb-0 small">John Doe has registered as a service provider</p>
                                                    <p class="text-muted mb-0 small">10 minutes ago</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item p-2 rounded" href="#">
                                            <div class="d-flex">
                                                <div class="bg-success rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="material-icons-outlined text-white">build</i>
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-bold">New service request</p>
                                                    <p class="text-muted mb-0 small">A new service request has been submitted</p>
                                                    <p class="text-muted mb-0 small">30 minutes ago</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item p-2 rounded" href="#">
                                            <div class="d-flex">
                                                <div class="bg-warning rounded-circle p-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="material-icons-outlined text-white">payments</i>
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-bold">New payment received</p>
                                                    <p class="text-muted mb-0 small">$150 payment received for premium plan</p>
                                                    <p class="text-muted mb-0 small">1 hour ago</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-center text-primary" href="#">
                                            View all notifications
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- User Menu -->
                            <div class="dropdown">
                                <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="userDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Admin" class="avatar me-2">
                                    @else
                                        <div class="avatar me-2 bg-primary d-flex align-items-center justify-content-center text-white">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="d-none d-md-inline me-2">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                                            <i class="material-icons-outlined me-2" style="font-size: 18px;">person</i>
                                            My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.settings.edit') }}">
                                            <i class="material-icons-outlined me-2" style="font-size: 18px;">settings</i>
                                            Settings
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="material-icons-outlined me-2" style="font-size: 18px;">logout</i>
                                                Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="container-fluid px-4 py-4">
                <!-- Page Header -->
                <div class="page-header mb-4">
                    <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                    @if(isset($breadcrumbs))
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                @foreach($breadcrumbs as $label => $url)
                                    @if($loop->last)
                                        <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
                                    @else
                                        <li class="breadcrumb-item"><a href="{{ $url }}">{{ $label }}</a></li>
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                    @endif
                </div>
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <!-- Content -->
                @yield('content')
            </div>
            
            <!-- Footer -->
            <footer class="bg-white border-top p-3 text-center text-muted">
                <div class="container-fluid">
                    <p class="mb-0">
                        &copy; {{ date('Y') }} HT Roadside Assistance. All rights reserved.
                        <span class="mx-2">|</span>
                        <a href="{{ route('privacy') }}" class="text-muted">Privacy Policy</a>
                        <span class="mx-2">|</span>
                        <a href="{{ route('terms') }}" class="text-muted">Terms of Service</a>
                    </p>
                </div>
            </footer>
        </main>
    </div>
    
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
