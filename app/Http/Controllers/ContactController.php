<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index()
    {

        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'email'   => 'required|email',
            'mobile_number'   => 'required|string|max:20',
            'message' => 'nullable|string',
        ]);

        // Save to DB
        Contact::create([
            'email'      => $request->email,
            'mobile_number'      => $request->mobile_number,
            'message'    => $request->message,
            'status' => 1,
        ]);
        // Redirect with success
        return back()->with('success', 'Message sent successfully!');
    }
}
