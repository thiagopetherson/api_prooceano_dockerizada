<?php

namespace App\Repositories;

use App\Interfaces\LocationRepositoryInterface;
use App\Models\Location;
use Illuminate\Support\Collection;

class LocationRepository implements LocationRepositoryInterface
{
    public function index(): Collection
    {
        return Location::all();
    }

    public function store(array $data): Location
    {
        return Location::create($data);
    }

    public function show(int $id): ?Location
    {
        return Location::find($id);
    }

    public function update(int $id, array $data): ?Location
    {
        $location = Location::find($id);
        if ($location) {
            $location->update($data);
            return $location;
        }
        return null;
    }

    public function destroy(int $id): bool
    {
        $location = Location::find($id);
        if ($location) {
            return $location->delete();
        }
        return false;
    }
}
