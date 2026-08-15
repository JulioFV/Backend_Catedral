<?php
namespace src\repository;

use src\config\Database;
use src\model\Uso;
use PDO;

class RepoUso{
    private $db;

    public function __construct(Database $db){
        $this->db = Database::getConnection();
    }

    public function createUso(Uso $uso): bool{
        $stmt = $this->db->prepare(
            "INSERT INTO uso (nombre, descripcion, estado)
             VALUES (:nombre, :descripcion, :estado)"
        );

        return $stmt->execute([
            ':nombre' => $uso->getNombre(),
            ':descripcion' => $uso->getDescripcion(),
            ':estado' =>$uso->getEstado()
        ]);
    }

    public function updateUso(Uso $uso): bool{
        $stmt = $this->db->prepare(
            "UPDATE uso
             SET nombre = :nombre,
                 descripcion = :descripcion,
                 estado = :estado
             WHERE id_uso = :id_uso"
        );

        return $stmt->execute([
            ':id_uso' => $uso->getIdUso(),
            ':nombre' => $uso->getNombre(),
            ':descripcion' => $uso->getDescripcion(),
            ':estado' => $uso->getEstado()
        ]);
    }

    public function deleteUso(int $id): bool{
        $stmt = $this->db->prepare("DELETE FROM uso WHERE id_uso = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getUsoById(int $id): ?array{
        $stmt = $this->db->prepare("SELECT * FROM uso WHERE id_uso = :id");
        $stmt->execute([':id' => $id]);

        $uso = $stmt->fetch(PDO::FETCH_ASSOC);
        return $uso ?: null;
    }

    public function getAllUsos(): array{
        $stmt = $this->db->prepare("SELECT * FROM uso");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}