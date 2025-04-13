<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ForecastUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:forecast-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        $date = Carbon::now()->startOfMonth();

        $newMonth = $date->copy()->addMonth();

        foreach ($users as $user) {

            $categories = Category::whereHas('users', function ($query) use ($user, $date) {
                $query->where('user_id', $user->id)
                    ->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year);
            })->with(['users' => function ($query) use ($date) {
                $query->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year);
            }])->withSum(['expenses as current_expense' => function ($query) use ($user, $date) {
                $query->where('user_id', $user->id)
                    ->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year);
            }], 'amount')->get();

            $income = DB::table('incomes')
                ->selectRaw("
                SUM(CASE
                    WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount
                    ELSE 0
                END) as current_income,
                SUM(CASE
                    WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount
                    ELSE 0
                END) as new_income
            ", [
                    $date->month, $date->year,
                    $newMonth->month, $newMonth->year
                ])
                ->where('user_id', $user->id)
                ->first();


            $estimate = DB::table('estimates')->selectRaw("
                SUM(CASE
                    WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount
                    ELSE 0
                END) as current_estimate,
                SUM(CASE
                    WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount
                    ELSE 0
                END) as new_estimate
            ", [
                $date->month, $date->year,
                $newMonth->month, $newMonth->year
            ])
                ->where('user_id', $user->id)
                ->first();

            if ($income->new_income <= 0) {
                $estimate = $estimate->new_estimate;
            } else {
                $estimate = $income->new_income;
            }

            foreach ($categories as $category) {
                foreach ($category->users as $userInfo) {

                    $expensePercent = round(floatVal($category->current_expense) / floatVal($estimate) * 100, 2);

                    $limit = (floatval($userInfo->pivot->limit) + $expensePercent) / 2;

                    DB::table('category_user')->where('user_id', $userInfo->id)
                        ->where('category_id', $category->id)
                        ->whereMonth('date', $newMonth)
                        ->whereYear('date', $newMonth)
                        ->update(['limit' => $limit]);
                }
            }
        }
        $this->info('Limits updated successfully!');
    }
}
