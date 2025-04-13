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

    public function users(Request $request)
    {
        $search = $request->input('search');

        $start_date = $request->input('start_date') ?? Carbon::now()->startOfMonth();

        $end_date = $request->input('end_date') ?? Carbon::now()->endOfMonth();

        $date = Carbon::parse($start_date)->format('d M Y') .' - '.Carbon::parse($end_date)->format('d M Y') ;

        $users = User::whereBetween('created_at', [$start_date, $end_date])
                ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email','like',"%{$search}%")
                ->orWhere('username','like',"%{$search}%");
            })
            ->orderBy('updated_at', 'desc')
            ->whereHas('roles', function ($q) use ($search) {
                $q->where('name', '!=', RoleName::ADMIN)->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        $users->appends(['search' => $search, 'start_date' => $request->input('start_date'), 'end_date' => $request->input('end_date')]);

        return view('admin.user', compact('users','search','date'));
    }

    public function category(User $user,Request $request)
    {
        $date = Carbon::parse($request->input('date'));

        $search = $request->input('search');

        $categories = $user->categories()
            ->whereMonth('date', $date->month)
            ->whereYear('date', $date->year)
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories->appends(['date'=>$date,'search' => $search]);

        return view('admin.category', compact('categories', 'user','date'));
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
