<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

// Models
use App\Models\DeviceLocation;

interface DeviceLocationRepositoryInterface
{
    /**
     * Pegar todas as localizações dos equipamentos
     *
     * @return Collection
     */
    public function index(): Collection;

    /**
     * Pegar localizações de um equipamento
     *
     * @param int $deviceId
     * @return Collection
     */
    public function getLocationByDevice(int $deviceId): Collection;

    /**
     * Criar uma nova localização para um equipamento.
     *
     * @param array $data
     * @return DeviceLocation
     */
    public function store(array $data): DeviceLocation;
}
