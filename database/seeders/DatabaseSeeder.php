<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionsAndRolesSeeder::class,
            OrganizationSeeder::class,
            AgencySeeder::class,
            DigitalPlatformSeeder::class,
            UserSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}