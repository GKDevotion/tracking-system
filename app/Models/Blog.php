<?php

namespace App\Models;

use App\Models\Categories;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "blogs";
    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category_id',
        'title',
        'slug',
        'image',
        'sort_url',
        'podcast_url',
        'short_description',
        'keyword',
        'description',
        'status',
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


    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    // public function category()
    // {
    //     return $this->belongsTo(Categories::class, 'category_id');
    // }

    public function sub_category()
    {
        return $this->hasOne(Categories::class, 'id', 'sub_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag_maps', 'blog_id', 'tag_id')
            ->withPivot(['category_id', 'sub_category_id'])
            ->withTimestamps();
    }



    // public function user(){
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }
}
