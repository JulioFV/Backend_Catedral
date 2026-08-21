<?php
namespace src\service;

use src\repository\RepoUsuario;
use src\model\User;

class ServiceUsuario
{
    private RepoUsuario $repoUsuario;

    public function __construct(RepoUsuario $repoUsuario)
    {
        $this->repoUsuario = $repoUsuario;
    }

    public function createUser(User $user): bool{
        // Validaciones básicas
        if (empty($user->getNombre()) ||
            empty($user->getApp()) ||
            empty($user->getEmail()) ||
            empty($user->getPassword()) ||
            empty($user->getIdRol())) {
            throw new \InvalidArgumentException("Todos los campos son obligatorios");
        }

        // Validar formato del correo
        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("El correo electrónico no es válido");
        }

        // Verificar si el correo ya existe
        if ($this->repoUsuario->getUserByEmail($user->getEmail()) !== null) {
            throw new \InvalidArgumentException("El correo ya está registrado");
        }

        return $this->repoUsuario->createUser($user);
    }

    public function login(string $email, string $password): ?array{
        $user = $this->repoUsuario->getUserByEmail($email);

        if ($user === null) {
            return null;
        }

        // Comparación directa (sin hash)
        if ($user['password'] !== $password) {
            return null;
        }

        return $user;
    }
    public function getUserById(int $id): ?array{
        return $this->repoUsuario->getUserById($id);
    }

    public function getUserByEmail(string $email): ?array{
        return $this->repoUsuario->getUserByEmail($email);
    }

    public function updateUser(User $user): bool{
        if (empty($user->getIdUsuario())) {
            throw new \InvalidArgumentException("El ID del usuario es obligatorio");
        }

        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("El correo electrónico no es válido");
        }

        // Validar que el correo no pertenezca a otro usuario
        $existingUser = $this->repoUsuario->getUserByEmail($user->getEmail());

        if ($existingUser !== null &&
            (int)$existingUser['id_usuario'] !== (int)$user->getIdUsuario()) {
            throw new \InvalidArgumentException("El correo ya está registrado por otro usuario");
        }

        return $this->repoUsuario->updateUser($user);
    }

    public function updatePassword(int $id, string $newPassword): bool{
        if (empty($newPassword)) {
            throw new \InvalidArgumentException("La nueva contraseña no puede estar vacía");
        }

        return $this->repoUsuario->updatePassword($id, $newPassword);
    }

    public function deleteUser(int $id): bool{
        return $this->repoUsuario->deleteUser($id);
    }
    public function readUsers(): ?array{
        return $this->repoUsuario->getUsers();
    }
    public function obtenerID(string $email): ?string{
        return $this->repoUsuario->getID($email);
    }
}
