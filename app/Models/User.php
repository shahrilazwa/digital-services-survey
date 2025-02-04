<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    const TYPES = [
        'Government' => 'Government',
        'Non-Government' => 'Non-Government',
        'Admin' => 'Admin',
    ];    

    protected $fillable = [
        'name', 
        'email', 
        'personal_email',
        'password',
        'user_type',
        'agency_id', 
        'org_id',  
        'other_details', 
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }
    
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }   

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'user_team_roles')
                    ->withPivot('role', 'start_date', 'end_date')
                    ->withTimestamps();
    }   
}
