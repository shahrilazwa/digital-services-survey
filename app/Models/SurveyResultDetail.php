<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResultDetail extends Model
{
    use HasFactory;

    protected $fillable = ['survey_result_id', 'question_id', 'response_value'];

    public function surveyResult()
    {
        return $this->belongsTo(SurveyResult::class);
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class);
    }
}