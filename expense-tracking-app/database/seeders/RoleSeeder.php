<?php

namespace Database\Seeders;

use App\Enum\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
//    public function run(): void
//    {
//        Role::create([
//            'id'=>1,
//            'name' => "Admin",
//        ]);
//
//        Role::create([
//            'id'=>2,
//            'name' => "User",
//        ]);
//    }

    public function run(): void
    {
        Role::create(['name' => RoleName::ADMIN]);

        Role::create(['name' => RoleName::User]);

//        $this->createAdminRole();
//        $this->createUserRole();
    }
//    protected function createAdminRole(): void
//    {
//        $role = Role::where('name', RoleName::ADMIN)->first();
//
//        if (!$role) {
//            $role = Role::create(['name' => RoleName::ADMIN]);
//        }
//
//        $permissions = Permission::where('name', 'like', 'category.%')->get();
//
//        $role->permissions()->syncWithoutDetaching($permissions->pluck('id')->toArray());
//    }

}
