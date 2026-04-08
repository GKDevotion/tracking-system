<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Stevebauman\Location\Facades\Location;

class CategoryController extends Controller
{


    public function index(Request $request)
    {
        $dataArr = Categories::with('user')
            ->when($request->search, fn($q) => $q->where('vendor', 'like', "%{$request->search}%"))
            ->when($request->created_at, fn($q) => $q->whereDate('date', '>=', $request->created_at))
            ->when($request->updated_at, fn($q) => $q->whereDate('date', '<=', $request->updated_at))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.category.index', compact('dataArr'));
    }


    public function create()
    {
        $categories = Categories::where('parent_id', 0)->get();

        return view('backend.pages.category.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'short_description' => 'nullable|string|max:500',
            'title' => 'required|min:1|max:64|unique:categories,title',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        // $data['user_id'] = Auth::id();
        // $data['status']  = 'in';

        // 🔥 Auto capture IP
        $ip = $request->ip();

        $category = new Categories();
        $category->user_id = Auth::id();
        $category->title = $request->title;
        $category->slug = Str::slug($request->title);
        $category->parent_id = $request->parent_id ?? 0;
        $category->status = $request->status ?? 1;
        $category->short_description = $request->short_description ?? null;
        $category->sort_order = $request->sort_order ?? 0;
        // $category->ip = $ip;

        // 🌍 Location Logic (same as yours) 

        if ($request->hasFile('image')) {

            // delete old image
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            // upload new
            $path = $request->file('image')->store('categories', 'public');
            $category->image = $path;
        }

        // if ($ip != "127.0.0.1" && strlen($ip) > 8) {

        //     $locationPosition = Location::get($ip);
        //     $locationPosition = json_encode($locationPosition);
        //     $locationPosition = json_decode($locationPosition, 1);

        //     $category->areaCode = $locationPosition['areaCode'];
        //     $category->cityName = $locationPosition['cityName'];
        //     $category->countryCode = $locationPosition['countryCode'];
        //     $category->countryName = $locationPosition['countryName'];
        //     $category->ip = $locationPosition['ip'];
        //     $category->isoCode = $locationPosition['isoCode'];
        //     $category->latitude =  $request->latitude ?? $locationPosition['latitude'];
        //     $category->longitude = $request->longitude ?? $locationPosition['longitude'];
        //     $category->metroCode = $locationPosition['metroCode'];
        //     $category->postalCode = $locationPosition['postalCode'];
        //     $category->regionCode = $locationPosition['regionCode'];
        //     $category->regionName = $locationPosition['regionName'];
        //     $category->zipCode = $locationPosition['zipCode'];
        //     $category->address = $request->address ?? null;
        // }


        $category->save();


        // category::create($data);

        return redirect()->route('web.category.index')->with('success', 'Category entry created successfully.');
    }

    public function show(Categories $category)
    {
        $categories = Categories::where('parent_id', 0)->get();
        $category->load('user');
        return view('backend.pages.category.view', compact('category', 'categories'));
    }

    public function edit(Categories $category)
    {
        $categories = Categories::where('parent_id', 0)->get();
        return view('backend.pages.category.form', compact('category', 'categories'));
    }

    public function update(Request $request, Categories $category)
    {
        $data = $request->validate([

            'short_description' => 'nullable|string|max:500',
            'title' => 'required|min:1|max:64|unique:categories,title,' . $category->id,
            // 'slug' => 'nullable|string|max:64|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|boolean',

        ]);

        $category->fill($data);
        $category->slug = Str::slug($request->title);
        $category->parent_id = $request->parent_id ?? 0;
        $category->status = $request->status ?? 1; 
        $category->sort_order = $request->sort_order ?? 0;
        $category->short_description = $request->short_description ?? null;

         // 

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $path = $request->file('image')->store('category', 'public');
            $category->image = $path;
        }

        $category->save();

        return redirect()->route('web.category.index')->with('success', 'Category entry updated successfully.');
    }

        public function destroy(Categories $category)
    {
        if ($category->children()->exists()) {
            return back()->with('error', 'Cannot delete category with existing subcategories.');
        }

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
