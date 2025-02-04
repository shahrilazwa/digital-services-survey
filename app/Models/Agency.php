<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'agency_name',
        'abbreviation',
        'org_id',
        'description',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'agency_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }   
}