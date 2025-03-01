<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // List of default permissions
        $permissions = [
            'create_roles',
            'edit_roles',
            'delete_roles',
            'view_roles',
            'dashboard',
            'statistics',
            'pages',
            'sales',
            'bills',
            'quotes',
            'create-quote',
            'create-backoffice_sale',
            'create-new-bill',
            'products-list',
            'categories-list',
            'attributes-list',
            'stock-sheet',
            'rental-bookings',
            'appointment-bookings',
            'access-control',
            'accounting',
            'ledger',
            'journal',
            'pretty-cash',
            'banking',
            'bookings',
            'users-list',
            'customer-users-list',
            'doctor-users-list',
            'patients-users-list',
            'supplier-users-list',
            'system-users-list',
            'new-permission'
        ];

        // Create permissions if they don't already exist
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // List of default permissions
        $permissions = [
            'create_roles',
            'edit_roles',
            'delete_roles',
            'view_roles',
            'dashboard',
            'statistics',
            'pages',
            'sales',
            'bills',
            'quotes',
            'create-quote',
            'create-backoffice_sale',
            'create-new-bill',
            'products-list',
            'categories-list',
            'attributes-list',
            'stock-sheet',
            'rental-bookings',
            'appointment-bookings',
            'access-control',
            'accounting',
            'ledger',
            'journal',
            'pretty-cash',
            'banking',
            'bookings',
            'users-list',
            'customer-users-list',
            'doctor-users-list',
            'patients-users-list',
            'supplier-users-list',
            'system-users-list',
            'new-permission'
        ];

        // Delete permissions if they exist
        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission) {
                $permission->delete();
            }
        }
    }
};
