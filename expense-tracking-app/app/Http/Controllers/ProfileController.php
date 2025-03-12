<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Statement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function dashboard(){

        $success=session()->get('success');

        $income=Income::where('user_id',Auth::id())->get();

        $expense=Expense::where('user_id',Auth::id())->get();

        $months=collect($expense)->merge($income)->groupBy(function ($income) {
            return Carbon::parse($income->date)->format('Y F');
        });

        $income=Income::where('user_id',Auth::id())
            ->whereMonth('date', Carbon::now())->whereYear('date', Carbon::now())->sum('amount');

        $expense=Expense::where('user_id',Auth::id())
            ->whereMonth('date', Carbon::now())->whereYear('date', Carbon::now())->sum('amount');

        $transaction[]=['income'=>$income,'expense'=>$expense,'left'=>floatval($income)-floatval($expense)];

        return view('dashboard', compact('success','months','transaction'));

    }
}
