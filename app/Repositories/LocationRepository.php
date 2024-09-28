<?php

namespace App\Repositories;

use App\Interfaces\LocationRepositoryInterface;
use App\Models\Location;
use Illuminate\Support\Collection;

class LocationRepository implements LocationRepositoryInterface
{
    /**
     * Retorna todas as localizações
     *
     * @return Collection 
     */
    public function index(): Collection
    {
        return Location::all();
    }

    /**
     * Cria uma localização
     * 
     * @param array $data
     * @return Location
     */
    public function store(array $data): Location
    {
        return Location::create($data);
    }

    /**
     * Retorna uma localização com base no id fornecido ou null se não existir
     *
     * @param int $id
     * @return Location|null
     */
    public function show(int $id): ?Location
    {
        return Location::find($id);
    }

    /**
     * Atualiza uma localização e retorna a localização atualizada ou null se ela não existir
     *
     * @param int $id
     * @param array $data
     * @return Location|null
     */
    public function update(int $id, array $data): ?Location
    {
        $location = Location::find($id);
        if ($location) {
            $location->update($data);
            return $location;
        }
        return null;
    }

    /**
     * Remove uma localização e retorna true ou false se ela não existir
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $location = Location::find($id);
        if ($location) {
            return $location->delete();
        }
        return false;
    }
}
