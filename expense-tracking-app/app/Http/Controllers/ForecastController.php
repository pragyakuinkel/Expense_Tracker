<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Estimate;
use App\Models\Expense;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ForecastController extends Controller
{
    public function forecast($date = null){

        if($date == null){
            $date = Carbon::now();
        }else{
            $date = Carbon::parse($date);
        }

        $forecasts=[];

        $categories = Category::whereHas('users', function ($query) use ($date) {
            $query->where('user_id', Auth::id())
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year);
        })->with(['users' => function ($query) use ($date) {
            $query->where('user_id', Auth::id())
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year);
        }])->get();

        $estimate=Estimate::where('user_id', Auth::id())->first();

        $expense=Expense::where('user_id', Auth::id())->whereMonth('date', $date->month)
            ->whereYear('date', $date->year)->sum('amount');

        $lastCategories = Category::whereHas('users', function ($query) use ($date) {
            $query->where('user_id', Auth::id())
                ->whereMonth('date', $date->copy()->subMonth()->month)
                ->whereYear('date', $date->copy()->subMonth()->year);
        })->with(['users' => function ($query) use ($date) {
            $query->where('user_id', Auth::id())
                ->whereMonth('date', $date->copy()->subMonth()->month)
                ->whereYear('date', $date->copy()->subMonth()->year);
        }])->get();

        if($date->month>Carbon::now()->month){
            foreach($lastCategories as $category){
                foreach($category->users as $user){
                    $LastExpense=Expense::where('user_id', Auth::id())
                        ->where('category_id', $category->id)
                        ->whereMonth('date', $date->copy()->subMonth())
                        ->whereYear('date', $date->copy()->subMonth()->year)->sum('amount');

                    $expensePercent=floatVal($LastExpense)/floatVal($estimate->amount)*100;

                    $limit=(floatval($user->pivot->limit)+$expensePercent)/2;

                    $estimateExpense=floatVal($estimate->amount)*floatVal($limit)/100;

                    $expensePercent=floatVal($expense)/floatVal($estimate->amount)*100;

                    $forecasts[]=['category'=>$category->name,'limit'=>$limit,'estimate'=>$estimateExpense,'expense'=>$expense,'expensePercent'=>$expensePercent];
                }
            }
        }else{
            foreach($categories as $category){
                foreach($category->users as $user){

                    $expense=Expense::where('user_id', Auth::id())
                        ->where('category_id', $category->id)
                        ->whereMonth('date', $date->month)
                        ->whereYear('date', $date->year)->sum('amount');

                    $estimateExpense=floatVal($estimate->amount)*floatVal($user->pivot->limit)/100;

                    $expensePercent=floatVal($expense)/floatVal($estimate->amount)*100;

                    $limit=$user->pivot->limit;

                    $forecasts[]=['category'=>$category->name,'limit'=>$limit,'estimate'=>$estimateExpense,'expense'=>$expense,'expensePercent'=>$expensePercent];
                }
            }
        }

        $expectedExpense=0;
        $actualExpense=0;

        foreach($forecasts as $forecast){
            $expectedExpense+=$forecast['estimate'];
            $actualExpense+=$forecast['expense'];
        }

        $monthSelected=$date->format('F');

        return view('forecast.forecast', compact('forecasts','estimate','expectedExpense','actualExpense','monthSelected'));
    }
}
