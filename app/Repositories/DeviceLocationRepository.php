<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

// Models
use App\Models\{Device, DeviceLocation};

// Interfaces
use App\Interfaces\DeviceLocationRepositoryInterface;

class DeviceLocationRepository implements DeviceLocationRepositoryInterface
{
    /**
     * Retorna todos os locais dos dispositivos.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return DeviceLocation::all();
    }

    /**
     * Retorna locais de um dispositivo específico.
     *
     * @param int $deviceId
     * @return Collection
     */
    public function getLocationByDevice(int $deviceId): Collection
    {
        return DeviceLocation::where('device_id', $deviceId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Cria um novo local para um dispositivo.
     *
     * @param array $data
     * @return DeviceLocation
     * @throws \Exception
     */
    public function store(array $data): DeviceLocation
    {
        $device = Device::find($data['device_id']);

        if (!$device) {
            throw new \Exception('Device not found');
        }

        return $device->deviceLocations()->create([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'temperature' => $data['device_id'] == 1 ? $data['temperature'] : null,
            'salinity' => $data['device_id'] == 2 ? $data['salinity'] : null,
        ]);
    }
}
