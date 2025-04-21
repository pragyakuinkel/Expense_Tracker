<?php

namespace App\Providers;

use App\Models\Estimate;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
            'income' => Income::class,
        ]);

        Gate::define('update-income', function (User $user, Income $income) {
            return $user->id === $income->user_id;
        });
        Gate::define('update-expense', function (User $user, Expense $expense) {
            return $user->id === $expense->user_id;
        });
    }
}
