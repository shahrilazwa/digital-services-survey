<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question_text', 'question_type', 'options', 'is_mandatory'];

    public function schemas()
    {
        return $this->belongsToMany(SurveySchema::class, 'survey_schema_questions', 'question_id', 'schema_id')
                    ->withPivot('question_order')
                    ->withTimestamps();
    }
}