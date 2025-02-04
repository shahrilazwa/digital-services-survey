<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_team_can_have_multiple_users_with_roles()
    {
        $team = Team::factory()->create();
        $user = User::factory()->create();

        $team->users()->attach($user->id, ['role' => 'Author', 'start_date' => now()]);

        $this->assertEquals('Author', $team->users()->first()->pivot->role);
    }
}