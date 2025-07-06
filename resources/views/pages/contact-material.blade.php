@extends('layouts.public-material')

@section('title', 'Contact Us')

@section('content')
<!-- Contact Hero Section -->
<section class="hero-section contact-hero">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">Contact Us</h1>
                <p class="hero-subtitle">We're here to help with any questions or concerns</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="fw-bold mb-4">Get In Touch</h2>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-outline mb-3">
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required />
                                        <label class="form-label" for="name">Your Name</label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-outline mb-3">
                                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required />
                                        <label class="form-label" for="email">Email Address</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-outline mb-3">
                                        <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" />
                                        <label class="form-label" for="phone">Phone Number (Optional)</label>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-outline mb-3">
                                        <select id="subject" name="subject" class="form-select @error('subject') is-invalid @enderror" required>
                                            <option value="" selected disabled>Select a subject</option>
                                            <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                            <option value="Membership" {{ old('subject') == 'Membership' ? 'selected' : '' }}>Membership</option>
                                            <option value="Service Request" {{ old('subject') == 'Service Request' ? 'selected' : '' }}>Service Request</option>
                                            <option value="Billing" {{ old('subject') == 'Billing' ? 'selected' : '' }}>Billing</option>
                                            <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                            <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <label class="form-label" for="subject">Subject</label>
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-outline mb-3">
                                        <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>
                                        <label class="form-label" for="message">Your Message</label>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="privacy" name="privacy" required />
                                        <label class="form-check-label" for="privacy">
                                            I agree to the <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="material-icons-outlined me-2" style="vertical-align: middle;">send</i>
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">Contact Information</h3>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex mb-3">
                                <i class="material-icons-outlined text-primary me-3" style="font-size: 24px;">phone</i>
                                <div>
                                    <h5 class="mb-1">Phone</h5>
                                    <p class="mb-0">
                                        <a href="tel:1-800-555-0123" class="text-muted text-decoration-none">1-800-555-0123</a>
                                    </p>
                                </div>
                            </li>
                            
                            <li class="d-flex mb-3">
                                <i class="material-icons-outlined text-primary me-3" style="font-size: 24px;">email</i>
                                <div>
                                    <h5 class="mb-1">Email</h5>
                                    <p class="mb-0">
                                        <a href="mailto:info@htroadside.com" class="text-muted text-decoration-none">info@htroadside.com</a>
                                    </p>
                                </div>
                            </li>
                            
                            <li class="d-flex mb-3">
                                <i class="material-icons-outlined text-primary me-3" style="font-size: 24px;">location_on</i>
                                <div>
                                    <h5 class="mb-1">Main Office</h5>
                                    <p class="mb-0 text-muted">
                                        123 Roadside Ave<br>
                                        San Francisco, CA 94103
                                    </p>
                                </div>
                            </li>
                            
                            <li class="d-flex">
                                <i class="material-icons-outlined text-primary me-3" style="font-size: 24px;">schedule</i>
                                <div>
                                    <h5 class="mb-1">Hours</h5>
                                    <p class="mb-0 text-muted">
                                        Monday - Friday: 9am - 6pm<br>
                                        Saturday: 10am - 4pm<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">Emergency Assistance</h3>
                        <p class="text-muted mb-3">Need immediate roadside assistance? Our service line is available 24/7.</p>
                        <a href="tel:1-800-555-0123" class="btn btn-primary w-100">
                            <i class="material-icons-outlined me-2" style="vertical-align: middle;">call</i>
                            Call for Assistance
                        </a>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">Connect With Us</h3>
                        <p class="text-muted mb-3">Follow us on social media for updates, tips, and more.</p>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-body p-0">
                        <div class="ratio ratio-21x9">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0968870204824!2d-122.41941492392031!3d37.77492971456249!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c6c8f4459%3A0xb10ed6d9b5050fa5!2sSan%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1654789542867!5m2!1sen!2sus" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="fw-bold">Frequently Asked Questions</h2>
                <p class="text-muted">Find quick answers to common questions</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="contactFaqAccordion">
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="faqHeading1">
                            <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                                How quickly will I receive a response to my inquiry?
                            </button>
                        </h3>
                        <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body bg-light">
                                <p>We strive to respond to all inquiries within 24 hours during business days. For urgent matters, please call our customer service line for immediate assistance.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="faqHeading2">
                            <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                How do I update my membership information?
                            </button>
                        </h3>
                        <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body bg-light">
                                <p>You can update your membership information by logging into your account on our website or mobile app. If you need assistance, please contact our customer service team.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="faqHeading3">
                            <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                How do I request roadside assistance?
                            </button>
                        </h3>
                        <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body bg-light">
                                <p>You can request roadside assistance through our mobile app, website, or by calling our 24/7 service line at 1-800-555-0123. We recommend using the app for the fastest service and real-time tracking.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0">
                        <h3 class="accordion-header" id="faqHeading4">
                            <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                Do you have service locations in my area?
                            </button>
                        </h3>
                        <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#contactFaqAccordion">
                            <div class="accordion-body bg-light">
                                <p>We provide service in most major cities and surrounding areas across the country. You can check coverage in your area by entering your zip code on our website or contacting our customer service team.</p>
                            </div>
                        </div>
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
