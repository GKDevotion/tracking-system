<?php

namespace App\Models;

use App\Models\Categories;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = "blogs";
    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category_id',
        'title',
        'slug',
        'image',
        'sort_url',
        'image',
        'podcast_url', 
        'short_description',
        'keyword',
        'description', 
        'status', 
    ];
    use HasFactory;

 
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
        return $this->belongsToMany(Tag::class, 'blog_tag_maps', 'blog_id', 'tag_id');
    }



    // public function user(){
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }
}
