<?php
namespace src\service;

use src\repository\RepoItem;
use src\repository\RepoLugar;
use src\repository\RepoMaterial;
use src\repository\RepoEstado;
use src\repository\RepoUso;
use src\model\Item;
use src\config\Database;
use Exception;

class ServiceItem
{
    private $repo;
    private $item;
    private $repoLugar;
    private $repoMaterial;
    private $repoEstado;
    private $repoUso;

    public function __construct(RepoItem $repo, RepoLugar $repoLugar, RepoMaterial $repoMaterial, RepoEstado $repoEstado, RepoUso $repoUso)
    {
        $this->repo =  $repo;
        $this->repoLugar =  $repoLugar;
        $this->repoMaterial = $repoMaterial;
        $this->repoEstado = $repoEstado;
        $this->repoUso = $repoUso;
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
    public function insertCsv(array $archivo): array{
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir el archivo");
        }

        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if ($extension !== 'csv') {
            throw new Exception("El archivo debe ser CSV");
        }

        $handle = fopen($archivo['tmp_name'], 'r');
        if ($handle === false) {
            throw new Exception("No se pudo abrir el archivo");
        }

        $insertados = 0;
        $errores = [];
        $numeroFila = 1; // fila 1 = encabezado

        fgetcsv($handle); // descartamos encabezado

        while (($fila = fgetcsv($handle)) !== false) {
            $numeroFila++;

            try {
                if (count($fila) < 10) {
                    throw new Exception("La fila no tiene todas las columnas esperadas");
                }

                $datos = [
                    'codigo'        => trim($fila[0]),
                    'nombre'        => trim($fila[1]),
                    'descripcion'   => trim($fila[2]),
                    'cantidad'      => $fila[3],
                    'material'      => trim($fila[4]),
                    'estado'        => trim($fila[5]),
                    'lugar'         => trim($fila[6]),
                    'uso'           => trim($fila[7]),
                    'activo'        => $fila[8],
                    'observaciones' => $fila[9],
                ];

                if (empty($datos['codigo'])) {
                    throw new Exception("El código es obligatorio");
                }
                if (empty($datos['nombre'])) {
                    throw new Exception("El nombre es obligatorio");
                }
                if (empty($datos['lugar'])) {
                    throw new Exception("El lugar es obligatorio");
                }

                // Lugar: nombre -> id -> código
                $idLugar = $this->repoLugar->getIdPorNombre($datos['lugar']);
                if ($idLugar === null) {
                    throw new Exception("El lugar '{$datos['lugar']}' no existe");
                }
                $codigoLugar = $this->repoLugar->getCodigoLugar($idLugar);
                if ($codigoLugar === null) {
                    throw new Exception("No se encontró el código para el lugar '{$datos['lugar']}'");
                }

                $idMaterial = $this->repoMaterial->getIdPorNombre($datos['material']);
                if ($idMaterial === null) {
                    throw new Exception("El material '{$datos['material']}' no existe");
                }

                $idEstado = $this->repoEstado->getIdPorNombre($datos['estado']);
                if ($idEstado === null) {
                    throw new Exception("El estado '{$datos['estado']}' no existe");
                }

                $idUso = $this->repoUso->getIdPorNombre($datos['uso']);
                if ($idUso === null) {
                    throw new Exception("El uso '{$datos['uso']}' no existe");
                }

                $codigoFinal = $codigoLugar . $datos['codigo'];
                $item = [
                    'codigo'        => $codigoFinal,
                    'nombre'        => $datos['nombre'],
                    'descripcion'   => $datos['descripcion'],
                    'cantidad'      => $datos['cantidad'],
                    'id_material'   => $idMaterial,
                    'id_estado'     => $idEstado,
                    'id_lugar'      => $idLugar,
                    'id_uso'        => $idUso,
                    'activo'        => $datos['activo'],
                    'observaciones' => $datos['observaciones'],
                ];

                Database::beginTransaction();
                try {
                    $this->repo->createItemCSV($item);
                    Database::commit();
                } catch (\Throwable $e) {
                    Database::rollBack();
                    throw $e;
                }

                $insertados++;
            } catch (Exception $e) {
                $errores[] = [
                    'fila'  => $numeroFila,
                    'error' => $e->getMessage(),
                ];
            }
        }

        fclose($handle);

        return [
            'insertados' => $insertados,
            'errores'    => $errores,
        ];
    }
}