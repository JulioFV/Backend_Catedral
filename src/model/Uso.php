<?php
namespace src\model;
class Uso{
    private $id_uso;
    private $nombre;
    private $descripcion;
    private $estado;

    public function __construct($id_uso, $nombre, $descripcion, $estado) {
        $this->id_uso = $id_uso;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
    }

    public function getIdUso() {
        return $this->id_uso;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }
    public function getEstado() {
        return $this->estado;
    }
    
}