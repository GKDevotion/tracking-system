<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForexUpdate extends Model
{
    protected $table = 'free_signals_updates';
    protected $fillable = [
            'signal_date',
            'pair',
            'order_type',
            'entry_price',
            'stop_loss',
            'take_profit',
            'profit',
            'sort_order',
            'status',
            'live_btn_url',
            'post_id',
            'result_id',
            'result_date',
            'ticket'
        ];

}
