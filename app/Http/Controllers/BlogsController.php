<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Categories;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogsController extends Controller
{ 

   
    public function index(Request $request)
    {
        // If you later connect to database, fetch properties here
        // Example: $properties = Property::all();
        // $blogs = Blog::where('status', 1)
        //     ->orderBy('created_at', 'desc') 
        //     ->paginate(8);
        $blogs = Blog::where('status', 1)
            ->when($request->tag, function ($query) use ($request) {
                $query->whereHas('tags', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->tag . '%');
                });
            })
            ->when($request->category, function ($q) use ($request) {
                $q->where('category_id', $request->category);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        $recentBlogs = Blog::select('id', 'title', 'slug', 'image', 'created_at')
            ->where('status', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->latest()
            ->get();


        $categories = Categories::where('parent_id', 0)
            ->where('status', 1)
            ->when($request->search, function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhereHas('children', function ($q2) use ($request) {
                        $q2->where('status', 1)
                            ->where('title', 'LIKE', '%' . $request->search . '%');
                    });
            })
            ->with(['children' => function ($q) use ($request) {
                $q->where('status', 1)
                    ->when($request->search, function ($q2) use ($request) {
                        $q2->where('title', 'LIKE', '%' . $request->search . '%');
                    });
            }])
            ->limit(5)
            ->with('children.children')
            ->latest()
            ->get();

        $popularTags = Tag::where('status', 1)->get();

        return view('frontend.blog',  compact('blogs', 'categories', 'popularTags', 'recentBlogs')); // assuming your blade file is buy-properties.blade.php
    }
    
    public function show($slug)
    { 
        $blog = Blog::with('category.parent')->where('slug', $slug)
        
            ->where('status', 1)
            ->firstOrFail();
        $shareUrl   = urlencode(route('blog.details', $blog->slug));
        $shareTitle = urlencode($blog->title);
        // Related blogs (optional)
        $relatedBlogs = Blog::select('id', 'title', 'slug', 'image', 'created_at')
            ->where('status', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->get();



        $categories = Categories::where('parent_id', 0)
            ->where('status', 1)
            ->limit(5)
            ->latest()
            ->with('children.children')
            ->get();

        $popularTags = Tag::where('status', 1)->get();
    
        return view('frontend.element.blog-details', compact('blog', 'shareUrl', 'shareTitle', 'relatedBlogs', 'categories', 'popularTags'));
    }
 
}
