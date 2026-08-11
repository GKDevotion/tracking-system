<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ActionRequiredMail;
use App\Models\PricingPlanCheckout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Staff-only actions on a checkout record. Wrap these routes in whatever
 * admin auth middleware your app already uses (see routes-to-add.php) —
 * nothing here checks permissions on its own.
 */
class AdminCheckoutController extends Controller
{
    /**
     * Flag a submitted payment as needing more info from the customer
     * (unclear receipt, missing TXID, amount mismatch, etc.) instead of
     * rejecting outright. Reopens the payment page and emails them
     * exactly what's needed.
     */
    public function requestMoreInfo(Request $request, PricingPlanCheckout $checkout)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        abort_if(
            $checkout->status !== PricingPlanCheckout::STATUS_PAYMENT_SUBMITTED,
            409,
            'Only a submitted payment awaiting review can be sent back for more info.'
        );

        $checkout->update([
            'status'     => PricingPlanCheckout::STATUS_ACTION_REQUIRED,
            'admin_note' => $request->message,
        ]);

        try {
            Mail::to($checkout->email)->send(new ActionRequiredMail($checkout));
        } catch (Exception $e) {
            Log::error('Mail Error: ' . $e->getMessage());
        }

        return back()->with('status', "Requested more info from {$checkout->full_name} ({$checkout->unique_id}).");
    }
}
