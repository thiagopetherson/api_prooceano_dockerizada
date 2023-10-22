<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache; // Importando a classe de Cache (Essa classe nos permite inserir e recuperar dados no Redis)
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
        $locations = null;
        if (Cache::has('locations')) {
            $locations = Cache::get('locations');
        } else {
            $locations = Location::all();
            Cache::put('locations', $locations, 180); // Fica em cache por 3 minutos (180 segundos)
        }

        // A parte acima, poderia ser feita da forma abaixo e teria o mesmo resultado
        /*
        $locations = Cache::remember('locations', 180, function () {
            return Location::all();
        });
        */

        return response()->json($locations, 200);
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
