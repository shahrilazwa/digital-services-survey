<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_tag');
    }    
}
