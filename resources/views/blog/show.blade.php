@extends('layouts.app')

@section('title', $post->title)

@section('meta')
    <meta name="description" content="{{ $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}">
    <meta name="keywords" content="{{ $post->meta_keywords }}">
    
    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->meta_title ?? $post->title }}">
    <meta property="og:description" content="{{ $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}">
    @if($post->featured_image)
        <meta property="og:image" content="{{ asset('storage/' . $post->featured_image) }}">
    @endif
    <meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
    <meta property="article:author" content="{{ $post->author->name }}">
    @foreach($post->tags as $tag)
        <meta property="article:tag" content="{{ $tag->name }}">
    @endforeach
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center text-sm text-primary-200 mb-4" data-aos="fade-up">
                    <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog</a>
                    <span class="mx-2">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </span>
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-white transition-colors">
                        {{ $post->category->name }}
                    </a>
                    <span class="mx-2">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </span>
                    <span>{{ Str::limit($post->title, 30) }}</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6" data-aos="fade-up">
                    {{ $post->title }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-4 mb-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center">
                        <img src="{{ $post->author->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}" alt="{{ $post->author->name }}" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <div class="font-medium">{{ $post->author->name }}</div>
                            <div class="text-xs text-primary-200">Author</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center text-primary-200">
                        <i class="far fa-calendar-alt mr-2"></i>
                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex items-center text-primary-200">
                        <i class="far fa-clock mr-2"></i>
                        <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                    </div>
                    
                    <div class="flex items-center text-primary-200">
                        <i class="far fa-eye mr-2"></i>
                        <span>{{ $post->view_count }} views</span>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2" data-aos="fade-up" data-aos-delay="200">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}" class="bg-primary-700 hover:bg-primary-600 text-white rounded-full px-3 py-1 text-sm transition-colors">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
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
    
    <!-- Featured Image -->
    @if($post->featured_image)
        <div class="bg-white py-10">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="rounded-lg overflow-hidden shadow-lg" data-aos="fade-up">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Blog Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row max-w-6xl mx-auto">
                <!-- Main Content -->
                <div class="lg:w-2/3 lg:pr-12">
                    <!-- Article Content -->
                    <article class="prose prose-lg max-w-none mb-12" data-aos="fade-up">
                        {!! $post->content !!}
                    </article>
                    
                    <!-- Share Buttons -->
                    <div class="border-t border-b border-gray-200 py-6 mb-12" data-aos="fade-up">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Share This Article</h3>
                        <div class="flex space-x-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" rel="noopener noreferrer" class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="bg-blue-400 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-blue-500 transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="bg-blue-700 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-blue-800 transition-colors">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . route('blog.show', $post->slug)) }}" target="_blank" rel="noopener noreferrer" class="bg-green-500 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-green-600 transition-colors">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode('Check out this article: ' . route('blog.show', $post->slug)) }}" class="bg-gray-600 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-gray-700 transition-colors">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Author Bio -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-12" data-aos="fade-up">
                        <div class="flex items-start">
                            <img src="{{ $post->author->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}" alt="{{ $post->author->name }}" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">About {{ $post->author->name }}</h3>
                                <p class="text-gray-600 mb-4">
                                    {{ $post->author->bio ?? 'Author at HT Roadside Assistance, sharing insights about roadside assistance, vehicle maintenance, and road safety.' }}
                                </p>
                                <div class="flex space-x-3">
                                    @if($post->author->twitter)
                                        <a href="{{ $post->author->twitter }}" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-500">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    @endif
                                    @if($post->author->linkedin)
                                        <a href="{{ $post->author->linkedin }}" target="_blank" rel="noopener noreferrer" class="text-blue-700 hover:text-blue-800">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    @endif
                                    @if($post->author->website)
                                        <a href="{{ $post->author->website }}" target="_blank" rel="noopener noreferrer" class="text-gray-700 hover:text-gray-900">
                                            <i class="fas fa-globe"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Post Navigation -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12" data-aos="fade-up">
                        @if($previousPost)
                            <a href="{{ route('blog.show', $previousPost->slug) }}" class="bg-white border border-gray-200 rounded-lg p-4 flex items-center hover:border-primary-300 hover:shadow-md transition-all">
                                <div class="mr-4 text-gray-400">
                                    <i class="fas fa-arrow-left text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Previous Article</div>
                                    <h4 class="font-semibold text-gray-900">{{ Str::limit($previousPost->title, 40) }}</h4>
                                </div>
                            </a>
                        @else
                            <div></div>
                        @endif
                        
                        @if($nextPost)
                            <a href="{{ route('blog.show', $nextPost->slug) }}" class="bg-white border border-gray-200 rounded-lg p-4 flex items-center hover:border-primary-300 hover:shadow-md transition-all">
                                <div class="flex-grow">
                                    <div class="text-sm text-gray-500">Next Article</div>
                                    <h4 class="font-semibold text-gray-900">{{ Str::limit($nextPost->title, 40) }}</h4>
                                </div>
                                <div class="ml-4 text-gray-400">
                                    <i class="fas fa-arrow-right text-xl"></i>
                                </div>
                            </a>
                        @else
                            <div></div>
                        @endif
                    </div>
                    
                    <!-- Comments Section -->
                    <div class="mb-12" data-aos="fade-up">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Comments ({{ $post->comments->count() }})</h3>
                        
                        @if($post->comments->count() > 0)
                            <div class="space-y-6 mb-8">
                                @foreach($post->comments->where('parent_id', null) as $comment)
                                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                                        <div class="flex items-start">
                                            <img src="{{ $comment->user ? ($comment->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name)) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->author_name) }}" alt="{{ $comment->user ? $comment->user->name : $comment->author_name }}" class="w-10 h-10 rounded-full mr-4">
                                            <div class="flex-grow">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div>
                                                        <h4 class="font-bold text-gray-900">{{ $comment->user ? $comment->user->name : $comment->author_name }}</h4>
                                                        <div class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                                    </div>
                                                    <button class="text-gray-500 hover:text-primary-600 reply-btn" data-comment-id="{{ $comment->id }}">
                                                        <i class="fas fa-reply mr-1"></i> Reply
                                                    </button>
                                                </div>
                                                <div class="text-gray-700 mb-4">
                                                    {{ $comment->content }}
                                                </div>
                                                
                                                <!-- Reply Form (Hidden by default) -->
                                                <div class="reply-form hidden mb-4" id="reply-form-{{ $comment->id }}">
                                                    <form action="{{ route('blog.comment.store', $post->slug) }}" method="POST" class="bg-gray-50 rounded-lg p-4">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        
                                                        <div class="mb-4">
                                                            <textarea name="content" rows="3" class="form-input w-full" placeholder="Write your reply..."></textarea>
                                                        </div>
                                                        
                                                        @guest
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                                <div>
                                                                    <input type="text" name="author_name" class="form-input w-full" placeholder="Your Name *" required>
                                                                </div>
                                                                <div>
                                                                    <input type="email" name="author_email" class="form-input w-full" placeholder="Your Email *" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-4">
                                                                <input type="url" name="author_website" class="form-input w-full" placeholder="Your Website (optional)">
                                                            </div>
                                                        @endguest
                                                        
                                                        <div class="flex justify-end">
                                                            <button type="button" class="btn btn-outline mr-2 cancel-reply" data-comment-id="{{ $comment->id }}">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                Post Reply
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                
                                                <!-- Replies -->
                                                @if($comment->replies->count() > 0)
                                                    <div class="mt-4 space-y-4 pl-6 border-l-2 border-gray-200">
                                                        @foreach($comment->replies as $reply)
                                                            <div class="bg-gray-50 rounded-lg p-4">
                                                                <div class="flex items-start">
                                                                    <img src="{{ $reply->user ? ($reply->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name)) : 'https://ui-avatars.com/api/?name=' . urlencode($reply->author_name) }}" alt="{{ $reply->user ? $reply->user->name : $reply->author_name }}" class="w-8 h-8 rounded-full mr-3">
                                                                    <div>
                                                                        <div class="flex items-center mb-1">
                                                                            <h5 class="font-bold text-gray-900">{{ $reply->user ? $reply->user->name : $reply->author_name }}</h5>
                                                                            <span class="mx-2 text-gray-400">•</span>
                                                                            <span class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                                        </div>
                                                                        <div class="text-gray-700">
                                                                            {{ $reply->content }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-6 text-center mb-8">
                                <p class="text-gray-600">Be the first to comment on this article!</p>
                            </div>
                        @endif
                        
                        <!-- Comment Form -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6" id="comment-form">
                            <h4 class="text-xl font-bold text-gray-900 mb-4">Leave a Comment</h4>
                            
                            <form action="{{ route('blog.comment.store', $post->slug) }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <textarea name="content" rows="4" class="form-input w-full" placeholder="Write your comment..."></textarea>
                                </div>
                                
                                @guest
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <input type="text" name="author_name" class="form-input w-full" placeholder="Your Name *" required>
                                        </div>
                                        <div>
                                            <input type="email" name="author_email" class="form-input w-full" placeholder="Your Email *" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <input type="url" name="author_website" class="form-input w-full" placeholder="Your Website (optional)">
                                    </div>
                                    <div class="mb-6">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="save_info" id="save_info" class="form-checkbox">
                                            <label for="save_info" class="ml-2 text-gray-700">Save my name, email, and website in this browser for the next time I comment.</label>
                                        </div>
                                    </div>
                                @endguest
                                
                                <button type="submit" class="btn btn-primary">
                                    Post Comment
                                </button>
                                
                                @guest
                                    <div class="mt-4 text-sm text-gray-600">
                                        <p>Your comment will be reviewed before it appears. <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700">Login</a> to post immediately.</p>
                                    </div>
                                @endguest
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:w-1/3 mt-12 lg:mt-0">
                    <!-- Related Posts -->
                    @if($relatedPosts->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-8" data-aos="fade-up">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Related Articles</h3>
                            <div class="space-y-4">
                                @foreach($relatedPosts as $relatedPost)
                                    <div class="flex items-start">
                                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="shrink-0 w-20 h-20 bg-gray-200 rounded-lg overflow-hidden mr-4">
                                            @if($relatedPost->featured_image)
                                                <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-newspaper text-gray-400"></i>
                                                </div>
                                            @endif
                                        </a>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">
                                                <a href="{{ route('blog.show', $relatedPost->slug) }}" class="hover:text-primary-600 transition-colors">
                                                    {{ Str::limit($relatedPost->title, 50) }}
                                                </a>
                                            </h4>
                                            <div class="text-sm text-gray-500">
                                                {{ $relatedPost->published_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Category -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Category</h3>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                {{ $post->category->name }}
                            </a>
                            <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded-full">
                                {{ $post->category->posts->count() }} posts
                            </span>
                        </div>
                        @if($post->category->description)
                            <p class="text-gray-600 mt-2 text-sm">
                                {{ $post->category->description }}
                            </p>
                        @endif
                    </div>
                    
                    <!-- Tags -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" class="inline-block bg-gray-100 hover:bg-primary-100 text-gray-800 hover:text-primary-800 rounded-full px-3 py-1 text-sm transition-colors">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Newsletter Signup -->
                    <div class="bg-primary-800 text-white rounded-lg shadow-sm p-6" data-aos="fade-up" data-aos-delay="300">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reply functionality
        const replyButtons = document.querySelectorAll('.reply-btn');
        const cancelButtons = document.querySelectorAll('.cancel-reply');
        
        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                document.getElementById(`reply-form-${commentId}`).classList.remove('hidden');
            });
        });
        
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                document.getElementById(`reply-form-${commentId}`).classList.add('hidden');
            });
        });
    });
</script>
@endpush
