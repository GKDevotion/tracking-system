<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoData extends Model
{
    //
      protected $fillable = [
        'page_slug',
        'meta_title',
        'meta_description',
        'json_ld',
        'keywords',
        'h1_tag',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'robots',
        'status',
    ];

    protected $casts = [
        'json_ld' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
