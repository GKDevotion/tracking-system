<?php

namespace App\Http\Controllers;

use App\Mail\CheckoutThankYouMail;
use App\Mail\PaymentConfirmationMail;
use App\Mail\PaymentSubmittedAdminMail;
use App\Mail\PaymentVerifiedVipMail;
use App\Models\Plan;
use App\Models\PricingPlanCheckout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    /**
     * STEP 1 — Personal information form.
     * Saves the lead, generates the unique reference + payment link,
     * and emails the user a "thank you" message.
     * For the free plan there is no payment step, so the record is
     * marked completed right away.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => ['required', 'email', 'max:255', Rule::unique('pricing_plan_checkout', 'email')],
            'country_id'    => 'required',
            'platform'   => 'required|in:telegram,whatsapp',
            'telegram_username' => ['nullable', 'string', 'max:255', Rule::unique('pricing_plan_checkout', 'tele_username')],
            'phone'      => ['required', 'string', 'max:255', Rule::unique('pricing_plan_checkout', 'mobile_number')],
        ]);

        $planMap   = Plan::where('is_active', 1)->pluck('id', 'name')->toArray();

        $planValue = $planMap[$request->plan] ?? 0;

        $tradeSignals = $request->platform === 'telegram' ? 0 : 1;

        $fullName = trim($request->first_name . ' ' . $request->last_name);

        $checkout = PricingPlanCheckout::create([
            'user_id'        => Auth::id(),
            'plan'           => $planValue,
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'full_name'      => $fullName,
            'email'          => $request->email,
            'country_id'        => $request->country_id,
            'trade_signals'  => $tradeSignals,
            'tele_username'  => $request->telegram_username,
            'mobile_number'  => $request->phone,
            'status'         => PricingPlanCheckout::STATUS_PENDING_PAYMENT
        ]);

        $this->safeSend(fn () => Mail::to($checkout->email)->send(new CheckoutThankYouMail($checkout)));

        return response()->json([
            'success'     => true,
            'message'     => 'Thanks! Please check your email for the link to complete your payment.',
            'unique_id'   => $checkout->unique_id,
            'payment_url' => $checkout->payment_url,
        ]);
    }

    /**
     * STEP 2 — Show the payment upload form for a given secure token.
     */
    public function showPaymentForm(string $token)
    {
        $checkout = PricingPlanCheckout::where('payment_token', $token)->firstOrFail();

        if ($checkout->status !== PricingPlanCheckout::STATUS_PENDING_PAYMENT) {
            return view('frontend.checkout-payment', [
                'checkout'       => $checkout,
                'alreadySubmitted' => true,
            ]);
        }

        return view('frontend.checkout-payment', [
            'checkout'          => $checkout,
            'alreadySubmitted'  => false,
        ]);
    }

    /**
     * STEP 2 — Store payment proof, mark the record submitted,
     * email the admin (with the proof attached) and email the user a confirmation.
     */
    public function storePayment(Request $request, string $token)
    {
        $checkout = PricingPlanCheckout::where('payment_token', $token)->firstOrFail();

        if ($checkout->status !== PricingPlanCheckout::STATUS_PENDING_PAYMENT) {
            return response()->json([
                'success' => false,
                'message' => 'This payment link has already been used or is no longer valid.',
            ], Response::HTTP_CONFLICT);
        }

        $rules = [
            'payment_type' => 'required|in:crypto,bank',
            'proof_file'   => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ];

        if ($request->payment_type === 'crypto') {
            $rules['crypto_network'] = 'required|in:trc20,bep20';
        }

        $request->validate($rules);

        // 0 = TRC20, 1 = BEP20, 2 = BANK
        if ($request->payment_type === 'bank') {
            $paymentOption = 2;
        } else {
            $paymentOption = $request->crypto_network === 'trc20' ? 0 : 1;
        }

        $filePath = null;
        if ($request->hasFile('proof_file')) {
            $filePath = $request->file('proof_file')->store('uploads', 'public');
        }

        $checkout->update([
            'payment_type'         => $request->payment_type,
            'payment_option'       => $paymentOption,
            'confirm_payment'      => $filePath,
            'status'               => PricingPlanCheckout::STATUS_PAYMENT_SUBMITTED,
            'payment_submitted_at' => now(),
        ]);

        $this->safeSend(fn () => Mail::to('support@wealthora.io')->send(new PaymentSubmittedAdminMail($checkout)));
        $this->safeSend(fn () => Mail::to($checkout->email)->send(new PaymentConfirmationMail($checkout)));

        return response()->json([
            'success'   => true,
            'message'   => 'Payment proof submitted successfully.',
            'unique_id' => $checkout->unique_id,
        ]);
    }

    /**
     * Send mail without letting an SMTP failure break the request/response cycle.
     */
    private function safeSend(callable $send): void
    {
        try {
            $send();
        } catch (Exception $e) {
            Log::error('Mail Error: ' . $e->getMessage());
        }
    }

    public function verifyPayment(Request $request, string $token)
    {
        $checkout = PricingPlanCheckout::where('payment_token', $token)->firstOrFail();

        if ($checkout->status !== PricingPlanCheckout::STATUS_PAYMENT_SUBMITTED) {
            return response()->json([
                'success' => false,
                'message' => 'This payment cannot be verified in its current state.',
            ], Response::HTTP_CONFLICT);
        }

        $startDate  = now();
        $expiryDate = now()->addDays($checkout->plan?->duration_days ?? 30); // adjust to your Plan model

        $checkout->update([
            'status'           => PricingPlanCheckout::STATUS_VERIFIED,
            'start_date'       => $startDate,
            'expiry_date'      => $expiryDate,
            'vip_access_link'  => config('app.vip_access_url'), // or per-plan link
            'verified_at'      => now(),
        ]);

        $this->safeSend(fn () => Mail::to($checkout->email)->send(new PaymentVerifiedVipMail($checkout)));

        return response()->json([
            'success' => true,
            'message' => 'Payment verified and VIP welcome email sent.',
            'unique_id' => $checkout->unique_id,
        ]);
    }
}
