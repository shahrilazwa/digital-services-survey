<?php

namespace Database\Factories;

use App\Models\Agency;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{

    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'personal_email' => $this->faker->unique()->safeEmail,
            'user_type' => $this->faker->randomElement(['Government', 'Non-Government']),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * State for government users with agency assignment.
     */
    public function governmentWithAgency()
    {
        return $this->state(function () {
            return [
                'user_type' => 'Government',
                'agency_id' => Agency::factory(),
                'org_id' => null,
            ];
        });
    }
    
    /**
     * State for government users with organization assignment.
     */
    public function governmentWithOrganization()
    {
        return $this->state(function () {
            return [
                'user_type' => 'Government',
                'org_id' => Organization::factory(),
                'agency_id' => null,
            ];
        });
    }
    
    /**
     * State for non-government users (no agency or organization assignment).
     */
    public function nonGovernment()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => 'Non-Government',
                'agency_id' => null,
                'org_id' => null,
            ];
        });
    }    

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
