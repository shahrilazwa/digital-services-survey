<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Agency;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class AgencyTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function an_agency_belongs_to_an_organization()
    {
        $organization = Organization::factory()->create();
        $agency = Agency::factory()->create(['org_id' => $organization->id]);

        $this->assertEquals($organization->id, $agency->organization->id);
    }

    #[Test]
    public function agency_requires_an_org_id()
    {
        $agency = new Agency(['agency_name' => 'Department of Transportation']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $agency->save();
    }

    #[Test]
    public function agency_can_retrieve_its_government_users()
    {
        $agency = Agency::factory()->create();
        $user1 = User::factory()->governmentWithAgency()->create(['agency_id' => $agency->id]);
        $user2 = User::factory()->governmentWithAgency()->create(['agency_id' => $agency->id]);

        $this->assertCount(2, $agency->users);
        $this->assertTrue($agency->users->contains($user1));
        $this->assertTrue($agency->users->contains($user2));
    }
}