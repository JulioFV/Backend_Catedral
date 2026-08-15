<?php
namespace src\controller;

use src\service\ServiceUso;
use src\model\Uso;
use src\utils\ResponseHelper;

class ControllerUso{
    private $usoService;

    public function __construct(ServiceUso $usoService){
        $this->usoService = $usoService;
    }

    public function getAllUsos(): void{
        $usos = $this->usoService->getAllUsos();
        ResponseHelper::success($usos);
    }

    public function getUsoById(int $id): void{
        $uso = $this->usoService->getUsoById($id);

        if(!$uso){
            ResponseHelper::error("Uso no encontrado", 404);
            return;
        }

        ResponseHelper::success($uso);
    }

    public function createUso(){
        $data = json_decode(file_get_contents('php://input'), true);
        if(empty($data['nombre'])){
            ResponseHelper::error("El nombre es obligatorio", 400);
            return;
        }

        $uso = new Uso(
            null,
            $data['nombre'],
            $data['descripcion'] ?? "",
            $data['estado'] ?? 1
        );

        if($this->usoService->createUso($uso)){
            ResponseHelper::success(
                null,
                "Uso creado correctamente",
                201
            );
        }else{
            ResponseHelper::error("No se pudo crear el uso", 500);
        }
    }

    public function updateUso(int $id): void{
        $data = json_decode(file_get_contents("php://input"),true);
        $existente = $this->usoService->getUsoById($id);

        if(!$existente){
            ResponseHelper::error("Uso no encontrado", 404);
            return;
        }

        $uso = new Uso(
            $id,
            $data['nombre'] ?? $existente['nombre'],
            $data['descripcion'] ?? $existente['descripcion'],
            $data['estado'] ?? $existente['estado']
        );

        if($this->usoService->updateUso($uso)){
            ResponseHelper::success(
                null,
                "Uso actualizado correctamente"
            );
        }else{
            ResponseHelper::error("No se pudo actualizar el uso", 500);
        }
    }

    public function deleteUso(int $id): void{
        $existente = $this->usoService->getUsoById($id);

        if(!$existente){
            ResponseHelper::error("Uso no encontrado", 404);
            return;
        }

        if($this->usoService->deleteUso($id)){
            ResponseHelper::success(
                null,
                "Uso eliminado correctamente"
            );
        }else{
            ResponseHelper::error("No se pudo eliminar el uso", 500);
        }
    }
}