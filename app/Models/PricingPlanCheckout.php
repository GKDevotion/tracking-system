<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
class PricingPlanCheckout extends Model
{
    protected $table = 'pricing_plan_checkout';

    protected $fillable = [
        'unique_id',
        'payment_token',
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
        'payment_type',
        'payment_option',
        'confirm_payment',
        'status',
        'payment_submitted_at',

    ];

    protected $casts = [
        'payment_submitted_at' => 'datetime',
    ];

    public const STATUS_PENDING_PAYMENT   = 'pending_payment';
    public const STATUS_PAYMENT_SUBMITTED = 'payment_submitted';
    public const STATUS_VERIFIED          = 'verified';
    public const STATUS_REJECTED          = 'rejected';
    public const STATUS_COMPLETED         = 'completed'; // free plan

    protected static function boot()
    {
        parent::boot();

        static::creating(function (PricingPlanCheckout $model) {
            if (empty($model->unique_id)) {
                $model->unique_id = self::generateUniqueId();
            }

            if (empty($model->payment_token)) {
                $model->payment_token = Str::random(48);
            }
        });
    }

    /**
     * Generates a reference like WOR11082026417
     * WOR + ddmmYYYY (today's date) + 3 random digits, guaranteed unique.
     */
    public static function generateUniqueId(): string
    {
        do {
            $id = 'WOR' . now()->format('dmY') . str_pad((string) random_int(0, 999), 3, '0', STR_PAD_LEFT);
        } while (self::where('unique_id', $id)->exists());

        return $id;
    }

    public function getPaymentUrlAttribute(): ?string
    {
        if (! $this->payment_token) {
            return null;
        }

        return route('checkout.payment.show', $this->payment_token);
    }

    public function planDetails(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan', 'id');
    }

    Public function countryData(): BelongsTo{
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
