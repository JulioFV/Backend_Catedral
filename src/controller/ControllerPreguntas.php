<?php
namespace src\controller;

use src\service\ServicePreguntas;
//use src\model\Pregunta;
use src\utils\ResponseHelper;

class ControllerPreguntas{
    private $preguntaService;

    public function __construct(ServicePreguntas $preguntaService){
        $this->preguntaService = $preguntaService;
    }

    public function leer(): void{
        $preguntas = $this->preguntaService->leer();
        ResponseHelper::success($preguntas);
    }

    public function insertarRespuesta(){
        $data = json_decode(file_get_contents('php://input'), true);
        if(empty($data['id_usuario'])){
            ResponseHelper::error("El ID del usuario es obligatorio", 400);
            return;
        }
        if(empty($data['id_pregunta'])){
            ResponseHelper::error("El ID de la pregunta es obligatorio", 400);
            return;
        }
        if(empty($data['respuesta'])){
            ResponseHelper::error("El la respuesta de la pregunta es obligatoria", 400);
            return;
        }

        $respuesta = $data['respuesta'];
        $id_usuario = $data['id_usuario'];
        $id_pregunta = $data['id_pregunta'];
        

        if($this->preguntaService->insertarRespuesta($respuesta, $id_usuario, $id_pregunta)){
            ResponseHelper::success(
                null,
                "Respuesta registrada correctamente",
                201
            );
        }else{
            ResponseHelper::error("No se pudo registrar la respuesta", 500);
        }
    }

    public function validar(): void{
        try {
            $data = json_decode(file_get_contents("php://input"),true);

            $respuesta = $data['respuesta'];
            $id_usuario = $data['id_usuario'];
            $id_pregunta = $data['id_pregunta'];

            if($this->preguntaService->validar($respuesta, $id_usuario, $id_pregunta)){
                ResponseHelper::success(
                    true,
                    "La respuesta es correcta"
                );
            }else{
                ResponseHelper::error("La respuesta no es correcta", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::error($e->getMessage(), 500);
        }
        
    }
    
    public function validarUsuario($id_usuario): void{
        try{
            if($this->preguntaService->validarUsuario((int)$id_usuario)){
                ResponseHelper::success(
                    true,
                    "El usuario ya tiene una respuesta registrada"
                );
            }else{
                ResponseHelper::success(false , "El usuario no tiene una respuesta registrada");
            }
        }catch (Exception $e){
            ResponseHelper::error($e->getMessage(), 500);
        }
    }
    public function obtenerPreguntaDelUsuario($id_usuario): void{
        try{
            $pregunta = $this->preguntaService->obtenerPreguntaDelUsuario((int) $id_usuario);
            if($pregunta != null){
                ResponseHelper::success(
                    $pregunta,
                    "Pregunta registrada"
                );
            }else{
                ResponseHelper::success(false , "El usuario no tiene una pregunta de seguridad");
            }
        }catch (Exception $e){
            ResponseHelper::error($e->getMessage(), 500);
        }
    }
}