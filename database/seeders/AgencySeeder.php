<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;
use App\Models\Organization;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        // Retrieve organizations by name
        $orgDigital = Organization::where('org_name', 'Ministry of Digital')->first();
        $orgJPM = Organization::where('org_name', 'Prime Minister Department')->first();
        $orgMOT = Organization::where('org_name', 'Ministry of Transport')->first();

        // Check that each organization exists before proceeding
        if ($orgDigital) {
            Agency::create([
                'agency_name' => 'National Digital Agency',
                'abbreviation' => 'JDN',
                'description' => 'Focuses on national digital policies.',
                'org_id' => $orgDigital->id,
            ]);
        }

        if ($orgJPM) {
            Agency::create([
                'agency_name' => 'Public Service Department',
                'abbreviation' => 'JPA',
                'description' => 'Manages public service matters.',
                'org_id' => $orgJPM->id,
            ]);

            Agency::create([
                'agency_name' => 'Public Complaints Bureau',
                'abbreviation' => 'BPA',
                'description' => 'Handles public complaints and feedback.',
                'org_id' => $orgJPM->id,
            ]);
        }

        if ($orgMOT) {
            Agency::create([
                'agency_name' => 'Road Transport Department',
                'abbreviation' => 'JPJ',
                'description' => 'Responsible for road transport administration.',
                'org_id' => $orgMOT->id,
            ]);

            Agency::create([
                'agency_name' => 'Marine Department Malaysia',
                'abbreviation' => 'JLM',
                'description' => 'Oversees marine safety and policies.',
                'org_id' => $orgMOT->id,
            ]);
        }
    }
}