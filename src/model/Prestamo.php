<?php
declare(strict_types=1);

namespace src\model;

class Prestamo
{
    private ?int $id_prestamo;
    private int $id_item;
    private ?int $id_usuario;
    private ?string $nombre_solicitante;
    private ?string $telefono_solicitante;
    private int $estatus;
    private int $cantidad;
    private int $id_garantia;
    private string $fecha_prestamo;
    private ?string $fecha_devolucion;
    private ?string $observaciones;
    private int $cantidadDevuelta = 0;


    public function __construct(

    ) {

    }

    // Getters
    public function getIdPrestamo(): ?int
    {
        return $this->id_prestamo;
    }

    public function getIdItem(): int
    {
        return $this->id_item;
    }

    public function getIdUsuario(): ?int
    {
        return $this->id_usuario;
    }

    public function getNombreSolicitante(): ?string
    {
        return $this->nombre_solicitante;
    }

    public function getTelefonoSolicitante(): ?string
    {
        return $this->telefono_solicitante;
    }

    public function getEstatus(): int
    {
        return $this->estatus;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function getIdGarantia(): int
    {
        return $this->id_garantia;
    }

    public function getFechaPrestamo(): string
    {
        return $this->fecha_prestamo;
    }

    public function getFechaDevolucion(): ?string
    {
        return $this->fecha_devolucion;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    // Setters
    public function setIdPrestamo(?int $id_prestamo): void
    {
        $this->id_prestamo = $id_prestamo;
    }

    public function setIdItem(int $id_item): void
    {
        $this->id_item = $id_item;
    }

    public function setIdUsuario(?int $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function setNombreSolicitante(?string $nombre_solicitante): void
    {
        $this->nombre_solicitante = $nombre_solicitante;
    }

    public function setTelefonoSolicitante(?string $telefono_solicitante): void
    {
        $this->telefono_solicitante = $telefono_solicitante;
    }

    public function setEstatus(int $estatus): void
    {
        $this->estatus = $estatus;
    }

    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    public function setIdGarantia(int $id_garantia): void
    {
        $this->id_garantia = $id_garantia;
    }

    public function setFechaPrestamo(string $fecha_prestamo): void
    {
        $this->fecha_prestamo = $fecha_prestamo;
    }

    public function setFechaDevolucion(?string $fecha_devolucion): void
    {
        $this->fecha_devolucion = $fecha_devolucion;
    }

    public function setObservaciones(?string $observaciones): void
    {
        $this->observaciones = $observaciones;
    }
    public function getCantidadDevuelta(): int {
    return $this->cantidadDevuelta;
}

public function setCantidadDevuelta(int $cantidadDevuelta): void {
    $this->cantidadDevuelta = $cantidadDevuelta;
}
}