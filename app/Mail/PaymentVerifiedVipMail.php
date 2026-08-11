<?php

namespace App\Mail;

use App\Models\PricingPlanCheckout;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentVerifiedVipMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PricingPlanCheckout $checkout)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Wealthora VIP 🚀',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-verified-vip',
        );
    }
}