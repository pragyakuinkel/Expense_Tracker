<?php

namespace Database\Seeders;

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
        ]);

        $users->roles()->attach(1);

        $users = User::create([
            'name' => "pragya",
            'email' => "pragya@gmail.com",
            'password' => bcrypt("123456789"),
        ]);

        $users->roles()->attach(2);
    }
}
