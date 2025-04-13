<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Estimate;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForecastController extends Controller
{
    public function forecast(Request $request){

        $success=session()->get('success');

        $date = Carbon::parse($request->input('date')) ?? Carbon::now();

        $previousMonth = $date->copy()->subMonth();

        $forecasts=[];

        $categories = Category::whereHas('users', function ($query) use ($date) {
            $query->where('user_id', Auth::id())
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year);
        })
        ->with(['users' => function ($query) use ($previousMonth, $date) {
            if($date->month == Carbon::now()->month){
                $query->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year);
            }else{
                $query->whereMonth('date', $previousMonth->month)
                    ->whereYear('date', $previousMonth->year);
            }

        }])
        ->withSum(['expenses as current_expense' => function ($query) use ($date) {
            $query->where('user_id', Auth::id())
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year);
        }], 'amount')
        ->withSum(['expenses as previous_expense' => function ($query) use ($previousMonth) {
            $query->where('user_id', Auth::id())
                ->whereMonth('date', $previousMonth->month)
                ->whereYear('date', $previousMonth->year);
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
                END) as previous_income
            ", [
                $date->month, $date->year,
                $previousMonth->month, $previousMonth->year
            ])
            ->where('user_id', Auth::id())
            ->first();


        $estimate = DB::table('estimates')->selectRaw("
                SUM(CASE
                    WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount
                    ELSE 0
                END) as current_estimate,
                SUM(CASE
                    WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount
                    ELSE 0
                END) as previous_estimate
            ", [
            $date->month, $date->year,
            $previousMonth->month, $previousMonth->year
        ])
            ->where('user_id', Auth::id())
            ->first();

        if($income->current_income <= 0){
            $estimate= $estimate->current_estimate;
        }else{
            $estimate= $income->current_income;
        }

        if($date->month > Carbon::now()->month){
            foreach($categories as $category){
                foreach($category->users as $user){

                    $limit=round(((floatVal($category->previous_expense)+(floatVal($estimate->previous_estimate ?? $income->previous_income)*floatVal($user->pivot->limit)/100))/2)/$estimate * 100,2);

                    $estimateExpense=round((floatVal($category->previous_expense)+(floatVal($estimate->previous_estimate ?? $income->previous_income)*floatVal($user->pivot->limit)/100))/2,2);

                    $expensePercent=round(floatVal($category->current_expense)/floatVal($estimate)*100,2);

                    $forecasts[]=[
                        'category'=>$category->name,
                        'limit'=>$limit,
                        'estimate'=>$estimateExpense,
                        'expense'=>$category->current_expense,
                        'expensePercent'=>$expensePercent
                    ];

                }
            }
        }else{
            foreach($categories as $category){
                foreach($category->users as $user){

                    $estimateExpense=round(floatVal($estimate)*floatVal($user->pivot->limit)/100,2);

                    $expensePercent=round(floatVal($category->current_expense)/floatVal($estimate)*100,2);

                    $limit=$user->pivot->limit;

                    $forecasts[]=[
                        'category'=>$category->name,
                        'limit'=>$limit,
                        'estimate'=>$estimateExpense,
                        'expense'=>$category->current_expense,
                        'expensePercent'=>$expensePercent
                    ];

                }
            }
        }

        $expectedExpense=0;

        $actualExpense=0;

        foreach($forecasts as $forecast){
            $expectedExpense+=$forecast['estimate'];
            $actualExpense+=$forecast['expense'];
        }

        return view('forecast.forecast', compact('forecasts','estimate','expectedExpense','actualExpense','date','success'));
    }
}
