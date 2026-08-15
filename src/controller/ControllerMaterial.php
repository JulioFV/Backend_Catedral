<?php
namespace src\controller;

use src\service\ServiceMaterial;

class ControllerMaterial {
    private ServiceMaterial $serviceMaterial;

    public function __construct(ServiceMaterial $serviceMaterial){
        $this->serviceMaterial = $serviceMaterial;
    }

    public function createMaterial(){
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Datos inválidos'
            ]);
            return;
        }

        $result = $this->serviceMaterial->createMaterial($data);

        if ($result) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Material creado correctamente'
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'No se pudo crear el material'
            ]);
        }
    }

    public function getAllMateriales(){
        header('Content-Type: application/json');

        $materiales = $this->serviceMaterial->getAllMateriales();

        echo json_encode([
            'success' => true,
            'data' => $materiales
        ]);
    }
}