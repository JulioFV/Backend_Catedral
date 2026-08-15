<?php
namespace src\service;

use src\repository\RepoMaterial;
use src\model\Material;

class ServiceMaterial {
    private RepoMaterial $repoMaterial;

    public function __construct(RepoMaterial $repoMaterial){
        $this->repoMaterial = $repoMaterial;
    }

    public function createMaterial(array $data): bool{
        if (empty($data['nombre'])) {
            return false;
        }

        $material = new Material(
            null,
            $data['nombre'],

        );

        return $this->repoMaterial->createMaterial($material);
    }

    public function getAllMateriales(): array{
        return $this->repoMaterial->getAllMateriales();
    }
}