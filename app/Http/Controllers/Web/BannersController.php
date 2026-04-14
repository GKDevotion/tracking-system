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
            'name' => 'required|min:1|max:255|unique:banners,name',
            'status' => 'nullable|boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banners = new Banners();
        $banners->name = $request->name;
        $banners->slug = Str::slug($request->name);
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

    public function show(Banners $banner)
    {

        return view('backend.pages.banners.view', compact('banner'));
    }

    public function edit(Banners $banner)
    {
        return view('backend.pages.banners.form', compact('banner'));
    }

    public function update(Request $request, Banners $banner)
    {
        $data = $request->validate([
            'name' => 'required|min:1|max:255|unique:banners,name,' . $banner->id,
            'status' => 'nullable|boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banner->name = $request->name;
        $banner->slug = Str::slug($request->name);
        $banner->type = $request->type;
        $banner->sort_order = $request->sort_order;
        $banner->is_animate_image =  $request->is_animate_image;
        $banner->animate_class_name    =   $request->animate_class_name;
        $banner->is_news   =   $request->is_news;
        $banner->is_click  =   $request->is_click;
        $banner->status = $request->status ?? 1;

        if ($request->hasFile('image_path')) {
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $path = $request->file('image_path')->store('banners', 'public');
            $banner->image_path = $path;
        }

        $banner->save();

        return redirect()->route('web.banners.index')->with('success', 'Banners updated successfully.');
    }

    public function destroy(Banners $banner)
    {
        if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return back()->with('success', 'Banner deleted successfully.');
    }
}
