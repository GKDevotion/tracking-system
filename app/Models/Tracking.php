<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'vendor',
        'in_time',
        'out_time',
        'short_description',
        'latitude',
        'longitude',
        'address',
        'status',
    ];

    protected $casts = [
        'date'      => 'date',
        'latitude'  => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
