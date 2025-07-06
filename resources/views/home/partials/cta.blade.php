<section class="py-20 bg-gradient-to-r from-primary-800 to-primary-600 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="mb-8 md:mb-0 md:w-2/3" data-aos="fade-right">
                <h2 class="text-3xl md:text-4xl font-bold font-heading mb-4">Ready to Join? Get Protected Today!</h2>
                <p class="text-xl text-primary-100 mb-6 max-w-xl">
                    Sign up for a membership plan and enjoy peace of mind knowing you're covered 24/7, 365 days a year.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('plans.index') }}" class="btn btn-white">
                        View Plans
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">
                        <i class="fas fa-user-plus mr-2"></i> Sign Up Now
                    </a>
                </div>
            </div>
            <div class="md:w-1/3" data-aos="fade-left">
                <div class="bg-white text-gray-800 rounded-lg p-6 shadow-xl">
                    <h3 class="text-xl font-bold mb-4">Need Immediate Help?</h3>
                    <p class="text-gray-600 mb-4">
                        Our 24/7 emergency service is just a call away.
                    </p>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '18001234567')) }}" class="flex items-center justify-center bg-red-600 text-white rounded-lg px-4 py-3 font-medium hover:bg-red-700 transition-colors">
                        <i class="fas fa-phone-alt mr-2"></i>
                        Call Now
                    </a>
                    <div class="mt-4 text-center text-sm text-gray-500">
                        No membership required for emergency service
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
