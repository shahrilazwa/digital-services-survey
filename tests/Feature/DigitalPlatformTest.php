<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Service;
use PHPUnit\Framework\Attributes\Test;
use App\Models\DigitalPlatform;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DigitalPlatformTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_digital_platform_can_offer_multiple_services()
    {
        $platform = DigitalPlatform::factory()->create();
        $service1 = Service::factory()->create();
        $service2 = Service::factory()->create();

        $platform->services()->attach([$service1->id, $service2->id]);

        $this->assertCount(2, $platform->services);
    }
}