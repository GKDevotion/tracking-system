<?php

namespace App\Http\Controllers;

use App\Models\ForexUpdate;
use App\Models\Plan;

class ForexResultController extends Controller
{

    public function index()
    {
        $signals = ForexUpdate::where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->latest()
            ->limit(30)
            ->get();
        return view('frontend.forex-result',compact('signals'));
    }

}
