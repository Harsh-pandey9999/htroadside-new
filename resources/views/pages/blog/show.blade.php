@extends('layouts.app')

@section('title', $post->title ?? 'Blog Post')

@section('meta')
    <meta name="description" content="{{ $post->meta_description ?? $post->excerpt ?? 'HT Roadside Assistance blog post' }}">
    <meta property="og:title" content="{{ $post->title ?? 'Blog Post' }} - HT Roadside Assistance">
    <meta property="og:description" content="{{ $post->meta_description ?? $post->excerpt ?? 'HT Roadside Assistance blog post' }}">
    <meta property="og:image" content="{{ asset($post->featured_image ?? 'img/default-post.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="w-full h-96 bg-cover bg-center" style="background-image: url('{{ asset($post->featured_image ?? 'img/default-post.jpg') }}')">
            <div class="absolute inset-0 bg-black opacity-60"></div>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center relative z-10">
                <div class="max-w-4xl">
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="bg-primary-100 text-primary-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>
                        <span class="text-white text-sm">
                            <i class="far fa-calendar-alt mr-1"></i> {{ $post->created_at->format('M d, Y') }}
                        </span>
                        <span class="text-white text-sm">
                            <i class="far fa-clock mr-1"></i> {{ $post->reading_time ?? '5' }} min read
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $post->title }}</h1>
                    <div class="flex items-center">
                        <img src="{{ asset($post->author->profile_photo_url ?? 'img/default-avatar.png') }}" alt="{{ $post->author->name ?? 'Author' }}" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="text-white font-semibold">{{ $post->author->name ?? 'Admin' }}</p>
                            <p class="text-gray-300">{{ $post->author->position ?? 'Author' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-wrap -mx-4">
                    <!-- Main Content -->
                    <div class="w-full lg:w-2/3 px-4">
                        <!-- Article Content -->
                        <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                            <!-- Social Share -->
                            <div class="flex items-center justify-between mb-8 pb-4 border-b">
                                <div class="flex items-center">
                                    <span class="text-gray-600 mr-4">Share:</span>
                                    <div class="flex space-x-3">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="text-gray-500 hover:text-blue-600">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="text-gray-500 hover:text-blue-400">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" class="text-gray-500 hover:text-blue-700">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="text-gray-500 hover:text-green-600">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-gray-600">
                                        <i class="far fa-eye mr-1"></i> {{ $post->views ?? '0' }} views
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Article Body -->
                            <div class="prose prose-lg max-w-none">
                                {!! $post->content !!}
                            </div>
                            
                            <!-- Tags -->
                            @if(isset($post->tags) && $post->tags->count() > 0)
                            <div class="mt-8 pt-6 border-t">
                                <div class="flex items-center flex-wrap gap-2">
                                    <span class="text-gray-700 font-semibold">Tags:</span>
                                    @foreach($post->tags as $tag)
                                    <a href="{{ route('blog.tag', $tag->slug) }}" class="bg-gray-100 text-gray-700 hover:bg-primary-100 hover:text-primary-700 text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ $tag->name }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <!-- Author Bio -->
                            <div class="mt-8 pt-6 border-t">
                                <div class="flex flex-col md:flex-row items-center md:items-start">
                                    <img src="{{ asset($post->author->profile_photo_url ?? 'img/default-avatar.png') }}" alt="{{ $post->author->name ?? 'Author' }}" class="w-24 h-24 rounded-full mb-4 md:mb-0 md:mr-6">
                                    <div>
                                        <h3 class="text-xl font-bold mb-2">{{ $post->author->name ?? 'Admin' }}</h3>
                                        <p class="text-gray-600 mb-4">{{ $post->author->bio ?? 'HT Roadside Assistance team member passionate about providing the best roadside assistance services across India.' }}</p>
                                        <div class="flex space-x-4">
                                            @if(isset($post->author->twitter))
                                            <a href="{{ $post->author->twitter }}" target="_blank" class="text-gray-500 hover:text-blue-400">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            @endif
                                            @if(isset($post->author->facebook))
                                            <a href="{{ $post->author->facebook }}" target="_blank" class="text-gray-500 hover:text-blue-600">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                            @endif
                                            @if(isset($post->author->linkedin))
                                            <a href="{{ $post->author->linkedin }}" target="_blank" class="text-gray-500 hover:text-blue-700">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comments Section -->
                        <div class="mt-8 bg-white rounded-lg shadow-md p-6 md:p-8">
                            <h3 class="text-2xl font-bold mb-6">Comments ({{ $post->comments_count ?? '0' }})</h3>
                            
                            <!-- Comment Form -->
                            <div class="mb-8">
                                <h4 class="text-lg font-semibold mb-4">Leave a Comment</h4>
                                <form action="{{ route('blog.comments.store', $post->id) }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                            @error('name')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                            @error('email')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                                        <textarea id="comment" name="comment" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn-primary">
                                        <i class="fas fa-paper-plane mr-2"></i> Post Comment
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Comments List -->
                            <div class="space-y-6">
                                @forelse($post->comments ?? [] as $comment)
                                <div class="border-b pb-6 last:border-b-0 last:pb-0">
                                    <div class="flex items-start">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->name) }}&background=random" alt="{{ $comment->name }}" class="w-12 h-12 rounded-full mr-4">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="font-semibold">{{ $comment->name }}</h4>
                                                <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700">{{ $comment->content }}</p>
                                            
                                            <!-- Reply Button -->
                                            <button class="text-primary-600 text-sm font-medium mt-2 reply-toggle" data-comment-id="{{ $comment->id }}">
                                                <i class="fas fa-reply mr-1"></i> Reply
                                            </button>
                                            
                                            <!-- Reply Form (Hidden by default) -->
                                            <div class="reply-form hidden mt-4" id="reply-form-{{ $comment->id }}">
                                                <form action="{{ route('blog.comments.reply', [$post->id, $comment->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label for="reply-name-{{ $comment->id }}" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                                            <input type="text" id="reply-name-{{ $comment->id }}" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                                        </div>
                                                        <div>
                                                            <label for="reply-email-{{ $comment->id }}" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                                            <input type="email" id="reply-email-{{ $comment->id }}" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="reply-comment-{{ $comment->id }}" class="block text-sm font-medium text-gray-700 mb-1">Reply</label>
                                                        <textarea id="reply-comment-{{ $comment->id }}" name="comment" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500"></textarea>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <button type="submit" class="btn-primary btn-sm">
                                                            <i class="fas fa-paper-plane mr-2"></i> Post Reply
                                                        </button>
                                                        <button type="button" class="ml-3 text-gray-500 text-sm font-medium cancel-reply" data-comment-id="{{ $comment->id }}">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <!-- Replies -->
                                            @if(isset($comment->replies) && $comment->replies->count() > 0)
                                            <div class="mt-4 pl-4 border-l-2 border-gray-200">
                                                @foreach($comment->replies as $reply)
                                                <div class="mb-4 last:mb-0">
                                                    <div class="flex items-start">
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->name) }}&background=random" alt="{{ $reply->name }}" class="w-10 h-10 rounded-full mr-3">
                                                        <div>
                                                            <div class="flex items-center mb-1">
                                                                <h5 class="font-semibold text-sm">{{ $reply->name }}</h5>
                                                                <span class="text-gray-500 text-xs ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <p class="text-gray-700 text-sm">{{ $reply->content }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500">No comments yet. Be the first to comment!</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Related Posts -->
                        @if(isset($relatedPosts) && $relatedPosts->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-2xl font-bold mb-6">Related Posts</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($relatedPosts as $relatedPost)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    <img src="{{ asset($relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" class="w-full h-48 object-cover">
                                    <div class="p-6">
                                        <div class="flex items-center mb-3">
                                            <span class="bg-primary-100 text-primary-800 text-xs font-semibold px-2 py-1 rounded-full">
                                                {{ $relatedPost->category->name ?? 'Uncategorized' }}
                                            </span>
                                            <span class="text-gray-500 text-xs ml-3">
                                                <i class="far fa-calendar-alt mr-1"></i> {{ $relatedPost->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <h3 class="text-xl font-bold mb-3">
                                            <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-gray-900 hover:text-primary-600">
                                                {{ $relatedPost->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-4">
                                            {{ Str::limit($relatedPost->excerpt, 100) }}
                                        </p>
                                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-primary-600 text-sm font-semibold hover:text-primary-700">
                                            Read More <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="w-full lg:w-1/3 px-4 mt-12 lg:mt-0">
                        <!-- Search -->
                        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                            <h3 class="text-lg font-bold mb-4">Search</h3>
                            <form action="{{ route('blog.index') }}" method="GET">
                                <div class="relative">
                                    <input type="text" name="search" placeholder="Search blog posts..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 pr-10">
                                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary-600">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Categories -->
                        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                            <h3 class="text-lg font-bold mb-4">Categories</h3>
                            <ul class="space-y-2">
                                @forelse($categories ?? [] as $category)
                                <li>
                                    <a href="{{ route('blog.category', $category->slug) }}" class="flex items-center justify-between text-gray-600 hover:text-primary-600">
                                        <span>{{ $category->name }}</span>
                                        <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded-full">
                                            {{ $category->posts_count ?? 0 }}
                                        </span>
                                    </a>
                                </li>
                                @empty
                                <li class="text-gray-500">No categories found</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Popular Posts -->
                        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                            <h3 class="text-lg font-bold mb-4">Popular Posts</h3>
                            <div class="space-y-4">
                                @forelse($popularPosts ?? [] as $popularPost)
                                <div class="flex items-start">
                                    <img src="{{ asset($popularPost->featured_image) }}" alt="{{ $popularPost->title }}" class="w-16 h-16 object-cover rounded-md mr-4">
                                    <div>
                                        <h4 class="font-semibold text-sm mb-1">
                                            <a href="{{ route('blog.show', $popularPost->slug) }}" class="text-gray-900 hover:text-primary-600">
                                                {{ $popularPost->title }}
                                            </a>
                                        </h4>
                                        <p class="text-gray-500 text-xs">
                                            <i class="far fa-calendar-alt mr-1"></i> {{ $popularPost->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                @empty
                                <p class="text-gray-500">No popular posts yet</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                            <h3 class="text-lg font-bold mb-4">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @forelse($tags ?? [] as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" class="bg-gray-100 text-gray-700 hover:bg-primary-100 hover:text-primary-700 text-xs font-semibold px-3 py-1 rounded-full">
                                    {{ $tag->name }}
                                </a>
                                @empty
                                <p class="text-gray-500">No tags found</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Newsletter -->
                        <div class="bg-primary-50 rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-bold mb-2">Subscribe to Our Newsletter</h3>
                            <p class="text-gray-600 text-sm mb-4">Get the latest roadside assistance tips and updates delivered to your inbox.</p>
                            <form action="{{ route('newsletter.subscribe') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="email" name="email" placeholder="Your email address" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                </div>
                                <button type="submit" class="btn-primary w-full">
                                    <i class="fas fa-paper-plane mr-2"></i> Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reply toggle functionality
        const replyToggles = document.querySelectorAll('.reply-toggle');
        const cancelReplies = document.querySelectorAll('.cancel-reply');
        
        replyToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById(`reply-form-${commentId}`);
                replyForm.classList.toggle('hidden');
            });
        });
        
        cancelReplies.forEach(cancel => {
            cancel.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById(`reply-form-${commentId}`);
                replyForm.classList.add('hidden');
            });
        });
    });
</script>
@endsection
