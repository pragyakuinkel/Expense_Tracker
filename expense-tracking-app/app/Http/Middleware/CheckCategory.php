<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCategory
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $categories = Category::whereHas('users', function ($query) {
            $query->where('user_id', auth()->id())->whereYear('date', Carbon::now()->year);
        })->exists();

        if ($categories) {
            return $next($request);
        }

        return redirect()->route('estimate.selectCategory');
    }
}
