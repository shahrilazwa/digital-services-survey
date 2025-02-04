<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Team;
use App\Models\User;
use App\Models\Agency;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_government_user_can_belong_to_an_agency()
    {
        $user = User::factory()->governmentWithAgency()->create();

        $this->assertEquals('Government', $user->user_type);
        $this->assertNotNull($user->agency_id);
        $this->assertNull($user->org_id);
        $this->assertInstanceOf(Agency::class, $user->agency);
    }

    public function test_government_user_can_belong_to_an_organization()
    {
        $user = User::factory()->governmentWithOrganization()->create();
    
        $this->assertEquals('Government', $user->user_type);
        $this->assertNotNull($user->org_id);
        $this->assertNull($user->agency_id);
        $this->assertInstanceOf(Organization::class, $user->organization);  // Should return the associated organization
    }

    public function test_user_can_belong_to_multiple_teams()
    {
        $user = User::factory()->create(['user_type' => 'Government']);
        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();

        $user->teams()->attach($team1->id, ['role' => 'Author', 'start_date' => now()]);
        $user->teams()->attach($team2->id, ['role' => 'Co-Author', 'start_date' => now()]);

        $this->assertCount(2, $user->teams);
    }

    public function test_team_can_have_multiple_users()
    {
        $team = Team::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $team->users()->attach($user1->id, ['role' => 'Author', 'start_date' => now()]);
        $team->users()->attach($user2->id, ['role' => 'Co-Author', 'start_date' => now()]);

        $this->assertCount(2, $team->users);
    }

    public function test_it_requires_a_unique_personal_email()
    {
        $user1 = User::factory()->create(['personal_email' => 'unique@example.com']);
        $user2 = User::make(['personal_email' => 'unique@example.com']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $user2->save();
    }

    public function test_user_type_is_required()
    {
        $user = User::make([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'personal_email' => 'john.doe.personal@example.com',
            'user_type' => 'Government',
            'password' => bcrypt('password123')
        ]);

        $this->assertTrue($user->save());
    }
}