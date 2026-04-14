<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $dataArr = Faq::with(['user'])
            ->when($request->search, fn($q) => $q->where('question', 'like', "%{$request->search}%"))
            ->when($request->created_at, fn($q) => $q->whereDate('created_at', '>=', $request->created_at))
            ->when($request->updated_at, fn($q) => $q->whereDate('updated_at', '<=', $request->updated_at))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.faq.index', compact('dataArr'));
    }

    public function create()
    {

        return view('backend.pages.faq.form');
    }

   public function store(Request $request)
{
    $request->validate([
        'faq.*.question' => 'required|string',
        'faq.*.answer'   => 'required|string',
    ]);

    foreach ($request->faq as $item) {
        Faq::create([
            'question' => $item['question'],
            'answer'   => $item['answer'],
            'status'   => $request->status ?? 1,
        ]);
    }

    return redirect()->route('web.faq.index')->with('success', 'FAQ created successfully.');
}

    public function show(Faq $faq)
    {

        return view('backend.pages.faq.view', compact('banner'));
    }

    public function edit(Faq $faq)
    {
        
        return view('backend.pages.faq.form', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'faq.*.question' => 'required|string',
            'faq.*.answer'   => 'required|string',
        ]);

        // If updating single FAQ only
        $first = $request->faq[0];

        $faq->update([
            'question' => $first['question'],
            'answer'   => $first['answer'],
            'status'   => $request->status ?? 1,
        ]);

        return redirect()->route('web.faq.index')->with('success', 'Faq updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with('success', 'Faq deleted successfully.');
    }
}
