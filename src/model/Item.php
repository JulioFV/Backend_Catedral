<?php
namespace src\model;
 
class Item
{
    private ?int $id_item = null;
    private string $codigo;
    private string $nombre;
    private ?string $descripcion = null;
    private int $cantidad = 1;
    private string $fecha_creacion;          // Podrías usar DateTime, pero lo dejamos como string para simplicidad
    private ?int $id_material = null;
    private ?int $id_estado = null;
    private ?int $id_lugar = null;
    private ?int $id_uso = null;
    private int $cantidad_prestada = 0;
    private int $activo = 0;
    private ?string $observaciones = null;

    /**
     * Constructor opcional. La fecha de creación se asignará por la base de datos, no es necesario pasarla.
     */
    public function __construct(
        ?int $id_item,
        string $codigo,
        string $nombre,
        ?string $descripcion = null,
        int $cantidad = 1,
        ?int $id_material = null,
        ?int $id_estado = null,
        ?int $id_lugar = null,
        ?int $id_uso = null,
        int $cantidad_prestada = 0,
        int $activo = 0,
        ?string $observaciones
    ) {
        $this->id_item = $id_item;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->cantidad = $cantidad;
        $this->id_material = $id_material;
        $this->id_estado = $id_estado;
        $this->id_lugar = $id_lugar;
        $this->id_uso = $id_uso;
        $this->cantidad_prestada = $cantidad_prestada;
        $this->observaciones = $observaciones;
        $this->activo = $activo;
        // fecha_creacion se omite porque la asigna la BD con NOW() o CURRENT_TIMESTAMP
        $this->fecha_creacion = ''; // Se rellenará al leer de la BD
    }

    // Getters y Setters

    public function getIdItem(): ?int
    {
        return $this->id_item;
    }

    public function setIdItem(?int $id_item): self
    {
        $this->id_item = $id_item;
        return $this;
    }

    public function getCodigo(): string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    public function getFechaCreacion(): string
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(string $fecha_creacion): self
    {
        $this->fecha_creacion = $fecha_creacion;
        return $this;
    }

    public function getIdMaterial(): ?int
    {
        return $this->id_material;
    }

    public function setIdMaterial(?int $id_material): self
    {
        $this->id_material = $id_material;
        return $this;
    }

    public function getIdEstado(): ?int
    {
        return $this->id_estado;
    }

    public function setIdEstado(?int $id_estado): self
    {
        $this->id_estado = $id_estado;
        return $this;
    }

    public function getIdLugar(): ?int
    {
        return $this->id_lugar;
    }

    public function setIdLugar(?int $id_lugar): self
    {
        $this->id_lugar = $id_lugar;
        return $this;
    }

    public function getIdUso(): ?int
    {
        return $this->id_uso;
    }

    public function setIdUso(?int $id_uso): self
    {
        $this->id_uso = $id_uso;
        return $this;
    }

    public function getCantidadPrestada(): int
    {
        return $this->cantidad_prestada;
    }

    public function setCantidadPrestada(int $cantidad_prestada): self
    {
        $this->cantidad_prestada = $cantidad_prestada;
        return $this;
    }

    public function getActivo(): ?int
    {
        return $this->activo;
    }

    public function setActivo(?int $activo): self
    {
        $this->activo = $activo;
        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;
        return $this;
    }
}