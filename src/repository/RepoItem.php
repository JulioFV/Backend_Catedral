<?php
namespace src\repository;
use src\config\Database;
use src\model\Item;
use PDO;

class RepoItem{
    private $db;
    public function __construct(){
        $this->db = Database::getConnection();
    }

    public function createItem(Item $item): bool {
        $stmt = $this->db->prepare("INSERT INTO item (codigo, nombre, descripcion,
        cantidad, id_material, id_estado, id_lugar, id_uso, cantidad_prestada,activo,observaciones) 
        VALUES (:codigo, :nombre, :descripcion, :cantidad, 
        :id_material, :id_estado, :id_lugar, :id_uso, :cantidad_prestada,:activo, :observaciones)");

        return $stmt->execute([
            ':codigo'            => $item->getCodigo(),
            ':nombre'            => $item->getNombre(),
            ':descripcion'       => $item->getDescripcion(),
            ':cantidad'          => $item->getCantidad(),
            ':id_material'       => (int)$item->getIdMaterial(),
            ':id_estado'         => $item->getIdEstado(),
            ':id_lugar'          => $item->getIdLugar(),
            ':id_uso'            => $item->getIdUso(),
            ':cantidad_prestada' => $item->getCantidadPrestada(),
            ':activo'            =>$item->getActivo(),
            ':observaciones'     =>$item->getObservaciones()
        ]);
    }
    public function readItem(): array{
        $stmt = $this->db->prepare("SELECT
                                    i.id_item,
                                    i.codigo,
                                    i.nombre,
                                    i.descripcion,
                                    i.cantidad,
                                    i.cantidad_prestada,
                                    i.fecha_creacion,
                                    i.activo,
                                    i.observaciones,

                                    m.nombre AS material,
                                    e.nombre AS estado,
                                    l.nombre AS lugar,
                                    l.codigo AS codigo_lugar,
                                    u.nombre AS uso

                                FROM item i

                                LEFT JOIN material m
                                    ON i.id_material = m.id_material

                                LEFT JOIN estado e
                                    ON i.id_estado = e.id_estado

                                LEFT JOIN lugar l
                                    ON i.id_lugar = l.id_lugar

                                LEFT JOIN uso u
                                    ON i.id_uso = u.id_uso;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateItem(Item $item): bool{
        $stmt = $this->db->prepare("UPDATE item SET 
                                        codigo = :codigo,
                                        nombre = :nombre,
                                        descripcion = :descripcion,
                                        cantidad = :cantidad,
                                        id_material = :id_material,
                                        id_estado = :id_estado,
                                        id_lugar = :id_lugar,
                                        id_uso = :id_uso,
                                        cantidad_prestada = :cantidad_prestada,
                                        activo = :activo,
                                        observaciones = :observaciones
                                    WHERE id_item = :id_item");
        
        return $stmt -> execute([
            ':codigo' => $item->getCodigo(),
            ':nombre' => $item->getNombre(),
            ':descripcion' => $item->getDescripcion(),
            ':cantidad' => (int)$item->getCantidad(),
            ':id_material' => (int)$item->getIdMaterial(),
            ':id_estado' => $item->getIdEstado(),
            ':id_lugar' => $item->getIdLugar(),
            ':id_uso' => $item->getIdUso(),
            ':id_item' => $item->getIdItem(),
            ':cantidad_prestada' => $item->getCantidadPrestada(),
            ':activo' => $item->getActivo(),
            'observaciones' => $item->getObservaciones()
        ]);
    }
    public function getById(int $id): ?array{
        $stmt = $this->db->prepare("SELECT id_item, cantidad, cantidad_prestada FROM item WHERE id_item = :id");
        $stmt->execute([':id' => $id]);

        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        return $item ?: null;
    }
    public function incrementarCantidadPrestada(int $idItem, int $cantidad): bool{
        $stmt = $this->db->prepare("UPDATE item 
        SET cantidad_prestada = cantidad_prestada + :cantidad
        WHERE id_item = :id");
        return $stmt->execute([
            ':cantidad' => $cantidad,
            ':id' => $idItem
        ]);
    }
    public function disminuirCantidadPrestada(int $idItem, int $cantidad): bool{
        $stmt = $this->db->prepare("UPDATE item 
        SET cantidad_prestada = cantidad_prestada - :cantidad
        WHERE id_item = :id
        AND cantidad_prestada >= :cantidad");
        return $stmt->execute([':cantidad' => $cantidad,
        ':id' => $idItem]);
    }
    public function inhabilitarItem(int $idItem, int $activo): bool{
        $stmt = $this->db->prepare("UPDATE item SET 
                                        activo = :activo
                                    WHERE id_item = :id_item");
        
        return $stmt -> execute([
            ':activo' => $activo,
            ':id_item' =>$idItem
        ]);
    }

    public function readItemByLocation(int $idLugar): array{
        $stmt = $this->db->prepare(
            "SELECT
                i.id_item,
                i.codigo,
                i.nombre,
                i.descripcion,
                i.cantidad,
                i.cantidad_prestada,
                i.fecha_creacion,
                i.activo,
                i.observaciones,
                m.nombre AS material,
                e.nombre AS estado,
                l.nombre AS lugar,
                l.codigo AS codigo_lugar,
                u.nombre AS uso
            FROM item i
            LEFT JOIN material m
                ON i.id_material = m.id_material
            LEFT JOIN estado e
                ON i.id_estado = e.id_estado
            LEFT JOIN lugar l
                ON i.id_lugar = l.id_lugar
            LEFT JOIN uso u
                ON i.id_uso = u.id_uso
            WHERE i.id_lugar = :idLugar"
        );

        $stmt->execute([
            ':idLugar' => $idLugar
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createItemCSV(array $item): bool {
        $stmt = $this->db->prepare("INSERT INTO item (codigo, nombre, descripcion,
        cantidad, id_material, id_estado, id_lugar, id_uso, activo,observaciones) 
        VALUES (:codigo, :nombre, :descripcion, :cantidad, 
        :id_material, :id_estado, :id_lugar, :id_uso, :activo, :observaciones)");

        return $stmt->execute([
            ':codigo'            => $item['codigo'],
            ':nombre'            => $item['nombre'],
            ':descripcion'       => $item['descripcion'],
            ':cantidad'          => $item['cantidad'],
            ':id_material'       => (int)$item['id_material'],
            ':id_estado'         => $item['id_estado'],
            ':id_lugar'          => $item['id_lugar'],
            ':id_uso'            => $item['id_uso'],
            ':activo'            =>$item['activo'],
            ':observaciones'     =>$item['observaciones']
        ]);
    }
    
}