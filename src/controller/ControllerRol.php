<?php
namespace src\controller;

use src\service\ServiceRol;
use src\model\Rol;
use src\utils\ResponseHelper;
use Exception;

class ControllerRol{

    private $service;

    public function __construct(ServiceRol $service){
        $this->service = $service;
    }

    public function createRol(){
        try{
            $data = json_decode(file_get_contents("php://input"), true);

            $rol = new Rol();
            $rol->setNombre($data['nombre'] ?? '');
            $rol->setDescripcion($data['descripcion'] ?? '');

            $this->service->createRol($rol);

            ResponseHelper::success(null, "Rol creado correctamente", 201);

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 400);
        }
    }

    public function getAllRoles(){
        try{
            $roles = $this->service->getAllRoles();
            ResponseHelper::success($roles, "Lista de roles obtenida correctamente");

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function getRolById($id){
        try{
            $rol = $this->service->getRolById((int)$id);

            if(!$rol){
                ResponseHelper::error("Rol no encontrado", 404);
                return;
            }

            ResponseHelper::success($rol, "Rol obtenido correctamente");

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 400);
        }
    }

    public function updateRol($id){
        try{
            $data = json_decode(file_get_contents("php://input"), true);

            $rol = new Rol();
            $rol->setIdRol((int)$id);
            $rol->setNombre($data['nombre'] ?? '');
            $rol->setDescripcion($data['descripcion'] ?? '');

            $this->service->updateRol($rol);

            ResponseHelper::success(null, "Rol actualizado correctamente");

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 400);
        }
    }

    public function deleteRol($id){
        try{
            $this->service->deleteRol((int)$id);
            ResponseHelper::success(null, "Rol eliminado correctamente");

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 400);
        }
    }
}