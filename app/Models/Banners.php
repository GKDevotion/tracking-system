<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Banners extends Model
{
    // use HasFactory, SoftDeletes;
    use HasFactory;
    protected $table = "banners";
    protected $fillable = [
        'name',
        'slug',
        'image_path',
        'type',
        'sort_order',
        'status',
        'is_animate_image',
        'animate_class_name',
        'is_news',
        'is_click'
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = Carbon::now('Asia/Dubai');
            $model->updated_at = Carbon::now('Asia/Dubai');
        });

        static::updating(function ($model) {
            $model->updated_at = Carbon::now('Asia/Dubai');
        });
    }

        public function user()
    {
        return $this->belongsTo(User::class);
    }

}
