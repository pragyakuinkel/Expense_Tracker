<?php

namespace App\Http\Controllers\Auth;

use App\Enum\RoleName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {

        DB::beginTransaction();

        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            $user->roles()->attach(Role::where('name',RoleName::User)->first()->id);

            DB::commit();

            return redirect('/login');

        }catch(\Exception $e){
            DB::rollBack();

            session()->flash('error',
                "User Registration Failed"
            );

            return back();
        }
    }
}
