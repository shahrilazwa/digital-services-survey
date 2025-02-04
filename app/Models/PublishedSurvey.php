<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishedSurvey extends Model
{
    use HasFactory;

    const STATUS = [
        'Draft' => 'Draft',
        'Closed' => 'Closed',
        'Published' => 'Published',
        'Archived' => 'Archived'
    ];    

    protected $fillable = [
        'survey_link', 
        'title', 
        'description', 
        'schema_id', 
        'execution_team_id', 
        'digital_platform_service_id', 
        'publication_date', 
        'start_date', 
        'end_date', 
        'status'
    ];

    public function schema()
    {
        return $this->belongsTo(SurveySchema::class);
    }

    public function results()
    {
        return $this->hasMany(SurveyResult::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'execution_team_id');
    }

    public function digitalPlatformService()
    {
        return $this->belongsTo(DigitalPlatformService::class, 'digital_platform_service_id');
    }
    
    public function digitalPlatform()
    {
        return $this->hasOneThrough(
            DigitalPlatform::class,
            DigitalPlatformService::class,
            'id', // Foreign key on digital_platform_service table
            'id', // Foreign key on digital_platforms table
            'digital_platform_service_id', // Local key on published_surveys table
            'digital_platform_id' // Local key on digital_platform_service table
        );
    }
    
    public function service()
    {
        return $this->hasOneThrough(
            Service::class,
            DigitalPlatformService::class,
            'id', // Foreign key on digital_platform_service table
            'id', // Foreign key on services table
            'digital_platform_service_id', // Local key on published_surveys table
            'service_id' // Local key on digital_platform_service table
        );
    }       
}