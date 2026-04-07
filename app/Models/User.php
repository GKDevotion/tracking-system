<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'full_name',
        'username',
        'email',
        'phone',
        'password',
        'role_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function trackings()
    {
        return $this->hasMany(Tracking::class);
    }

    public function getPermissionsAttribute()
    {
        if (!$this->role_id) return collect();
        return Permission::where('role_id', $this->role_id)->with('menu')->get();
    }

    public function hasPermission(string $menuSlug, string $ability = 'can_view'): bool
    {
        $permission = Permission::whereHas('menu', function ($q) use ($menuSlug) {
            $q->where('slug', $menuSlug);
        })->where('role_id', $this->role_id)->first();

        return $permission ? (bool) $permission->$ability : false;
    }
}
