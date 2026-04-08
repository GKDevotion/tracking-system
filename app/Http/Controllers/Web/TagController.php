<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $dataArr = Tag::with('user')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->created_at, fn($q) => $q->whereDate('created_at', '>=', $request->created_at))
            ->when($request->updated_at, fn($q) => $q->whereDate('updated_at', '<=', $request->updated_at))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.tag.index', compact('dataArr'));
    }

    public function create()
    {
        return view('backend.pages.tag.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:1|max:64|unique:tags,name',
            'status' => 'nullable|boolean'
        ]);

        $tag = new Tag();
        $tag->user_id = Auth::id();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->status = $request->status ?? 1;
        $tag->save();

        return redirect()->route('web.tag.index')->with('success', 'Tag created successfully.');
    }

    public function show(Tag $tag)
    {
        $tag->load('user');
        return view('backend.pages.tag.view', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('backend.pages.tag.form', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => 'required|min:1|max:64|unique:tags,name,' . $tag->id,
            'status' => 'nullable|boolean',
        ]);

        $tag->fill($data);
        $tag->slug = Str::slug($request->name);
        $tag->status = $request->status ?? 1;
        $tag->save();

        return redirect()->route('web.tag.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return back()->with('success', 'Tag deleted successfully.');
    }
}
