<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PricingPlanCheckout;
use Illuminate\Http\Request;

class PricingPlanCheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $checkouts = PricingPlanCheckout::with('user')
            ->when($request->search, fn($q) => $q->where('full_name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->plan, fn($q) => $q->where('plan', $request->plan))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('backend.pages.pricing_plan_checkout.index', compact('checkouts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PricingPlanCheckout $pricingPlanCheckout)
    {
        return view('backend.pages.pricing_plan_checkout.show', compact('pricingPlanCheckout'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PricingPlanCheckout $pricingPlanCheckout)
    {
        return view('backend.pages.pricing_plan_checkout.edit', compact('pricingPlanCheckout'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PricingPlanCheckout $pricingPlanCheckout)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'trade_signals' => 'required|in:0,1',
            'tele_username' => 'nullable|string|max:255',
            'mobile_number' => 'required|string|max:255',
            'payment_option' => 'required|in:0,1',
            // confirm_payment can be updated if needed
        ]);

        $pricingPlanCheckout->update($data);

        return redirect()->route('web.pricing-plan-checkout.index')->with('success', 'Checkout updated successfully.');
    }
}
