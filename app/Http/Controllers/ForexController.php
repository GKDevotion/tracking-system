<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class ForexController extends Controller
{ 

    public function index()
    { 
        $plans = Plan::where('is_active', true)->orderBy('sort_order')->get();

        $planArr = [];
        foreach ($plans as $plan) {

            // Check link condition
            $finalLink = ($plan->link === '-' || empty($plan->link))
                ? 'free'
                : $plan->link;

            $planArr[$plan->name] = [
                'price_item_class' => $plan->is_highlighted ? 'highlighted-box box-bg-shape' : '',
                'price' => $plan->price,
                'value' => $plan->description,
                'feature' => $plan->features,
                'cta' => $plan->cta,
                'link' => $finalLink,
            ];
        }

        return view('frontend.forex-signal',compact('planArr'));
    }
 
}
