<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannersController extends Controller
{
    public function index(Request $request)
    {
        $dataArr = Banners::with(['user'])
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->created_at, fn($q) => $q->whereDate('created_at', '>=', $request->created_at))
            ->when($request->updated_at, fn($q) => $q->whereDate('updated_at', '<=', $request->updated_at))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.banners.index', compact('dataArr'));
    }

    public function create()
    {

        return view('backend.pages.banners.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:1|max:255|unique:blogs,title',
            'status' => 'nullable|boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banners = new Banners();
        $banners->name = $request->name;
        $banners->slug = Str::slug($request->title);
        $banners->type = $request->type;
        $banners->sort_order = $request->sort_order;
        $banners->is_animate_image = $request->is_animate_image;
        $banners->animate_class_name  = $request->animate_class_name;
        $banners->is_news = $request->is_news;
        $banners->is_click =  $request->is_click;
        $banners->status = $request->status ?? 1;

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('banners', 'public');
            $banners->image_path = $path;
        }

        $banners->save();

        return redirect()->route('web.banners.index')->with('success', 'Blog created successfully.');
    }

    public function show()
    {
       
        return view('backend.pages.banners.view');
    }

    public function edit()
    {
        
        return view('backend.pages.banners.form');
    }

    public function update(Request $request, Banners $banners)
    {
        $data = $request->validate([
            'title' => 'required|min:1|max:255|unique:banners,title,' . $banners->id,
            'status' => 'nullable|boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banners->name = $request->name;
        $banners->slug = Str::slug($request->title);
        $banners->type = $request->type;
        $banners->sort_order = $request->sort_order;
        $banners->is_animate_image =  $request->is_animate_image;
        $banners->animate_class_name    =   $request->animate_class_name;
        $banners->is_news   =   $request->is_news;
        $banners->is_click  =   $request->is_click;
        $banners->status = $request->status ?? 1;

        if ($request->hasFile('image_path')) {
            if ($banners->image_path && Storage::disk('public')->exists($banners->image_path)) {
                Storage::disk('public')->delete($banners->image_path);
            }

            $path = $request->file('image_path')->store('banners', 'public');
            $banners->image_path = $path;
        }

        $banners->save();

        return redirect()->route('web.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banners $banners)
    {
        if ($banners->image_path && Storage::disk('public')->exists($banners->image_path)) {
            Storage::disk('public')->delete($banners->image_path);
        }

        $banners->delete();

        return back()->with('success', 'Banner deleted successfully.');
    }
}
