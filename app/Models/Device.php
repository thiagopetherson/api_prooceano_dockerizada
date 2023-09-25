<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DeviceLocation;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['name','description'];
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Relationship Methods
    
    public function deviceLocations()
    {
        return $this->hasMany(DeviceLocation::class);
    }

}
