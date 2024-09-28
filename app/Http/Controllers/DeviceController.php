<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

// Form Requests
use App\Http\Requests\Device\{DeviceStoreRequest, DeviceUpdateRequest};

// Resources
use App\Http\Resources\Device\{IndexResource, ShowResource, StoreResource, UpdateResource};

// Exception
use Exception;

// Interfaces
use App\Interfaces\DeviceRepositoryInterface;

class DeviceController extends Controller
{
    protected $deviceRepository;

    public function __construct(DeviceRepositoryInterface $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $devices = $this->deviceRepository->index();
            return response()->json(IndexResource::collection($devices), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao buscar dispositivos'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeviceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviceStoreRequest $request)
    {
        try {
            $device = $this->deviceRepository->store($request->validated());
            return response()->json(new StoreResource($device), Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao criar o dispositivo'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $device = $this->deviceRepository->show($id);

            if ($device === null)
                return response()->json(['erro' => 'O dispositivo pesquisado não existe'], Response::HTTP_NOT_FOUND);

            return response()->json(new ShowResource($device), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao buscar o dispositivo'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DeviceUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeviceUpdateRequest $request, $id)
    {
        try {
            $device = $this->deviceRepository->update($id, $request->validated());

            if ($device)
                return response()->json(new UpdateResource($device), Response::HTTP_OK);

            return response()->json(['erro' => 'O dispositivo não existe no banco de dados'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao atualizar o dispositivo'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->deviceRepository->destroy($id);

            if ($deleted)
                return response()->json(['Mensagem' => 'O dispositivo foi deletado com sucesso!'], Response::HTTP_NO_CONTENT);

            return response()->json(['erro' => 'O dispositivo não existe no banco de dados'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao excluir o dispositivo'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
