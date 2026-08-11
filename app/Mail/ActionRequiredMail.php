<?php

namespace App\Mail;

use App\Models\PricingPlanCheckout;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActionRequiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public PricingPlanCheckout $checkout;

    public function __construct(PricingPlanCheckout $checkout)
    {
        $this->checkout = $checkout;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Action Required — Wealthora Subscription',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.action-required',
            with: [
                'checkout'   => $this->checkout,
                'paymentUrl' => $this->checkout->payment_url,
            ],
        );
    }
}
