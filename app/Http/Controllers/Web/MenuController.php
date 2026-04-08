<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with('parent')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();
        return view('backend.pages.menus.form', ['menu' => new Menu(), 'parents' => $parents]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'icon'       => 'nullable|string|max:100',
            'route'      => 'nullable|string|max:200',
            'parent_id'  => 'nullable|exists:menus,id',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name'] . '-' . uniqid());

        Menu::create($data);

        return redirect()->route('web.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $parents = Menu::whereNull('parent_id')
            ->where('is_active', true)
            ->where('id', '!=', $menu->id)
            ->orderBy('sort_order')
            ->get();

        return view('backend.pages.menus.form', compact('menu', 'parents'));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'icon'       => 'nullable|string|max:100',
            'route'      => 'nullable|string|max:200',
            'parent_id'  => 'nullable|exists:menus,id',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $menu->update($data);

        return redirect()->route('web.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->children()->count() > 0) {
            return back()->with('error', 'Cannot delete menu with child items.');
        }

        $menu->delete();

        return back()->with('success', 'Menu deleted successfully.');
    }
}
