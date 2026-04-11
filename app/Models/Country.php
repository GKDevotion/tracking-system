<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "countries";
    protected $fillable = [
        'sortname',
        'sort_description',
        'name',
        'symbol',
        'code',
        'image',
        'flag',
        'status'
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



    // public function user(){
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }
}
