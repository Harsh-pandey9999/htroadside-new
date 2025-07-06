@extends('layouts.public-material')

@section('title', 'Terms of Service')

@section('content')
<!-- Terms Hero Section -->
<section class="hero-section about-hero">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">Terms of Service</h1>
                <p class="hero-subtitle">Please read these terms carefully before using our services</p>
            </div>
        </div>
    </div>
</section>

<!-- Terms Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Agreement to Terms</h2>
                            <p>These Terms of Service ("Terms") govern your access to and use of the HT Roadside Assistance website, mobile applications, and services (collectively, the "Services"). By accessing or using our Services, you agree to be bound by these Terms and our Privacy Policy.</p>
                            <p>If you do not agree to these Terms, you may not access or use the Services. We may modify these Terms at any time. Your continued use of the Services after any such changes constitutes your acceptance of the new Terms.</p>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Eligibility</h2>
                            <p>You must be at least 18 years old to use our Services. By using our Services, you represent and warrant that:</p>
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item border-0 ps-0">
                                    <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">arrow_right</i>
                                    You are at least 18 years old
                                </li>
                                <li class="list-group-item border-0 ps-0">
                                    <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">arrow_right</i>
                                    You have the legal capacity to enter into a binding agreement
                                </li>
                                <li class="list-group-item border-0 ps-0">
                                    <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">arrow_right</i>
                                    You will comply with these Terms and all applicable laws
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Account Registration and Security</h2>
                            <p>To use certain features of our Services, you may need to create an account. When you register, you agree to provide accurate, current, and complete information. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p>
                            <p>You agree to immediately notify us of any unauthorized use of your account or any other breach of security. We cannot and will not be liable for any loss or damage arising from your failure to comply with these requirements.</p>
                            
                            <div class="alert alert-info border-0 shadow-sm mt-4">
                                <div class="d-flex">
                                    <i class="material-icons-outlined text-primary me-3" style="font-size: 2rem;">info</i>
                                    <div>
                                        <h5 class="fw-bold">Important</h5>
                                        <p class="mb-0">Never share your account credentials with anyone. Our customer service representatives will never ask for your password.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Membership Plans and Payment</h2>
                            <p>We offer various membership plans for our roadside assistance services. By purchasing a membership, you agree to the following terms:</p>
                            
                            <div class="accordion mt-4" id="termsPaymentAccordion">
                                <div class="accordion-item border-0 mb-3">
                                    <h3 class="accordion-header" id="headingBilling">
                                        <button class="accordion-button shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBilling" aria-expanded="true" aria-controls="collapseBilling">
                                            Billing and Renewal
                                        </button>
                                    </h3>
                                    <div id="collapseBilling" class="accordion-collapse collapse show" aria-labelledby="headingBilling" data-bs-parent="#termsPaymentAccordion">
                                        <div class="accordion-body bg-light">
                                            <p>Membership fees are billed annually in advance. Your membership will automatically renew at the end of each billing cycle unless you cancel it before the renewal date. We will send you a reminder email before your membership renews.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item border-0 mb-3">
                                    <h3 class="accordion-header" id="headingCancellation">
                                        <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCancellation" aria-expanded="false" aria-controls="collapseCancellation">
                                            Cancellation and Refunds
                                        </button>
                                    </h3>
                                    <div id="collapseCancellation" class="accordion-collapse collapse" aria-labelledby="headingCancellation" data-bs-parent="#termsPaymentAccordion">
                                        <div class="accordion-body bg-light">
                                            <p>You may cancel your membership at any time through your account settings or by contacting our customer service. If you cancel within 30 days of purchase and have not used any services, you may be eligible for a full refund. After 30 days, refunds are prorated based on the remaining time in your membership period.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item border-0 mb-3">
                                    <h3 class="accordion-header" id="headingPriceChanges">
                                        <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePriceChanges" aria-expanded="false" aria-controls="collapsePriceChanges">
                                            Price Changes
                                        </button>
                                    </h3>
                                    <div id="collapsePriceChanges" class="accordion-collapse collapse" aria-labelledby="headingPriceChanges" data-bs-parent="#termsPaymentAccordion">
                                        <div class="accordion-body bg-light">
                                            <p>We reserve the right to adjust pricing for our services. If we change the pricing for your membership plan, we will notify you at least 30 days before the change takes effect. Continued use of the Services after a price change constitutes your acceptance of the new pricing.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Service Limitations</h2>
                            <p>Our roadside assistance services are subject to the following limitations:</p>
                            
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Limitation</th>
                                            <th scope="col">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Service Calls</td>
                                            <td>The number of service calls allowed per membership year is limited based on your plan. Additional service calls may incur extra charges.</td>
                                        </tr>
                                        <tr>
                                            <td>Towing Distance</td>
                                            <td>Towing is limited to the maximum distance specified in your plan. Additional mileage will be charged at the prevailing rate.</td>
                                        </tr>
                                        <tr>
                                            <td>Vehicle Eligibility</td>
                                            <td>Services are provided for passenger vehicles only. Commercial vehicles, motorcycles, and vehicles exceeding certain weight limits may not be eligible for all services.</td>
                                        </tr>
                                        <tr>
                                            <td>Service Area</td>
                                            <td>Services are available within the continental United States and Canada. Coverage in remote areas may be limited.</td>
                                        </tr>
                                        <tr>
                                            <td>Response Time</td>
                                            <td>While we strive to provide prompt service, response times may vary based on location, weather conditions, traffic, and service demand.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">User Conduct</h2>
                            <p>You agree not to use our Services to:</p>
                            
                            <div class="row g-4 mt-3">
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="material-icons-outlined text-danger me-3" style="font-size: 2rem;">block</i>
                                                <h5 class="fw-bold mb-0">Prohibited Activities</h5>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2">
                                                    <i class="material-icons-outlined text-danger me-2" style="font-size: 1rem; vertical-align: middle;">close</i>
                                                    Violate any applicable laws or regulations
                                                </li>
                                                <li class="mb-2">
                                                    <i class="material-icons-outlined text-danger me-2" style="font-size: 1rem; vertical-align: middle;">close</i>
                                                    Impersonate any person or entity
                                                </li>
                                                <li>
                                                    <i class="material-icons-outlined text-danger me-2" style="font-size: 1rem; vertical-align: middle;">close</i>
                                                    Engage in fraudulent activities
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="material-icons-outlined text-success me-3" style="font-size: 2rem;">check_circle</i>
                                                <h5 class="fw-bold mb-0">Expected Conduct</h5>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2">
                                                    <i class="material-icons-outlined text-success me-2" style="font-size: 1rem; vertical-align: middle;">check</i>
                                                    Provide accurate information
                                                </li>
                                                <li class="mb-2">
                                                    <i class="material-icons-outlined text-success me-2" style="font-size: 1rem; vertical-align: middle;">check</i>
                                                    Treat service providers with respect
                                                </li>
                                                <li>
                                                    <i class="material-icons-outlined text-success me-2" style="font-size: 1rem; vertical-align: middle;">check</i>
                                                    Report any issues promptly
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Intellectual Property</h2>
                            <p>The Services and all content, features, and functionality thereof, including but not limited to all information, software, text, displays, images, video, and audio, and the design, selection, and arrangement thereof, are owned by HT Roadside Assistance, its licensors, or other providers of such material and are protected by copyright, trademark, patent, trade secret, and other intellectual property or proprietary rights laws.</p>
                            <p>These Terms permit you to use the Services for your personal, non-commercial use only. You must not reproduce, distribute, modify, create derivative works of, publicly display, publicly perform, republish, download, store, or transmit any of the material on our Services, except as follows:</p>
                            <ul class="list-group list-group-flush mt-3">
                                <li class="list-group-item border-0 ps-0">
                                    <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">arrow_right</i>
                                    Your computer may temporarily store copies of such materials in RAM incidental to your accessing and viewing those materials.
                                </li>
                                <li class="list-group-item border-0 ps-0">
                                    <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">arrow_right</i>
                                    You may store files that are automatically cached by your Web browser for display enhancement purposes.
                                </li>
                                <li class="list-group-item border-0 ps-0">
                                    <i class="material-icons-outlined text-primary me-2" style="vertical-align: middle;">arrow_right</i>
                                    You may print or download one copy of a reasonable number of pages of the website for your own personal, non-commercial use and not for further reproduction, publication, or distribution.
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Disclaimer of Warranties</h2>
                            <p>THE SERVICES ARE PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS, WITHOUT ANY WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED. NEITHER HT ROADSIDE ASSISTANCE NOR ANY PERSON ASSOCIATED WITH HT ROADSIDE ASSISTANCE MAKES ANY WARRANTY OR REPRESENTATION WITH RESPECT TO THE COMPLETENESS, SECURITY, RELIABILITY, QUALITY, ACCURACY, OR AVAILABILITY OF THE SERVICES.</p>
                            <p>THE FOREGOING DOES NOT AFFECT ANY WARRANTIES THAT CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.</p>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Limitation of Liability</h2>
                            <p>IN NO EVENT WILL HT ROADSIDE ASSISTANCE, ITS AFFILIATES, OR THEIR LICENSORS, SERVICE PROVIDERS, EMPLOYEES, AGENTS, OFFICERS, OR DIRECTORS BE LIABLE FOR DAMAGES OF ANY KIND, UNDER ANY LEGAL THEORY, ARISING OUT OF OR IN CONNECTION WITH YOUR USE, OR INABILITY TO USE, THE SERVICES, INCLUDING ANY DIRECT, INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES.</p>
                            <p>THE FOREGOING DOES NOT AFFECT ANY LIABILITY THAT CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.</p>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Indemnification</h2>
                            <p>You agree to defend, indemnify, and hold harmless HT Roadside Assistance, its affiliates, licensors, and service providers, and its and their respective officers, directors, employees, contractors, agents, licensors, suppliers, successors, and assigns from and against any claims, liabilities, damages, judgments, awards, losses, costs, expenses, or fees (including reasonable attorneys' fees) arising out of or relating to your violation of these Terms or your use of the Services.</p>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Governing Law and Jurisdiction</h2>
                            <p>These Terms and any dispute or claim arising out of or in connection with them or their subject matter or formation shall be governed by and construed in accordance with the laws of the State of California, without giving effect to any choice or conflict of law provision or rule.</p>
                            <p>Any legal suit, action, or proceeding arising out of, or related to, these Terms or the Services shall be instituted exclusively in the federal courts of the United States or the courts of the State of California, in each case located in the City of San Francisco and County of San Francisco. You waive any and all objections to the exercise of jurisdiction over you by such courts and to venue in such courts.</p>
                        </div>
                        
                        <div>
                            <h2 class="fw-bold mb-4">Contact Information</h2>
                            <p>If you have any questions about these Terms, please contact us at:</p>
                            
                            <div class="card border-0 shadow-sm mt-3">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <h5 class="fw-bold mb-3">By Email</h5>
                                            <p class="mb-0">
                                                <a href="mailto:legal@htroadside.com" class="text-decoration-none">
                                                    <i class="material-icons-outlined me-2" style="vertical-align: middle;">email</i>
                                                    legal@htroadside.com
                                                </a>
                                            </p>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <h5 class="fw-bold mb-3">By Mail</h5>
                                            <p class="mb-0">
                                                HT Roadside Assistance<br>
                                                Attn: Legal Department<br>
                                                123 Roadside Ave<br>
                                                San Francisco, CA 94103
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-5">
                            <p class="text-muted small">Last Updated: June 1, 2023</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
