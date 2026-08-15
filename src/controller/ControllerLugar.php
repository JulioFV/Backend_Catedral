<?php
namespace src\controller;

use src\service\ServiceLugar;
use src\utils\ResponseHelper;

class ControllerLugar
{
    private ServiceLugar $serviceLugar;

    public function __construct(ServiceLugar $serviceLugar)
    {
        $this->serviceLugar = $serviceLugar;
    }

    public function create(){
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Datos inválidos o JSON mal formado'
            ], 400);
        }

        $result = $this->serviceLugar->createLugar($data);

        if ($result) {
            ResponseHelper::json([
                'success' => true,
                'message' => 'Lugar creado correctamente'
            ], 201);
        }

        ResponseHelper::json([
            'success' => false,
            'message' => 'No se pudo crear el lugar'
        ], 400);
    }

    public function getAll(){
        $lugares = $this->serviceLugar->getAllLugares();

        ResponseHelper::json([
            'success' => true,
            'data' => $lugares
        ]);
    }
    public function update($id){
        // Obtener cuerpo JSON (datos a actualizar)
        $data = json_decode(file_get_contents('php://input'), true) ?? [];

        // Verificar que el ID venga por la URL
        if (empty($id)) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'ID no proporcionado en la URL'
            ], 400);
        }

        // Sobrescribir/asegurar el ID en los datos con el provisto en la URL
        $data['id'] = $id;

        $result = $this->serviceLugar->updateLugar($id, $data);

        if ($result) {
            ResponseHelper::json([
                'success' => true,
                'message' => 'Lugar actualizado correctamente'
            ], 200);
        }

        ResponseHelper::json([
            'success' => false,
            'message' => 'No se pudo actualizar el lugar'
        ], 400);
    }

}