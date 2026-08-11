<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TelegramPrivateSignal extends Model
{
    protected $table = 'telegram_private_signals';

    protected $fillable = [
        'channel_id',
        'telegram_message_id',
        'reply_to_message_id',

        'symbol',
        'direction',

        'entry',
        'stop_loss',

        'take_profit_1',
        'take_profit_2',
        'take_profit_3',

        'status',
        'result_pips',
        'message_type',

        'raw_message',
        'raw_payload',

        'telegram_date',
    ];

    protected $casts = [
        'entry' => 'decimal:5',
        'stop_loss' => 'decimal:5',
        'take_profit_1' => 'decimal:5',
        'take_profit_2' => 'decimal:5',
        'take_profit_3' => 'decimal:5',
        'result_pips' => 'decimal:2',
        'telegram_date' => 'datetime',
    ];

    public function updates(): HasMany
    {
        return $this->hasMany(
            TelegramPrivateSignalUpdate::class,
            'signal_id'
        );
    }
}
