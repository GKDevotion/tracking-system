<?php
// ════════════════════════════════════════════════════════════
//  app/Models/BmCategory.php
// ════════════════════════════════════════════════════════════
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BmCategory extends Model
{
    use HasFactory;

    protected $table = 'bm_categories';

    protected $fillable = ['name', 'slug', 'status'];

    protected $casts = ['status' => 'integer'];

    // Auto-generate slug before save
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

    public function templates()
    {
        return $this->hasMany(BmMailTemplate::class, 'category_id');
    }
}
