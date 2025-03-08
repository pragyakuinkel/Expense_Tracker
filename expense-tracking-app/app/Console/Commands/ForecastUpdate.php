<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Estimate;
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

        foreach ($users as $user) {

            $categories = Category::whereHas('users', function ($query) use ($user, $date) {
                $query->where('user_id', $user->id)
                    ->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year);
            })->with(['users' => function ($query) use ($user, $date) {
                $query->where('user_id', $user->id)
                    ->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year);
            }])->get();

            $lastCategories = Category::whereHas('users', function ($query) use ($user, $date) {
                $query->where('user_id', $user->id)
                    ->whereMonth('date', $date->copy()->subMonth()->month)
                    ->whereYear('date', $date->copy()->subMonth()->year);
            })->with(['users' => function ($query) use ($user, $date) {
                $query->where('user_id', $user->id)
                    ->whereMonth('date', $date->copy()->subMonth()->month)
                    ->whereYear('date', $date->copy()->subMonth()->year);
            }])->get();

            $estimate=Estimate::where('user_id', $user->id)->whereMonth('date', $date->copy()->subMonth())
                ->whereYear('date', $date->copy()->subMonth()->year)->first();

            $newCategories = $categories->filter(function($category) use ($lastCategories) {
                return $lastCategories->contains('id', $category->id);
            });//in both month

            foreach($newCategories as $category){
                foreach($category->users as $userInfo){
                    $LastExpense=Expense::where('user_id', $user->id)
                        ->where('category_id', $category->id)
                        ->whereMonth('date', $date->copy()->subMonth())
                        ->whereYear('date', $date->copy()->subMonth()->year)->sum('amount');

                    $expensePercent=round(floatVal($LastExpense)/floatVal($estimate->amount)*100,2);

                    $limit=round((floatval($userInfo->pivot->limit)+$expensePercent)/2, 2);

//            $category->users()->updateExistingPivot($userInfo->id, [
//                'limit' => $limit,
//                'date' => Carbon::now()->addMonth()->startOfMonth()
//            ]);

                    DB::table('category_user')->where('user_id',$userInfo->id)->where('category_id',$category->id)->whereMonth('date',Carbon::now()->addMonth())->whereYear('date',Carbon::now()->addMonth())
                        ->update(['limit' => $limit]);
                }
            }
        }
        $this->info('Limits updated successfully!');
    }
}
