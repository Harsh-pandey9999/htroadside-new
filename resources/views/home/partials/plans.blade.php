<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title" data-aos="fade-up">Membership Plans</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                Choose the right plan for your needs and enjoy priority service and exclusive benefits.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Basic Plan -->
            <div class="card overflow-hidden" data-aos="fade-up" data-aos-delay="150">
                <div class="bg-gray-100 p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Basic</h3>
                    <p class="text-gray-600 mb-4">For occasional drivers</p>
                    <div class="flex justify-center items-baseline mb-4">
                        <span class="text-4xl font-bold text-primary-600">$9.99</span>
                        <span class="text-gray-500 ml-1">/month</span>
                    </div>
                    <p class="text-sm text-gray-500">or $99/year (save 17%)</p>
                </div>
                <div class="p-6">
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Up to 3 service calls per year</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Towing up to 5 miles</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Jump starts & tire changes</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Fuel delivery (cost of fuel extra)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Lockout service</span>
                        </li>
                    </ul>
                    <a href="{{ route('plans.show', 'basic') }}" class="btn btn-outline w-full text-center">
                        Choose Basic
                    </a>
                </div>
            </div>
            
            <!-- Plus Plan (Highlighted) -->
            <div class="card overflow-hidden transform md:-translate-y-4 border-2 border-primary-500 relative" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute top-0 right-0 bg-primary-500 text-white px-4 py-1 text-sm font-semibold">
                    Most Popular
                </div>
                <div class="bg-primary-600 p-6 text-center text-white">
                    <h3 class="text-xl font-bold mb-1">Plus</h3>
                    <p class="text-primary-100 mb-4">For regular drivers</p>
                    <div class="flex justify-center items-baseline mb-4">
                        <span class="text-4xl font-bold">$14.99</span>
                        <span class="text-primary-200 ml-1">/month</span>
                    </div>
                    <p class="text-sm text-primary-200">or $149/year (save 17%)</p>
                </div>
                <div class="p-6">
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Up to 5 service calls per year</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Towing up to 25 miles</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>All Basic services included</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Battery replacement service</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Priority dispatch</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Trip interruption coverage</span>
                        </li>
                    </ul>
                    <a href="{{ route('plans.show', 'plus') }}" class="btn btn-primary w-full text-center">
                        Choose Plus
                    </a>
                </div>
            </div>
            
            <!-- Premium Plan -->
            <div class="card overflow-hidden" data-aos="fade-up" data-aos-delay="250">
                <div class="bg-gray-800 p-6 text-center text-white">
                    <h3 class="text-xl font-bold mb-1">Premium</h3>
                    <p class="text-gray-400 mb-4">For frequent travelers</p>
                    <div class="flex justify-center items-baseline mb-4">
                        <span class="text-4xl font-bold text-primary-400">$24.99</span>
                        <span class="text-gray-400 ml-1">/month</span>
                    </div>
                    <p class="text-sm text-gray-400">or $249/year (save 17%)</p>
                </div>
                <div class="p-6">
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Unlimited service calls</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Towing up to 100 miles</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>All Plus services included</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>RV and motorcycle coverage</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Rental car reimbursement</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Hotel discounts</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Concierge service</span>
                        </li>
                    </ul>
                    <a href="{{ route('plans.show', 'premium') }}" class="btn btn-outline w-full text-center">
                        Choose Premium
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="300">
            <p class="text-gray-600 mb-6">
                All plans include 24/7 customer support and access to our mobile app.
            </p>
            <a href="{{ route('plans.index') }}" class="btn btn-primary">
                Compare All Plans
            </a>
        </div>
    </div>
</section>
