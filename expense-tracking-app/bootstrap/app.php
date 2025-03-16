<?php

use App\Console\Commands\ForecastUpdate;
use App\Http\Middleware\CheckAdminUser;
use App\Http\Middleware\CheckCategory;
use App\Http\Middleware\CheckIncome;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\CheckUserStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'income' => CheckIncome::class,
            'category' => CheckCategory::class,
            'admin' => CheckUserRole::class,
            'status' => CheckUserStatus::class,
            'user' => CheckAdminUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->withSchedule(function (Schedule $schedule) {
        $schedule->call(ForecastUpdate::class)->lastDayOfMonth();
    })

    ->create();
