<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;
return new class extends Migration
{
    /**
     * List of default permissions.
     *
     * @var array
     */
    private $permissions = [
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

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create permissions if they don't exist
        foreach ($this->permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Assign permissions to the 'admin' role
        $adminRole = Role::findByName('admin');
        if ($adminRole) {
            $adminRole->givePermissionTo($this->permissions);
        }


        
        $user = User::where('email','admin@mail.mail')->first(); // Unique constraint to avoid duplicates
      
        if ($user) {
            $role = Role::firstOrCreate(['name' => 'admin']);
            $user->assignRole($role);
        } else {
            // Optionally, handle the case where the user doesn't exist.
            // Example: Log an error or create the user
            Log::error('User with email admin@mail.mail not found.');
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revoke permissions from the 'admin' role
        $adminRole = Role::findByName('admin');
        if ($adminRole) {
            $adminRole->revokePermissionTo($this->permissions);
        }

        // Delete permissions
        foreach ($this->permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission) {
                $permission->delete();
            }
        }
    }
};
