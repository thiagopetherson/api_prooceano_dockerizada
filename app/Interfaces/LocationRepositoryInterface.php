<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Location;

interface LocationRepositoryInterface
{
    /**
     * Pegar todas as localizações
     *
     * @return Collection
     */
    public function index(): Collection;

    /**
     * Criar localização.
     *
     * @param array $a
     * @return Location
     */
    public function store(array $a): Location;

    /**
     * Pegar uma localização
     *
     * @param int $a
     * @return Location|null
     */
    public function show(int $a): ?Location;

    /**
     * Atualizar localização
     *
     * @param int $a
     * @param array $b
     * @return Location|null
     */
    public function update(int $a, array $b): ?Location;

    /**
     * Deletar localização
     *
     * @param int $a
     * @return bool
     */
    public function destroy(int $a): bool;
}
