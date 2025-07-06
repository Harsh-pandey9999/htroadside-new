@extends('layouts.public-material')

@section('title', 'Our Services')

@section('content')
<!-- Services Hero Section -->
<section class="hero-section services-hero">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">Our Services</h1>
                <p class="hero-subtitle">Professional roadside assistance services for all your needs</p>
            </div>
        </div>
    </div>
</section>

<!-- Services List Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                    <i class="material-icons-outlined text-primary">{{ $service->icon ?? 'build' }}</i>
                                </div>
                                <h4 class="card-title mb-0">{{ $service->name }}</h4>
                            </div>
                            <p class="card-text text-muted">{{ $service->short_description }}</p>
                            <div class="mt-3">
                                <a href="{{ route('services.show', $service->slug) }}" class="btn btn-outline-primary">
                                    Learn More
                                    <i class="material-icons-outlined ms-1" style="vertical-align: middle; font-size: 18px;">arrow_forward</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="fw-bold">Why Choose HT Roadside Assistance?</h2>
                <p class="text-muted">We're committed to providing fast, reliable service when you need it most</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 70px; height: 70px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 32px;">timer</i>
                        </div>
                        <h4>Fast Response Time</h4>
                        <p class="text-muted">Our average response time is under 30 minutes, so you won't be left stranded for long.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 70px; height: 70px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 32px;">verified_user</i>
                        </div>
                        <h4>Certified Professionals</h4>
                        <p class="text-muted">All our service providers are certified, insured, and background-checked for your safety.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 70px; height: 70px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 32px;">support_agent</i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p class="text-muted">Our customer support team is available around the clock to assist you with any issues.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Areas Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4">Service Areas</h2>
                <p class="lead mb-4">We provide roadside assistance services in the following areas:</p>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">location_on</i>
                                New York City
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">location_on</i>
                                Los Angeles
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">location_on</i>
                                Chicago
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">location_on</i>
                                Houston
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">location_on</i>
                                Phoenix
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">location_on</i>
                                Philadelphia
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">location_on</i>
                                San Antonio
                            </li>
                            <li class="mb-3">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">location_on</i>
                                San Diego
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="mt-3">Don't see your area? <a href="{{ route('contact') }}" class="text-primary">Contact us</a> to check if we service your location.</p>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow">
                    <div class="card-body p-0">
                        <img src="{{ asset('storage/service-map.jpg') }}" alt="Service Areas Map" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-4">Need Roadside Assistance?</h2>
                <p class="lead mb-4">We're ready to help you 24/7, 365 days a year</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('request-service') }}" class="btn btn-light btn-lg">
                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">build</i>
                        Request Service Now
                    </a>
                    <a href="{{ route('plans.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">card_membership</i>
                        View Membership Plans
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
