<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

// Form Requests
use App\Http\Requests\DeviceLocation\DeviceLocationStoreRequest;

// Resources
use App\Http\Resources\DeviceLocation\{IndexResource, GetLocationByDeviceResource, StoreResource};

// Exception
use Exception;

// Interfaces
use App\Interfaces\DeviceLocationRepositoryInterface;

class DeviceLocationController extends Controller
{
    protected $deviceLocationRepository;

    public function __construct(DeviceLocationRepositoryInterface $deviceLocationRepository)
    {
        $this->deviceLocationRepository = $deviceLocationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $deviceLocations = $this->deviceLocationRepository->index();
            return response()->json(IndexResource::collection($deviceLocations), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao buscar locais dos dispositivos'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display device locations by device id.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getLocationByDevice($id)
    {
        try {
            $deviceLocations = $this->deviceLocationRepository->getLocationByDevice($id);

            return response()->json(GetLocationByDeviceResource::collection($deviceLocations), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao buscar locais do dispositivo'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeviceLocationStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviceLocationStoreRequest $request)
    {
        try {
            $deviceLocation = $this->deviceLocationRepository->store($request->validated());
            return response()->json(new StoreResource($deviceLocation), Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro ao criar o local do dispositivo'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
