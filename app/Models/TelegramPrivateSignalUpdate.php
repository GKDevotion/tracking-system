<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramPrivateSignalUpdate extends Model
{
    protected $table = 'telegram_private_signal_updates';

    protected $fillable = [
        'signal_id',
        'channel_id',
        'telegram_message_id',
        'reply_to_message_id',
        'update_type',
        'result_pips',
        'message',
        'raw_payload',
        'telegram_date',
    ];

    protected $casts = [
        'result_pips' => 'decimal:2',
        'telegram_date' => 'datetime',
    ];

    public function signal(): BelongsTo
    {
        return $this->belongsTo(
            TelegramPrivateSignal::class,
            'signal_id'
        );
    }
}
