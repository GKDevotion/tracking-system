<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $dataArr = Contact::with(['user'])
            ->when($request->search, fn($q) => $q->where('email', 'like', "%{$request->search}%"))
            ->when($request->created_at, fn($q) => $q->whereDate('created_at', '>=', $request->created_at))
            ->when($request->updated_at, fn($q) => $q->whereDate('updated_at', '<=', $request->updated_at))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.contact.index', compact('dataArr'));
    }

    public function create()
    {
        //
    }

    public function store()
    {
       //
    }

    public function show()
    {
        //
    }

    public function edit(Banners $banner)
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy(Contact $contact)
    {

        $contact->delete();

        return back()->with('success', 'Contact deleted successfully.');
    }
}
