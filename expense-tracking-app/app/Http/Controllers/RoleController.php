<?php

namespace App\Http\Controllers;

use App\Enum\RoleName;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class   RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $roles =  Role::where('name', '!=', RoleName::ADMIN)->where('name','like','%'.$search.'%')->get();

        return view('role.index', compact('roles', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        Role::create([
            'name' => $request->name
        ]);

        session()->flash('success', 'Role created successfully');

        return redirect()->route('role.index');
    }

    public function assignRole(Role $role, Request $request)
    {
        $search = $request->input('search');
        $users = User::where('id', '!=', Auth::id())->where('name', 'like', '%'.$search.'%')->get();
        return view('role.assignRole', compact('role', 'users', 'search'));
    }

    public function removeRole(Role $role, User $user)
    {

        $role->users()->detach($user);

        session()->flash('success', 'Role removed successfully');

        return back();
    }

    public function addRole(Role $role, User $user)
    {
        $role->users()->attach($user);

        session()->flash('success', 'Role added successfully');

        return back();
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
