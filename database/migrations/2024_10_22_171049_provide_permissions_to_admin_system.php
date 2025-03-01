<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            // Permissions to be assigned
            $permissions = [
                'create_roles', 'edit_roles', 'delete_roles', 'view_roles', 'dashboard',
                'statistics', 'pages', 'sales', 'bills', 'quotes', 'create-quote',
                'create-backoffice_sale', 'create-new-bill', 'products-list',
                'categories-list', 'attributes-list', 'stock-sheet', 'rental-bookings',
                'appointment-bookings', 'access-control', 'accounting', 'ledger', 'journal',
                'pretty-cash', 'banking', 'bookings', 'users-list', 'customer-users-list',
                'doctor-users-list', 'patients-users-list', 'supplier-users-list',
                'system-users-list', 'new-permission',
            ];

            // Create missing permissions and assign them to the admin role
            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $adminRole->givePermissionTo($permission);
            }
        } else {
            // Log or handle the absence of the admin role
            info("Admin role not found. Skipping permission assignment.");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $permissions = Permission::whereIn('name', [
                'create_roles', 'edit_roles', 'delete_roles', 'view_roles', 'dashboard',
                'statistics', 'pages', 'sales', 'bills', 'quotes', 'create-quote',
                'create-backoffice_sale', 'create-new-bill', 'products-list',
                'categories-list', 'attributes-list', 'stock-sheet', 'rental-bookings',
                'appointment-bookings', 'access-control', 'accounting', 'ledger', 'journal',
                'pretty-cash', 'banking', 'bookings', 'users-list', 'customer-users-list',
                'doctor-users-list', 'patients-users-list', 'supplier-users-list',
                'system-users-list', 'new-permission',
            ])->get();

            // Revoke permissions from the admin role
            $adminRole->revokePermissionTo($permissions->pluck('name')->toArray());
        }
    }
};
