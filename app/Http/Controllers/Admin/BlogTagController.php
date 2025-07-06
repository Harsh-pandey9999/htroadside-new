<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = BlogTag::withCount('posts')->get();
        return view('admin.blog.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        // Generate slug from name
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;

        // Ensure slug is unique
        while (BlogTag::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Create the tag
        BlogTag::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true,
            'meta_title' => $request->meta_title ?? $request->name,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogTag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(BlogTag $tag)
    {
        $tag->load('posts');
        return view('admin.blog.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogTag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogTag $tag)
    {
        return view('admin.blog.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogTag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogTag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        // Update slug if name has changed
        if ($tag->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;

            // Ensure slug is unique
            while (BlogTag::where('slug', $slug)->where('id', '!=', $tag->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $tag->slug = $slug;
        }

        // Update tag fields
        $tag->name = $request->name;
        $tag->description = $request->description;
        $tag->is_active = $request->is_active ?? true;
        $tag->meta_title = $request->meta_title ?? $request->name;
        $tag->meta_description = $request->meta_description;
        $tag->meta_keywords = $request->meta_keywords;
        
        $tag->save();

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogTag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogTag $tag)
    {
        // Detach the tag from all posts
        $tag->posts()->detach();
        
        // Delete the tag
        $tag->delete();

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'Tag deleted successfully.');
    }

    /**
     * Toggle the active status of the tag.
     *
     * @param  \App\Models\BlogTag  $tag
     * @return \Illuminate\Http\Response
     */
    public function toggleActive(BlogTag $tag)
    {
        $tag->is_active = !$tag->is_active;
        $tag->save();

        return redirect()->back()
            ->with('success', 'Tag status updated successfully.');
    }
}
