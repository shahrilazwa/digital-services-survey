<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Service;
use PHPUnit\Framework\Attributes\Test;
use App\Models\DigitalPlatform;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_service_can_be_assigned_to_multiple_digital_platforms()
    {
        $service = Service::factory()->create();
        $platform1 = DigitalPlatform::factory()->create();
        $platform2 = DigitalPlatform::factory()->create();

        $service->digitalPlatforms()->attach([$platform1->id, $platform2->id]);

        $this->assertCount(2, $service->digitalPlatforms);
    }
}