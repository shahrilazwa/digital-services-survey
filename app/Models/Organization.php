<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    const TYPES = [
        'Ministry' => 'Ministry',
        'State Government' => 'State Government',
    ];     

    protected $fillable = [
        'org_name',
        'abbreviation',
        'type',
        'description',
    ];
    
    public function agencies()
    {
        return $this->hasMany(Agency::class, 'org_id');
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }      
}
