<?php
namespace src\repository;

use src\config\Database;
use src\model\Preguntas;
use PDO;

class RepoPregunta{
    private $db;

    public function __construct(Database $db){
        $this->db = Database::getConnection();
    }

    public function createRespuesta($respuesta, $id_usuario, $id_pregunta): bool{
        $stmt = $this->db->prepare(
            "INSERT INTO respuestas_seguras_usuario (id_usuario, id_pregunta, respuesta)
             VALUES (:id_usuario, :id_pregunta, :respuesta)"
        );

        return $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':id_pregunta' => $id_pregunta,
            ':respuesta' =>$respuesta
        ]);
    }

    public function leer(): array{
        $stmt = $this->db->prepare("SELECT * FROM preguntas_seguridad");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRespuesta(int $id_usuario,int $id_pregunta): ?string {
        $stmt = $this->db->prepare("
            SELECT respuesta
            FROM respuestas_seguras_usuario
            WHERE id_usuario = :id_usuario
              AND id_pregunta = :id_pregunta
            LIMIT 1
        ");

        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':id_pregunta' => $id_pregunta
        ]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['respuesta'] ?? null;
    }
    public function validarUsuario(int $id_usuario): ?bool{
        $stmt = $this->db->prepare("
            SELECT id_usuario
            FROM respuestas_seguras_usuario
            WHERE id_usuario = :id_usuario
            LIMIT 1
        ");

        $stmt->execute([
            ':id_usuario' => $id_usuario
        ]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado === false) {
            return false;
        }

        return true;
    }
    public function obtenerPreguntaDelUsuario(int $id_usuario): ?array{
        $stmt = $this->db->prepare("SELECT p.id_pregunta, p.descripcion
            FROM preguntas_seguridad p
            INNER JOIN respuestas_seguras_usuario r
                ON p.id_pregunta = r.id_pregunta
            WHERE r.id_usuario = :id_usuario
            LIMIT 1
        ");

        $stmt->execute([
            ':id_usuario' => $id_usuario
        ]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado ?: null;
    }
}