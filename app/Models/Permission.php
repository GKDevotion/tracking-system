<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'menu_id',
        'can_view',
        'can_insert',
        'can_edit',
        'can_delete',
    ];

    protected $casts = [
        'can_view'   => 'boolean',
        'can_insert' => 'boolean',
        'can_edit'   => 'boolean',
        'can_delete' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
