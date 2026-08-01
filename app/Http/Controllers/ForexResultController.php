<?php

namespace App\Http\Controllers;

use App\Models\ForexUpdate;
use App\Models\Plan;

class ForexResultController extends Controller
{

    public function index()
    {
       $signals = ForexUpdate::where('status', 1)
                ->orderByDesc('signal_date')
                ->paginate(15);
        return view('frontend.forex-result',compact('signals'));
    }

}
