<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Form Request
use App\Http\Requests\DeviceLocation\DeviceLocationStoreRequest;

// Events
use App\Events\{RefreshFirstDeviceLocation, RefreshSecondDeviceLocation};

// Resources
use App\Http\Resources\DeviceLocation\{IndexResource, GetLocationByDeviceResource, StoreResource};

// Models
use App\Models\{DeviceLocation, Device};

class DeviceLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deviceLocations = DeviceLocation::all();
        return response()->json(IndexResource::collection($deviceLocations), 200);
    }
    
    /**
     * Display device locations.
     *
     * @param  \App\Models\DeviceLocation $id
     * @return \Illuminate\Http\Response
     */
    public function getLocationByDevice($id)
    {
        $deviceLocations = DeviceLocation::where('device_id', $id)->orderBy('created_at','desc')->take(5)->get();
        return response()->json(GetLocationByDeviceResource::collection($deviceLocations), 200);
    }    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviceLocationStoreRequest $request)
    {       
        // Pegando o device daquele respectivo ID
        $device = Device::find($request->device_id); 

        $temperature = '';
        $salinity = '';        

        if ($request->device_id == 1)
            $temperature = $request->temperature;

        if ($request->device_id == 2)
            $salinity = $request->salinity;
       
        $deviceLocations = $device->deviceLocations()->create([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'temperature' => $temperature,
            'salinity' => $salinity,
        ]);
        
        return response()->json(new StoreResource($deviceLocations), 200);
    }       
}
