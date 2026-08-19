<?php
namespace src\repository;
use src\config\Database;
use src\model\Material;
use PDO;

class RepoMaterial{
    private $db;
    public function __construct(Database $db){
        $this->db = $db;
    }

    public function createMaterial(Material $material){
        $stmt = $this->db->getConnection()->prepare("INSERT INTO material (nombre) VALUES (:nombre)");
        $stmt->bindValue(':nombre', $material->getNombre(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getAllMateriales(): array{
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM material");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getIdPorNombre($nombre): ?string{
        $stmt = $this->db->getConnection()->prepare("SELECT id_material FROM material WHERE nombre = :nombre");
        $stmt->execute([':nombre' => $nombre]);
        $resultado = $stmt->fetchColumn();
        return $resultado === false ? null : $resultado;    
    }
}