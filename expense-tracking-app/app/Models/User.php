<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function estimate()
    {
        return $this->hasOne(Estimate::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot('limit', 'date');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function statement()
    {
        $this->hasMany(Log::class);
    }    public function hasRole(string $id): bool
    {
        return $this->roles()->where('id', $id)->exists();
    }

    public function hasPermission(string $permission, string $role): bool
    {
        $permissions = Permission::whereHas('roles', function ($q) use ($role) {
            $q->where('id', $role);
        })->where('name', $permission)->exists();

        return $permissions;
    }
}
