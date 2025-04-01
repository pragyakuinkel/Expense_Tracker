<?php

namespace App\Http\Controllers;

use App\Enum\RoleName;
use App\Models\Category;
use App\Models\Income;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;


class AdminController extends Controller
{

    public function dashboard()
    {

        $user_count = User::count();

        $category_count = Category::count();

        $max_spent_categories = Category::withSum('expenses', 'amount')
            ->orderBy('expenses_sum_amount', 'desc')->limit(5)
            ->get();

        $max_spent = Category::withSum('expenses', 'amount')
            ->orderBy('expenses_sum_amount', 'desc')
            ->first();

        $avg_income = Income::whereMonth('date', Carbon::now())->whereYear('date', Carbon::now())->avg('amount') ?? 0;

        return view('admin.dashboard', compact('user_count', 'category_count', 'max_spent', 'avg_income', 'max_spent_categories'));
    }

    public function users()
    {
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'user');
        })->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.user', compact('users'));
    }

    public function category(User $user)
    {
        $categories = $user->categories()
            ->withSum('expenses', 'amount')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($category) {
                return Carbon::parse($category->pivot->date)->format('Y F');
            });

        return view('admin.category', compact('categories', 'user'));
    }

    public function permissions(string $roleId = null)
    {
        if ($roleId == null) {
            $roleId = Role::where('name', RoleName::User)->first()->id;
        }

        $permissions = Permission::get()->groupBy('group');

        $roles = Role::where('name', '!=', RoleName::ADMIN)->get();

        $user = Role::find($roleId);

        return view('admin.permission', compact('permissions', 'user', 'roles'));
    }

    public function addPermission(Request $request)
    {

        $user = Role::find($request->id);

        $user->permissions()->sync($request->input('permissions', []));

        session()->flash('success', 'Permission updated successfully');

        return back();
    }
}
