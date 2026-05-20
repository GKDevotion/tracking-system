<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class ForexController extends Controller
{ 

    public function index()
    { 
        $plans = Plan::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        $planArr = [];
        foreach ($plans as $plan) {
            // dd( $plans[0]->remove );
            $planArr[$plan->name] = [
                'price_item_class' => $plan->is_highlighted ? 'highlighted-box box-bg-shape' : '',
                'price'            => $plan->price,
                'value'            => $plan->description,
                // If you don't do Step 2 below, you must use json_decode($plan->features) here
                'feature'          => is_string($plan->features) ? json_decode($plan->features, true) : $plan->features,
                'remove'          => is_string($plan->remove) ? json_decode($plan->remove, true) : $plan->remove,
                'cta'              => $plan->cta,
                'link'             => ($plan->link === '-' || empty($plan->link)) ? 'free' : $plan->link,
            ];
        }

        // dd( $planArr );
        return view('frontend.forex-signal',compact('planArr'));
    }
 
}
