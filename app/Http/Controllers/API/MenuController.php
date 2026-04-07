<?php

namespace App\Http\Controllers\API;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends BaseApiController
{
    public function index(Request $request)
    {
        $menus = Menu::with('parent', 'children')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()->paginate(10);

        return $this->paginated('Menus retrieved.', $menus);
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
        $menu = Menu::create($data);

        return $this->success('Menu created.', $menu, 201);
    }

    public function show(Menu $menu)
    {
        return $this->success('Menu retrieved.', $menu->load('parent', 'children'));
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

        return $this->success('Menu updated.', $menu);
    }

    public function destroy(Menu $menu)
    {
        if ($menu->children()->count() > 0) {
            return $this->error('Cannot delete menu with child items.', 422);
        }

        $menu->delete();
        return $this->success('Menu deleted.');
    }

    public function parentMenu(){
        $menu = Menu::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();
        return $this->success('Parent Menu retrived.', $menu);
    }
}
