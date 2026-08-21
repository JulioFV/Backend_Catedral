<?php
namespace src\service;

use Exception;
use src\model\Estado;
use src\repository\RepoEstado;
use src\utils\ResponseHelper;

class ServiceEstado
{
    private RepoEstado $repoEstado;

    public function __construct(RepoEstado $repoEstado)
    {
        $this->repoEstado = $repoEstado;
    }

    public function createEstado(array $data){
        try {
            if (!isset($data['nombre']) || trim($data['nombre']) === '') {
                ResponseHelper::json([
                    'success' => false,
                    'message' => 'El nombre del estado es obligatorio.'
                ], 400);
            }

            $estado = new Estado();
            $estado->setNombre(trim($data['nombre']));

            $created = $this->repoEstado->createEstado($estado);

            if (!$created) {
                ResponseHelper::json([
                    'success' => false,
                    'message' => 'No fue posible registrar el estado.'
                ], 500);
            }

            ResponseHelper::json([
                'success' => true,
                'message' => 'Estado registrado correctamente.'
            ], 201);

        } catch (Exception $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Error interno del servidor.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllEstados(){
        try {
            $estados = $this->repoEstado->getAllEstados();

            ResponseHelper::json([
                'success' => true,
                'data' => $estados
            ]);

        } catch (Exception $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Error al obtener los estados.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}