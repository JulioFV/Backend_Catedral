<?php
namespace src\model;
class Lugar{
    private ?int $id_lugar = null;
    private string $nombre;
    private string $referencia;
    private string $responsable;
    private ?string $observaciones;
    private string $codigo;

    public function __construct( ?int $id_lugar, string $nombre, string $referencia, string $responsable, ?string $observaciones, string $codigo) {
        $this->id_lugar = $id_lugar;
        $this->nombre = $nombre;
        $this->referencia = $referencia;
        $this->responsable = $responsable;
        $this->observaciones = $observaciones;
        $this->codigo = $codigo;
    }

    public function getIdLugar(): ?int {
        return $this->id_lugar;
    }
    public function setIdLugar(?int $id_lugar): self{
        $this->id_lugar = $id_lugar;
        return $this;
    }
    public function getNombre(): string{
        return $this->nombre;
    }
    public function setNombre(string $nombre): self{
        $this->nombre = $nombre;
        return $this;
    }
    public function getReferencia(): string{
        return $this->referencia;
    }
    public function setReferencia(string $referencia): self{
        $this->referencia = $referencia;
        return $this;
    }
    public function getResponsable(): string {
        return $this->responsable;
    }
    public function setResponsable(string $responsable): self{
        $this->referencia = $referencia;
        return $this;
    }
    public function getObservaciones(): ?string{
        return $this->observaciones;
    }
    public function setObservaciones(?string $observaciones): self {
        $this->observaciones = $observaciones;
        return $this;
    }
    public function getCodigo(): string{
        return $this->codigo;
    }
    public function setCodigo(string $codigo): self{
        $this->codigo = $codigo;
        return $this;
    }
}