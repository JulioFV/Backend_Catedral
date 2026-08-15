<?php
namespace src\model;
class Garantia{
    private $id_garantia;
    private $nombre;

    public function __construct($id_garantia, $nombre) {
        $this->id_garantia = $id_garantia;
        $this->nombre = $nombre;
    }

    public function getIdGarantia() {
        return $this->id_garantia;
    }

    public function getNombre() {
        return $this->nombre;
    }
}