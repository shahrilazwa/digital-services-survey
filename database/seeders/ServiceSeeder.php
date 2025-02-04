<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\DigitalPlatform;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample services
        $service1 = Service::create([
            'service_name' => 'Online Registration',
            'description' => 'Allows users to register online.',
        ]);

        $service2 = Service::create([
            'service_name' => 'Payment Processing',
            'description' => 'Handles online payments and transactions.',
        ]);

        $service3 = Service::create([
            'service_name' => 'Document Submission',
            'description' => 'Allows users to submit documents electronically.',
        ]);

        // Retrieve digital platforms
        $digitalPlatform1 = DigitalPlatform::where('platform_name', 'mySIKAP')->first();
        $digitalPlatform2 = DigitalPlatform::where('platform_name', 'HRMIS')->first();

        // Attach services to digital platforms with descriptions for the pivot table
        if ($digitalPlatform1) {
            $digitalPlatform1->services()->attach([
                $service1->id => ['description' => 'Registration service for mySIKAP users.'],
                $service2->id => ['description' => 'Payment service for mySIKAP users.'],
            ]);
        }

        if ($digitalPlatform2) {
            $digitalPlatform2->services()->attach([
                $service2->id => ['description' => 'Payment service for HRMIS users.'],
                $service3->id => ['description' => 'Document submission for HRMIS users.'],
            ]);
        }
    }
}