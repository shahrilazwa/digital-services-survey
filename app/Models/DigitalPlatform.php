<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalPlatform extends Model
{
    use HasFactory;

    const TYPES = [
        'Web System' => 'Web System',
        'Mobile App' => 'Mobile App',
        'Portal' => 'Portal',
    ];

    const EA_CLUSTERS = [
        'Infrastructure' => 'Infrastructure',
        'Administration' => 'Administration',
        'Economy' => 'Economy',
        'Security' => 'Security',
        'Social' => 'Social',
    ];     

    protected $fillable = [
        'platform_name',
        'abbreviation',
        'type',
        'ea_cluster',
        'url',
        'description',
        'agency_id',
        'org_id',
    ];
    
    /**
     * Get the agency that owns the digital platform.
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
    
    /**
     * Get the organization that owns the digital platform.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    } 
    
    /**
     * The services offered by this digital platform.
     */
    public function services()
    {
        // return $this->belongsToMany(Service::class, 'digital_platform_service')->withTimestamps();
        return $this->belongsToMany(Service::class, 'digital_platform_service')
        ->withPivot('id') // Include the `id` from the pivot table
        ->withTimestamps();        
    }    
}
