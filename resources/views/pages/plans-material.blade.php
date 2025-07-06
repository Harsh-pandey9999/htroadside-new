@extends('layouts.public-material')

@section('title', 'Membership Plans')

@section('content')
<!-- Plans Hero Section -->
<section class="hero-section services-hero">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">Membership Plans</h1>
                <p class="hero-subtitle">Choose the right plan for your roadside assistance needs</p>
            </div>
        </div>
    </div>
</section>

<!-- Plans Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-3">Our Membership Plans</h2>
                <p class="text-muted">We offer a variety of plans to meet your needs and budget. All plans include our core services with different coverage levels and benefits.</p>
            </div>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Basic Plan -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="fw-bold mb-0">Basic</h3>
                        <p class="mb-0">Essential Coverage</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="display-6 fw-bold text-primary mb-0">$59</h4>
                            <p class="text-muted">per year</p>
                        </div>
                        
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>24/7 Roadside Assistance</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Up to 3 service calls per year</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Towing up to 5 miles</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Flat tire service</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Battery jump-start</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-muted me-3">cancel</i>
                                <span class="text-muted">Fuel delivery service</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-muted me-3">cancel</i>
                                <span class="text-muted">Lockout assistance</span>
                            </li>
                        </ul>
                        
                        <div class="text-center">
                            <a href="{{ route('register') }}?plan=basic" class="btn btn-primary btn-lg w-100">
                                <i class="material-icons-outlined me-2" style="vertical-align: middle;">shopping_cart</i>
                                Choose Plan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Standard Plan -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-header bg-success text-white text-center py-4">
                        <span class="badge bg-warning position-absolute top-0 start-50 translate-middle px-3 py-2">MOST POPULAR</span>
                        <h3 class="fw-bold mb-0">Standard</h3>
                        <p class="mb-0">Comprehensive Coverage</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="display-6 fw-bold text-success mb-0">$99</h4>
                            <p class="text-muted">per year</p>
                        </div>
                        
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>24/7 Roadside Assistance</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Up to 5 service calls per year</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Towing up to 25 miles</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Flat tire service</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Battery jump-start</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Fuel delivery service</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Lockout assistance</span>
                            </li>
                        </ul>
                        
                        <div class="text-center">
                            <a href="{{ route('register') }}?plan=standard" class="btn btn-success btn-lg w-100">
                                <i class="material-icons-outlined me-2" style="vertical-align: middle;">shopping_cart</i>
                                Choose Plan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Premium Plan -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-info text-white text-center py-4">
                        <h3 class="fw-bold mb-0">Premium</h3>
                        <p class="mb-0">Ultimate Coverage</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="display-6 fw-bold text-info mb-0">$149</h4>
                            <p class="text-muted">per year</p>
                        </div>
                        
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>24/7 Roadside Assistance</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Unlimited service calls</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Towing up to 100 miles</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Flat tire service</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Battery jump-start</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Fuel delivery service (fuel included)</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Lockout assistance</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Trip interruption coverage</span>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center">
                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                <span>Rental car reimbursement</span>
                            </li>
                        </ul>
                        
                        <div class="text-center">
                            <a href="{{ route('register') }}?plan=premium" class="btn btn-info btn-lg w-100">
                                <i class="material-icons-outlined me-2" style="vertical-align: middle;">shopping_cart</i>
                                Choose Plan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Plan Comparison -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-3">Plan Comparison</h2>
                <p class="text-muted">See how our plans stack up against each other</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered bg-white shadow-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col">Features</th>
                                <th scope="col" class="text-center">Basic</th>
                                <th scope="col" class="text-center">Standard</th>
                                <th scope="col" class="text-center">Premium</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Price (Annual)</td>
                                <td class="text-center">$59</td>
                                <td class="text-center">$99</td>
                                <td class="text-center">$149</td>
                            </tr>
                            <tr>
                                <td>Service Calls</td>
                                <td class="text-center">3 per year</td>
                                <td class="text-center">5 per year</td>
                                <td class="text-center">Unlimited</td>
                            </tr>
                            <tr>
                                <td>Towing Distance</td>
                                <td class="text-center">5 miles</td>
                                <td class="text-center">25 miles</td>
                                <td class="text-center">100 miles</td>
                            </tr>
                            <tr>
                                <td>Flat Tire Service</td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                            </tr>
                            <tr>
                                <td>Battery Jump-Start</td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                            </tr>
                            <tr>
                                <td>Fuel Delivery</td>
                                <td class="text-center"><i class="material-icons-outlined text-danger">cancel</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i> (fuel included)</td>
                            </tr>
                            <tr>
                                <td>Lockout Assistance</td>
                                <td class="text-center"><i class="material-icons-outlined text-danger">cancel</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                            </tr>
                            <tr>
                                <td>Trip Interruption Coverage</td>
                                <td class="text-center"><i class="material-icons-outlined text-danger">cancel</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-danger">cancel</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                            </tr>
                            <tr>
                                <td>Rental Car Reimbursement</td>
                                <td class="text-center"><i class="material-icons-outlined text-danger">cancel</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-danger">cancel</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                            </tr>
                            <tr>
                                <td>Mobile App Access</td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                            </tr>
                            <tr>
                                <td>24/7 Customer Support</td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                                <td class="text-center"><i class="material-icons-outlined text-success">check_circle</i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-3">Frequently Asked Questions</h2>
                <p class="text-muted">Find answers to common questions about our membership plans</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="plansFaqAccordion">
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="faqHeading1">
                            <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                                How do I choose the right plan for me?
                            </button>
                        </h3>
                        <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#plansFaqAccordion">
                            <div class="accordion-body bg-light">
                                <p>Consider your driving habits, vehicle age, and typical travel distances. If you have a newer car and drive mainly in urban areas, the Basic plan might be sufficient. For older vehicles or if you frequently travel longer distances, the Standard or Premium plans offer more comprehensive coverage.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="faqHeading2">
                            <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                Can I upgrade my plan later?
                            </button>
                        </h3>
                        <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#plansFaqAccordion">
                            <div class="accordion-body bg-light">
                                <p>Yes, you can upgrade your plan at any time. The price difference will be prorated based on the remaining time in your current subscription. Log into your account and navigate to the "Membership" section to upgrade.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="faqHeading3">
                            <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                What is trip interruption coverage?
                            </button>
                        </h3>
                        <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#plansFaqAccordion">
                            <div class="accordion-body bg-light">
                                <p>Trip interruption coverage provides reimbursement for accommodations, meals, and transportation if your vehicle breaks down more than 100 miles from home and requires overnight repairs. Premium members can be reimbursed up to $250 per day for up to 3 days.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="faqHeading4">
                            <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                Are there any additional fees?
                            </button>
                        </h3>
                        <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#plansFaqAccordion">
                            <div class="accordion-body bg-light">
                                <p>The annual membership fee covers all services included in your plan. There are no hidden fees or charges for covered services. However, if you exceed your plan's limits (such as towing distance), additional charges may apply for the excess.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0">
                        <h3 class="accordion-header" id="faqHeading5">
                            <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                                How quickly will help arrive after I request service?
                            </button>
                        </h3>
                        <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#plansFaqAccordion">
                            <div class="accordion-body bg-light">
                                <p>Our average response time is 30-45 minutes in urban areas and 45-60 minutes in rural areas. Response times may vary based on weather conditions, location, and service demand. All members receive real-time updates and ETA tracking through our mobile app.</p>
                            </div>
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
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-3">What Our Members Say</h2>
                <p class="text-muted">Thousands of drivers trust HT Roadside Assistance every day</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card testimonial-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <img src="{{ asset('storage/testimonials/user1.jpg') }}" alt="Sarah Johnson" class="testimonial-avatar">
                        </div>
                        <h5 class="fw-bold mb-1">Sarah Johnson</h5>
                        <p class="text-muted small mb-3">Premium Member · 2 years</p>
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-quote mb-0">The Premium plan has saved me multiple times during long road trips. The unlimited service calls and 100-mile towing are worth every penny. Their response time is impressive!</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card testimonial-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <img src="{{ asset('storage/testimonials/user2.jpg') }}" alt="Michael Chen" class="testimonial-avatar">
                        </div>
                        <h5 class="fw-bold mb-1">Michael Chen</h5>
                        <p class="text-muted small mb-3">Standard Member · 1 year</p>
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <p class="testimonial-quote mb-0">The Standard plan is perfect for my needs. I've used the lockout assistance twice and the fuel delivery once. The mobile app makes requesting help incredibly easy and convenient.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card testimonial-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <img src="{{ asset('storage/testimonials/user3.jpg') }}" alt="Jennifer Martinez" class="testimonial-avatar">
                        </div>
                        <h5 class="fw-bold mb-1">Jennifer Martinez</h5>
                        <p class="text-muted small mb-3">Basic Member · 6 months</p>
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-quote mb-0">Even the Basic plan provides excellent service. When I had a flat tire, help arrived in just 30 minutes. I'm considering upgrading to Standard for the additional benefits.</p>
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
                <h2 class="fw-bold mb-4">Ready to Join?</h2>
                <p class="lead mb-4">Sign up today and drive with confidence knowing we've got your back on the road</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">person_add</i>
                        Sign Up Now
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">help_outline</i>
                        Have Questions?
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
