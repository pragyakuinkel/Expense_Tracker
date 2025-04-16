<?php

namespace App\Http\Controllers\Auth;

use App\Enum\RoleName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        if(User::where('username',$request->name)->exists()){
            $userType = 'username';
        }elseif (User::where('email',$request->name)->exists()){
            $userType = 'email';
        }else{
            session()->flash('no_role', "There is no such user with that email/ username");

            return redirect('/login');
        }

        if(
            Auth::attempt(
            [
                $userType => $request->name,
                'password' => $request->password,
            ]
        )
        ){

            $request->session()->regenerate();

            if (Auth::user()->roles()->first() == null) {
                Auth::guard('web')->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                session()->flash('no_role', "You don't have permission to access any page");

                return redirect('/login');

            } else if (Auth::user()->hasRole(Role::where('name', RoleName::ADMIN)->first()->id)) {

                session(['role' => Role::where('name', RoleName::ADMIN)->first()->id]);

                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->intended(route('dashboard', absolute: false));
            }
        }else{
            session()->flash('no_role', "Make sure username/email and password are correct");

            return redirect('/login');
        }
        dd(session()->all());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
