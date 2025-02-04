<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResult extends Model
{
    use HasFactory;

    protected $fillable = ['published_survey_id', 'response_json', 'demographics', 'submitted_at'];

    public function publishedSurvey()
    {
        return $this->belongsTo(PublishedSurvey::class);
    }

    public function details()
    {
        return $this->hasMany(SurveyResultDetail::class);
    }
}