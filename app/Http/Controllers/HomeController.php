<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    public function index()
    {
        $planArr = [
            'Basic Plan' => [
                'price_item_class' => '',
                'price' => 'Free',
                'value' => '800-1,000 Points / Month',
                'feature' => ['1-2 signals weekly', 'Forex & Gold', 'Entry / SL / TP'],
                'cta' => 'Join Free',
                'link' => 'purchase?plan=free',
            ],
            'Advanced Trader' => [
                'price_item_class' => 'highlighted-box box-bg-shape',
                'price' => "$29 / Month",
                'value' => '2,500-3,500 Points / Month',
                'feature' => ['1-2 signals weekly', 'Forex, Gold & Crypto', 'Trade reasoning included'],
                'cta' => 'Subscribe Now',
                'link' => 'purchase?plan=purchase',
            ],
            'Institutional Trader' => [
                'price_item_class' => '',
                'price' => "$59 / Month",
                'value' => '6,000-8,000 Points / Month',
                'feature' => ['3-5 signals daily', 'Forex, Gold, Crypto & Indices', 'Advanced analysis'],
                'cta' => 'Subscribe Now',
                'link' => 'purchase?plan=purchase',
            ],
            // 'Private Client Portfolio' => [
            //     'price' => "Custom Price",
            //     'value' => "10,000+ Points Potential",
            //     'feature' => [
            //         'Portfolio-based signals',
            //         'All Markets',
            //         'Personalized strategy'
            //     ],
            //     'cta' => "Contact US",
            // ]
        ];
        return view('frontend.index', compact('planArr'));
    }
}
