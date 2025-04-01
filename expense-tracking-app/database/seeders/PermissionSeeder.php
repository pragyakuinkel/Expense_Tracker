<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $routes = collect(Route::getRoutes())
            ->map(function ($route) {
                $folder = explode('/', $route->uri())[0];
                return [
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                    'folder' => $folder,
                ];
            })
            ->groupBy('folder');

        foreach ($routes as $folder => $folderRoute) {
            foreach ($folderRoute as $route) {
                if ($route['uri'] == 'login' || $route['uri'] == 'forgot-password' || $route['uri'] == 'reset-password' || $route['uri'] == 'verify-email' || $route['uri'] == 'verify-email/{id}/{hash}' || $route['uri'] == 'storage/{path}' || $route['uri'] == 'up' || $route['uri'] == '/' || $route['uri'] == 'register' || $route['uri'] == 'reset-password/{token}
                ' || $route['uri'] == 'confirm-password' || $route['uri'] == 'reset-password/{token}
                ') {
                    break;
                }
                Permission::firstOrCreate([
                    'name' => $route['name'],
                    'uri' => $route['uri'],
                    'group' => $folder,
                    'slug' => Str::slug(str_replace('.', ' ', $route['name'])),
                ]);
            }
        }
    }
}
