@extends('layouts.public-material')

@section('title', $service->name)

@section('content')
<!-- Service Detail Hero Section -->
<section class="hero-section service-detail-hero">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">{{ $service->name }}</h1>
                <p class="hero-subtitle">{{ $service->short_description }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Service Detail Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h2 class="fw-bold mb-4">About This Service</h2>
                        <div class="service-description mb-4">
                            {!! $service->description !!}
                        </div>
                        
                        <h3 class="fw-bold mb-3">Service Details</h3>
                        <ul class="list-unstyled mb-4">
                            @if($service->estimated_time)
                                <li class="mb-2">
                                    <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">schedule</i>
                                    <strong>Estimated Time:</strong> {{ $service->estimated_time }}
                                </li>
                            @endif
                            
                            @if($service->category)
                                <li class="mb-2">
                                    <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">category</i>
                                    <strong>Category:</strong> {{ $service->category }}
                                </li>
                            @endif
                            
                            @if($service->service_area)
                                <li class="mb-2">
                                    <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">location_on</i>
                                    <strong>Service Area:</strong> {{ $service->service_area }}
                                </li>
                            @endif
                        </ul>
                        
                        @if($service->price)
                            <h3 class="fw-bold mb-3">Pricing</h3>
                            <div class="card bg-light border-0 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="material-icons-outlined text-primary me-2" style="font-size: 24px;">payments</i>
                                        <h4 class="mb-0">${{ number_format($service->price, 2) }}</h4>
                                    </div>
                                    <p class="text-muted mb-0">Pricing may vary based on location, vehicle type, and service complexity. Members receive discounted rates.</p>
                                </div>
                            </div>
                        @endif
                        
                        <h3 class="fw-bold mb-3">How It Works</h3>
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 50px; height: 50px; align-items: center; justify-content: center;">
                                            <span class="fw-bold">1</span>
                                        </div>
                                        <h5>Request Service</h5>
                                        <p class="small text-muted">Submit a service request through our app or website</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 50px; height: 50px; align-items: center; justify-content: center;">
                                            <span class="fw-bold">2</span>
                                        </div>
                                        <h5>Provider Assignment</h5>
                                        <p class="small text-muted">We'll assign a qualified provider to your location</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 50px; height: 50px; align-items: center; justify-content: center;">
                                            <span class="fw-bold">3</span>
                                        </div>
                                        <h5>Service Completion</h5>
                                        <p class="small text-muted">The provider will arrive and complete the service</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a href="{{ route('customer.request-service') }}?service={{ $service->id }}" class="btn btn-primary btn-lg">
                                <i class="material-icons-outlined me-2" style="vertical-align: middle;">build</i>
                                Request This Service
                            </a>
                            <a href="{{ route('services.index') }}" class="btn btn-outline-primary btn-lg">
                                <i class="material-icons-outlined me-2" style="vertical-align: middle;">arrow_back</i>
                                Back to Services
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- FAQs Section -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="fw-bold mb-4">Frequently Asked Questions</h2>
                        
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item border-0 mb-3">
                                <h3 class="accordion-header" id="faqHeading1">
                                    <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                                        How quickly can I expect service?
                                    </button>
                                </h3>
                                <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body bg-light">
                                        <p>Our average response time is under 30 minutes, depending on your location and current demand. Premium members receive priority service.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 mb-3">
                                <h3 class="accordion-header" id="faqHeading2">
                                    <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                        Is this service covered by my membership?
                                    </button>
                                </h3>
                                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body bg-light">
                                        <p>Coverage depends on your membership level. Basic members receive 4 service calls per year, while Premium members have unlimited service calls. Check your membership details in your account or contact customer support for specific coverage information.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 mb-3">
                                <h3 class="accordion-header" id="faqHeading3">
                                    <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                        What if my vehicle needs more extensive repairs?
                                    </button>
                                </h3>
                                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body bg-light">
                                        <p>If your vehicle requires more extensive repairs than can be provided on the roadside, our service providers can tow your vehicle to a repair facility of your choice (within your plan's mileage limit). Premium members receive extended towing distances.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0">
                                <h3 class="accordion-header" id="faqHeading4">
                                    <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                        Can I request a specific service provider?
                                    </button>
                                </h3>
                                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body bg-light">
                                        <p>While we typically assign the nearest available qualified provider to ensure the fastest response time, Premium members can request preferred providers if they're available. You can save preferred providers in your account settings.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mt-4 mt-lg-0">
                <!-- Service Sidebar -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">Need Help Now?</h3>
                        <p class="text-muted mb-4">Request immediate roadside assistance or call our 24/7 support line</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('customer.request-service') }}?service={{ $service->id }}" class="btn btn-primary">
                                <i class="material-icons-outlined me-2" style="vertical-align: middle;">build</i>
                                Request Service
                            </a>
                            <a href="tel:1-800-555-0123" class="btn btn-outline-primary">
                                <i class="material-icons-outlined me-2" style="vertical-align: middle;">call</i>
                                1-800-555-0123
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Membership Promo -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white p-4">
                        <h3 class="fw-bold mb-0">Save With a Membership</h3>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-3">Join our membership program and save on roadside assistance services</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Priority service
                            </li>
                            <li class="mb-2">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Discounted rates
                            </li>
                            <li class="mb-2">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Multiple service calls
                            </li>
                            <li class="mb-2">
                                <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">check_circle</i>
                                Extended towing
                            </li>
                        </ul>
                        <div class="d-grid">
                            <a href="{{ route('plans.index') }}" class="btn btn-primary">
                                <i class="material-icons-outlined me-2" style="vertical-align: middle;">card_membership</i>
                                View Membership Plans
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Related Services -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">Related Services</h3>
                        <ul class="list-group list-group-flush">
                            @php
                                $relatedServices = \App\Models\Service::where('id', '!=', $service->id)
                                    ->where('is_active', true)
                                    ->inRandomOrder()
                                    ->take(3)
                                    ->get();
                                
                                if ($relatedServices->isEmpty()) {
                                    // If database query fails or returns empty, use mock data
                                    $mockServices = [
                                        ['name' => 'Flat Tire Service', 'slug' => 'flat-tire-service'],
                                        ['name' => 'Battery Jump Start', 'slug' => 'battery-jump-start'],
                                        ['name' => 'Towing Service', 'slug' => 'towing-service'],
                                        ['name' => 'Lockout Service', 'slug' => 'lockout-service'],
                                        ['name' => 'Fuel Delivery', 'slug' => 'fuel-delivery']
                                    ];
                                    
                                    // Filter out the current service
                                    $filteredServices = array_filter($mockServices, function($item) use ($service) {
                                        return $item['slug'] != $service->slug;
                                    });
                                    
                                    // Take 3 random services
                                    $randomServices = array_slice($filteredServices, 0, 3);
                                    
                                    $relatedServices = collect($randomServices)->map(function($item) {
                                        return (object) $item;
                                    });
                                }
                            @endphp
                            
                            @foreach($relatedServices as $relatedService)
                                <li class="list-group-item px-0 py-3 border-bottom">
                                    <a href="{{ route('service.detail', $relatedService->slug) }}" class="text-decoration-none d-flex align-items-center">
                                        <i class="material-icons-outlined text-primary me-3">{{ $relatedService->icon ?? 'build' }}</i>
                                        <span>{{ $relatedService->name }}</span>
                                        <i class="material-icons-outlined ms-auto">arrow_forward</i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="d-grid mt-3">
                            <a href="{{ route('services.index') }}" class="btn btn-outline-primary">
                                View All Services
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="fw-bold">Customer Testimonials</h2>
                <p class="text-muted">See what our customers say about our {{ $service->name }}</p>
            </div>
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
                        <p class="testimonial-quote mb-3">"The service was incredibly fast and professional. The technician was friendly and explained everything. Highly recommend!"</p>
                        <h5 class="mb-0">Michael Davis</h5>
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
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <p class="testimonial-quote mb-3">"I was stranded on the highway and they arrived in just 20 minutes. The service provider was knowledgeable and got me back on the road quickly."</p>
                        <h5 class="mb-0">Jessica Wilson</h5>
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
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-quote mb-3">"Outstanding service! The app made it easy to request help and track the provider. Worth every penny of the membership fee!"</p>
                        <h5 class="mb-0">Robert Johnson</h5>
                        <p class="text-muted small">Premium Member</p>
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
                <h2 class="fw-bold mb-4">Ready to Get Started?</h2>
                <p class="lead mb-4">Join thousands of satisfied customers who trust HT Roadside Assistance</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">person_add</i>
                        Sign Up Now
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
