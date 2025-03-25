<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class   RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
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
            'name'=>$request->name
        ]);

        session()->flash('success', 'Role created successfully');

        return redirect()->route('role.index');
    }

    public function assignRole(Role $role)
    {
        $users = User::all();
        return view('role.assignRole', compact('role', 'users'));
    }

    public function removeRole(User $user)
    {


        session()->flash('success', 'Role removed successfully');
    }

    public function addRole(Role $role)
    {
        session()->flash('success', 'Role added successfully');
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
