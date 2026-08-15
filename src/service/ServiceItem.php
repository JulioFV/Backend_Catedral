<?php
namespace src\service;

use src\repository\RepoItem;
use src\model\Item;
use Exception;

class ServiceItem
{
    private $repo;
    private $item;

    public function __construct()
    {
        $this->repo = new RepoItem();
    }

    public function createItem(array $data): bool
    {
        if (empty($data['codigo']) || empty($data['nombre'])) {
            throw new Exception('El código y el nombre son obligatorios');
        }

        $item = new Item(
            null,
            $data['codigo'],
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['cantidad'] ?? 0,
            $data['id_material'] ?? 0,
            $data['id_estado'] ?? 0,
            $data['id_lugar'] ?? 0,
            $data['id_uso'] ?? 0,
            $data['cantidad_prestada'] ?? 0,
            $data['activo'] ?? 0,
            $data['observaciones'] ?? null
        );

        return $this->repo->createItem($item);
    }

    public function readItem(): array{
        return $this->repo->readItem();
    }

    public function updateItem(int $id, array $data): bool{
        $item = new Item(
            $id,
            $data['codigo'],
            $data['nombre'],
            $data['descripcion'] ?? null,
            $data['cantidad'] ?? 0,
            $data['id_material'] ?? 0,
            $data['id_estado'] ?? 0,
            $data['id_lugar'] ?? 0,
            $data['id_uso'] ?? 0,
            $data['cantidad_prestada'] ?? 0,
            $data['activo'] ?? 0,
            $data['observaciones'] ?? null
        );

        return $this->repo->updateItem($item);
    }

    public function incrementarCantidadPrestada(int $idItem, int $cantidad): bool{
        $item = $this->repo->getById($idItem);

        if (!$item) {
            throw new Exception('Item no encontrado');
        }

        $disponible = $item['cantidad'] - $item['cantidad_prestada'];

        if ($cantidad <= 0) {
            throw new Exception('La cantidad debe ser mayor a cero');
        }

        if ($cantidad > $disponible) {
            throw new Exception('No hay suficiente cantidad disponible para prestar');
        }

        return $this->repo->incrementarCantidadPrestada($idItem, $cantidad);
    }

    public function disminuirCantidadPrestada(int $idItem, int $cantidad): bool{
        $item = $this->repo->getById($idItem);

        if (!$item) {
            throw new Exception('Item no encontrado');
        }

        if ($cantidad <= 0) {
            throw new Exception('La cantidad debe ser mayor a cero');
        }

        if ($cantidad > $item['cantidad_prestada']) {
            throw new Exception('La cantidad a devolver es mayor que la cantidad prestada');
        }

        return $this->repo->disminuirCantidadPrestada($idItem, $cantidad);
    }

    public function inhabilitarItem(int $id, int $activo): bool{
        return $this->repo->inhabilitarItem($id, $activo);
    }
    public function readItemByLocation($id): array{
        return $this->repo->readItemByLocation($id);
    }
}