<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agency>
 */
class AgencyFactory extends Factory
{
    protected $model = Agency::class;

    public function definition()
    {
        return [
            'agency_name' => $this->faker->unique()->company,
            'org_id' => Organization::factory(), // Links to a new organization
            'description' => $this->faker->sentence,
        ];
    }
}