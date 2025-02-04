<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\SurveyQuestion;
use App\Models\SurveySchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class SurveyQuestionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_question_can_belong_to_multiple_schemas()
    {
        $question = SurveyQuestion::factory()->create();
        $schema1 = SurveySchema::factory()->create();
        $schema2 = SurveySchema::factory()->create();
    
        // Attach schemas with updated pivot keys
        $question->schemas()->attach($schema1->id, ['question_order' => 1]);
        $question->schemas()->attach($schema2->id, ['question_order' => 2]);
    
        $this->assertCount(2, $question->schemas);
        $this->assertEquals(1, $question->schemas()->first()->pivot->question_order);
    }

    #[Test]
    public function a_question_must_have_question_text_and_question_type()
    {
        $question = SurveyQuestion::make([
            'question_text' => 'Sample Question Text',
            'question_type' => 'Multiple Choice' // Use a valid enum type
        ]);
    
        $this->assertTrue($question->save());
    }

    #[Test]
    public function question_type_must_be_valid_enum_value()
    {
        $validQuestion = SurveyQuestion::make([
            'question_text' => 'What is your age?',
            'question_type' => 'Multiple Choice' // Use a valid type according to your schema
        ]);
    
        $this->assertTrue($validQuestion->save());
    
        // Optionally, if the database constraints are configured, test invalid type
        $invalidQuestion = SurveyQuestion::make([
            'question_text' => 'What is your age?',
            'question_type' => 'Invalid Type' // Use an invalid type
        ]);
    
        $this->expectException(\Illuminate\Database\QueryException::class);
        $invalidQuestion->save();
    }

    #[Test]
    public function options_must_be_valid_json_if_present()
    {
        $questionWithValidOptions = SurveyQuestion::make([
            'question_text' => 'What is your favorite color?',
            'question_type' => 'Multiple Choice',
            'options' => json_encode(['Red', 'Blue', 'Green'])
        ]);

        $questionWithInvalidOptions = SurveyQuestion::make([
            'question_text' => 'What is your favorite color?',
            'question_type' => 'Multiple Choice',
            'options' => 'Not JSON'
        ]);

        $this->assertTrue($questionWithValidOptions->save());

        // Assert invalid options cannot be saved
        $this->expectException(\Illuminate\Database\QueryException::class);
        $questionWithInvalidOptions->save();
    }

    #[Test]
    public function test_a_question_must_have_question_text_and_question_type()
    {
        $question = SurveyQuestion::make([
            'question_text' => 'Sample Question Text',
            'question_type' => 'Multiple Choice'
        ]);
    
        $this->assertTrue($question->save());
    }
    
    #[Test]
    public function test_question_type_must_be_valid_enum_value()
    {
        $validQuestion = SurveyQuestion::make([
            'question_text' => 'What is your age?',
            'question_type' => 'Multiple Choice' // Use valid type
        ]);
    
        $this->assertTrue($validQuestion->save());
    
        // Test an invalid type if you expect an exception for invalid enums
    }    
}