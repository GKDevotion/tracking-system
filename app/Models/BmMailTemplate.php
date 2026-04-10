<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BmMailTemplate extends Model
{
    use HasFactory;

    protected $table = 'bm_mail_templates';

    protected $fillable = [
        'category_id', 'name', 'slug', 'subject',
        'short_description', 'mail_template', 'status',
    ];

    protected $casts = ['status' => 'integer'];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            $model->slug = $model->slug ?: Str::slug($model->name);
        });
        static::updating(function (self $model) {
            if ($model->isDirty('name') && ! $model->isDirty('slug')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(BmCategory::class, 'category_id');
    }

    public function logs()
    {
        return $this->hasMany(BmMailLog::class, 'template_id');
    }
}
