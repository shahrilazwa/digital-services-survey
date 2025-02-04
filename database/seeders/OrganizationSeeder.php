<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        Organization::create([
            'org_name' => 'Ministry of Digital',
            'abbreviation' => 'KD',
            'type' => 'Ministry',
            'description' => 'Handles digital transformation policies and initiatives.',
        ]);

        Organization::create([
            'org_name' => 'Prime Minister Department',
            'abbreviation' => 'JPM',
            'type' => 'Ministry',
            'description' => 'Oversees the operations of the government ministries.',
        ]);

        Organization::create([
            'org_name' => 'Ministry of Transport',
            'abbreviation' => 'MoT',
            'type' => 'Ministry',
            'description' => 'Responsible for transport policies and regulations.',
        ]);

        Organization::create([
            'org_name' => 'Selangor State Government',
            'type' => 'State Government',
            'description' => 'Responsible for Selangor governance, policies and regulations.',
        ]);

        Organization::create([
            'org_name' => 'Kedah State Government',
            'type' => 'State Government',
            'description' => 'Responsible for Kedah governance, policies and regulations.',
        ]);        
    }
}