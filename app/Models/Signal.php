<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Signal extends Model
{
    protected $fillable = [
        'pair','direction','entry_min','entry_max','sl',
        'tp1','tp2','tp3','signal_text','status','channel',
        'approved_by','approved_at','telegram_message_id','screenshot_url'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'entry_min'   => 'decimal:5',
        'entry_max'   => 'decimal:5',
    ];

    public function results(): HasMany
    {
        return $this->hasMany(SignalResult::class);
    }

    public function isForex(): bool
    {
        return str_contains($this->pair, '/') &&
               !in_array($this->pair, ['XAU/USD','XAG/USD','WTI/USD']);
    }

    public function isJPY(): bool
    {
        return str_contains($this->pair, 'JPY');
    }
}
