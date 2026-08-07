<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PricingPlanCheckoutMail extends Mailable
{
    use Queueable, SerializesModels;

    public $checkout;

    public function __construct($checkout)
    {
        $this->checkout = $checkout;
    }

    public function build()
    {
        return $this->subject('New Pricing Plan Registration')
                    ->view('emails.pricing-plan-checkout');
    }
}
