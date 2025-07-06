<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title" data-aos="fade-up">Frequently Asked Questions</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                Find answers to the most common questions about our roadside assistance services.
            </p>
        </div>
        
        <div class="max-w-3xl mx-auto" x-data="{selected:null}">
            <div class="space-y-4">
                <!-- Question 1 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="150">
                    <button 
                        @click="selected !== 1 ? selected = 1 : selected = null"
                        class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50"
                    >
                        <span class="text-lg font-medium text-gray-900">How quickly can I expect assistance after I call?</span>
                        <i class="fas" :class="selected == 1 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                    </button>
                    <div x-show="selected == 1" x-transition class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-600">
                            Our average response time is 30 minutes, but it can vary based on your location, traffic conditions, and service demand. In urban areas, we typically arrive within 15-30 minutes, while rural areas might take 30-45 minutes. You can track your technician's arrival in real-time through our mobile app.
                        </p>
                    </div>
                </div>
                
                <!-- Question 2 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <button 
                        @click="selected !== 2 ? selected = 2 : selected = null"
                        class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50"
                    >
                        <span class="text-lg font-medium text-gray-900">Do I need a membership to use your services?</span>
                        <i class="fas" :class="selected == 2 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                    </button>
                    <div x-show="selected == 2" x-transition class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-600">
                            No, you don't need a membership to use our services. We offer pay-per-use roadside assistance for non-members. However, members enjoy priority service, discounted rates, and additional benefits depending on their plan level. Membership plans offer significant savings for those who want peace of mind and regular coverage.
                        </p>
                    </div>
                </div>
                
                <!-- Question 3 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="250">
                    <button 
                        @click="selected !== 3 ? selected = 3 : selected = null"
                        class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50"
                    >
                        <span class="text-lg font-medium text-gray-900">What areas do you service?</span>
                        <i class="fas" :class="selected == 3 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                    </button>
                    <div x-show="selected == 3" x-transition class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-600">
                            We provide roadside assistance services in over 100 major metropolitan areas across the United States. Our coverage extends to most highways and major roads. You can check if your area is covered by entering your zip code on our coverage page or contacting our customer service. We're continuously expanding our service areas to help more drivers.
                        </p>
                    </div>
                </div>
                
                <!-- Question 4 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <button 
                        @click="selected !== 4 ? selected = 4 : selected = null"
                        class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50"
                    >
                        <span class="text-lg font-medium text-gray-900">What types of vehicles do you service?</span>
                        <i class="fas" :class="selected == 4 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                    </button>
                    <div x-show="selected == 4" x-transition class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-600">
                            Our standard services cover most passenger vehicles, including cars, SUVs, minivans, and light trucks. Premium members also receive coverage for motorcycles and RVs. For commercial vehicles or heavy-duty trucks, we offer specialized commercial roadside assistance plans. Please contact our customer service for specific vehicle requirements or limitations.
                        </p>
                    </div>
                </div>
                
                <!-- Question 5 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="350">
                    <button 
                        @click="selected !== 5 ? selected = 5 : selected = null"
                        class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50"
                    >
                        <span class="text-lg font-medium text-gray-900">How do I cancel or change my membership plan?</span>
                        <i class="fas" :class="selected == 5 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                    </button>
                    <div x-show="selected == 5" x-transition class="p-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-600">
                            You can manage your membership through your online account or by contacting our customer service. To upgrade, downgrade, or cancel your plan, log in to your account, go to "Membership Settings," and select the desired option. Changes to your plan will take effect on your next billing cycle. If you cancel within the first 30 days, you may be eligible for a full refund if no services have been used.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="400">
                <p class="text-gray-600 mb-6">
                    Still have questions? We're here to help.
                </p>
                <a href="{{ route('faq') }}" class="btn btn-outline mr-4">
                    View All FAQs
                </a>
                <a href="{{ route('contact') }}" class="btn btn-primary">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>
