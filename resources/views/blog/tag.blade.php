@extends('layouts.app')

@section('title', '#' . $tag->name . ' - Blog')

@section('meta')
    <meta name="description" content="Browse all articles tagged with {{ $tag->name }} on HT Roadside Assistance blog.">
    <meta name="keywords" content="{{ $tag->name }}, roadside assistance, blog, articles">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <div class="flex items-center justify-center text-sm text-primary-200 mb-4" data-aos="fade-up">
                    <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog</a>
                    <span class="mx-2">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </span>
                    <span>Tag</span>
                    <span class="mx-2">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </span>
                    <span>{{ $tag->name }}</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6" data-aos="fade-up">
                    #{{ $tag->name }}
                </h1>
                
                <div class="text-primary-200" data-aos="fade-up" data-aos-delay="100">
                    <span class="bg-primary-700 rounded-full px-4 py-2">
                        {{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="relative h-16 mt-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="absolute bottom-0 text-white fill-current">
                <path d="M0,96L60,80C120,64,240,32,360,21.3C480,11,600,21,720,42.7C840,64,960,96,1080,96C1200,96,1320,64,1380,48L1440,32L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
            </svg>
        </div>
    </section>
    
    <!-- Blog Posts Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row max-w-6xl mx-auto">
                <!-- Main Content -->
                <div class="lg:w-2/3 lg:pr-12">
                    @if($posts->count() > 0)
                        <!-- Posts Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                            @foreach($posts as $post)
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                        <div class="h-48 bg-gray-200 overflow-hidden">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform hover:scale-105">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-newspaper text-gray-400 text-4xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    
                                    <div class="p-6">
                                        <div class="flex items-center mb-2">
                                            <a href="{{ route('blog.category', $post->category->slug) }}" class="text-xs font-semibold uppercase tracking-wider bg-primary-100 text-primary-800 rounded-full px-2 py-1 hover:bg-primary-200 transition-colors">
                                                {{ $post->category->name }}
                                            </a>
                                        </div>
                                        
                                        <div class="flex items-center text-sm text-gray-500 mb-2">
                                            <span class="flex items-center">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ $post->published_at->format('M d, Y') }}
                                            </span>
                                            <span class="mx-2">•</span>
                                            <span class="flex items-center">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                                            </span>
                                        </div>
                                        
                                        <h2 class="text-xl font-bold text-gray-900 mb-2 hover:text-primary-600">
                                            <a href="{{ route('blog.show', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>
                                        </h2>
                                        
                                        <p class="text-gray-600 mb-4">
                                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                                        </p>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <img src="{{ $post->author->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}" alt="{{ $post->author->name }}" class="w-8 h-8 rounded-full mr-2">
                                                <span class="text-sm text-gray-700">{{ $post->author->name }}</span>
                                            </div>
                                            
                                            <a href="{{ route('blog.show', $post->slug) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                                                Read More <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mb-12" data-aos="fade-up">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-12 text-center mb-12" data-aos="fade-up">
                            <i class="fas fa-tag text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Articles Found</h3>
                            <p class="text-gray-600 mb-6">
                                There are no articles with this tag yet. Please check back later or explore other tags.
                            </p>
                            <a href="{{ route('blog.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Blog
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="lg:w-1/3 mt-12 lg:mt-0">
                    <!-- Search -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8" data-aos="fade-up">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Search</h3>
                        <form action="{{ route('blog.search') }}" method="GET">
                            <div class="flex">
                                <input type="text" name="q" placeholder="Search articles..." class="form-input rounded-l-lg w-full" value="{{ request('q') }}">
                                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 rounded-r-lg">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Categories -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Categories</h3>
                        <ul class="space-y-2">
                            @foreach($categories as $category)
                                <li class="flex items-center justify-between">
                                    <a href="{{ route('blog.category', $category->slug) }}" class="text-gray-700 hover:text-primary-600 transition-colors">
                                        {{ $category->name }}
                                    </a>
                                    <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded-full">
                                        {{ $category->posts->count() }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Popular Tags -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Popular Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $t)
                                <a href="{{ route('blog.tag', $t->slug) }}" class="inline-block {{ $t->id === $tag->id ? 'bg-primary-100 text-primary-800 font-semibold' : 'bg-gray-100 text-gray-800 hover:bg-primary-100 hover:text-primary-800' }} rounded-full px-3 py-1 text-sm transition-colors">
                                    #{{ $t->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Recent Posts -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8" data-aos="fade-up" data-aos-delay="300">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Recent Posts</h3>
                        <div class="space-y-4">
                            @foreach($recentPosts as $recentPost)
                                <div class="flex items-start">
                                    <a href="{{ route('blog.show', $recentPost->slug) }}" class="shrink-0 w-20 h-20 bg-gray-200 rounded-lg overflow-hidden mr-4">
                                        @if($recentPost->featured_image)
                                            <img src="{{ asset('storage/' . $recentPost->featured_image) }}" alt="{{ $recentPost->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-newspaper text-gray-400"></i>
                                            </div>
                                        @endif
                                    </a>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-1">
                                            <a href="{{ route('blog.show', $recentPost->slug) }}" class="hover:text-primary-600 transition-colors">
                                                {{ Str::limit($recentPost->title, 50) }}
                                            </a>
                                        </h4>
                                        <div class="text-sm text-gray-500">
                                            {{ $recentPost->published_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Newsletter Signup -->
                    <div class="bg-primary-800 text-white rounded-lg shadow-sm p-6" data-aos="fade-up" data-aos-delay="400">
                        <h3 class="text-xl font-bold mb-4 border-b border-primary-700 pb-2">Subscribe to Our Newsletter</h3>
                        <p class="text-primary-100 mb-4">
                            Stay updated with our latest articles, tips, and roadside assistance news.
                        </p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <input type="email" name="email" placeholder="Your email address" required class="w-full rounded-lg border-primary-700 bg-primary-700 text-white placeholder-primary-300 px-4 py-3 focus:border-white focus:outline-none focus:ring-1 focus:ring-white">
                            </div>
                            <button type="submit" class="w-full bg-white text-primary-800 hover:bg-gray-100 font-semibold py-3 px-4 rounded-lg transition-colors">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary-800 to-primary-600 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6" data-aos="fade-up">Need Roadside Assistance?</h2>
                <p class="text-xl text-primary-100 mb-8" data-aos="fade-up" data-aos-delay="100">
                    We provide 24/7 emergency roadside assistance services to keep you moving.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('services.index') }}" class="btn btn-white">
                        Our Services
                    </a>
                    <a href="{{ route('request-service') }}" class="btn btn-secondary">
                        <i class="fas fa-wrench mr-2"></i> Request Service
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
