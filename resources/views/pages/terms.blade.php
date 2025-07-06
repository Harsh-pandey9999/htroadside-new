@extends('layouts.app')

@section('title', 'Terms of Service - ' . settings('site_name', 'HT Roadside'))
@section('meta_description', 'Terms of Service for ' . settings('site_name', 'HT Roadside') . '. Read our terms and conditions for using our roadside assistance services.')

@section('content')
<div class="bg-gray-100">
    <!-- Page Header -->
    <div class="bg-primary-700 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4" data-aos="fade-up">Terms of Service</h1>
            <div class="flex items-center text-sm" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200">Home</a>
                <span class="mx-2">/</span>
                <span>Terms of Service</span>
            </div>
        </div>
    </div>

    <!-- Terms Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none">
                <h2>1. Acceptance of Terms</h2>
                <p>By accessing and using the services provided by {{ settings('site_name', 'HT Roadside') }}, you agree to comply with and be bound by these Terms of Service. If you do not agree to these terms, please do not use our services.</p>
                
                <h2>2. Description of Services</h2>
                <p>{{ settings('site_name', 'HT Roadside') }} provides roadside assistance services including but not limited to towing, jump starts, tire changes, lockout assistance, and fuel delivery. The availability of specific services may vary by location and membership plan.</p>
                
                <h2>3. Membership Plans</h2>
                <p>Different membership plans offer varying levels of service and benefits. The specific services included in each plan are detailed on our website. We reserve the right to modify plan offerings and pricing with appropriate notice to members.</p>
                
                <h2>4. Service Requests</h2>
                <p>Members may request service through our website, mobile app, or by calling our service hotline. Response times are estimated and may vary based on factors including but not limited to weather conditions, traffic, and service provider availability.</p>
                
                <h2>5. Payment Terms</h2>
                <p>Membership fees are charged according to the plan selected. By providing payment information, you authorize us to charge the applicable fees to your payment method. All fees are non-refundable unless otherwise specified.</p>
                
                <h2>6. Limitations of Service</h2>
                <p>Our services are intended for emergency roadside assistance and not for regular maintenance or repair services. We reserve the right to limit the frequency of service calls and may decline service in cases of misuse or fraud.</p>
                
                <h2>7. User Responsibilities</h2>
                <p>Users are responsible for providing accurate information when requesting service and for ensuring that their vehicle is legally registered and in a condition that can be safely serviced.</p>
                
                <h2>8. Limitation of Liability</h2>
                <p>{{ settings('site_name', 'HT Roadside') }} is not liable for any indirect, incidental, special, or consequential damages resulting from the use or inability to use our services, or for any damage to vehicles or property during service provision.</p>
                
                <h2>9. Modifications to Terms</h2>
                <p>We reserve the right to modify these Terms of Service at any time. Changes will be effective upon posting to our website. Continued use of our services after changes constitutes acceptance of the modified terms.</p>
                
                <h2>10. Governing Law</h2>
                <p>These Terms of Service are governed by and construed in accordance with the laws of the jurisdiction in which {{ settings('site_name', 'HT Roadside') }} is registered, without regard to its conflict of law principles.</p>
                
                <h2>11. Contact Information</h2>
                <p>If you have any questions about these Terms of Service, please contact us at {{ settings('contact_email', 'info@htroadside.com') }} or call {{ settings('contact_phone', '1-800-123-4567') }}.</p>
                
                <p class="text-sm text-gray-600 mt-8">Last updated: June 1, 2025</p>
            </div>
        </div>
    </div>
</div>
@endsection
