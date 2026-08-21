<?php
namespace src\model;
class Preguntas{
    private $id_pregunta;
    private $respuesta;
    private $id_usuario;
    private $id_respuesta;

    public function __construct() {}
    
    // Getter y Setter para id_pregunta
    public function getIdPregunta(): int {
        return $this->id_pregunta;
    }

    public function setIdPregunta(int $id_pregunta): void {
        $this->id_pregunta = $id_pregunta;
    }

    // Getter y Setter para respuesta
    public function getRespuesta(): string {
        return $this->respuesta;
    }

    public function setRespuesta(string $respuesta): void {
        $this->respuesta = $respuesta;
    }

    // Getter y Setter para id_usuario
    public function getIdUsuario(): int {
        return $this->id_usuario;
    }

    public function setIdUsuario(int $id_usuario): void {
        $this->id_usuario = $id_usuario;
    }

    // Getter y Setter para id_respuesta
    public function getIdRespuesta(): int {
        return $this->id_respuesta;
    }

    public function setIdRespuesta(int $id_respuesta): void {
        $this->id_respuesta = $id_respuesta;
    }
}