<?php

namespace src\service;

use src\repository\RepoPrestamo;
use src\repository\RepoItem;
use src\model\Prestamo;
use src\utils\EstatusPrestamo;
use Exception;

class ServicePrestamo{
    private RepoPrestamo $repoPrestamo;
    private RepoItem $repoItem;

    public function __construct(
        RepoPrestamo $repoPrestamo,
        RepoItem $repoItem
    ){
        $this->repoPrestamo = $repoPrestamo;
        $this->repoItem = $repoItem;
    }

    /**
     * Registrar un nuevo préstamo
     */
    public function registrarPrestamo(Prestamo $prestamo): bool{
        $item = $this->repoItem->getById($prestamo->getIdItem());

        if(!$item){
            throw new Exception("El item no existe.");
        }

        $cantidadSolicitada = $prestamo->getCantidad();

        if($cantidadSolicitada <= 0){
            throw new Exception("La cantidad solicitada debe ser mayor a cero.");
        }

        $disponibles = $item['cantidad'] - $item['cantidad_prestada'];

        if($cantidadSolicitada > $disponibles){
            throw new Exception(
                "No hay suficientes unidades disponibles. Disponibles: " . $disponibles
            );
        }

        // El estatus del préstamo no depende del stock del ítem,
        // sino de su propio progreso de devolución. Al crearlo, nada se ha devuelto.
        $prestamo->setEstatus(EstatusPrestamo::ACTIVO);
        $prestamo->setCantidadDevuelta(0);

        $creado = $this->repoPrestamo->createPrestamo($prestamo);

        if(!$creado){
            throw new Exception("No fue posible registrar el préstamo.");
        }

        $actualizado = $this->repoItem->incrementarCantidadPrestada(
            $prestamo->getIdItem(),
            $cantidadSolicitada
        );

        if(!$actualizado){
            throw new Exception(
                "El préstamo fue registrado pero no fue posible actualizar el inventario."
            );
        }

        return true;
    }

    /**
     * Registrar la devolución de un préstamo
     */
    public function devolverPrestamo(int $idPrestamo, array $data): bool{
        if (!isset($data['cantidad'])) {
            throw new Exception("Debes indicar la cantidad a devolver.");
        }

        $cantidadADevolver = (int) $data['cantidad'];

        if ($cantidadADevolver <= 0) {
            throw new Exception("La cantidad a devolver debe ser mayor a cero.");
        }

        $prestamoData = $this->repoPrestamo->getById($idPrestamo);

        if (!$prestamoData) {
            throw new Exception("El préstamo no existe.");
        }

        $estatusActual = (int) $prestamoData['estatus'];

        if ($estatusActual === EstatusPrestamo::DEVUELTO) {
            throw new Exception("El préstamo ya fue devuelto en su totalidad.");
        }

        $cantidadPrestada = (int) $prestamoData['cantidad'];
        $cantidadDevuelta = (int) $prestamoData['cantidad_devuelta'];
        $pendiente        = $cantidadPrestada - $cantidadDevuelta;

        if ($cantidadADevolver > $pendiente) {
            throw new Exception(
                "La cantidad a devolver ($cantidadADevolver) supera lo pendiente ($pendiente)."
            );
        }

        $nuevaCantidadDevuelta = $cantidadDevuelta + $cantidadADevolver;
        $nuevoPendiente        = $cantidadPrestada - $nuevaCantidadDevuelta;

        $prestamo = new Prestamo();
        $prestamo->setIdPrestamo($prestamoData['id_prestamo']);
        $prestamo->setIdItem($prestamoData['id_item']);
        $prestamo->setIdUsuario($prestamoData['id_usuario']);
        $prestamo->setNombreSolicitante($prestamoData['nombre_solicitante']);
        $prestamo->setTelefonoSolicitante($prestamoData['telefono_solicitante']);
        $prestamo->setCantidad($cantidadPrestada);
        $prestamo->setCantidadDevuelta($nuevaCantidadDevuelta);
        $prestamo->setIdGarantia($prestamoData['id_garantia']);
        $prestamo->setFechaPrestamo($prestamoData['fecha_prestamo']);
        $prestamo->setObservaciones($prestamoData['observaciones']);

        if ($nuevoPendiente === 0) {
            $prestamo->setEstatus(EstatusPrestamo::DEVUELTO);
                $prestamo->setFechaDevolucion(date('Y-m-d H:i:s'));
            } else {
                $prestamo->setEstatus(EstatusPrestamo::PARCIAL);
                $prestamo->setFechaDevolucion($prestamoData['fecha_devolucion']); // se conserva null hasta que sea total
            }

            $actualizado = $this->repoPrestamo->updatePrestamo($prestamo);

            if (!$actualizado) {
                throw new Exception("No fue posible actualizar el préstamo.");
            }

            // OJO: se descuenta solo lo que se devuelve AHORA, no el total original.
            $inventario = $this->repoItem->disminuirCantidadPrestada(
                $prestamoData['id_item'],
                $cantidadADevolver
            );

            if (!$inventario) {
                throw new Exception(
                    "El préstamo fue actualizado pero no fue posible actualizar el inventario."
                );
            }

            return true;
    }

    /**
     * Obtener todos los préstamos
     */
    public function obtenerPrestamos(): array{
        return $this->repoPrestamo->getAllPrestamos();
    }

    /**
     * Obtener un préstamo por ID
     */
    public function obtenerPrestamoPorId(int $id): ?array{
        return $this->repoPrestamo->getById($id);
    }

    /**
     * Eliminar un préstamo
     */
    public function eliminarPrestamo(int $idPrestamo): bool{
        $prestamo = $this->repoPrestamo->getById($idPrestamo);

        if(!$prestamo){
            throw new Exception("El préstamo no existe.");
        }

        if((int)$prestamo['estatus'] === 1){
            throw new Exception(
                "No se puede eliminar un préstamo que aún está activo."
            );
        }

        return $this->repoPrestamo->deletePrestamo($idPrestamo);
    }

    /**
     * ACTUALIZAR UN PRESTAMO
     */
    public function actualizarPrestamo(Prestamo $prestamo): bool{
        return $this->repoPrestamo->updatePrestamo($prestamo);
    }
}
