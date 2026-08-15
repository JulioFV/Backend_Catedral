<?php
namespace src\repository;

use src\config\Database;
use src\model\Prestamo;
use PDO;

class RepoPrestamo{
    private $db;

    public function __construct(Database $db){
        $this->db = Database::getConnection();
    }

    public function createPrestamo(Prestamo $prestamo): bool{
        $stmt = $this->db->prepare(
            "INSERT INTO prestamo (
                id_item, id_usuario, nombre_solicitante, telefono_solicitante,
                estatus, cantidad, cantidad_devuelta, id_garantia,
                fecha_prestamo, fecha_devolucion, observaciones
            ) VALUES (
                :id_item, :id_usuario, :nombre_solicitante, :telefono_solicitante,
                :estatus, :cantidad, :cantidad_devuelta, :id_garantia,
                :fecha_prestamo, :fecha_devolucion, :observaciones
            )"
        );

        return $stmt->execute([
            ':id_item' => $prestamo->getIdItem(),
            ':id_usuario' => $prestamo->getIdUsuario(),
            ':nombre_solicitante' => $prestamo->getNombreSolicitante(),
            ':telefono_solicitante' => $prestamo->getTelefonoSolicitante(),
            ':estatus' => $prestamo->getEstatus(),
            ':cantidad' => $prestamo->getCantidad(),
            ':cantidad_devuelta' => $prestamo->getCantidadDevuelta(),
            ':id_garantia' => $prestamo->getIdGarantia(),
            ':fecha_prestamo' => $prestamo->getFechaPrestamo(),
            ':fecha_devolucion' => $prestamo->getFechaDevolucion(),
            ':observaciones' => $prestamo->getObservaciones()
        ]);
    }

    public function getById(int $id): ?array{
        $stmt = $this->db->prepare(
            "SELECT * FROM prestamo WHERE id_prestamo = :id"
        );

        $stmt->execute([
            ':id' => $id
        ]);

        $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

        return $prestamo ?: null;
    }

    public function updatePrestamo(Prestamo $prestamo): bool{
        $stmt = $this->db->prepare(
            "UPDATE prestamo SET
                id_item = :id_item,
                id_usuario = :id_usuario,
                nombre_solicitante = :nombre_solicitante,
                telefono_solicitante = :telefono_solicitante,
                estatus = :estatus,
                cantidad = :cantidad,
                id_garantia = :id_garantia,
                fecha_prestamo = :fecha_prestamo,
                fecha_devolucion = :fecha_devolucion,
                observaciones = :observaciones,
                cantidad_devuelta = :cantidad_devuelta
            WHERE id_prestamo = :id_prestamo"
        );

        return $stmt->execute([
            ':id_item' => $prestamo->getIdItem(),
            ':id_usuario' => $prestamo->getIdUsuario(),
            ':nombre_solicitante' => $prestamo->getNombreSolicitante(),
            ':telefono_solicitante' => $prestamo->getTelefonoSolicitante(),
            ':estatus' => $prestamo->getEstatus(),
            ':cantidad' => $prestamo->getCantidad(),
            ':id_garantia' => $prestamo->getIdGarantia(),
            ':fecha_prestamo' => $prestamo->getFechaPrestamo(),
            ':fecha_devolucion' => $prestamo->getFechaDevolucion(),
            ':observaciones' => $prestamo->getObservaciones(),
            'cantidad_devuelta' => $prestamo->getCantidadDevuelta(),
            ':id_prestamo' => $prestamo->getIdPrestamo()
        ]);
    }

    public function getAllPrestamos(): array{
        $stmt = $this->db->prepare("
            SELECT
                p.id_prestamo,
                p.nombre_solicitante,
                p.telefono_solicitante,
                p.estatus,
                p.cantidad,
                p.fecha_prestamo,
                p.fecha_devolucion,
                p.observaciones,

                i.id_item,
                i.codigo AS codigo_item,
                i.nombre AS item,

                g.id_garantia,
                g.nombre AS garantia,

                u.id_usuario,
                CONCAT(u.nombre, ' ', u.app) AS usuario

            FROM prestamo p

            LEFT JOIN item i
                ON p.id_item = i.id_item

            LEFT JOIN garantia g
                ON p.id_garantia = g.id_garantia

            LEFT JOIN usuario u
                ON p.id_usuario = u.id_usuario

            ORDER BY p.fecha_prestamo DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletePrestamo(int $idPrestamo): bool{
        $stmt = $this->db->prepare(
            "DELETE FROM prestamo WHERE id_prestamo = :id"
        );

        return $stmt->execute([
            ':id' => $idPrestamo
        ]);
    }
}
