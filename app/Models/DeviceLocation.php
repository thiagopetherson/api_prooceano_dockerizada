<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class DeviceLocation extends Model
{
    use HasFactory;

    protected $fillable = ['device_id','latitude','longitude','temperature','salinity'];

    // Relationship Methods

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
