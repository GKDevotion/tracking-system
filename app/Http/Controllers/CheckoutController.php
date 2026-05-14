<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PricingPlanCheckout;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $plan = $request->get('plan', 'basic');

        $isFree = $plan === 'free';

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $rules = [

            'first_name' => 'required|string|max:255',

            'last_name' => 'required|string|max:255',

            'email' => 'required|email|max:255',

            'country' => 'required',

            'platform' => 'required|in:telegram,whatsapp',

            'telegram_username' => 'nullable|string|max:255',

            'phone' => 'required|string|max:255',

        ];

        if (!$isFree) {

            // crypto OR bank
            $rules['payment_type'] =
                'required|in:crypto,bank';

            // proof required
            $rules['proof_file'] =
                'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048';

            // only for crypto
            if ($request->payment_type == 'crypto') {

                $rules['crypto_network'] =
                    'required|in:trc20,bep20';
            }
        }

        $request->validate($rules);

        /*
        |--------------------------------------------------------------------------
        | PLAN MAP
        |--------------------------------------------------------------------------
        */

        $planMap = [

            'basic' => 0,

            'advanced' => 1,

            'institutional' => 2,

        ];

        $planValue = $planMap[$plan] ?? 0;

        /*
        |--------------------------------------------------------------------------
        | TRADE SIGNALS
        |--------------------------------------------------------------------------
        */

        $tradeSignals =
            $request->platform === 'telegram'
            ? 0
            : 1;

        /*
        |--------------------------------------------------------------------------
        | PAYMENT OPTION
        |--------------------------------------------------------------------------
        |
        | 0 = TRC20
        | 1 = BEP20
        | 2 = BANK
        |
        */

        $paymentOption = null;

        if (!$isFree) {

            if ($request->payment_type == 'bank') {

                $paymentOption = 2;

            } else {

                $paymentOption =
                    $request->crypto_network == 'trc20'
                    ? 0
                    : 1;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FULL NAME
        |--------------------------------------------------------------------------
        */

        $fullName =
            $request->first_name . ' ' . $request->last_name;

        /*
        |--------------------------------------------------------------------------
        | FILE UPLOAD
        |--------------------------------------------------------------------------
        */

        $filePath = null;

        if ($request->hasFile('proof_file')) {

            $filePath = $request->file('proof_file')
                ->store('uploads', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE DATA
        |--------------------------------------------------------------------------
        */

        PricingPlanCheckout::create([

            'user_id' => Auth::id(),

            'plan' => $planValue,

            'first_name' => $request->first_name,

            'last_name' => $request->last_name,

            'full_name' => $fullName,

            'email' => $request->email,

            'country' => $request->country,

            'trade_signals' => $tradeSignals,

            'tele_username' => $request->telegram_username,

            'mobile_number' => $request->phone,

            // crypto OR bank
            'payment_type' => $request->payment_type,

            // 0=TRC20, 1=BEP20, 2=BANK
            'payment_option' => $paymentOption,

            'confirm_payment' => $filePath,

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Checkout submitted successfully.'

        ]);
    }
}