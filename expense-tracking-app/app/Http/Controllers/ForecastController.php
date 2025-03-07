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

        $success=session()->get('success');

        if($date == null){
            $date = Carbon::now();
        }else{
            $date = Carbon::parse($date)->startOfMonth();
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
            $estimate=Estimate::where('user_id', Auth::id())->whereMonth('date', $date->copy()->subMonth())
                ->whereYear('date', $date->copy()->subMonth()->year)->first();

            $newCategories = $categories->filter(function($category) use ($lastCategories) {
                return $lastCategories->contains('id', $category->id);
            });//in both month

            $categories = $categories->filter(function($category) use ($lastCategories) {
                return !$lastCategories->contains('id', $category->id);
            });//only current month

            foreach($newCategories as $category){
                foreach($category->users as $user){
                    $LastExpense=Expense::where('user_id', Auth::id())
                        ->where('category_id', $category->id)
                        ->whereMonth('date', $date->copy()->subMonth())
                        ->whereYear('date', $date->copy()->subMonth()->year)->sum('amount');

                    $expensePercent=round(floatVal($LastExpense)/floatVal($estimate->amount)*100,2);

                    $limit=round((floatval($user->pivot->limit)+$expensePercent)/2, 2);

                    $estimateExpense=round(floatVal($estimate->amount)*floatVal($limit)/100,2);

                    $expensePercent=round(floatVal($expense)/floatVal($estimate->amount)*100,2);

                    $estimate=Estimate::where('user_id', Auth::id())->whereMonth('date', $date->month)
                        ->whereYear('date', $date->year)->first();

                    $forecasts[]=['category'=>$category->name,'limit'=>$limit,'estimate'=>$estimateExpense,'expense'=>$expense,'expensePercent'=>$expensePercent];
                }
            }

            foreach($categories as $category){
                foreach($category->users as $user){

                    $expense=Expense::where('user_id', Auth::id())
                        ->where('category_id', $category->id)
                        ->whereMonth('date', $date->month)
                        ->whereYear('date', $date->year)->sum('amount');

                    $estimateExpense=round(floatVal($estimate->amount)*floatVal($user->pivot->limit)/100,2);

                    $expensePercent=round(floatVal($expense)/floatVal($estimate->amount)*100,2);

                    $limit=$user->pivot->limit;

                    $forecasts[]=['category'=>$category->name,'limit'=>$limit,'estimate'=>$estimateExpense,'expense'=>$expense,'expensePercent'=>$expensePercent];
                }
            }
        }else{
            $estimate=Estimate::where('user_id', Auth::id())->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)->first();

            foreach($categories as $category){
                foreach($category->users as $user){

                    $expense=Expense::where('user_id', Auth::id())
                        ->where('category_id', $category->id)
                        ->whereMonth('date', $date->month)
                        ->whereYear('date', $date->year)->sum('amount');

                    $estimateExpense=round(floatVal($estimate->amount)*floatVal($user->pivot->limit)/100,2);

                    $expensePercent=round(floatVal($expense)/floatVal($estimate->amount)*100,2);

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

        return view('forecast.forecast', compact('forecasts','estimate','expectedExpense','actualExpense','monthSelected','success'));
    }
}
