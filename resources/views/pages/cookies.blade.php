@extends('layouts.app')

@section('title', 'Cookie Policy - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', 'Cookie Policy for ' . settings('site_name', 'HT Roadside') . '. Learn how we use cookies on our website.')

@section('content')
<div class="bg-gray-100">
    <!-- Page Header -->
    <div class="bg-primary-700 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4" data-aos="fade-up">Cookie Policy</h1>
            <div class="flex items-center text-sm" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200">Home</a>
                <span class="mx-2">/</span>
                <span>Cookie Policy</span>
            </div>
        </div>
    </div>

    <!-- Cookie Policy Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none">
                <h2>1. What Are Cookies</h2>
                <p>Cookies are small text files that are placed on your computer or mobile device when you visit a website. They are widely used to make websites work more efficiently and provide information to the website owners.</p>
                
                <h2>2. How We Use Cookies</h2>
                <p>{{ settings('site_name', 'HT Roadside') }} uses cookies for a variety of purposes, including:</p>
                <ul>
                    <li><strong>Essential Cookies:</strong> These cookies are necessary for the website to function properly. They enable core functionality such as security, network management, and account access. You may disable these by changing your browser settings, but this may affect how the website functions.</li>
                    <li><strong>Analytics Cookies:</strong> These cookies allow us to count visits and traffic sources so we can measure and improve the performance of our site. They help us to know which pages are the most and least popular and see how visitors move around the site.</li>
                    <li><strong>Functionality Cookies:</strong> These cookies enable the website to provide enhanced functionality and personalization. They may be set by us or by third-party providers whose services we have added to our pages.</li>
                    <li><strong>Advertising Cookies:</strong> These cookies may be set through our site by our advertising partners. They may be used by those companies to build a profile of your interests and show you relevant advertisements on other sites.</li>
                </ul>
                
                <h2>3. Types of Cookies We Use</h2>
                <p>We use the following types of cookies on our website:</p>
                
                <h3>3.1 Session Cookies</h3>
                <p>Session cookies are temporary cookies that are erased when you close your browser. They are used to store temporary information, such as items in your shopping cart.</p>
                
                <h3>3.2 Persistent Cookies</h3>
                <p>Persistent cookies remain on your device for a set period or until you delete them. They are used to remember your preferences and settings when you visit our website again.</p>
                
                <h3>3.3 First-Party Cookies</h3>
                <p>First-party cookies are set by our website that you are visiting.</p>
                
                <h3>3.4 Third-Party Cookies</h3>
                <p>Third-party cookies are set by a domain other than our website. These are primarily used for advertising and analytics purposes.</p>
                
                <h2>4. Managing Cookies</h2>
                <p>Most web browsers allow you to control cookies through their settings. You can usually find these settings in the "Options" or "Preferences" menu of your browser. You can also delete cookies that have already been set.</p>
                
                <p>Please note that disabling certain cookies may affect the functionality of our website and limit the services we can provide to you.</p>
                
                <h2>5. Cookie Consent</h2>
                <p>When you first visit our website, you will be shown a cookie banner that allows you to accept or decline non-essential cookies. You can change your preferences at any time by clicking on the "Cookie Settings" link in the footer of our website.</p>
                
                <h2>6. Changes to Our Cookie Policy</h2>
                <p>We may update our Cookie Policy from time to time. Any changes will be posted on this page with an updated revision date.</p>
                
                <h2>7. Contact Us</h2>
                <p>If you have any questions about our Cookie Policy, please contact us at {{ settings('contact_email', 'info@htroadside.com') }} or call {{ settings('contact_phone', '1-800-123-4567') }}.</p>
                
                <p class="text-sm text-gray-600 mt-8">Last updated: June 1, 2025</p>
            </div>
        </div>
    </div>
</div>
@endsection
