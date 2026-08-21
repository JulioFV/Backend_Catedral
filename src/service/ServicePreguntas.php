<?php
namespace src\service;

use src\repository\RepoPregunta;
use src\utils\NormalizadorRespuestas;
use src\model\Preguntas;

class ServicePreguntas{
    private $repoPregunta;
    private $normRespuestas;
    private $preguntas;

    public function __construct(RepoPregunta $repoPregunta, NormalizadorRespuestas $normRespuestas, Preguntas $preguntas){
        $this->repoPregunta = $repoPregunta;
        $this->normRespuestas = $normRespuestas;
        $this->preguntas = $preguntas;
    }

    public function leer(): array{
        return $this->repoPregunta->leer();
    }

    public function insertarRespuesta($respuesta, $id_usuario, $id_pregunta): bool{
        $respuestaNormalizada = $this->normRespuestas->normalizarTexto($respuesta);
        return $this->repoPregunta->createRespuesta($respuestaNormalizada, $id_usuario, $id_pregunta);
    }

    public function validar($respuesta, $id_usuario, $id_pregunta): bool {
        $respuestaBD = $this->repoPregunta->getRespuesta($id_usuario, $id_pregunta);
        if($respuestaBD === null){
            return false;
        }
        $respuestaUsuario = $this->normRespuestas->normalizarTexto($respuesta);
        $respuestaAlmacenada = $this->normRespuestas->normalizarTexto($respuestaBD);
        return $respuestaUsuario === $respuestaAlmacenada;
    }
    public function validarUsuario($id_usuario): bool{
        if($this->repoPregunta->validarUsuario($id_usuario)){
            return true;
        }else{
            return false;
        }
    }
    public function obtenerPreguntaDelUsuario($id_usuario): ?array{
        return $this->repoPregunta->obtenerPreguntaDelUsuario($id_usuario);
    }
    
}