<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function dashboard(){
        $user_count = User::count();
        $category_count = Category::count();
        $max_spent = Category::withSum('expenses', 'amount')
        ->orderByDesc('expenses_sum_amount')
        ->first();
        $avg_income=Income::whereMonth('date',Carbon::now())->whereYear('date',Carbon::now())->avg('amount') ?? 0;
        return view('admin.dashboard', compact('user_count', 'category_count','max_spent','avg_income'));
    }

    public function users(){
        $users=User::whereHas( 'roles', function($q){
            $q->where('name','user');
        })->orderBy('updated_at','desc')->paginate(10);
        return view('admin.user',compact('users'));
    }

    public function category(User $user){
        $categories = $user
            ->categories()
            ->orderBy('created_at','desc')->get()->groupBy(function ($category) {
            return Carbon::parse($category->pivot->date)->format('Y F');
        });


        return view('admin.category',compact('categories','user'));
    }
}
