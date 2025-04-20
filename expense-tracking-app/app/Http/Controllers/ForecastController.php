<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonthRequest;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForecastController extends Controller
{
    public function forecast(MonthRequest $request)
    {
        $success = session()->get('success');

        $date = Carbon::parse($request->input('date')) ?? Carbon::now();
        $previousMonth = $date->copy()->subMonth();
        $now = Carbon::now();
        $forecasts = [];

        $categories = Category::whereHas('users', function ($query) use ($date) {
            $query->where('user_id', Auth::id())
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year);
        })
            ->withSum(['expenses as current_expense' => function ($query) use ($date) {
                $query->where('user_id', Auth::id())
                    ->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year);
            }], 'amount')
            ->withSum(['expenses as previous_expense' => function ($query) use ($previousMonth) {
                $query->where('user_id', Auth::id())
                    ->whereMonth('date', $previousMonth->month)
                    ->whereYear('date', $previousMonth->year);
            }], 'amount')
            ->get();

        $income = DB::table('incomes')
            ->selectRaw("
                SUM(CASE WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount ELSE 0 END) as current_income,
                SUM(CASE WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount ELSE 0 END) as previous_income
            ", [
                $date->month, $date->year,
                $previousMonth->month, $previousMonth->year
            ])
            ->where('user_id', Auth::id())
            ->first();

        $estimate = DB::table('estimates')
            ->selectRaw("
                SUM(CASE WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount ELSE 0 END) as current_estimate,
                SUM(CASE WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount ELSE 0 END) as previous_estimate
            ", [
                $date->month, $date->year,
                $previousMonth->month, $previousMonth->year
            ])
            ->where('user_id', Auth::id())
            ->first();

        $estimate = $income->current_income <= 0
            ? $estimate->current_estimate
            : $income->current_income;

        foreach ($categories as $category) {
            if ($date->month > $now->month || $date->year > $now->year) {
                $previousPivot = $category->users()
                    ->where('user_id', Auth::id())
                    ->whereMonth('date', $previousMonth->month)
                    ->whereYear('date', $previousMonth->year)
                    ->first();

                $limitPercent = $previousPivot?->pivot?->limit ?? 0;

                $estimateFromLimit = floatval($estimate->previous_estimate ?? $income->previous_income) * $limitPercent / 100;

                $estimateExpense = round((floatval($category->previous_expense) + $estimateFromLimit) / 2, 4);

                $limit = round($estimateExpense / $estimate * 100, 4);

                $expensePercent = round(floatval($category->current_expense) / floatval($estimate) * 100, 4);
            } else {
                $currentPivot = $category->users()
                    ->where('user_id', Auth::id())
                    ->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year)
                    ->first();

                $limit = $currentPivot?->pivot?->limit ?? 0;

                $estimateExpense = round(floatval($estimate) * $limit / 100, 4);

                $expensePercent = round(floatval($category->current_expense) / floatval($estimate) * 100, 4);
            }

            $forecasts[] = [
                'category' => $category->name,
                'limit' => $limit,
                'estimate' => $estimateExpense,
                'expense' => $category->current_expense,
                'expensePercent' => $expensePercent
            ];
        }

        $expectedExpense = array_sum(array_column($forecasts, 'estimate'));
        $actualExpense = array_sum(array_column($forecasts, 'expense'));

        return view('forecast.forecast', compact(
            'forecasts',
            'estimate',
            'expectedExpense',
            'actualExpense',
            'date',
            'success'
        ));
    }
}
