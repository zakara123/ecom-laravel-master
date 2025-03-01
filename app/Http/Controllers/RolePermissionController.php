<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->pluck('id')->toArray();

        return view('access-control.roles-permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    public function store(Request $request, Role $role)
    {
        // Fetch permissions by IDs from the request
        $permissions = Permission::whereIn('id', $request->permissions)->get();

        // Assign permissions to the role
        $role->syncPermissions($permissions);
        return redirect()->route('roles.permissions.index', $role)->with('success', 'Permissions assigned successfully.');
    }

    public function destroy(Role $role, Permission $permission)
    {
        $role->revokePermissionTo($permission);
        return redirect()->route('roles.permissions.index', $role)->with('success', 'Permission revoked successfully.');
    }
}
