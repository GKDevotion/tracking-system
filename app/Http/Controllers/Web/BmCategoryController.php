<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BmCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = BmCategory::withCount('templates');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $categories = $query->latest()->paginate(15);

        return view('business-mail.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        if( $request->id ){
            $category = BmCategory::find($request->id);

            $data = $request->validate([
                'name'   => ['required', 'string', 'max:100', Rule::unique('bm_categories', 'name')->ignore($request->id)],
                'slug'   => ['nullable', 'string', 'max:120', Rule::unique('bm_categories', 'slug')->ignore($request->id)],
                'status' => 'nullable|in:0,1',
            ]);
        } else {
            $category = new BmCategory();

                $data = $request->validate([
                'name'   => 'required|string|max:100|unique:bm_categories,name',
                'slug'   => 'nullable|string|max:120|unique:bm_categories,slug',
                'status' => 'nullable|in:0,1',
            ]);
        }

        if (isset($data['slug']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug']   = $data['slug'];
        }

        $data['status'] = $data['status'] ?? 1;

        $category->update($data);

        return back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, $id=0)
    {
        $data = $request->validate([
            'name'   => ['required', 'string', 'max:100', Rule::unique('bm_categories', 'name')->ignore($id)],
            'slug'   => ['nullable', 'string', 'max:120', Rule::unique('bm_categories', 'slug')->ignore($id)],
            'status' => 'nullable|in:0,1',
        ]);

        if (isset($data['slug']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if( $id ){
            $category = BmCategory::find($id);
        } else {
            $category = new BmCategory();
        }

        $category->update($data);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy(BmCategory $category)
    {
        if ($category->templates()->count() > 0) {
            return back()->with('error', 'Cannot delete — this category has mail templates. Remove templates first.');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
