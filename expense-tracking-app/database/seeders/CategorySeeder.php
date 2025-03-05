<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name'=>"Gym",
            'role_id'=>1
        ]);Category::create([
            'name'=>"Food",
            'role_id'=>1
        ]);
        Category::create([
            'name'=>"Travel",
            'role_id'=>1
        ]);
        Category::create([
            'name'=>"Rent",
            'role_id'=>1
        ]);
        Category::create([
            'name'=>"Grocery",
            'role_id'=>1
        ]);
    }
}
