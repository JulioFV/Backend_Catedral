<?php
namespace src\model;
class Material{
    private $id_material;
    private $nombre;


    public function __construct($id_material, $nombre) {
        $this->id_material = $id_material;
        $this->nombre = $nombre;
    }
    public function getIdMaterial() {
        return $this->id_material;
    }
    public function getNombre() {
        return $this->nombre;
    }
}