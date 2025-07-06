@extends('layouts.public-material')

@section('title', 'About Us')

@section('content')
<!-- About Hero Section -->
<section class="hero-section about-hero">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">About HT Roadside Assistance</h1>
                <p class="hero-subtitle">Your trusted partner on the road since 2010</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4">Our Story</h2>
                <p class="lead mb-4">Founded in 2010, HT Roadside Assistance was born from a simple idea: to provide fast, reliable roadside assistance with exceptional customer service.</p>
                <p class="mb-4">What started as a small local operation has grown into a nationwide network of certified service providers, all committed to helping drivers when they need it most. Our founder, Michael Thompson, experienced firsthand the frustration of being stranded on the road with no reliable help in sight. This experience inspired him to create a service that puts customers first.</p>
                <p>Today, we serve thousands of customers across the country, providing peace of mind to drivers everywhere. Our commitment to quality service, transparency, and customer satisfaction remains at the heart of everything we do.</p>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow">
                    <div class="card-body p-0">
                        <img src="{{ asset('storage/about-image.jpg') }}" alt="Our Story" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Mission Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="fw-bold">Our Mission</h2>
                <p class="lead">To provide fast, reliable roadside assistance with exceptional customer service, ensuring no driver is left stranded.</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 70px; height: 70px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 32px;">speed</i>
                        </div>
                        <h4>Speed</h4>
                        <p class="text-muted">We understand that time matters when you're stranded. Our average response time is under 30 minutes.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 70px; height: 70px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 32px;">verified</i>
                        </div>
                        <h4>Reliability</h4>
                        <p class="text-muted">All our service providers are certified, insured, and background-checked to ensure quality service.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 70px; height: 70px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 32px;">support_agent</i>
                        </div>
                        <h4>Customer Service</h4>
                        <p class="text-muted">Our 24/7 customer support team is always ready to assist you with any questions or concerns.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Leadership Team</h2>
            <p class="text-muted">Meet the people behind HT Roadside Assistance</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card team-card h-100">
                    <div class="card-body text-center p-4">
                        <img src="{{ asset('storage/team/ceo.jpg') }}" alt="CEO" class="team-avatar mb-3">
                        <h4>Michael Thompson</h4>
                        <p class="text-primary mb-3">Founder & CEO</p>
                        <p class="text-muted mb-3">With over 20 years of experience in the automotive industry, Michael founded HT Roadside Assistance with a vision to transform roadside assistance services.</p>
                        <div class="social-icons">
                            <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card team-card h-100">
                    <div class="card-body text-center p-4">
                        <img src="{{ asset('storage/team/coo.jpg') }}" alt="COO" class="team-avatar mb-3">
                        <h4>Sarah Johnson</h4>
                        <p class="text-primary mb-3">Chief Operations Officer</p>
                        <p class="text-muted mb-3">Sarah oversees our nationwide network of service providers and ensures operational excellence across all service areas.</p>
                        <div class="social-icons">
                            <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card team-card h-100">
                    <div class="card-body text-center p-4">
                        <img src="{{ asset('storage/team/cto.jpg') }}" alt="CTO" class="team-avatar mb-3">
                        <h4>David Chen</h4>
                        <p class="text-primary mb-3">Chief Technology Officer</p>
                        <p class="text-muted mb-3">David leads our technology initiatives, developing innovative solutions to improve service delivery and customer experience.</p>
                        <div class="social-icons">
                            <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Core Values</h2>
            <p class="text-muted">The principles that guide everything we do</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 60px; height: 60px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 28px;">verified_user</i>
                        </div>
                        <h4>Integrity</h4>
                        <p class="text-muted">We operate with honesty and transparency in all our interactions.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 60px; height: 60px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 28px;">thumb_up</i>
                        </div>
                        <h4>Excellence</h4>
                        <p class="text-muted">We strive for excellence in every service we provide.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 60px; height: 60px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 28px;">favorite</i>
                        </div>
                        <h4>Compassion</h4>
                        <p class="text-muted">We approach every situation with empathy and understanding.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary text-white d-inline-flex mb-3" style="width: 60px; height: 60px; align-items: center; justify-content: center;">
                            <i class="material-icons-outlined" style="font-size: 28px;">lightbulb</i>
                        </div>
                        <h4>Innovation</h4>
                        <p class="text-muted">We continuously seek better ways to serve our customers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Milestones Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Milestones</h2>
            <p class="text-muted">A journey of growth and innovation</p>
        </div>
        
        <div class="timeline">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="timeline-item-left">
                        <div class="card border-0 shadow-sm mb-4 ms-md-4">
                            <div class="card-body p-4">
                                <h4 class="fw-bold">2010</h4>
                                <p class="text-muted mb-0">Founded in San Francisco with a small team of 5 service providers</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
            
            <div class="row g-0">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="timeline-item-right">
                        <div class="card border-0 shadow-sm mb-4 me-md-4">
                            <div class="card-body p-4">
                                <h4 class="fw-bold">2013</h4>
                                <p class="text-muted mb-0">Expanded to 10 major cities with over 100 service providers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="timeline-item-left">
                        <div class="card border-0 shadow-sm mb-4 ms-md-4">
                            <div class="card-body p-4">
                                <h4 class="fw-bold">2015</h4>
                                <p class="text-muted mb-0">Launched our mobile app for on-the-go service requests</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
            
            <div class="row g-0">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="timeline-item-right">
                        <div class="card border-0 shadow-sm mb-4 me-md-4">
                            <div class="card-body p-4">
                                <h4 class="fw-bold">2018</h4>
                                <p class="text-muted mb-0">Reached 500,000 customers served nationwide</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="timeline-item-left">
                        <div class="card border-0 shadow-sm mb-4 ms-md-4">
                            <div class="card-body p-4">
                                <h4 class="fw-bold">2020</h4>
                                <p class="text-muted mb-0">Introduced advanced tracking technology and AI-powered dispatch</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
            
            <div class="row g-0">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="timeline-item-right">
                        <div class="card border-0 shadow-sm mb-0 me-md-4">
                            <div class="card-body p-4">
                                <h4 class="fw-bold">Today</h4>
                                <p class="text-muted mb-0">Serving over 1 million customers with 1,000+ service providers across the country</p>
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
                        <p class="testimonial-quote mb-3">"I've been a Premium member for 3 years now and the service has been consistently excellent. The peace of mind is worth every penny!"</p>
                        <h5 class="mb-0">Robert Anderson</h5>
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
                        <p class="testimonial-quote mb-3">"Their app is so easy to use! I had a flat tire on the highway and within minutes of requesting help, I could see my provider on the way. Great service!"</p>
                        <h5 class="mb-0">Emily Rodriguez</h5>
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
                        <p class="testimonial-quote mb-3">"The customer service is outstanding! When I called with questions about my membership, they were patient and helpful. Highly recommend!"</p>
                        <h5 class="mb-0">David Wilson</h5>
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
                <h2 class="fw-bold mb-4">Join Our Team</h2>
                <p class="lead mb-4">We're always looking for talented individuals to join our growing team</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('careers.index') }}" class="btn btn-light btn-lg">
                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">work</i>
                        View Open Positions
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">contact_support</i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
