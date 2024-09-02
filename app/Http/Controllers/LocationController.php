<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

// Models
use App\Models\Location;

 // Chamando os Form Requests
use App\Http\Requests\Location\{LocationStoreRequest, LocationUpdateRequest};

// Resources
use App\Http\Resources\Location\{IndexResource, ShowResource, StoreResource, UpdateResource};


class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();
        return response()->json(IndexResource::collection($locations), 200);
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

       return response()->json(new StoreResource($location), 200);
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

        if($location === null)
            return response()->json(['erro' => 'Localização pesquisada não existe'], 404);        

        return response()->json(new ShowResource($location), 200);
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

            return response()->json(new UpdateResource($location), 200);
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
