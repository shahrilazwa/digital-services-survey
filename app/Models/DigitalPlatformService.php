<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalPlatformService extends Model
{
    use HasFactory;

    protected $table = 'digital_platform_service';

    protected $fillable = [
        'digital_platform_id',
        'service_id',
        'description',
    ];
    
    public function digitalPlatform()
    {
        return $this->belongsTo(DigitalPlatform::class, 'digital_platform_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }    
}
