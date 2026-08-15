<?php
namespace src\repository;
use src\config\Database;
use src\model\Garantia;
use PDO;

class RepoGarantia{
    private $db;
    public function __construct(Database $db){
        $this->db = $db;
    }

    public function createGarantia(Garantia $garantia){
        $stmt = $this->db->getConnection()->prepare("INSERT INTO garantia (nombre) VALUES (:nombre)");
        $stmt->bindValue(':nombre', $garantia->getNombre(), PDO::PARAM_STR);
        return $stmt->execute();
    }
    public function getAllGarantias(): array{
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM garantia");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}