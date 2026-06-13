<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignalResult extends Model
{
    protected $fillable = [
        'signal_id','result_type','pips_points','result_text',
        'status','approved_by','approved_at','telegram_message_id'
    ];

    protected $casts = ['approved_at' => 'datetime'];

    public function signal(): BelongsTo
    {
        return $this->belongsTo(Signal::class);
    }
}
