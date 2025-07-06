@extends('layouts.public-material')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">Fast & Reliable Roadside Assistance</h1>
                <p class="hero-subtitle">24/7 emergency services to keep you moving. Professional help is just a click away.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('request-service') }}" class="btn btn-light btn-lg">
                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">build</i>
                        Request Service
                    </a>
                    <a href="{{ route('plans.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">card_membership</i>
                        View Memberships
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="{{ asset('storage/' . settings('hero_image', 'hero.png')) }}" alt="Roadside Assistance" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Services</h2>
            <p class="text-muted">Professional roadside assistance services for all your needs</p>
        </div>
        
        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                                <i class="material-icons-outlined feature-icon text-primary">{{ $service->icon ?? 'build' }}</i>
                            </div>
                            <h4 class="card-title">{{ $service->name }}</h4>
                            <p class="card-text text-muted">{{ $service->short_description }}</p>
                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-outline-primary mt-3">Learn More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('services.index') }}" class="btn btn-primary">
                View All Services
                <i class="material-icons-outlined ms-2" style="vertical-align: middle;">arrow_forward</i>
            </a>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">How It Works</h2>
            <p class="text-muted">Get roadside assistance in three simple steps</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 60px; height: 60px; align-items: center; justify-content: center;">
                            <span class="fw-bold">1</span>
                        </div>
                        <h4>Request Service</h4>
                        <p class="text-muted">Use our app or website to request roadside assistance with your location.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 60px; height: 60px; align-items: center; justify-content: center;">
                            <span class="fw-bold">2</span>
                        </div>
                        <h4>Provider Assignment</h4>
                        <p class="text-muted">We'll assign the nearest qualified service provider to your location.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 60px; height: 60px; align-items: center; justify-content: center;">
                            <span class="fw-bold">3</span>
                        </div>
                        <h4>Get Assistance</h4>
                        <p class="text-muted">Track your provider in real-time and get the help you need quickly.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">What Our Customers Say</h2>
            <p class="text-muted">Trusted by thousands of drivers nationwide</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card testimonial-card h-100">
                    <div class="card-body text-center p-4">
                        <img src="{{ asset('storage/testimonials/user1.jpg') }}" alt="Customer" class="testimonial-avatar">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-quote mb-3">HT Roadside saved me when I had a flat tire on the highway. The provider arrived in just 20 minutes and got me back on the road quickly!</p>
                        <h5 class="mb-0">Sarah Johnson</h5>
                        <p class="text-muted small">Premium Member</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card testimonial-card h-100">
                    <div class="card-body text-center p-4">
                        <img src="{{ asset('storage/testimonials/user2.jpg') }}" alt="Customer" class="testimonial-avatar">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-quote mb-3">I locked my keys in my car and was panicking. HT Roadside's lockout service was prompt and professional. Highly recommend their membership!</p>
                        <h5 class="mb-0">Michael Rodriguez</h5>
                        <p class="text-muted small">Basic Member</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card testimonial-card h-100">
                    <div class="card-body text-center p-4">
                        <img src="{{ asset('storage/testimonials/user3.jpg') }}" alt="Customer" class="testimonial-avatar">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <p class="testimonial-quote mb-3">The battery jump service was excellent. The app made it easy to request help and track the provider. Great value for the membership fee!</p>
                        <h5 class="mb-0">Jennifer Lee</h5>
                        <p class="text-muted small">Premium Member</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Membership Plans Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Membership Plans</h2>
            <p class="text-muted">Choose the plan that fits your needs</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header text-center bg-primary text-white py-4">
                        <h3 class="mb-0">Basic</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <span class="display-4 fw-bold">$79</span>
                            <span class="text-muted">/year</span>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                4 service calls per year
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Towing up to 5 miles
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Flat tire service
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Battery jump service
                            </li>
                            <li class="mb-3 text-muted">
                                <i class="material-icons-outlined text-muted me-2" style="vertical-align: middle;">cancel</i>
                                Fuel delivery service
                            </li>
                            <li class="mb-3 text-muted">
                                <i class="material-icons-outlined text-muted me-2" style="vertical-align: middle;">cancel</i>
                                Lockout service
                            </li>
                        </ul>
                        <div class="text-center mt-4">
                            <a href="{{ route('plans.index') }}#basic" class="btn btn-outline-primary btn-lg w-100">Choose Plan</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-header text-center bg-primary text-white py-4">
                        <h3 class="mb-0">Premium</h3>
                        <span class="badge bg-warning text-dark mt-2">Most Popular</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <span class="display-4 fw-bold">$149</span>
                            <span class="text-muted">/year</span>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                <strong>Unlimited</strong> service calls
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Towing up to 25 miles
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Flat tire service
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Battery jump service
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Fuel delivery service
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Lockout service
                            </li>
                        </ul>
                        <div class="text-center mt-4">
                            <a href="{{ route('plans.index') }}#premium" class="btn btn-primary btn-lg w-100">Choose Plan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('plans.index') }}" class="btn btn-outline-primary">
                View All Plans
                <i class="material-icons-outlined ms-2" style="vertical-align: middle;">arrow_forward</i>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 class="fw-bold mb-4">Ready to Get Started?</h2>
        <p class="lead mb-4">Join thousands of satisfied customers who trust HT Roadside Assistance</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                <i class="material-icons-outlined me-2" style="vertical-align: middle;">person_add</i>
                Sign Up Now
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                <i class="material-icons-outlined me-2" style="vertical-align: middle;">contact_support</i>
                Contact Us
            </a>
        </div>
    </div>
</section>

<!-- App Download Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4">Download Our Mobile App</h2>
                <p class="lead mb-4">Get roadside assistance at your fingertips with our easy-to-use mobile app.</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-3">
                        <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                        Request service with just a few taps
                    </li>
                    <li class="mb-3">
                        <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                        Track your service provider in real-time
                    </li>
                    <li class="mb-3">
                        <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                        Manage your membership and payment details
                    </li>
                    <li class="mb-3">
                        <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                        Access your service history and receipts
                    </li>
                </ul>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#" class="btn btn-dark">
                        <i class="fab fa-apple me-2"></i>
                        App Store
                    </a>
                    <a href="#" class="btn btn-dark">
                        <i class="fab fa-google-play me-2"></i>
                        Google Play
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('storage/app-mockup.png') }}" alt="Mobile App" class="img-fluid rounded shadow" style="max-height: 500px;">
            </div>
        </div>
    </div>
</section>
@endsection
