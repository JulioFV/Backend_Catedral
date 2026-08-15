<?php

namespace src\controller;

use src\service\ServicePrestamo;
use src\model\Prestamo;
use src\utils\ResponseHelper;
use Exception;

class ControllerPrestamo{
    private ServicePrestamo $servicePrestamo;

    public function __construct(ServicePrestamo $servicePrestamo){
        $this->servicePrestamo = $servicePrestamo;
    }

    /**
     * Registrar un nuevo préstamo
     */
    public function createPrestamo(): void{
        try{
            $data = json_decode(file_get_contents("php://input"),true);
            $prestamo = new Prestamo();

            $prestamo->setIdItem($data['id_item']);
            $prestamo->setIdUsuario($data['id_usuario'] ?? null);
            $prestamo->setNombreSolicitante($data['nombre_solicitante']);
            $prestamo->setTelefonoSolicitante($data['telefono_solicitante'] ?? null);
            $prestamo->setCantidad($data['cantidad']);
            $prestamo->setIdGarantia($data['id_garantia'] ?? null);
            $prestamo->setFechaPrestamo($data['fecha_prestamo'] ?? date('Y-m-d H:i:s'));
            $prestamo->setFechaDevolucion($data['fecha_devolucion'] ?? null);
            $prestamo->setObservaciones($data['observaciones'] ?? null);

            $this->servicePrestamo->registrarPrestamo($prestamo);

            ResponseHelper::json([
                'status' => 'success',
                'message' => 'Prestamo creado correctamente'
            ],201);

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 400);
        }
    }
    /**
     * Registrar devolución de un préstamo
     */
    public function devolverPrestamo(int $idPrestamo): void{
        try{
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                throw new Exception('JSON inválido');
            }

            $this->servicePrestamo->devolverPrestamo($idPrestamo, $data);

            ResponseHelper::success('Préstamo devuelto correctamente');

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 400);
        }
    }
    /**
     * Obtener todos los préstamos
     */
    public function getAllPrestamos(): void{
        try{
            $prestamos = $this->servicePrestamo->obtenerPrestamos();

            ResponseHelper::success($prestamos, 'Préstamos obtenidos correctamente');

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 500);
        }
    }

    /**
     * Obtener un préstamo por ID
     */
    public function getPrestamoById(int $id): void{
        try{
            $prestamo = $this->servicePrestamo->obtenerPrestamoPorId($id);

            if(!$prestamo){
                ResponseHelper::error('Préstamo no encontrado', 404);
                return;
            }

            ResponseHelper::success('Préstamo obtenido correctamente', $prestamo);

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 500);
        }
    }


    /**
     * Eliminar un préstamo
     */
    public function deletePrestamo(int $idPrestamo): void{
        try{
            $this->servicePrestamo->eliminarPrestamo($idPrestamo);

            ResponseHelper::success('Préstamo eliminado correctamente');

        }catch(Exception $e){
            ResponseHelper::error($e->getMessage(), 400);
        }
    }

    public function updatePrestamo(int $id): void{
        $data = json_decode(file_get_contents("php://input"),true);
        $prestamo = new Prestamo(

        );
        $prestamo->setIdPrestamo($id);
        $prestamo->setIdItem($data['id_item']);
            $prestamo->setIdUsuario($data['id_usuario'] ?? null);
            $prestamo->setNombreSolicitante($data['nombre_solicitante']);
            $prestamo->setTelefonoSolicitante($data['telefono_solicitante'] ?? null);
            $prestamo->setEstatus($data['estatus']);
            $prestamo->setCantidad($data['cantidad']);
            $prestamo->setIdGarantia($data['id_garantia'] ?? null);
            $prestamo->setFechaPrestamo($data['fecha_prestamo'] ?? date('Y-m-d H:i:s'));
            $prestamo->setFechaDevolucion($data['fecha_devolucion'] ?? null);
            $prestamo->setObservaciones($data['observaciones'] ?? null);

        if($this->servicePrestamo->actualizarPrestamo($prestamo)){
            ResponseHelper::success(
                null,
                "Prestamo actualizado correctamente"
            );
        }else{
            ResponseHelper::error("No se pudo actualizar el prestamo", 500);
        }
    }
}
