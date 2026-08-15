<?php
namespace src\repository;
use src\config\Database;
use PDO;

class RepoGeneral{
    private $db;
    public function __construct(Database $db){
        $this->db = $db;
    }
    public function obtenerEstadosGenerales(): array{
        $stmt = $this->db->getConnection()->prepare("SELECT
                                                    (SELECT COUNT(*) FROM item WHERE activo = 1) AS tot_items,
                                                    (SELECT COUNT(*) FROM prestamo WHERE estatus = 1) AS tot_prestamos,
                                                    (SELECT COUNT(*) FROM lugar) AS tot_lugares;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}