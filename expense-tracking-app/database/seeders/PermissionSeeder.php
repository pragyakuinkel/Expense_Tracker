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

        $actionLabels = [
            'index' => 'View All',
            'create' => 'Create',
            'store' => 'Store',
            'edit' => 'Edit',
            'update' => 'Update',
            'destroy' => 'Delete',
            'show' => 'View',
        ];

        foreach ($routes as $folder => $folderRoute) {
            foreach ($folderRoute as $route) {
                if($route['folder'] == 'admin' || $route['folder'] == 'category' || $route['folder'] == 'role'){

                    $label = $actionLabels[Str::of($route['name'])->explode('.')->last()] ?? Str::headline(Str::of($route['name'])->explode('.')->last());
                    Permission::firstOrCreate([
                        'name' => $route['name'],
                        'uri' => $route['uri'],
                        'group' => $folder,
                        'slug' => $label,
                    ]);
                }
            }
        }
    }
}
