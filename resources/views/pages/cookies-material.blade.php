@extends('layouts.public-material')

@section('title', 'Cookie Policy')

@section('content')
<!-- Cookie Policy Hero Section -->
<section class="hero-section about-hero">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">Cookie Policy</h1>
                <p class="hero-subtitle">How we use cookies and similar technologies</p>
            </div>
        </div>
    </div>
</section>

<!-- Cookie Policy Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">What Are Cookies?</h2>
                            <p>Cookies are small text files that are stored on your computer or mobile device when you visit a website. They are widely used to make websites work more efficiently and provide information to the website owners. Cookies help us improve your experience on our website and deliver personalized services.</p>
                            
                            <div class="alert alert-light border-0 shadow-sm mt-4">
                                <div class="d-flex">
                                    <i class="material-icons-outlined text-primary me-3" style="font-size: 2rem;">cookie</i>
                                    <div>
                                        <h5 class="fw-bold">Cookie Basics</h5>
                                        <p class="mb-0">Cookies can be "persistent" or "session" cookies. Persistent cookies remain on your device when you go offline, while session cookies are deleted as soon as you close your web browser.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">How We Use Cookies</h2>
                            <p>We use cookies for various purposes, including:</p>
                            
                            <div class="row g-4 mt-3">
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="material-icons-outlined text-primary me-3" style="font-size: 2rem;">settings</i>
                                                <h5 class="fw-bold mb-0">Essential Cookies</h5>
                                            </div>
                                            <p class="mb-0">These cookies are necessary for the website to function properly. They enable basic functions like page navigation, secure areas access, and remembering your preferences. The website cannot function properly without these cookies.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="material-icons-outlined text-primary me-3" style="font-size: 2rem;">analytics</i>
                                                <h5 class="fw-bold mb-0">Analytics Cookies</h5>
                                            </div>
                                            <p class="mb-0">These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously. They help us improve our website and services based on user behavior.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="material-icons-outlined text-primary me-3" style="font-size: 2rem;">functions</i>
                                                <h5 class="fw-bold mb-0">Functional Cookies</h5>
                                            </div>
                                            <p class="mb-0">These cookies enable enhanced functionality and personalization, such as remembering your preferences, login information, and language settings. They may be set by us or third-party providers.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="material-icons-outlined text-primary me-3" style="font-size: 2rem;">campaign</i>
                                                <h5 class="fw-bold mb-0">Marketing Cookies</h5>
                                            </div>
                                            <p class="mb-0">These cookies track your online activity to help advertisers deliver more relevant advertising or to limit how many times you see an ad. They can share this information with other organizations or advertisers.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Types of Cookies We Use</h2>
                            
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Cookie Name</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Purpose</th>
                                            <th scope="col">Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>_session</td>
                                            <td>Essential</td>
                                            <td>Maintains your session state across page requests</td>
                                            <td>Session</td>
                                        </tr>
                                        <tr>
                                            <td>XSRF-TOKEN</td>
                                            <td>Essential</td>
                                            <td>Helps protect against cross-site request forgery attacks</td>
                                            <td>Session</td>
                                        </tr>
                                        <tr>
                                            <td>remember_web_*</td>
                                            <td>Functional</td>
                                            <td>Remembers your login information if you select "Remember Me"</td>
                                            <td>2 weeks</td>
                                        </tr>
                                        <tr>
                                            <td>design_version</td>
                                            <td>Functional</td>
                                            <td>Remembers your preferred design version (original or material)</td>
                                            <td>1 year</td>
                                        </tr>
                                        <tr>
                                            <td>_ga</td>
                                            <td>Analytics</td>
                                            <td>Used by Google Analytics to distinguish users</td>
                                            <td>2 years</td>
                                        </tr>
                                        <tr>
                                            <td>_gid</td>
                                            <td>Analytics</td>
                                            <td>Used by Google Analytics to distinguish users</td>
                                            <td>24 hours</td>
                                        </tr>
                                        <tr>
                                            <td>_fbp</td>
                                            <td>Marketing</td>
                                            <td>Used by Facebook to deliver advertisements</td>
                                            <td>3 months</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Third-Party Cookies</h2>
                            <p>In addition to our own cookies, we may also use various third-party cookies to report usage statistics, deliver advertisements, and so on. These cookies may track your browsing habits across different websites and online services.</p>
                            
                            <div class="alert alert-light border-0 shadow-sm mt-4">
                                <div class="d-flex">
                                    <i class="material-icons-outlined text-primary me-3" style="font-size: 2rem;">public</i>
                                    <div>
                                        <h5 class="fw-bold">Third-Party Services We Use</h5>
                                        <ul class="mb-0 mt-2">
                                            <li class="mb-2">Google Analytics (for website usage analysis)</li>
                                            <li class="mb-2">Google Maps (for location services)</li>
                                            <li class="mb-2">Facebook Pixel (for advertising)</li>
                                            <li>Stripe (for payment processing)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Managing Cookies</h2>
                            <p>Most web browsers allow you to control cookies through their settings preferences. However, if you limit the ability of websites to set cookies, you may worsen your overall user experience, as it will no longer be personalized to you. It may also stop you from saving customized settings like login information.</p>
                            
                            <div class="accordion mt-4" id="cookieManagementAccordion">
                                <div class="accordion-item border-0 mb-3">
                                    <h3 class="accordion-header" id="headingChrome">
                                        <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseChrome" aria-expanded="false" aria-controls="collapseChrome">
                                            Google Chrome
                                        </button>
                                    </h3>
                                    <div id="collapseChrome" class="accordion-collapse collapse" aria-labelledby="headingChrome" data-bs-parent="#cookieManagementAccordion">
                                        <div class="accordion-body bg-light">
                                            <p>To manage cookies in Chrome:</p>
                                            <ol>
                                                <li>Click the menu icon (three dots) in the top-right corner</li>
                                                <li>Select "Settings"</li>
                                                <li>Click "Privacy and security" in the left sidebar</li>
                                                <li>Click "Cookies and other site data"</li>
                                                <li>Choose your preferred cookie settings</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item border-0 mb-3">
                                    <h3 class="accordion-header" id="headingFirefox">
                                        <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFirefox" aria-expanded="false" aria-controls="collapseFirefox">
                                            Mozilla Firefox
                                        </button>
                                    </h3>
                                    <div id="collapseFirefox" class="accordion-collapse collapse" aria-labelledby="headingFirefox" data-bs-parent="#cookieManagementAccordion">
                                        <div class="accordion-body bg-light">
                                            <p>To manage cookies in Firefox:</p>
                                            <ol>
                                                <li>Click the menu icon (three lines) in the top-right corner</li>
                                                <li>Select "Options" (Windows) or "Preferences" (Mac)</li>
                                                <li>Click "Privacy & Security" in the left sidebar</li>
                                                <li>Under "Cookies and Site Data," choose your preferred settings</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item border-0 mb-3">
                                    <h3 class="accordion-header" id="headingSafari">
                                        <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSafari" aria-expanded="false" aria-controls="collapseSafari">
                                            Safari
                                        </button>
                                    </h3>
                                    <div id="collapseSafari" class="accordion-collapse collapse" aria-labelledby="headingSafari" data-bs-parent="#cookieManagementAccordion">
                                        <div class="accordion-body bg-light">
                                            <p>To manage cookies in Safari:</p>
                                            <ol>
                                                <li>Click "Safari" in the menu bar</li>
                                                <li>Select "Preferences"</li>
                                                <li>Click the "Privacy" tab</li>
                                                <li>Choose your preferred cookie settings</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item border-0">
                                    <h3 class="accordion-header" id="headingEdge">
                                        <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEdge" aria-expanded="false" aria-controls="collapseEdge">
                                            Microsoft Edge
                                        </button>
                                    </h3>
                                    <div id="collapseEdge" class="accordion-collapse collapse" aria-labelledby="headingEdge" data-bs-parent="#cookieManagementAccordion">
                                        <div class="accordion-body bg-light">
                                            <p>To manage cookies in Edge:</p>
                                            <ol>
                                                <li>Click the menu icon (three dots) in the top-right corner</li>
                                                <li>Select "Settings"</li>
                                                <li>Click "Cookies and site permissions" in the left sidebar</li>
                                                <li>Under "Cookies and data stored," choose your preferred settings</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Our Cookie Banner</h2>
                            <p>When you first visit our website, you will see a cookie banner that informs you about our use of cookies and gives you the option to accept or decline non-essential cookies. You can change your cookie preferences at any time by clicking the "Cookie Settings" link in the footer of our website.</p>
                            
                            <div class="card border-0 bg-light mt-4">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-3">Cookie Consent Options</h5>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="material-icons-outlined text-success me-3">check_circle</i>
                                                <span>Accept All Cookies</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="material-icons-outlined text-warning me-3">settings</i>
                                                <span>Customize Settings</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="material-icons-outlined text-danger me-3">block</i>
                                                <span>Reject Non-Essential</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="fw-bold mb-4">Changes to Our Cookie Policy</h2>
                            <p>We may update our Cookie Policy from time to time to reflect changes in technology, regulation, or our business practices. Any changes will be posted on this page with an updated "Last Updated" date. We encourage you to review this Cookie Policy periodically to stay informed about our use of cookies.</p>
                        </div>
                        
                        <div>
                            <h2 class="fw-bold mb-4">Contact Us</h2>
                            <p>If you have any questions or concerns about our Cookie Policy or our use of cookies, please contact us at:</p>
                            
                            <div class="card border-0 shadow-sm mt-3">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <h5 class="fw-bold mb-3">By Email</h5>
                                            <p class="mb-0">
                                                <a href="mailto:privacy@htroadside.com" class="text-decoration-none">
                                                    <i class="material-icons-outlined me-2" style="vertical-align: middle;">email</i>
                                                    privacy@htroadside.com
                                                </a>
                                            </p>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <h5 class="fw-bold mb-3">By Mail</h5>
                                            <p class="mb-0">
                                                HT Roadside Assistance<br>
                                                Attn: Privacy Officer<br>
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
