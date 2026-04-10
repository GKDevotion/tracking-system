<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlanCheckout extends Model
{
    protected $table = 'pricing_plan_checkout';

    protected $fillable = [
        'user_id',
        'plan',
        'first_name',
        'last_name',
        'full_name',
        'email',
        'country',
        'trade_signals',
        'tele_username',
        'mobile_number',
        'payment_option',
        'confirm_payment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
