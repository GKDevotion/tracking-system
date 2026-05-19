<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SeoData;
use App\Models\Menu;
use Illuminate\Http\Request; 

class SeoDataController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        $dataArr = SeoData::with('user')
            ->when($request->search, function ($q) use ($request) {
                $q->where('page_slug', 'like', '%' . $request->search . '%')
                  ->orWhere('meta_title', 'like', '%' . $request->search . '%');
            })
            ->when($request->created_at, function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->created_at);
            })
            ->when($request->updated_at, function ($q) use ($request) {
                $q->whereDate('updated_at', '<=', $request->updated_at);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.seo-data.index', compact('dataArr'));
    }

    /**
     * Create form
     */
    public function create()
    {
        $menus = Menu::where('is_active', 1)
        ->orderBy('sort_order')
        ->get();

        $seoData = new SeoData();

        return view('backend.pages.seo-data.form', compact('seoData', 'menus'));
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $request->validate([
            'page_slug'        => 'required|string|max:255|unique:seo_data,page_slug',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'keywords'         => 'nullable|string',
            'h1_tag'           => 'nullable|string|max:255',
            'og_title'         => 'nullable|string|max:255',
            'og_description'   => 'nullable|string',
            'og_image'         => 'nullable|string',
            'canonical_url'    => 'nullable|string|max:255',
            'robots'           => 'nullable|string|max:255',
            'status'           => 'nullable|boolean',
        ]);

        SeoData::create([ 
            'page_slug'        => $request->page_slug,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'keywords'         => $request->keywords,
            'h1_tag'           => $request->h1_tag,
            'og_title'         => $request->og_title,
            'og_description'   => $request->og_description,
            'og_image'         => $request->og_image,
            'canonical_url'    => $request->canonical_url,
            'robots'           => $request->robots,
            'status'           => $request->status ?? 1,
        ]);

        return redirect()
            ->route('web.seo-data.index')
            ->with('success', 'SEO Data created successfully.');
    }

    /**
     * Show single record
     */
    public function show(SeoData $seoData)
    {
        $seoData->load('user');

        return view('backend.pages.seo-data.view', compact('seoData'));
    }

    /**
     * Edit form
     */
    public function edit(SeoData $seoData, $id)
    {
          // IMPORTANT
        $seoData = SeoData::findOrFail($id);

        $menus = Menu::where('is_active', 1)
        ->orderBy('sort_order')
        ->get();

        return view('backend.pages.seo-data.form', compact('seoData', 'menus'));
    }

    /**
     * Update record
     */
    public function update(Request $request, SeoData $seoData)
    {
        $request->validate([
            'page_slug'        => 'required|string|max:255,' . $seoData->id,
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'keywords'         => 'nullable|string',
            'h1_tag'           => 'nullable|string|max:255',
            'og_title'         => 'nullable|string|max:255',
            'og_description'   => 'nullable|string',
            'og_image'         => 'nullable|string',
            'canonical_url'    => 'nullable|string|max:255',
            'robots'           => 'nullable|string|max:255',
            'status'           => 'nullable|boolean',
        ]);

        $seoData->update([
            'page_slug'        => $request->page_slug,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'keywords'         => $request->keywords,
            'h1_tag'           => $request->h1_tag,
            'og_title'         => $request->og_title,
            'og_description'   => $request->og_description,
            'og_image'         => $request->og_image,
            'canonical_url'    => $request->canonical_url,
            'robots'           => $request->robots,
            'status'           => $request->status ?? 1,
        ]);

        return redirect()
            ->route('web.seo-data.index')
            ->with('success', 'SEO Data updated successfully.');
    }

    /**
     * Delete record
     */
    public function destroy(SeoData $seoData)
    {
        $seoData->delete();

        return back()->with('success', 'SEO Data deleted successfully.');
    }
}