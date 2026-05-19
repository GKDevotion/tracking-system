<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForexUpdate extends Model
{
    protected $table = 'free_signals_updates';
    protected $fillable = [
            'signal_date',
            'order_type',
            'entry_price',
            'pair',
            'live_btn_url',
            'stop_loss',
            'take_profit',
            'profit',
            'sort_order',
            'status',
        ];
 
}
