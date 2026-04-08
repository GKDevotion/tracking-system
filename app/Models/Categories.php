<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'image',
        'sort_order',
        'description',
        'short_description',
        'parent_id',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sub_category()
    {
        return $this->hasMany(Categories::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('status', 1);
    }
    public function SingleChildren()
    {
        return $this->hasOne(Categories::class, 'id', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id', 'id')->where('status', 1);
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    // public function blogs()
    // {
    //     return $this->hasMany(Blog::class, 'category_id', 'blog_category_maps');
    // }



    // public function getPackageViaCategory(){
    //     return $this->hasMany(Package::class, 'sub_category_id')->where( 'status', 1 )->limit(8);
    // }
}
