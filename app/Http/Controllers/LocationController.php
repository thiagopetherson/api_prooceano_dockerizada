<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
 // Chamando os Form Requests (Para validação)
use App\Http\Requests\Location\LocationStoreRequest;
use App\Http\Requests\Location\LocationUpdateRequest;

use Symfony\Component\HttpFoundation\Response;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $location = Location::all();
        return response()->json($location, 200);
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request)
    {
        $location = new Location;
        $location->name = $request->name;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->save();

       return response()->json($location, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::find($id);

        if($location === null) {
            return response()->json(['erro' => 'Localização pesquisada não existe'], 404);
        }

        return response()->json($location, 200);
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocationUpdateRequest $request, $id)
    {
        $location = Location::find($id);

        if($location) {
            $location->name = $request->name;
            $location->latitude = $request->latitude;
            $location->longitude = $request->longitude;
            $location->save();

            return response()->json($location, 200);
        }

        return response()->json(['erro' => 'Localidade não existe'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::find($id);

        if($location) {
            $location->delete();
            return response()->json(['Mensagem:' => 'A localização foi deletada com sucesso!'], Response::HTTP_NO_CONTENT);
        }

        return response()->json(['erro' => 'Impossível realizar a exclusão. A localização não existe no banco de dados'], 404);
    }
}
