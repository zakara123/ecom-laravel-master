<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleBasedPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List of permissions to create
        $permissions = [
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
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to the admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            // Assign all permissions to the admin role
            $adminRole->givePermissionTo($permissions);
        }
    }
}
