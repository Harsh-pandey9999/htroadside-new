<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title" data-aos="fade-up">What Our Customers Say</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                Don't just take our word for it. Here's what our customers have to say about our services.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="card p-8" data-aos="fade-up" data-aos-delay="150">
                <div class="flex mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @endfor
                </div>
                <blockquote class="text-gray-600 mb-6 italic">
                    "I was stranded on the highway with a flat tire and no spare. Called HT Roadside and they arrived within 20 minutes. The technician was professional, friendly, and had me back on the road quickly. Excellent service!"
                </blockquote>
                <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah Johnson" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-bold text-gray-900">Sarah Johnson</h4>
                        <p class="text-gray-500 text-sm">Los Angeles, CA</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="card p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="flex mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @endfor
                </div>
                <blockquote class="text-gray-600 mb-6 italic">
                    "I've been a Premium member for over a year now, and it's been worth every penny. Had to use their towing service twice and both times they were prompt and efficient. The app makes requesting help so easy. Highly recommend!"
                </blockquote>
                <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Michael Rodriguez" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-bold text-gray-900">Michael Rodriguez</h4>
                        <p class="text-gray-500 text-sm">Chicago, IL</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="card p-8" data-aos="fade-up" data-aos-delay="250">
                <div class="flex mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @endfor
                </div>
                <blockquote class="text-gray-600 mb-6 italic">
                    "Locked my keys in my car at the mall with my toddler's stroller inside. Called HT Roadside in a panic and they sent someone right away. The technician was so kind and got my car unlocked in minutes. They saved my day!"
                </blockquote>
                <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Jennifer Taylor" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-bold text-gray-900">Jennifer Taylor</h4>
                        <p class="text-gray-500 text-sm">Dallas, TX</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('testimonials') }}" class="btn btn-outline">
                Read More Testimonials
            </a>
        </div>
    </div>
</section>
