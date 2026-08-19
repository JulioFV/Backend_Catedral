<?php
namespace src\controller;

use src\service\ServiceItem;
use src\utils\ResponseHelper;
use Exception;

class ControllerItem
{
    private ServiceItem $service;

    public function __construct(ServiceItem $service)
    {
        $this->service = $service;
    }

    public function createItem(){
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                ResponseHelper::json([
                    'status' => 'error',
                    'message' => 'JSON inválido'
                ], 400);
            }

            $this->service->createItem($data);

            ResponseHelper::json([
                'status' => 'success',
                'message' => 'Item creado correctamente'
            ], 201);

        } catch (Exception $e) {
            ResponseHelper::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function readItem(){
        try {
            $items = $this->service->readItem();

            ResponseHelper::json([
                'status' => 'success',
                'data' => $items
            ]);

        } catch (Exception $e) {
            ResponseHelper::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateItem($id){
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                ResponseHelper::json([
                    'status' => 'error',
                    'message' => 'JSON inválido'
                ], 400);
            }

            if ($this->service->updateItem((int)$id, $data)) {
                ResponseHelper::json(['status' => 'success', 'message' => 'Item actualizado correctamente']);
            } else {
                ResponseHelper::json(['status' => 'error', 'message' => 'No se pudo actualizar el ítem'], 500);
            }

        } catch (Exception $e) {
            ResponseHelper::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function incrementarCantidadPrestada($id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true, 512, JSON_NUMERIC_CHECK);
            $cantidad = (int)($data['cantidad'] ?? 0);

            $this->service->incrementarCantidadPrestada((int)$id, $cantidad);

            ResponseHelper::json([
                'status' => 'success',
                'message' => 'Cantidad prestada actualizada correctamente'
            ]);

        } catch (Exception $e) {
            ResponseHelper::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function disminuirCantidadPrestada($id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $cantidad = (int)($data['cantidad'] ?? 0);

            $this->service->disminuirCantidadPrestada((int)$id, $cantidad);

            ResponseHelper::json([
                'status' => 'success',
                'message' => 'Cantidad prestada disminuida correctamente'
            ]);

        } catch (Exception $e) {
            ResponseHelper::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
    public function inhabilitarItem($id){
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                ResponseHelper::json([
                    'status' => 'error',
                    'message' => 'JSON inválido'
                ], 400);
            }
            $activo = $data['activo'];

            if ($this->service->inhabilitarItem((int)$id, (int)$activo)) {
                ResponseHelper::json(['status' => 'success', 'message' => 'Item inhabilitado correctamente']);
            } else {
                ResponseHelper::json(['status' => 'error', 'message' => 'No se pudo inhabilitar el ítem'], 500);
            }

        } catch (Exception $e) {
            ResponseHelper::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
    public function readItemByLocation($id){
        try {
            $items = $this->service->readItemByLocation($id);

            ResponseHelper::json([
                'status' => 'success',
                'data' => $items
            ]);

        } catch (Exception $e) {
            ResponseHelper::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function insertcsv(): void{
        try{
            if(!isset($_FILES['archivo'])){
                ResponseHelper::error(
                    "No se recibio ningún archivo",
                    400
                );
                return;
            }
            $archivo = $_FILES['archivo'];
            $resultado = $this->service->insertCsv($archivo);

            ResponseHelper::success(
                $resultado,
                "CSV importado correctamente"
            );
        }catch (Exception $e){
            ResponseHelper::error(
                $e->getMessage(),
                500
            );
        }
    }
}