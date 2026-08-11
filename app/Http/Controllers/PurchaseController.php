<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Plan;

class PurchaseController extends Controller
{ 

    public function index()
    { 

        $planMap = Plan::where('is_active', 1)->pluck( 'id', 'name' );
 
        $countries = Country::where('status', 1)->orderBy('name')->get();
        return view('frontend.purchase', compact('countries', 'planMap'));
    }
 
}
