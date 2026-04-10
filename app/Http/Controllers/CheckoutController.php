<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PricingPlanCheckout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $plan = $request->get('plan', 'basic');
        $isFree = $plan === 'free';

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'platform' => 'required|in:telegram,whatsapp',
            'telegram_username' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
        ];

        if (!$isFree) {
            $rules['payment_type'] = 'required|in:trc20,bep20';
            $rules['proof_file'] = 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048';
        }

        $request->validate($rules);

        // Map plan
        $planMap = [ 
            'basic' => 0,
            'advanced' => 1,
            'institutional' => 2,
        ];
        $planValue = $planMap[$plan] ?? 0;

        // Map trade_signals
        $tradeSignals = $request->platform === 'telegram' ? 0 : 1;

        // Map payment_option
        $paymentOption = null;
        if (!$isFree) {
            $paymentOption = $request->payment_type === 'trc20' ? 0 : 1;
        }

        // Full name
        $fullName = $request->first_name . ' ' . $request->last_name;

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('proof_file')) {
            $filePath = $request->file('proof_file')->store('uploads', 'public');
        }

        // Create record
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
            'payment_option' => $paymentOption,
            'confirm_payment' => $filePath,
        ]);

        return response()->json(['success' => true, 'message' => 'Checkout submitted successfully.']);
    }
}
