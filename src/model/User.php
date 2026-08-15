<?php

namespace src\model;

class User
{
    private ?int $id_usuario;
    private string $nombre;
    private string $app;
    private string $email;
    private string $password;
    private int $id_rol;

    public function __construct() {

    }

    // Getters
    public function getIdUsuario(): ?int
    {
        return $this->id_usuario;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApp(): string
    {
        return $this->app;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getIdRol(): int
    {
        return $this->id_rol;
    }

    // Setters
    public function setIdUsuario(?int $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setApp(string $app): void
    {
        $this->app = $app;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setIdRol(int $id_rol): void
    {
        $this->id_rol = $id_rol;
    }
}