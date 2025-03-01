<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissions
{
    // new update
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rolesPermissions = [
            'patient' => ['appointment-bookings', 'bookings', 'rental-bookings'],
            'doctor' => ['appointment-bookings', 'bookings'],
            'customer' => ['bookings', 'rental-bookings']
        ];

        // Ensure all roles and permissions are created at the start
        foreach ($rolesPermissions as $role => $permissions) {
            $roleInstance = Role::firstOrCreate(['name' => $role]);

            foreach ($permissions as $permission) {
                $permissionInstance = Permission::firstOrCreate(['name' => $permission]);
                // Ensure the role has the permission
                if (!$roleInstance->hasPermissionTo($permissionInstance)) {
                    $roleInstance->givePermissionTo($permissionInstance);
                }
            }
        }

        // If the user is authenticated, assign their role and permissions
        if (auth()->check()) {
            $user = auth()->user();
            $userRole = $user->role;

            // Check if the user's role exists in the definition and is not already assigned
            if (isset($rolesPermissions[$userRole]) && !$user->hasRole($userRole)) {
                $user->assignRole($userRole);
            }
        }

        return $next($request);
    }
}
