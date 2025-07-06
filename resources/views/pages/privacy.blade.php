@extends('layouts.app')

@section('title', 'Privacy Policy - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', 'Privacy Policy for ' . settings('site_name', 'HT Roadside') . '. Learn how we collect, use, and protect your personal information.')

@section('content')
<div class="bg-gray-100">
    <!-- Page Header -->
    <div class="bg-primary-700 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4" data-aos="fade-up">Privacy Policy</h1>
            <div class="flex items-center text-sm" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200">Home</a>
                <span class="mx-2">/</span>
                <span>Privacy Policy</span>
            </div>
        </div>
    </div>

    <!-- Privacy Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none">
                <h2>1. Introduction</h2>
                <p>At {{ settings('site_name', 'HT Roadside') }}, we respect your privacy and are committed to protecting your personal data. This privacy policy will inform you about how we look after your personal data when you visit our website and tell you about your privacy rights and how the law protects you.</p>
                
                <h2>2. Information We Collect</h2>
                <p>We may collect, use, store and transfer different kinds of personal data about you which we have grouped together as follows:</p>
                <ul>
                    <li><strong>Identity Data</strong> includes first name, last name, username or similar identifier.</li>
                    <li><strong>Contact Data</strong> includes billing address, delivery address, email address and telephone numbers.</li>
                    <li><strong>Vehicle Data</strong> includes make, model, year, and license plate number of your vehicle.</li>
                    <li><strong>Location Data</strong> includes your current location when requesting roadside assistance.</li>
                    <li><strong>Financial Data</strong> includes payment card details.</li>
                    <li><strong>Transaction Data</strong> includes details about payments to and from you and other details of products and services you have purchased from us.</li>
                    <li><strong>Technical Data</strong> includes internet protocol (IP) address, your login data, browser type and version, time zone setting and location, browser plug-in types and versions, operating system and platform, and other technology on the devices you use to access this website.</li>
                </ul>
                
                <h2>3. How We Use Your Information</h2>
                <p>We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>
                <ul>
                    <li>To provide roadside assistance services to you.</li>
                    <li>To process and manage your membership and payments.</li>
                    <li>To communicate with you about your service requests and membership.</li>
                    <li>To improve our services and website.</li>
                    <li>To comply with legal obligations.</li>
                </ul>
                
                <h2>4. Data Security</h2>
                <p>We have put in place appropriate security measures to prevent your personal data from being accidentally lost, used or accessed in an unauthorized way, altered or disclosed. We limit access to your personal data to those employees, agents, contractors and other third parties who have a business need to know.</p>
                
                <h2>5. Data Retention</h2>
                <p>We will only retain your personal data for as long as necessary to fulfill the purposes we collected it for, including for the purposes of satisfying any legal, accounting, or reporting requirements.</p>
                
                <h2>6. Your Legal Rights</h2>
                <p>Under certain circumstances, you have rights under data protection laws in relation to your personal data, including the right to:</p>
                <ul>
                    <li>Request access to your personal data.</li>
                    <li>Request correction of your personal data.</li>
                    <li>Request erasure of your personal data.</li>
                    <li>Object to processing of your personal data.</li>
                    <li>Request restriction of processing your personal data.</li>
                    <li>Request transfer of your personal data.</li>
                    <li>Right to withdraw consent.</li>
                </ul>
                
                <h2>7. Third-Party Links</h2>
                <p>This website may include links to third-party websites, plug-ins and applications. Clicking on those links or enabling those connections may allow third parties to collect or share data about you. We do not control these third-party websites and are not responsible for their privacy statements.</p>
                
                <h2>8. Changes to This Privacy Policy</h2>
                <p>We may update our privacy policy from time to time. We will notify you of any changes by posting the new privacy policy on this page and updating the "Last updated" date.</p>
                
                <h2>9. Contact Us</h2>
                <p>If you have any questions about this privacy policy or our privacy practices, please contact us at {{ settings('contact_email', 'info@htroadside.com') }} or call {{ settings('contact_phone', '1-800-123-4567') }}.</p>
                
                <p class="text-sm text-gray-600 mt-8">Last updated: June 1, 2025</p>
            </div>
        </div>
    </div>
</div>
@endsection
