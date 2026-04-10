<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Configuration extends Model
{
    protected $fillable = [
        'key',
        'value',
        'display_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
