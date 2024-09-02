<?php

namespace App\Http\Resources\DeviceLocation;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'device_id' => $this->device_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'temperature' => $this->temperature,
            'salinity' => $this->salinity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
