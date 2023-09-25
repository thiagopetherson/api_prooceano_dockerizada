<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
// Chamando os Form Requests (Para validação)
use App\Http\Requests\Device\DeviceStoreRequest; 
use App\Http\Requests\Device\DeviceUpdateRequest;

use Symfony\Component\HttpFoundation\Response;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $device = Device::all();
        return response()->json($device, 200);
    }    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviceStoreRequest $request)
    {
        $device = new Device;
        $device->name = $request->name;
        $device->description = $request->description;        
        $device->save();

       return response()->json($device, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $device = Device::find($id);

        if($device === null) {
            return response()->json(['erro' => 'O dispositivo pesquisado não existe'], 404);
        }

        return response()->json($device, 200);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(DeviceUpdateRequest $request, $id)
    {
        $device = Device::find($id);

        if($device) {
            $device->name = $request->name;
            $device->description = $request->description;            
            $device->save();

            return response()->json($device, 200);
        }

        return response()->json(['erro' => 'O dispositivo não existe'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $device = Device::find($id);

        if($device) {
            $device->delete();
            return response()->json(['Mensagem:' => 'O dispositivo foi deletado com sucesso!'], Response::HTTP_NO_CONTENT);
        }

        return response()->json(['erro' => 'Impossível realizar a exclusão. O dispositivo não existe no banco de dados'], 404);
    }
}
