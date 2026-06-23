<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MT5Trade extends Model
{
    protected $table = 'mt5_trades';

    protected $fillable = [
        'signal_id','ticket','pair','direction',
        'lots','entry','sl','tp1','status','raw_response',
    ];

    public function signal(): BelongsTo
    {
        return $this->belongsTo(Signal::class);
    }
}
