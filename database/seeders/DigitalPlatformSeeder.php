<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DigitalPlatform;
use App\Models\Agency;

class DigitalPlatformSeeder extends Seeder
{
    public function run(): void
    {
        $agencyJPJ = Agency::where('abbreviation', 'JPJ')->first();
        $agencyJPA = Agency::where('abbreviation', 'JPA')->first();

        DigitalPlatform::create([
            'platform_name' => 'mySIKAP',
            'abbreviation' => 'MSKP',
            'url' => 'https://public.jpj.gov.my/',
            'type' => 'Web System',
            'agency_id' => $agencyJPJ->id,
        ]);

        DigitalPlatform::create([
            'platform_name' => 'Human Resource Management Information System',
            'abbreviation' => 'HRMIS',
            'url' => 'https://hrmis2.eghrmis.gov.my/',
            'type' => 'Web System',
            'agency_id' => $agencyJPA->id,
        ]);
    }
}