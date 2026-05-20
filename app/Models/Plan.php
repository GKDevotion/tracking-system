<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'type',
        'description',
        'features',
        'cta',
        'link',
        'remove',
        'is_highlighted',
        'is_active',
        'sort_order',
    ];
 

    protected $casts = [
        'features' => 'array',
        'remove' => 'array',
        'is_highlighted' => 'boolean',
        'is_active' => 'boolean',
    ];
}
