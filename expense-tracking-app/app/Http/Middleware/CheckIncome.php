<?php

namespace App\Http\Middleware;

use App\Models\Estimate;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIncome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $estimate=Estimate::where('user_id',$request->user()->id)->first();

        if($estimate){
            return $next($request);
        }

        return redirect()->route('estimate.income');
    }
}
