<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

// Models
use App\Models\Location;

 // Chamando os Form Requests
use App\Http\Requests\Location\{LocationStoreRequest, LocationUpdateRequest};

// Resources
use App\Http\Resources\Location\{IndexResource, ShowResource, StoreResource, UpdateResource};

// Exception
use Exception;

// Interfaces
use App\Interfaces\LocationRepositoryInterface;

class LocationController extends Controller
{

    protected $locationRepository;

    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $locations = $this->locationRepository->index();
            return response()->json(IndexResource::collection($locations), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao buscar localizações'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request)
    {
        try {
            $location = $this->locationRepository->store($request->validated());
            return response()->json(new StoreResource($location), Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao criar a localização'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $location = $this->locationRepository->show($id);

            if ($location === null)
                return response()->json(['erro' => 'Localização pesquisada não existe'], Response::HTTP_NOT_FOUND);            

            return response()->json(new ShowResource($location), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao buscar a localização'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        try {
            $location = $this->locationRepository->update($id, $request->validated());

            if ($location)
                return response()->json(new UpdateResource($location), Response::HTTP_OK);            

            return response()->json(['erro' => 'Localidade não existe no banco de dados'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao atualizar a localização'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->locationRepository->destroy($id);

            if ($deleted)
                return response()->json(['Mensagem' => 'A localização foi deletada com sucesso!'], Response::HTTP_NO_CONTENT);            

            return response()->json(['erro' => 'A localização não existe no banco de dados'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao excluir a localização'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
