<?php

namespace App\Mail;

use App\Models\PricingPlanCheckout;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSubmittedAdminMail extends Mailable
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
            subject: 'Payment proof submitted — Ref: ' . $this->checkout->unique_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-submitted-admin',
            with: ['checkout' => $this->checkout],
        );
    }

    public function attachments(): array
    {
        if (! $this->checkout->confirm_payment) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->checkout->confirm_payment),
        ];
    }
}
