<?php

namespace App\Http\Middleware;

use App\Enum\RoleName;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = Role::find(session('role'));

        if ($role->name == RoleName::ADMIN->value) {
            return $next($request);
        }

        $hasPermission = $role->hasPermission($request->route()->getName(), $role->id);

        if ($hasPermission) {
            return $next($request);
        } else {
            abort(401);
        }
    }
}
