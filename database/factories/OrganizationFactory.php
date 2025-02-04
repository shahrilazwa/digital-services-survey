<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition()
    {
        return [
            'org_name' => $this->faker->unique()->company,
            'type' => $this->faker->randomElement(['Ministry', 'State Government']),
            'description' => $this->faker->sentence,
        ];
    }
}