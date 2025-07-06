<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = BlogPost::with(['author', 'category'])
            ->published()
            ->orderBy('published_at', 'desc');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->withCategory($request->category);
        }

        // Filter by tag
        if ($request->has('tag') && $request->tag) {
            $query->withTag($request->tag);
        }

        // Filter by search term
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        $posts = $query->paginate(9);
        $featuredPosts = BlogPost::with(['author', 'category'])
            ->published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        $categories = BlogCategory::withCount('posts')->active()->get();
        $tags = BlogTag::withCount('posts')->active()->get();

        return view('blog.index', compact('posts', 'featuredPosts', 'categories', 'tags'));
    }

    /**
     * Display the specified blog post.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = BlogPost::with(['author', 'category', 'tags', 'comments' => function($query) {
            $query->approved()->parents()->with(['user', 'replies' => function($query) {
                $query->approved()->with('user');
            }]);
        }])->where('slug', $slug)->published()->firstOrFail();

        // Increment view count
        $post->incrementViewCount();

        // Get related posts
        $relatedPosts = BlogPost::with(['author', 'category'])
            ->where('id', '!=', $post->id)
            ->where(function($query) use ($post) {
                $query->where('category_id', $post->category_id)
                    ->orWhereHas('tags', function($query) use ($post) {
                        $query->whereIn('blog_tags.id', $post->tags->pluck('id'));
                    });
            })
            ->published()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Get previous and next posts
        $previousPost = BlogPost::where('published_at', '<', $post->published_at)
            ->published()
            ->orderBy('published_at', 'desc')
            ->first();
            
        $nextPost = BlogPost::where('published_at', '>', $post->published_at)
            ->published()
            ->orderBy('published_at', 'asc')
            ->first();

        return view('blog.show', compact('post', 'relatedPosts', 'previousPost', 'nextPost'));
    }

    /**
     * Display posts by category.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->active()->firstOrFail();
        
        $posts = BlogPost::with(['author', 'category'])
            ->published()
            ->withCategory($slug)
            ->orderBy('published_at', 'desc')
            ->paginate(9);
            
        $categories = BlogCategory::withCount('posts')->active()->get();
        $tags = BlogTag::withCount('posts')->active()->get();

        return view('blog.category', compact('category', 'posts', 'categories', 'tags'));
    }

    /**
     * Display posts by tag.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function tag($slug)
    {
        $tag = BlogTag::where('slug', $slug)->active()->firstOrFail();
        
        $posts = BlogPost::with(['author', 'category'])
            ->published()
            ->withTag($slug)
            ->orderBy('published_at', 'desc')
            ->paginate(9);
            
        $categories = BlogCategory::withCount('posts')->active()->get();
        $tags = BlogTag::withCount('posts')->active()->get();

        return view('blog.tag', compact('tag', 'posts', 'categories', 'tags'));
    }

    /**
     * Store a newly created comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $postSlug
     * @return \Illuminate\Http\Response
     */
    public function storeComment(Request $request, $postSlug)
    {
        $post = BlogPost::where('slug', $postSlug)->published()->firstOrFail();

        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:blog_comments,id',
            'author_name' => Auth::check() ? 'nullable' : 'required|string|max:255',
            'author_email' => Auth::check() ? 'nullable' : 'required|email|max:255',
            'author_website' => 'nullable|url|max:255',
        ]);

        $comment = new BlogComment();
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->parent_id = $request->parent_id;
        $comment->content = $request->content;
        
        // If user is not logged in, use provided author details
        if (!Auth::check()) {
            $comment->author_name = $request->author_name;
            $comment->author_email = $request->author_email;
            $comment->author_website = $request->author_website;
        }
        
        // Auto-approve comments for logged-in users, otherwise require approval
        $comment->is_approved = Auth::check();
        
        // Store IP and user agent for spam prevention
        $comment->ip_address = $request->ip();
        $comment->user_agent = $request->userAgent();
        
        $comment->save();

        if ($comment->is_approved) {
            return redirect()->back()->with('success', 'Your comment has been posted successfully.');
        } else {
            return redirect()->back()->with('success', 'Your comment has been submitted and is awaiting approval.');
        }
    }
    
    /**
     * Search for blog posts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->route('blog.index');
        }
        
        $posts = BlogPost::with(['author', 'category', 'tags'])
            ->published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhereHas('tags', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('category', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        $categories = BlogCategory::withCount('posts')->active()->get();
        $tags = BlogTag::withCount('posts')->active()->take(15)->get();
        $recentPosts = BlogPost::published()->orderBy('published_at', 'desc')->take(5)->get();
        
        // Popular searches - this could be dynamically generated based on actual search data
        $popularSearches = ['Roadside Assistance', 'Towing', 'Flat Tire', 'Battery Jump', 'Emergency', 'Vehicle Maintenance'];
        
        return view('blog.search', compact('posts', 'query', 'categories', 'tags', 'recentPosts', 'popularSearches'));
    }
}
