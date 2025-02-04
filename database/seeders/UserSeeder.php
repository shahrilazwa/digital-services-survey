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
        $roleAdmin = Role::where('name', 'admin')->first();
        $roleDefault = Role::where('name', 'default')->first();
        $roleSuperAdmin = Role::where('name', 'super-admin')->first();

        $orgDigital = Organization::where('org_name', 'Ministry of Digital')->first();
        $agencyJDN = Agency::where('abbreviation', 'JDN')->first();

        $userAdmin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'agency_id' => $agencyJDN->id,
        ]);
        $userAdmin->assignRole($roleAdmin);

        $userDefault = User::factory()->create([
            'name' => 'Default User',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'org_id' => $orgDigital->id,
        ]);
        $userDefault->assignRole($roleDefault);

        $userSuperAdmin = User::factory()->create([
            'name' => 'Super-Admin User',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'agency_id' => $agencyJDN->id,
        ]);
        $userSuperAdmin->assignRole($roleSuperAdmin);
    }
}