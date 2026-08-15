<?php
namespace src\service;

use src\repository\RepoRol;
use src\model\Rol;
use Exception;

class ServiceRol{

    private $repo;

    public function __construct(RepoRol $repo){
        $this->repo = $repo;
    }

    public function createRol(Rol $rol){
        if(empty($rol->getNombre())){
            throw new Exception("El nombre del rol es obligatorio");
        }

        return $this->repo->createRol($rol);
    }

    public function getAllRoles(): array{
        return $this->repo->getAllRoles();
    }

    public function getRolById(int $id){
        if($id <= 0){
            throw new Exception("ID de rol inválido");
        }

        return $this->repo->getRolById($id);
    }

    public function updateRol(Rol $rol){
        if($rol->getIdRol() <= 0){
            throw new Exception("ID de rol inválido");
        }

        if(empty($rol->getNombre())){
            throw new Exception("El nombre del rol es obligatorio");
        }

        return $this->repo->updateRol($rol);
    }

    public function deleteRol(int $id){
        if($id <= 0){
            throw new Exception("ID de rol inválido");
        }

        return $this->repo->deleteRol($id);
    }
}