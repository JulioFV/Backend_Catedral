<?php
namespace src\repository;

use src\config\Database;
use src\model\Rol;
use PDO;

class RepoRol{
    private $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function createRol(Rol $rol){
        $stmt = $this->db->getConnection()->prepare(
            "INSERT INTO rol (nombre, descripcion) VALUES (:nombre, :descripcion)"
        );
        $stmt->bindValue(':nombre', $rol->getNombre(), PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $rol->getDescripcion(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getAllRoles(): array{
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM rol");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRolById(int $id){
        $stmt = $this->db->getConnection()->prepare(
            "SELECT * FROM rol WHERE id_rol = :id"
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRol(Rol $rol){
        $stmt = $this->db->getConnection()->prepare(
            "UPDATE rol 
             SET nombre = :nombre,
                 descripcion = :descripcion
             WHERE id_rol = :id"
        );
        $stmt->bindValue(':id', $rol->getIdRol(), PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $rol->getNombre(), PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $rol->getDescripcion(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteRol(int $id){
        $stmt = $this->db->getConnection()->prepare(
            "DELETE FROM rol WHERE id_rol = :id"
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}