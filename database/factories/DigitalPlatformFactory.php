<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DigitalPlatform>
 */
class DigitalPlatformFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'platform_name' => $this->faker->unique()->domainName,
            'abbreviation' => strtoupper($this->faker->lexify('???')),
            'type' => $this->faker->randomElement(['Web System', 'Mobile App', 'Portal']),
            'url' => $this->faker->url,
            'description' => $this->faker->sentence,
            'agency_id' => $this->faker->boolean ? Agency::factory() : null,
            'org_id' => $this->faker->boolean ? Organization::factory() : null,
        ];
    }
}
