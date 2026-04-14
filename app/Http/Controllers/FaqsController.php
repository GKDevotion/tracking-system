<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqsController extends Controller
{ 

    public function index()
    { 
         $faqs = Faq::where('status', 1)->get();
        return view('frontend.faq', compact('faqs'));
    }
 
}
