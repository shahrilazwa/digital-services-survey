<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsAndRolesSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'update users', 'delete users', 'create users', 'view users',
            'update roles', 'delete roles', 'create roles', 'view roles',
            'update permissions', 'delete permissions', 'create permissions', 'view permissions',
            'update agencies', 'delete agencies', 'create agencies', 'view agencies',
            'update organizations', 'delete organizations', 'create organizations', 'view organizations',
            'update digital platforms', 'delete digital platforms', 'create digital platforms', 'view digital platforms',
            'update survey schema', 'delete survey schema', 'create survey schema', 'view survey schema'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo(['view users', 'update users', 'delete users', 'view roles', 'view permissions']);

        $roleDefault = Role::create(['name' => 'default']);
        
        $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        $roleSuperAdmin->givePermissionTo($permissions);
    }
}
