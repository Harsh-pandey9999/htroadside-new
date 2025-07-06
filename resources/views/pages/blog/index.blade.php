@extends('layouts.app')

@section('title', 'Expert Roadside Assistance Blog | HT Roadside')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary-700 to-primary-900 text-white overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <!-- Animated elements -->
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-primary-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute top-10 -left-10 w-48 h-48 bg-secondary-500 rounded-full opacity-10 animate-pulse" style="animation-delay: 1s"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 relative z-10">
            <div class="max-w-3xl" data-aos="fade-up">
                <span class="inline-block px-4 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-sm font-semibold mb-4 animate-on-scroll slide-in-left">EXPERT INSIGHTS & GUIDES</span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-on-scroll slide-in-left" style="animation-delay: 0.2s">Your Roadside Assistance Resource Center</h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-100 animate-on-scroll slide-in-left" style="animation-delay: 0.4s">Discover professional tips, industry insights, and expert advice to keep you safe and informed on the road</p>
                <div class="flex flex-wrap gap-4 animate-on-scroll slide-in-left" style="animation-delay: 0.6s">
                    <a href="#latest-posts" class="btn btn-white btn-hover-effect">
                        <i class="fas fa-newspaper mr-2"></i> Latest Articles
                    </a>
                    <a href="#categories" class="btn btn-outline text-white border-white hover:bg-white hover:bg-opacity-10 btn-hover-effect">
                        <i class="fas fa-th-large mr-2"></i> Browse Categories
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Posts Section -->
    <section id="latest-posts" class="py-20 bg-theme-primary dark:bg-dark-200 transition-colors duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-wrap -mx-4">
                    <!-- Main Content -->
                    <div class="w-full lg:w-2/3 px-4">
                        <!-- Section Header -->
                        <div class="mb-12" data-aos="fade-up">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 font-heading">Latest Insights</h2>
                            <div class="w-20 h-1 bg-primary-600 mb-6"></div>
                            <p class="text-gray-600 dark:text-gray-300">Stay informed with our latest articles, guides, and expert advice</p>
                        </div>
                        
                        <!-- Featured Post -->
                        @if(isset($featuredPost))
                        <div class="mb-12" data-aos="fade-up" data-aos-delay="100">
                            <div class="blog-card bg-white dark:bg-dark-100 rounded-xl shadow-md overflow-hidden relative group">
                                <!-- Card overlay with gradient -->
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black opacity-60 transition-opacity duration-300 group-hover:opacity-70"></div>
                                
                                <!-- Featured tag -->
                                <div class="absolute top-4 right-4 z-10">
                                    <span class="bg-primary-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                                        Featured
                                    </span>
                                </div>
                                
                                <!-- Lazy-loaded image with blur-up technique -->
                                <div class="relative h-96 overflow-hidden">
                                    <img 
                                        data-src="{{ asset($featuredPost->featured_image) }}" 
                                        src="{{ asset($featuredPost->featured_image) }}" 
                                        alt="{{ $featuredPost->title }}" 
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105"
                                    >
                                </div>
                                
                                <!-- Content positioned over the image at the bottom -->
                                <div class="absolute bottom-0 left-0 right-0 p-6 z-10">
                                    <div class="flex items-center mb-3">
                                        <span class="bg-white bg-opacity-90 dark:bg-dark-100 dark:bg-opacity-90 text-primary-800 dark:text-primary-400 text-xs font-semibold px-3 py-1 rounded-full">
                                            {{ $featuredPost->category->name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="text-white text-sm ml-4 flex items-center">
                                            <i class="far fa-calendar-alt mr-1"></i> {{ $featuredPost->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <h2 class="text-2xl md:text-3xl font-bold mb-3 text-white">
                                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="hover:text-primary-300 transition-colors">
                                            {{ $featuredPost->title }}
                                        </a>
                                    </h2>
                                    <p class="text-gray-100 mb-4 line-clamp-2">
                                        {{ $featuredPost->excerpt }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img 
                                                src="{{ asset($featuredPost->author->profile_photo_url ?? 'img/default-avatar.png') }}" 
                                                alt="{{ $featuredPost->author->name ?? 'Author' }}" 
                                                class="w-10 h-10 rounded-full border-2 border-white mr-3"
                                            >
                                            <div>
                                                <p class="text-sm font-semibold text-white">{{ $featuredPost->author->name ?? 'Admin' }}</p>
                                                <p class="text-xs text-gray-200">{{ $featuredPost->author->position ?? 'Author' }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="btn-primary py-2 px-4 rounded-lg text-sm transform transition hover:translate-x-1">
                                            Read Article <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Blog Posts -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @forelse($posts as $post)
                            <div class="blog-card bg-white dark:bg-dark-100 rounded-xl shadow-md overflow-hidden group relative animate-on-scroll" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <!-- Card overlay -->
                                <div class="card-overlay"></div>
                                
                                <!-- Image container with hover effect -->
                                <div class="relative h-52 overflow-hidden">
                                    <img 
                                        data-src="{{ asset($post->featured_image) }}" 
                                        src="{{ asset($post->featured_image) }}" 
                                        alt="{{ $post->title }}" 
                                        class="lazy-image w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105"
                                    >
                                    <!-- Category badge positioned on the image -->
                                    <div class="absolute top-3 right-3 z-10">
                                        <span class="bg-white dark:bg-dark-100 bg-opacity-90 dark:bg-opacity-90 text-primary-800 dark:text-primary-400 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                                            {{ $post->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="p-6 relative z-10">
                                    <!-- Date and reading time -->
                                    <div class="flex items-center justify-between mb-3 text-gray-500 dark:text-gray-400 text-xs">
                                        <span class="flex items-center">
                                            <i class="far fa-calendar-alt mr-1"></i> {{ $post->created_at->format('M d, Y') }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="far fa-clock mr-1"></i> {{ ceil(str_word_count($post->content) / 200) }} min read
                                        </span>
                                    </div>
                                    
                                    <!-- Title with hover effect -->
                                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">
                                        <a href="{{ route('blog.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    
                                    <!-- Excerpt with line clamping -->
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                                        {{ Str::limit($post->excerpt, 120) }}
                                    </p>
                                    
                                    <!-- Author and read more link -->
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center">
                                            <img 
                                                src="{{ asset($post->author->profile_photo_url ?? 'img/default-avatar.png') }}" 
                                                alt="{{ $post->author->name ?? 'Author' }}" 
                                                class="w-8 h-8 rounded-full mr-2 border border-gray-200 dark:border-gray-700"
                                            >
                                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $post->author->name ?? 'Admin' }}</p>
                                        </div>
                                        <a href="{{ route('blog.show', $post->slug) }}" class="text-primary-600 dark:text-primary-400 text-sm font-semibold hover:text-primary-700 dark:hover:text-primary-300 transition-all duration-300 transform hover:translate-x-1">
                                            Read More <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-2 py-12 text-center bg-white dark:bg-dark-100 rounded-xl shadow-md" data-aos="fade-up">
                                <div class="flex flex-col items-center justify-center p-6">
                                    <i class="fas fa-newspaper text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">No Articles Yet</h3>
                                    <p class="text-gray-500 dark:text-gray-400">We're working on creating valuable content for you. Check back soon!</p>
                                </div>
                            </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $posts->links() }}
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="w-full lg:w-1/3 px-4 mt-12 lg:mt-0">
                        <!-- Search -->
                        <div id="search-box" class="bg-white dark:bg-dark-100 rounded-xl shadow-md p-6 mb-8 animate-on-scroll" data-aos="fade-left">
                            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-search mr-2 text-primary-600 dark:text-primary-400"></i> Search Articles
                            </h3>
                            <form action="{{ route('blog.index') }}" method="GET">
                                <div class="relative">
                                    <input type="text" name="search" placeholder="What are you looking for?" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-dark-200 dark:text-white pr-10 transition-all duration-300">
                                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Categories -->
                        <div id="categories" class="bg-white dark:bg-dark-100 rounded-xl shadow-md p-6 mb-8 animate-on-scroll" data-aos="fade-left" data-aos-delay="100">
                            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-th-large mr-2 text-primary-600 dark:text-primary-400"></i> Categories
                            </h3>
                            <ul class="space-y-3">
                                @forelse($categories ?? [] as $category)
                                <li class="transform transition-transform duration-300 hover:translate-x-1">
                                    <a href="{{ route('blog.category', $category->slug) }}" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-dark-200 hover:bg-primary-50 dark:hover:bg-primary-900/20 text-gray-700 dark:text-gray-300 hover:text-primary-700 dark:hover:text-primary-400 transition-colors">
                                        <span class="font-medium">{{ $category->name }}</span>
                                        <span class="bg-white dark:bg-dark-100 text-primary-700 dark:text-primary-400 text-xs font-semibold px-2 py-1 rounded-full shadow-sm">
                                            {{ $category->posts_count ?? 0 }}
                                        </span>
                                    </a>
                                </li>
                                @empty
                                <li class="p-3 rounded-lg bg-gray-50 dark:bg-dark-200 text-gray-500 dark:text-gray-400 text-center">
                                    <i class="fas fa-folder-open mr-2"></i> No categories found
                                </li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Popular Posts -->
                        <div class="bg-white dark:bg-dark-100 rounded-xl shadow-md p-6 mb-8 animate-on-scroll" data-aos="fade-left" data-aos-delay="200">
                            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-fire mr-2 text-primary-600 dark:text-primary-400"></i> Popular Articles
                            </h3>
                            <div class="space-y-4">
                                @forelse($popularPosts ?? [] as $popularPost)
                                <div class="flex items-start p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-dark-200 transition-colors group">
                                    <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 mr-4">
                                        <img 
                                            src="{{ asset($popularPost->featured_image) }}" 
                                            alt="{{ $popularPost->title }}" 
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        >
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-sm mb-1 line-clamp-2">
                                            <a href="{{ route('blog.show', $popularPost->slug) }}" class="text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                                {{ $popularPost->title }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-xs">
                                            <span class="flex items-center mr-3">
                                                <i class="far fa-calendar-alt mr-1"></i> {{ $popularPost->created_at->format('M d, Y') }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="far fa-eye mr-1"></i> {{ $popularPost->views ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="p-4 rounded-lg bg-gray-50 dark:bg-dark-200 text-gray-500 dark:text-gray-400 text-center">
                                    <i class="fas fa-chart-line mr-2"></i> No popular posts yet
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="bg-white dark:bg-dark-100 rounded-xl shadow-md p-6 mb-8 animate-on-scroll" data-aos="fade-left" data-aos-delay="300">
                            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-tags mr-2 text-primary-600 dark:text-primary-400"></i> Popular Tags
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @forelse($tags ?? [] as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" class="bg-gray-100 dark:bg-dark-200 text-gray-700 dark:text-gray-300 hover:bg-primary-100 dark:hover:bg-primary-900/30 hover:text-primary-700 dark:hover:text-primary-400 text-xs font-semibold px-3 py-2 rounded-full transition-colors">
                                    <i class="fas fa-tag mr-1 text-gray-400 dark:text-gray-500"></i> {{ $tag->name }}
                                </a>
                                @empty
                                <div class="w-full p-4 rounded-lg bg-gray-50 dark:bg-dark-200 text-gray-500 dark:text-gray-400 text-center">
                                    <i class="fas fa-tags mr-2"></i> No tags found
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Newsletter -->
                        <div class="bg-gradient-to-br from-primary-600 to-primary-800 dark:from-primary-800 dark:to-primary-900 rounded-xl shadow-md p-6 text-white animate-on-scroll" data-aos="fade-left" data-aos-delay="400">
                            <div class="relative overflow-hidden">
                                <!-- Decorative elements -->
                                <div class="absolute -top-6 -right-6 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
                                <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white bg-opacity-10 rounded-full"></div>
                                
                                <h3 class="text-xl font-bold mb-2 relative">Stay Updated</h3>
                                <p class="text-primary-100 text-sm mb-4 relative">Get expert roadside assistance tips and exclusive offers delivered to your inbox.</p>
                                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="relative">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="email" name="email" placeholder="Your email address" required class="w-full px-4 py-3 bg-white bg-opacity-20 backdrop-blur-sm border border-white border-opacity-20 rounded-lg focus:ring-white focus:border-white text-white placeholder-primary-100 outline-none">
                                    </div>
                                    <button type="submit" class="btn-white w-full btn-hover-effect">
                                        <i class="fas fa-paper-plane mr-2"></i> Subscribe Now
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Emergency Contact -->
                        <div class="bg-white dark:bg-dark-100 rounded-xl shadow-md p-6 border-l-4 border-red-600 animate-on-scroll" data-aos="fade-left" data-aos-delay="500">
                            <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-phone-alt mr-2 text-red-600"></i> Emergency Assistance
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">Need immediate roadside help? Our team is available 24/7 for emergency assistance.</p>
                            <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '18001234567')) }}" class="btn bg-red-600 hover:bg-red-700 text-white w-full flex items-center justify-center pulse">
                                <i class="fas fa-phone-alt mr-2"></i> Call Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary-700 to-primary-900 text-white relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-full h-20 bg-white opacity-5" style="transform: skewY(-3deg) translateY(-50%)"></div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-white rounded-full opacity-10 animate-pulse"></div>
        <div class="absolute top-10 -left-10 w-48 h-48 bg-white rounded-full opacity-5 animate-pulse" style="animation-delay: 1.5s"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Need Roadside Assistance Right Now?</h2>
                <p class="text-xl text-primary-100 mb-8">Our professional team is available 24/7 to help you with any roadside emergency. One call away from expert assistance.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', settings('contact_phone', '18001234567')) }}" class="btn bg-white text-primary-700 hover:bg-gray-100 btn-hover-effect">
                        <i class="fas fa-phone-alt mr-2"></i> Call for Assistance
                    </a>
                    <a href="{{ route('services.index') }}" class="btn border-2 border-white text-white hover:bg-white hover:bg-opacity-10 btn-hover-effect">
                        <i class="fas fa-info-circle mr-2"></i> Learn About Our Services
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-primary-800 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Need Roadside Assistance?</h2>
                <p class="text-xl mb-8">We're available 24/7 to help you get back on the road</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('plans.index') }}" class="btn-white">
                        <i class="fas fa-shield-alt mr-2"></i> View Our Plans
                    </a>
                    <a href="{{ route('contact') }}" class="btn-outline-white">
                        <i class="fas fa-phone-alt mr-2"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
