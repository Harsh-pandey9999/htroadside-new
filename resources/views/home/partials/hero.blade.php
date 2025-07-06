<section class="relative bg-gradient-to-r from-primary-900 to-primary-700 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#grid)"/>
        </svg>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 relative z-10">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-heading leading-tight mb-6">
                    24/7 Roadside Assistance You Can Trust
                </h1>
                <p class="text-xl text-primary-100 mb-8 max-w-lg">
                    We're here when you need us most. Fast, reliable roadside assistance services to get you back on the road quickly and safely.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('services.index') }}" class="btn btn-white">
                        Our Services
                    </a>
                    <a href="{{ route('request-service.store') }}" class="btn btn-secondary">
                        <i class="fas fa-wrench mr-2"></i> Request Service
                    </a>
                </div>
                
                <div class="mt-10 flex items-center">
                    <div class="flex -space-x-2">
                        <img src="https://randomuser.me/api/portraits/women/21.jpg" alt="Customer" class="w-10 h-10 rounded-full border-2 border-white">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Customer" class="w-10 h-10 rounded-full border-2 border-white">
                        <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Customer" class="w-10 h-10 rounded-full border-2 border-white">
                        <img src="https://randomuser.me/api/portraits/men/18.jpg" alt="Customer" class="w-10 h-10 rounded-full border-2 border-white">
                    </div>
                    <div class="ml-4">
                        <div class="flex items-center">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-white">4.9/5 from 2,000+ reviews</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="md:w-1/2 md:pl-10" data-aos="fade-left">
                <div class="relative">
                    <div class="absolute inset-0 bg-primary-500 rounded-lg transform rotate-3"></div>
                    <img src="{{ asset('images/wbg/car-with-map.png') }}" alt="Roadside Assistance" class="relative rounded-lg shadow-2xl z-10">
                    
                    <!-- Emergency Badge -->
                    <div class="absolute -top-5 -right-5 bg-red-600 text-white rounded-full px-4 py-2 shadow-lg z-20 flex items-center">
                        <i class="fas fa-phone-alt mr-2"></i>
                        <span class="font-bold">24/7 Emergency</span>
                    </div>
                    
                    <!-- Features Badge -->
                    <div class="absolute -bottom-5 -left-5 bg-white text-primary-800 rounded-lg px-4 py-3 shadow-lg z-20">
                        <div class="flex items-center space-x-3">
                            <div class="flex flex-col items-center justify-center bg-primary-100 rounded-full w-10 h-10">
                                <i class="fas fa-bolt text-primary-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold">Fast Response</p>
                                <p class="text-xs text-gray-600">Average 30 min arrival</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="text-gray-50 fill-current">
            <path d="M0,96L60,80C120,64,240,32,360,21.3C480,11,600,21,720,42.7C840,64,960,96,1080,96C1200,96,1320,64,1380,48L1440,32L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z"></path>
        </svg>
    </div>
</section>
