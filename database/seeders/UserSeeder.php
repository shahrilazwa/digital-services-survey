<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Agency;
use App\Models\Organization;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch available roles
        $roles = [
            'Survey Admin' => 'admin@example.com',
            'Survey Manager' => 'manager@example.com',
            'Survey Designer' => 'designer@example.com',
            'Survey Reviewer' => 'reviewer@example.com',
            'Survey Publisher' => 'publisher@example.com',
            'Survey Operator' => 'operator@example.com',
            'Data Analyst' => 'analyst@example.com',
            'Super Admin' => 'superadmin@example.com',
        ];

        // Get agency and organization data
        $agencyJDN = Agency::where('abbreviation', 'JDN')->first();
        $orgDigital = Organization::where('org_name', 'Ministry of Digital')->first();

        // Loop through roles and create users
        foreach ($roles as $roleName => $email) {
            $role = Role::where('name', $roleName)->first();

            if (!$role) {
                continue; // Skip if role not found
            }

            // Create a user for each role
            $user = User::firstOrCreate([
                'email' => $email
            ], [
                'name' => ucfirst(explode('@', $email)[0]), // Generate user name
                'password' => bcrypt('password'), // Default password
                'personal_email' => 'personal_' . $email, // Set personal email
                'agency_id' => $agencyJDN->id ?? null,
                'org_id' => $orgDigital->id ?? null,
            ]);

            // Assign role to user
            $user->assignRole($role);
        }
    }
}