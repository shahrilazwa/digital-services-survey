<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_team_roles')
                    ->withPivot('role', 'start_date', 'end_date')
                    ->withTimestamps();
    }

    public function surveySchemas()
    {
        return $this->hasMany(SurveySchema::class);
    }

    public function publishSurvey()
    {
        return $this->hasMany(PublishedSurvey::class);
    }    
}