<?php
namespace src\repository;

use src\config\Database;
use src\model\Estado;
use PDO;

class RepoEstado
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createEstado(Estado $estado): bool
    {
        $sql = "INSERT INTO estado (nombre) VALUES (:nombre)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':nombre', $estado->getNombre(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getAllEstados(): array
    {
        $stmt = $this->db->getConnection()->prepare("SELECT id_estado, nombre FROM estado");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getIdPorNombre($nombre): ?string{
        $stmt = $this->db->getConnection()->prepare("SELECT id_estado FROM estado WHERE nombre = :nombre");
        $stmt->execute([':nombre' => $nombre]);
        $resultado = $stmt->fetchColumn();
        return $resultado === false ? null : $resultado;
    }
}