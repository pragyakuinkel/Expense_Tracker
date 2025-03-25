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

    public function run(): void
    {
        Role::create(['name' => RoleName::ADMIN]);

        Role::create(['name' => RoleName::User]);

    }

}
