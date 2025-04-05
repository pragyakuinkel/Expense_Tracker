<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function dashboard(Request $request)
    {

        $start_date = $request->input('start_date') ?? Carbon::now()->startOfYear();

        $end_date = $request->input('end_date') ?? Carbon::now()->endOfYear();

        $date = Carbon::parse($start_date)->format('d M Y') .' - '.Carbon::parse($end_date)->format('d M Y') ?? "";

        $income = Income::where('user_id', Auth::id())
            ->whereBetween('date', [$start_date, $end_date])
            ->where(function ($query) use ($request) {
                $query->where('description','like',"%{$request->search}%")
                    ->orWhere('date','like',"%{$request->search}%")
                    ->orWhere('amount','like',"%{$request->search}%");
            })
            ->get();

        $expense = Expense::where('user_id', Auth::id())
            ->whereBetween('date', [$start_date, $end_date])
            ->where(function ($query) use ($request) {
                $query->where('description','like',"%{$request->search}%")
                    ->orWhere('date','like',"%{$request->search}%")
                    ->orWhere('amount','like',"%{$request->search}%")
                    ->OrWhereHas('category', function ($query) use ($request) {
                        $query->where('name','like',"%{$request->search}%");
                    });
            })
            ->get();

        $months = collect($expense)->merge($income)
            ->sortByDesc('date')
            ->groupBy(function ($income) {
            return Carbon::parse($income->date)->format('Y F');
        });

        $income = Income::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now())->whereYear('date', Carbon::now())->sum('amount');

        $expense = Expense::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now())->whereYear('date', Carbon::now())->sum('amount');

        $search = $request->input('search');

        $transaction[] = ['income' => $income, 'expense' => $expense, 'left' => floatval($income) - floatval($expense)];

        return view('dashboard', compact('months', 'transaction', 'search','date'));

    }

    public function select(){

        $roles = Role::whereHas('users',function($query){
            $query->where('id',Auth::id());
        })->get();

        if($roles->count() <= 1){
            foreach($roles as $role){
                session(['role' => $role->id]);
                return redirect()->route('dashboard');
            }
        }
        return view('user_role.select', compact('roles'));
    }

    public function assignRoleSelect(Request $request){

        session(['role' => $request->role]);

        return redirect()->route('dashboard');
    }
}
