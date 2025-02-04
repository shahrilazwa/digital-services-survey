<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySchema extends Model
{
    use HasFactory;

    const STATUS = [
        'Draft' => 'Draft',
        'Available' => 'Available',
        'In-Use' => 'In-Use',
        'Archived' => 'Archived',
    ];
    
    const STEPS = [
        'Schema Details' => 'Schema Details',
        'Schema Design' => 'Schema Design',
        'Schema Team' => 'Schema Team',
        'Schema Preview' => 'Schema Preview',
        'Schema Manage' => 'Schema Manage',
    ];     

    protected $fillable = [
        'team_id', 
        'title', 
        'description', 
        'schema_json',
        'current_step',
        'completed_steps',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'completed_steps' => 'array',
    ];

    // Accessor for checking completed steps
    public function hasCompletedStep($step)
    {
        $completedSteps = $this->completed_steps ?? [];
        return in_array($step, $completedSteps);
    }

    public function getCompletedSteps(): array
    {
        // Ensure `completed_steps` is always an array
        if (is_array($this->completed_steps)) {
            return $this->completed_steps;
        }

        return json_decode($this->completed_steps, true) ?? [];
    }    

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function questions()
    {
        return $this->belongsToMany(SurveyQuestion::class, 'survey_schema_questions', 'schema_id', 'question_id')
                    ->withPivot('question_order')
                    ->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }    
}