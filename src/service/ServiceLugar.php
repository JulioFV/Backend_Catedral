<?php
namespace src\service;

use src\repository\RepoLugar;
use src\model\Lugar;

class ServiceLugar
{
    private RepoLugar $repoLugar;

    public function __construct(RepoLugar $repoLugar)
    {
        $this->repoLugar = $repoLugar;
    }

    public function createLugar(array $data): bool{
        if (
            empty($data['nombre']) ||
            empty($data['referencia']) ||
            empty($data['responsable'])||
            empty($data['codigo'])
        ) {
            return false;
        }

        $lugar = new Lugar(
            null,
            $data['nombre'],
            $data['referencia'],
            $data['responsable'],
            $data['observaciones'] ?? null,
            $data['codigo']
        );

        return $this->repoLugar->createLugar($lugar);
    }

    public function getAllLugares(): array
    {
        return $this->repoLugar->getAllLugares();
    }
    public function updateLugar(int $id, array $data): bool{
        if (
            empty($data['nombre']) ||
            empty($data['referencia']) ||
            empty($data['responsable']) ||
            empty($data['codigo'])
        ) {
            return false;
        }

        $lugar = new Lugar(
            $id,
            $data['nombre'],
            $data['referencia'],
            $data['responsable'],
            $data['observaciones'] ?? null,
            $data['codigo']
        );

        return $this->repoLugar->updateLugar($lugar);
    }
}