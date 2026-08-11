<?php

namespace App\Mail;

use App\Models\PricingPlanCheckout;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CheckoutThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public PricingPlanCheckout $checkout;
    public ?string $paymentUrl;

    public function __construct(PricingPlanCheckout $checkout)
    {
        
        $this->checkout = $checkout;

        dd( $this->checkout);
        // Only paid plans get a payment link. Free plans get null here.
        $this->paymentUrl = $checkout->status === PricingPlanCheckout::STATUS_PENDING_PAYMENT
            ? $checkout->payment_url
            : null;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thanks for signing up — Ref: ' . $this->checkout->unique_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.checkout-thankyou',
            with: [
                'checkout'   => $this->checkout,
                'paymentUrl' => $this->paymentUrl,
            ],
        );
    }
}
