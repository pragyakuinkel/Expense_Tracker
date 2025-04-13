<?php

namespace App\Models;

use App\Enum\RoleName;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'value' => RoleName::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function hasPermission(string $permission, string $role): bool
    {
        $permissions = Permission::whereHas('roles', function ($q) use ($role) {
            $q->where('id', $role);//
        })->where('name', $permission)->exists();

        return $permissions;
    }

    public function hasPermissionGroup(string $permission, string $role): bool
    {
        $totalPermission = Permission::where('group', $permission)->count();

        $permissions = Permission::whereHas('roles', function ($q) use ($role) {
            $q->where('id', $role);
        })->where('group', $permission)->count();

        return $totalPermission == $permissions;
    }
}
