<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'description',
    ];
    
    public function digitalPlatforms()
    {
        // return $this->belongsToMany(DigitalPlatform::class, 'digital_platform_service')->withTimestamps();

        return $this->belongsToMany(DigitalPlatform::class, 'digital_platform_service')
        ->withPivot('id') // Include the `id` from the pivot table
        ->withTimestamps();        
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'service_tag');
    }    
}
