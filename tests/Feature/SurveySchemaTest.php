<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\SurveySchema;
use App\Models\SurveyQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveySchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_survey_schema_can_have_multiple_questions()
    {
        $schema = SurveySchema::factory()->create();
        $question1 = SurveyQuestion::factory()->create();
        $question2 = SurveyQuestion::factory()->create();

        $schema->questions()->attach($question1->id, ['question_order' => 1]);
        $schema->questions()->attach($question2->id, ['question_order' => 2]);

        $this->assertCount(2, $schema->questions);
        $this->assertEquals(1, $schema->questions()->first()->pivot->question_order);
    }

    public function test_survey_schema_json_is_stored_correctly()
    {
        $schemaData = ['name' => 'Sample Schema', 'questions' => ['Q1', 'Q2']];
        $schema = SurveySchema::factory()->create(['schema_json' => json_encode($schemaData)]);

        $this->assertEquals($schemaData, json_decode($schema->schema_json, true));
    }
}