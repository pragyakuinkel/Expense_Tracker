<?php

namespace Database\Seeders;

use App\Enum\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::create([
            'name' => "admin",
            'email' => "admin@gmail.com",
            'password' => bcrypt("admin"),
        ])->roles()->sync(Role::where('name', RoleName::ADMIN)->first());

        $users = User::create([
            'name' => "pragya",
            'email' => "pragya@gmail.com",
            'password' => bcrypt("123456789"),
        ])->roles()->sync(Role::where('name', RoleName::User)->first());

    }
}
