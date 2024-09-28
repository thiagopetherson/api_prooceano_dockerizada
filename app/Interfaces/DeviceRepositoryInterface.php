<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Device;

interface DeviceRepositoryInterface
{
    /**
     * Pegar todos os equipamentos
     *
     * @return Collection
     */
    public function index(): Collection;

    /**
     * Criar equipamento.
     *
     * @param array $a
     * @return Device
     */
    public function store(array $a): Device;

    /**
     * Pegar um equipamento
     *
     * @param int $a
     * @return Device|null
     */
    public function show(int $a): ?Device;

    /**
     * Atualizar equipamento
     *
     * @param int $a
     * @param array $b
     * @return Device|null
     */
    public function update(int $a, array $b): ?Device;

    /**
     * Deletar equipamento
     *
     * @param int $a
     * @return bool
     */
    public function destroy(int $a): bool;
}
