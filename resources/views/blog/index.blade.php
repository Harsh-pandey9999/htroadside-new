@extends('layouts.app')

@section('title', 'Blog')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6" data-aos="fade-up">HT Roadside Blog</h1>
                <p class="text-xl text-primary-100 mb-8" data-aos="fade-up" data-aos-delay="100">
                    Stay updated with the latest news, tips, and insights about roadside assistance and vehicle maintenance.
                </p>
                
                @if(request()->has('search'))
                    <div class="bg-primary-700 rounded-lg p-4 inline-block" data-aos="fade-up" data-aos-delay="200">
                        <p class="text-primary-100">Search results for: <span class="font-semibold">{{ request('search') }}</span></p>
                    </div>
                @elseif(request()->has('category'))
                    <div class="bg-primary-700 rounded-lg p-4 inline-block" data-aos="fade-up" data-aos-delay="200">
                        <p class="text-primary-100">Category: <span class="font-semibold">{{ $categories->where('slug', request('category'))->first()->name ?? 'Unknown' }}</span></p>
                    </div>
                @elseif(request()->has('tag'))
                    <div class="bg-primary-700 rounded-lg p-4 inline-block" data-aos="fade-up" data-aos-delay="200">
                        <p class="text-primary-100">Tag: <span class="font-semibold">{{ $tags->where('slug', request('tag'))->first()->name ?? 'Unknown' }}</span></p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="relative h-16 mt-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="absolute bottom-0 text-white fill-current">
                <path d="M0,96L60,80C120,64,240,32,360,21.3C480,11,600,21,720,42.7C840,64,960,96,1080,96C1200,96,1320,64,1380,48L1440,32L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
            </svg>
        </div>
    </section>
    
    <!-- Featured Posts Section (Only show on main blog page, not on search/category/tag pages) -->
    @if(!request()->has('search') && !request()->has('category') && !request()->has('tag') && $featuredPosts->count() > 0)
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center" data-aos="fade-up">Featured Articles</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($featuredPosts as $featuredPost)
                        <div class="card h-full flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="block relative overflow-hidden rounded-t-xl">
                                @if($featuredPost->featured_image)
                                    <img src="{{ asset('storage/' . $featuredPost->featured_image) }}" alt="{{ $featuredPost->title }}" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-newspaper text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="absolute top-0 right-0 bg-primary-600 text-white text-xs font-bold px-3 py-1 m-2 rounded">
                                    Featured
                                </div>
                            </a>
                            <div class="p-6 flex-grow flex flex-col">
                                <div class="mb-4">
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <span>{{ $featuredPost->published_at->format('M d, Y') }}</span>
                                        <span class="mx-2">•</span>
                                        <a href="{{ route('blog.category', $featuredPost->category->slug) }}" class="text-primary-600 hover:text-primary-700">
                                            {{ $featuredPost->category->name }}
                                        </a>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="hover:text-primary-600 transition-colors">
                                            {{ $featuredPost->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        {{ $featuredPost->excerpt ?? Str::limit(strip_tags($featuredPost->content), 120) }}
                                    </p>
                                </div>
                                <div class="mt-auto flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ $featuredPost->author->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($featuredPost->author->name) }}" alt="{{ $featuredPost->author->name }}" class="w-8 h-8 rounded-full mr-2">
                                        <span class="text-sm text-gray-700">{{ $featuredPost->author->name }}</span>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        <i class="far fa-eye mr-1"></i> {{ $featuredPost->view_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    <!-- Blog Posts Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row">
                <!-- Main Content -->
                <div class="lg:w-2/3 lg:pr-12">
                    <!-- Search Form -->
                    <div class="mb-10" data-aos="fade-up">
                        <form action="{{ route('blog.index') }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." class="form-input rounded-r-none flex-grow">
                            <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-r-lg hover:bg-primary-700 transition-colors">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    
                    @if($posts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($posts as $post)
                                <div class="card h-full flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="block relative overflow-hidden rounded-t-xl">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-newspaper text-4xl text-gray-400"></i>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="p-6 flex-grow flex flex-col">
                                        <div class="mb-4">
                                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                                <span class="mx-2">•</span>
                                                <a href="{{ route('blog.category', $post->category->slug) }}" class="text-primary-600 hover:text-primary-700">
                                                    {{ $post->category->name }}
                                                </a>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                                <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary-600 transition-colors">
                                                    {{ $post->title }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 mb-4">
                                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                                            </p>
                                        </div>
                                        <div class="mt-auto flex items-center justify-between">
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
                        <div class="mt-12" data-aos="fade-up">
                            {{ $posts->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-lg p-8 text-center" data-aos="fade-up">
                            <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No Posts Found</h3>
                            <p class="text-gray-600 mb-4">
                                We couldn't find any posts matching your criteria. Try adjusting your search or browse our categories.
                            </p>
                            <a href="{{ route('blog.index') }}" class="btn btn-primary">
                                View All Posts
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="lg:w-1/3 mt-12 lg:mt-0">
                    <!-- Categories -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8" data-aos="fade-up">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Categories</h3>
                        <ul class="space-y-2">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('blog.category', $category->slug) }}" class="flex items-center justify-between py-2 hover:text-primary-600 transition-colors {{ request('category') == $category->slug ? 'text-primary-600 font-semibold' : 'text-gray-700' }}">
                                        <span>{{ $category->name }}</span>
                                        <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded-full">{{ $category->posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Popular Tags -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Popular Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" class="inline-block bg-gray-100 hover:bg-primary-100 text-gray-800 hover:text-primary-800 rounded-full px-3 py-1 text-sm transition-colors {{ request('tag') == $tag->slug ? 'bg-primary-100 text-primary-800 font-semibold' : '' }}">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Newsletter Signup -->
                    <div class="bg-primary-800 text-white rounded-lg shadow-sm p-6" data-aos="fade-up" data-aos-delay="200">
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
