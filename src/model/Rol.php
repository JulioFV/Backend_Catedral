<?php
namespace src\model;
class Rol{
    private $id_rol;
    private $nombre;
    private $descripcion;

    public function __construct($id_rol = null, $nombre = null, $descripcion = null) {
        $this->id_rol = $id_rol;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function getIdRol() {
        return $this->id_rol;
    }

    public function setIdRol($id_rol) {
        $this->id_rol = $id_rol;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}