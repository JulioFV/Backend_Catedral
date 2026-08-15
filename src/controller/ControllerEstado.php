<?php
namespace src\controller;

use src\service\ServiceEstado;

class ControllerEstado
{
    private ServiceEstado $serviceEstado;

    public function __construct(ServiceEstado $serviceEstado)
    {
        $this->serviceEstado = $serviceEstado;
    }

    /**
     * POST /estado
     */
    public function createEstado()
    {
        $data = json_decode(file_get_contents("php://input"), true) ?? [];

        $this->serviceEstado->createEstado($data);
    }

    /**
     * GET /estado
     */
    public function getAllEstados()
    {
        try {
            $estados = $this->serviceEstado->getAllEstados();

            ResponseHelper::json([
                'status' => 'success',
                'data' => $estados
            ]);

        } catch (Exception $e) {
            ResponseHelper::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}