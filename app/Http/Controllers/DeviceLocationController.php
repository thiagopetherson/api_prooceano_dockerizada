<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache; // Importando a classe de Cache (Essa classe nos permite inserir e recuperar dados no Redis)
use App\Models\DeviceLocation;
use App\Models\Device;
use Illuminate\Http\Request;
// Chamando o Form Request (Para validação)
use App\Http\Requests\DeviceLocation\DeviceLocationStoreRequest;
// Importando os eventos
use App\Events\RefreshFirstDeviceLocation;
use App\Events\RefreshSecondDeviceLocation;

class DeviceLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devicesLocations = Cache::remember('devicesLocations', 15, function () {
            return DeviceLocation::all();
        });

        return response()->json($devicesLocations, 200);
    }

    public function getLocationByDevice($id)
    {
        /*
        $deviceLocations = Cache::remember('deviceLocations:' . $id, 180, function () use ($id) {
            return DeviceLocation::where('device_id', $id)->orderBy('created_at','desc')->take(5)->get();
        });
        */

        // O cache acima está funcionando. Mas eu havia aplicado apenas para teste
        $deviceLocations = DeviceLocation::where('device_id', $id)->orderBy('created_at','desc')->take(5)->get();
        return response()->json($deviceLocations, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        return response()->json($deviceLocations, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeviceLocation  $deviceLocation
     * @return \Illuminate\Http\Response
     */
    public function show(DeviceLocation $deviceLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeviceLocation  $deviceLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(DeviceLocation $deviceLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeviceLocation  $deviceLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeviceLocation $deviceLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeviceLocation  $deviceLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeviceLocation $deviceLocation)
    {
        //
    }
}
