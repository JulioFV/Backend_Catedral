<?php
namespace src\service;

use src\repository\RepoUso;
use src\model\Uso;

class ServiceUso{
    private $repoUso;

    public function __construct(RepoUso $repoUso){
        $this->repoUso = $repoUso;
    }

    public function getAllUsos(): array{
        return $this->repoUso->getAllUsos();
    }

    public function getUsoById(int $id): ?array{
        return $this->repoUso->getUsoById($id);
    }

    public function createUso(Uso $uso): bool{
        return $this->repoUso->createUso($uso);
    }

    public function updateUso(Uso $uso): bool{
        return $this->repoUso->updateUso($uso);
    }

    public function deleteUso(int $id): bool{
        return $this->repoUso->deleteUso($id);
    }
}