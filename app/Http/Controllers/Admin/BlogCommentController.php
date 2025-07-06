<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = BlogComment::with(['post', 'user']);

        // Filter by approval status
        if ($request->has('is_approved') && $request->is_approved !== 'all') {
            $query->where('is_approved', $request->is_approved == 'approved');
        }

        // Filter by post
        if ($request->has('post_id') && $request->post_id) {
            $query->where('post_id', $request->post_id);
        }

        // Filter by search term
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('content', 'like', "%{$searchTerm}%")
                  ->orWhere('author_name', 'like', "%{$searchTerm}%")
                  ->orWhere('author_email', 'like', "%{$searchTerm}%");
            });
        }

        // Order by
        $orderBy = $request->order_by ?? 'created_at';
        $orderDirection = $request->order_direction ?? 'desc';
        $query->orderBy($orderBy, $orderDirection);

        $comments = $query->paginate(15);

        return view('admin.blog.comments.index', compact('comments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(BlogComment $comment)
    {
        $comment->load(['post', 'user', 'parent', 'replies']);
        return view('admin.blog.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogComment $comment)
    {
        $comment->load(['post', 'user', 'parent']);
        return view('admin.blog.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogComment $comment)
    {
        $request->validate([
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'author_email' => 'nullable|email|max:255',
            'author_website' => 'nullable|url|max:255',
            'is_approved' => 'boolean',
        ]);

        // Update comment fields
        $comment->content = $request->content;
        $comment->author_name = $request->author_name;
        $comment->author_email = $request->author_email;
        $comment->author_website = $request->author_website;
        $comment->is_approved = $request->is_approved ?? false;
        
        $comment->save();

        return redirect()->route('admin.blog.comments.index')
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogComment $comment)
    {
        // Delete the comment (soft delete)
        $comment->delete();

        return redirect()->route('admin.blog.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }

    /**
     * Approve the specified comment.
     *
     * @param  \App\Models\BlogComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function approve(BlogComment $comment)
    {
        $comment->is_approved = true;
        $comment->save();

        return redirect()->back()
            ->with('success', 'Comment approved successfully.');
    }

    /**
     * Unapprove the specified comment.
     *
     * @param  \App\Models\BlogComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function unapprove(BlogComment $comment)
    {
        $comment->is_approved = false;
        $comment->save();

        return redirect()->back()
            ->with('success', 'Comment unapproved successfully.');
    }

    /**
     * Bulk approve comments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:blog_comments,id',
        ]);

        BlogComment::whereIn('id', $request->comment_ids)
            ->update(['is_approved' => true]);

        return redirect()->back()
            ->with('success', count($request->comment_ids) . ' comments approved successfully.');
    }

    /**
     * Bulk unapprove comments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkUnapprove(Request $request)
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:blog_comments,id',
        ]);

        BlogComment::whereIn('id', $request->comment_ids)
            ->update(['is_approved' => false]);

        return redirect()->back()
            ->with('success', count($request->comment_ids) . ' comments unapproved successfully.');
    }

    /**
     * Bulk delete comments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:blog_comments,id',
        ]);

        BlogComment::whereIn('id', $request->comment_ids)->delete();

        return redirect()->back()
            ->with('success', count($request->comment_ids) . ' comments deleted successfully.');
    }

    /**
     * Reply to a comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, BlogComment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $reply = new BlogComment();
        $reply->post_id = $comment->post_id;
        $reply->user_id = auth()->id();
        $reply->parent_id = $comment->id;
        $reply->content = $request->content;
        $reply->is_approved = true;
        $reply->save();

        return redirect()->back()
            ->with('success', 'Reply added successfully.');
    }
}
