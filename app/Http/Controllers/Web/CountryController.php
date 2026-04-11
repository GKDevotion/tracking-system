<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Categories;
use App\Models\Country;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $dataArr = Country::with(['user'])
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->created_at, fn($q) => $q->whereDate('created_at', '>=', $request->created_at))
            ->when($request->updated_at, fn($q) => $q->whereDate('updated_at', '<=', $request->updated_at))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.country.index', compact('dataArr'));
    }

    public function create()
    {
        $categories = Categories::where('status', 1)->get();

        return view('backend.pages.country.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:1|max:255|unique:countries,name',
            'sortname' => 'nullable|string|max:100',
            'sort_description' => 'nullable|string|max:500',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $country = new Country();
        $country->name = $request->name;
        $country->sortname = $request->sortname;
        $country->symbol = $request->symbol;
        $country->sort_description = $request->sort_description;
        $country->status = $request->status ?? 1;


        // Store main image
        if ($request->hasFile('image')) {
            $country->image = $request->file('image')->store('countries', 'public');
        }

        // Store flag image
        if ($request->hasFile('flag')) {
            $country->flag = $request->file('flag')->store('countries/flags', 'public');
        }

        $country->save();


        return redirect()->route('web.country.index')->with('success', 'Country created successfully.');
    }

    public function show(Country $country)
    {
        return view('backend.pages.country.view', compact('country'));
    }

    public function edit(Country $country)
    {
        
        return view('backend.pages.country.form', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $data = $request->validate([
            'name' => 'required|min:1|max:255|unique:countries,name,' . $country->id,
            'sortname' => 'nullable|string|max:100', 
            'sort_description' => 'nullable|string|max:500',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $country->name = $request->name;
        $country->sortname = $request->sortname;
        $country->sort_description = $request->sort_description;
        $country->symbol = $request->symbol;
        $country->code = $request->code;
        $country->status = $request->status ?? 1;

        if ($request->hasFile('image')) {
            if ($country->image && Storage::disk('public')->exists($country->image)) {
                Storage::disk('public')->delete($country->image);
            }

            $path = $request->file('image')->store('countries', 'public');
            $country->image = $path;
        }

        if ($request->hasFile('flag')) {
            if ($country->flag && Storage::disk('public')->exists($country->flag)) {
                Storage::disk('public')->delete($country->flag);
            }

            $path = $request->file('flag')->store('countries/flags', 'public');
            $country->flag = $path;
        }

        $country->save();

     

        return redirect()->route('web.country.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        if ($country->image && Storage::disk('public')->exists($country->image)) {
            Storage::disk('public')->delete($country->image);
        }

        if ($country->flag && Storage::disk('public')->exists($country->flag)) {
            Storage::disk('public')->delete($country->flag);
        }

        $country->delete();

        return back()->with('success', 'Country deleted successfully.');
    }
}
