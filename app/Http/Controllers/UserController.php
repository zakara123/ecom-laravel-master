<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereNotIn('role', ['doctor', 'patient'])
            ->latest()
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $roles = Role::all(); // Fetch all roles from the database

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all(); // Fetch all roles from the database

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'login' => 'required',
            'email' => 'email|unique:users',
        ]);


        $customer = User::updateOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'login' => $request->login,
            'role' => $request->role,
            'supplier' => $request->supplier,
            'id_store' => $request->id_store,
            'store' => $request->store,
            'zone' => $request->zone,
            'access_online_store_orders' => $request->access_online_store_orders,
            'sms_received' => $request->sms_received,
            'sms_validate' => $request->sms_validate,
            'restaurant_stats' => $request->restaurant_stats,
            'zone_stats' => $request->zone_stats,
            'device_token' => $request->device_token,
            'alarm_notification' => $request->alarm_notification,
            'email_verified_at' => $request->email_verified_at,
            'password' => Hash::make($request->password),
        ]);

        // Create role if it doesn't exist
        $role = Role::firstOrCreate(['name' => $request->role]);

        // Assign the role to the user
        $customer->assignRole($role);

        return redirect()->route('user.index')->with('message', 'User Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = Role::all(); // Fetch all roles from the database

        return view('users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all(); // Fetch all roles from the database

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'login' => 'required',

        ]);


        $customer = User::find($id);
        if($customer->isDirty('email')) $this->validate($request, ['email' => 'email|unique:users']);
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'login' => $request->login,
            'role' => $request->role,
            'supplier' => $request->supplier,
            'id_store' => $request->id_store,
            'store' => $request->store,
            'zone' => $request->zone,
            'access_online_store_orders' => $request->access_online_store_orders,
            'sms_received' => $request->sms_received,
            'sms_validate' => $request->sms_validate,
            'restaurant_stats' => $request->restaurant_stats,
            'zone_stats' => $request->zone_stats,
            'device_token' => $request->device_token,
            'alarm_notification' => $request->alarm_notification,
            'email_verified_at' => $request->email_verified_at,
            'password' => Hash::make($request->password),
        ]);

        // Create role if it doesn't exist
        $role = Role::firstOrCreate(['name' => $request->role]);

        // Assign the role to the user
        $customer->assignRole($role);

        return redirect()->back()->with('message', 'User Updated Successfully');
        //return redirect()->route('user.index')->with('message', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('message', 'User Deleted Successfully');
    }
}
