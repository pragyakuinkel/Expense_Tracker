<?php

namespace App\Providers;

use App\Models\Estimate;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'estimate' => Estimate::class,
            'expense' => Expense::class,
        ]);
    }
}
