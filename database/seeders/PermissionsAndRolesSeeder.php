<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Carbon\Carbon;

class PermissionsAndRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Get the Super Admin user
        $superAdmin = User::where('email', 'superadmin@example.com')->first();

        // Define permissions grouped by categories
        $permissions = [
            'Users' => [
                ['name' => 'create users', 'description' => 'Create new users'],
                ['name' => 'view users', 'description' => 'View user details'],
                ['name' => 'update users', 'description' => 'Update user information'],
                ['name' => 'delete users', 'description' => 'Delete users']
            ],
            'Roles' => [
                ['name' => 'create roles', 'description' => 'Create new roles'],
                ['name' => 'view roles', 'description' => 'View role details'],
                ['name' => 'update roles', 'description' => 'Update roles'],
                ['name' => 'delete roles', 'description' => 'Delete roles']
            ],
            'Permissions' => [
                ['name' => 'create permissions', 'description' => 'Create new permissions'],
                ['name' => 'view permissions', 'description' => 'View permissions'],
                ['name' => 'update permissions', 'description' => 'Update permissions'],
                ['name' => 'delete permissions', 'description' => 'Delete permissions']
            ],
            'Survey Schema' => [
                ['name' => 'create survey schema', 'description' => 'Create survey schema'],
                ['name' => 'view survey schema', 'description' => 'View survey schema'],
                ['name' => 'update survey schema', 'description' => 'Update survey schema'],
                ['name' => 'delete survey schema', 'description' => 'Delete survey schema'],
                ['name' => 'approve survey schema', 'description' => 'Approve survey schema for publishing']
            ],
            'Published Surveys' => [
                ['name' => 'publish survey', 'description' => 'Publish surveys'],
                ['name' => 'view published surveys', 'description' => 'View published surveys'],
                ['name' => 'delete published surveys', 'description' => 'Delete published surveys']
            ],
            'Survey Results' => [
                ['name' => 'view survey results', 'description' => 'View survey results'],
                ['name' => 'analyze survey results', 'description' => 'Analyze survey results'],
                ['name' => 'export survey results', 'description' => 'Export survey results to CSV/PDF']
            ]
        ];

        // Create and store permissions in DB
        foreach ($permissions as $group => $groupPermissions) {
            foreach ($groupPermissions as $perm) {
                Permission::firstOrCreate(
                    ['name' => $perm['name'], 'guard_name' => 'web'],
                    [
                        'description' => $perm['description'],
                        'created_by' => $superAdmin->id ?? null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
            }
        }

        // Define roles with their assigned permissions and descriptions
        $roles = [
            'Survey Admin' => [
                'description' => 'Has full control over surveys and user management.',
                'permissions' => ['view users', 'update users', 'delete users', 'view roles', 'view permissions']
            ],
            'Survey Manager' => [
                'description' => 'Manages survey approval and publishing.',
                'permissions' => ['approve survey schema', 'publish survey']
            ],
            'Survey Designer' => [
                'description' => 'Creates and modifies survey schemas.',
                'permissions' => ['create survey schema', 'update survey schema']
            ],
            'Survey Reviewer' => [
                'description' => 'Reviews and approves survey schemas.',
                'permissions' => ['view survey schema', 'approve survey schema']
            ],
            'Survey Operator' => [
                'description' => 'Views surveys and published data.',
                'permissions' => ['view survey schema', 'view published surveys']
            ],
            'Survey Publisher' => [
                'description' => 'Handles survey publication.',
                'permissions' => ['publish survey']
            ],
            'Data Analyst' => [
                'description' => 'Analyzes and exports survey results.',
                'permissions' => ['view survey results', 'analyze survey results', 'export survey results']
            ],
            'Super Admin' => [
                'description' => 'Has full control over all system functionalities.',
                'permissions' => array_merge(...array_values(array_map(fn ($g) => array_column($g, 'name'), $permissions)))
            ]
        ];

        // Assign permissions to roles
        foreach ($roles as $roleName => $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'web'],
                [
                    'description' => $roleData['description'],
                    'created_by' => $superAdmin->id ?? null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );
            $role->syncPermissions($roleData['permissions']);
        }
    }
}