<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Expense;
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

        $months=Expense::where('user_id', Auth::id())->orderBy('date', 'desc')->get()
            ->groupBy(function ($expense) {
                return Carbon::parse($expense->date)->format('Y F');
            });;

        return view('dashboard', compact('success','months'));
//1
//        $data = new Collection([["id"=>1,"name"=>"ABC"]]);
//
//        $data=$data->map(function($item) {
//            return ["label"=>$item["name"],
//            'value'=>$item["id"]];
//
////            return $item->id;
//        });
//
//        dd($data);

//2
//        $data = new Collection([
//            ["id"=>1,"amount"=>10000,'VAT'=>113],
//            ["id"=>2,"amount"=>2000,'VAT'=>213],
//        ]);
//
//        $total = $data->reduce(function ($carry,$item) {
//            return $carry + $item['amount'] + $item['VAT'];
//        });
//
//        dd($total);

// 6
//
//        $result = $data->sum('amount');
//
//        dd($result);

//3
//        $data=new Collection([
//            ["name"=>"ABC","age"=>18],
//            ["name"=>"BCD", "age"=>25],
//        ]);
//
//        $keyed = $data->mapWithKeys(function ($item) {
//            return [$item['name'] => $item['age']];
//        });
//
//        dd($keyed);

//4
//        $data=new Collection([
//            ["id"=>1,"name"=>"ABC"],
//            ["id"=>2,"name"=>"BCD"],
//        ]);
//
//        $collection = $data->map(function ($item) {
//            return strtolower($item['name']);
//        });
//
//        $data->flatMap(function (array $values) {
//            return array_map('strtolower', $values);
//        });

//        dd($collection);

//        $data=new Collection([
//            ["id"=>"1","name"=>"ABC"],["age"=>20,"company"=>"DEF"]
//        ]);
//
//        $collection=$data->flatMap(function ($values) {
//            return array_map('strtolower',$values);
//        });
////
//        dd($collection);
    }
}
