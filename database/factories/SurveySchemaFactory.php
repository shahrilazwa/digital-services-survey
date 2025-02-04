<?php

namespace Database\Factories;

use App\Models\SurveySchema;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveySchemaFactory extends Factory
{
    protected $model = SurveySchema::class;

    public function definition()
    {
        return [
            'team_id' => \App\Models\Team::factory(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'schema_json' => json_encode(['title' => 'Sample Survey Schema']),
        ];
    }
}