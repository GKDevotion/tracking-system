<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Categories;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $dataArr = Blog::with(['user', 'category'])
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->created_at, fn($q) => $q->whereDate('created_at', '>=', $request->created_at))
            ->when($request->updated_at, fn($q) => $q->whereDate('updated_at', '<=', $request->updated_at))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.blog.index', compact('dataArr'));
    }

    public function create()
    {
        $categories = Categories::where('parent_id', 0)->with('childrenRecursive')->get();
        $tags = Tag::where('status', 1)->get();

        return view('backend.pages.blog.form', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:1|max:255|unique:blogs,title',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'keyword' => 'nullable|string|max:500',
            'podcast_url' => 'nullable|url',
            'sort_url' => 'nullable|url',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $blog = new Blog();
        $blog->user_id = Auth::id();
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category_id;
        $blog->sub_category_id = $request->sub_category_id ?? null;
        $blog->short_description = $request->short_description ?? null;
        $blog->description = $request->description ?? null;
        $blog->keyword = $request->keyword ?? null;
        $blog->podcast_url = $request->podcast_url ?? null;
        $blog->sort_url = $request->sort_url ?? null;
        $blog->status = $request->status ?? 1;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blogs', 'public');
            $blog->image = $path;
        }

        $blog->save();

        $tagSync = [];
        if ($request->filled('tags') && is_array($request->tags)) {
            foreach ($request->tags as $tagId) {
                $tagSync[$tagId] = [
                    'category_id' => $blog->category_id,
                    'sub_category_id' => $blog->sub_category_id,
                ];
            }
        }
        $blog->tags()->sync($tagSync);

        return redirect()->route('web.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function show(Blog $blog)
    {
        $blog->load(['user', 'category', 'sub_category', 'tags']);
        return view('backend.pages.blog.view', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = Categories::where('parent_id', 0)->with('childrenRecursive')->get();
        $tags = Tag::where('status', 1)->get();
        $blog->load('tags');
        
        return view('backend.pages.blog.form', compact('blog', 'categories', 'tags'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title' => 'required|min:1|max:255|unique:blogs,title,' . $blog->id,
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'keyword' => 'nullable|string|max:500',
            'podcast_url' => 'nullable|url',
            'sort_url' => 'nullable|url',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category_id;
        $blog->sub_category_id = $request->sub_category_id ?? null;
        $blog->short_description = $request->short_description ?? null;
        $blog->description = $request->description ?? null;
        $blog->keyword = $request->keyword ?? null;
        $blog->podcast_url = $request->podcast_url ?? null;
        $blog->sort_url = $request->sort_url ?? null;
        $blog->status = $request->status ?? 1;

        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }

            $path = $request->file('image')->store('blogs', 'public');
            $blog->image = $path;
        }

        $blog->save();

        $tagSync = [];
        if ($request->filled('tags') && is_array($request->tags)) {
            foreach ($request->tags as $tagId) {
                $tagSync[$tagId] = [
                    'category_id' => $blog->category_id,
                    'sub_category_id' => $blog->sub_category_id,
                ];
            }
        }
        $blog->tags()->sync($tagSync);

        return redirect()->route('web.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return back()->with('success', 'Blog deleted successfully.');
    }
}
