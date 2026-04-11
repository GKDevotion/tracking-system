<?php

namespace App\Http\Controllers;

use App\Models\Country;

class PurchaseController extends Controller
{ 

    public function index()
    { 

        $countries = Country::where('status', 1)->orderBy('name')->get();
        return view('frontend.purchase', compact('countries'));
    }
 
}
