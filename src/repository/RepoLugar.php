<?php
namespace src\repository;
use src\model\Lugar;
use src\config\Database;
use PDO;

class RepoLugar{
    private $db;
    public function __construct(Database $db){
        $this->db = Database::getConnection();

    }

    public function createLugar(Lugar $lugar){
        $stmt = $this->db->prepare("INSERT INTO lugar (nombre, referencia, responsable, observaciones, codigo)
        VALUES (:nombre, :referencia, :responsable, :observaciones, :codigo)");
        return $stmt->execute([
            ':nombre' => $lugar->getNombre(),
            ':referencia' => $lugar->getReferencia(),
            ':responsable' => $lugar->getResponsable(),
            ':observaciones' => $lugar->getObservaciones(),
            'codigo' => $lugar->getCodigo()
        ]);
    }

    public function getAllLugares(): array{
        $stmt = $this->db->prepare("SELECT * FROM lugar");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateLugar(Lugar $lugar){
        $stmt = $this->db->prepare("UPDATE lugar SET nombre = :nombre, referencia = :referencia,
            responsable = :responsable, observaciones = :observaciones, codigo = :codigo
            WHERE id_lugar = :id");

        return $stmt->execute([
            ':nombre' => $lugar->getNombre(),
            ':referencia' => $lugar->getReferencia(),
            ':responsable' => $lugar->getResponsable(),
            ':observaciones' => $lugar->getObservaciones(),
            ':codigo' => $lugar->getCodigo(),
            ':id' => $lugar->getIdLugar()
        ]);
    }
}