<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_organization_can_have_multiple_agencies()
    {
        $organization = Organization::factory()->create();
        $agency1 = \App\Models\Agency::factory()->create(['org_id' => $organization->id]);
        $agency2 = \App\Models\Agency::factory()->create(['org_id' => $organization->id]);

        $this->assertCount(2, $organization->agencies);
    }
}