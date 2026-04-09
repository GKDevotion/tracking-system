<?php
namespace App\Http\Controllers\API\BusinessMail;

use App\Http\Controllers\Controller;
use App\Models\BmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = BmCategory::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data'    => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100|unique:bm_categories,name',
            'slug'   => 'nullable|string|max:120|unique:bm_categories,slug',
            'status' => 'nullable|in:0,1',
        ]);

        $validated['slug']   = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['status'] = $validated['status'] ?? 1;

        $category = BmCategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'data'    => $category,
        ], 201);
    }

    public function show(BmCategory $category)
    {
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function update(Request $request, BmCategory $category)
    {
        $validated = $request->validate([
            'name'   => ['sometimes', 'required', 'string', 'max:100',
                         Rule::unique('bm_categories', 'name')->ignore($category->id)],
            'slug'   => ['nullable', 'string', 'max:120',
                         Rule::unique('bm_categories', 'slug')->ignore($category->id)],
            'status' => 'nullable|in:0,1',
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data'    => $category->fresh(),
        ]);
    }

    public function destroy(BmCategory $category)
    {
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.',
        ]);
    }
}
