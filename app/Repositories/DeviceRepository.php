<?php

namespace App\Repositories;

use App\Interfaces\DeviceRepositoryInterface;
use App\Models\Device;
use Illuminate\Support\Collection;

class DeviceRepository implements DeviceRepositoryInterface
{
    /**
     * Retorna todas os equipamentos
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Device::all();
    }

    /**
     * Cria um equipamento
     *
     * @param array $data
     * @return Device
     */
    public function store(array $data): Device
    {
        return Device::create($data);
    }

    /**
     * Retorna um equipamento com base no id fornecido ou null se não existir
     *
     * @param int $id
     * @return Device|null
     */
    public function show(int $id): ?Device
    {
        return Device::find($id);
    }

    /**
     * Atualiza um equipamento e retorna o equipamento atualizado ou null se ele não existir
     *
     * @param int $id
     * @param array $data
     * @return Device|null
     */
    public function update(int $id, array $data): ?Device
    {
        $device = Device::find($id);
        if ($device) {
            $device->update($data);
            return $device;
        }
        return null;
    }

    /**
     * Remove um equipamento e retorna true ou false se ele não existir
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $device = Device::find($id);
        if ($device) {
            return $device->delete();
        }
        return false;
    }
}
