<?php

namespace Database\Factories;

use App\Models\SurveyQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyQuestionFactory extends Factory
{
    protected $model = SurveyQuestion::class;

    public function definition()
    {
        return [
            'question_text' => $this->faker->sentence,
            'question_type' => 'Multiple Choice', // Replace with a valid type according to your database schema
            'options' => json_encode(['Option 1', 'Option 2', 'Option 3']),
            'is_mandatory' => $this->faker->boolean,
        ];
    }
}