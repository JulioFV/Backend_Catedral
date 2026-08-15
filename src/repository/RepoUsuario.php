<?php
namespace src\repository;

use src\config\Database;
use src\model\User;
use PDO;

class RepoUsuario
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = Database::getConnection();

    }

    public function createUser(User $user): bool{
        $stmt = $this->db->prepare(
            "INSERT INTO usuario (nombre, app, email, password, id_rol)
             VALUES (:nombre, :app, :email, :password, :id_rol)"
        );

        return $stmt->execute([
            ':nombre'   => $user->getNombre(),
            ':app'      => $user->getApp(),
            ':email'    => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':id_rol'   => $user->getIdRol()
        ]);
    }

    public function getUserByEmail(string $email): ?array{
        $stmt = $this->db->prepare(
            "SELECT * FROM usuario WHERE email = :email"
        );

        $stmt->execute([
            ':email' => $email
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function getUserById(int $id): ?array{
        $stmt = $this->db->prepare(
            "SELECT * FROM usuario WHERE id_usuario = :id"
        );

        $stmt->execute([
            ':id' => $id
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function updateUser(User $user): bool{
        try {
            $stmt = $this->db->prepare(
                "UPDATE usuario
                 SET nombre = :nombre,
                     app = :app,
                     email = :email,
                     password = :password,
                     id_rol = :id_rol
                 WHERE id_usuario = :id_usuario"
            );

            return $stmt->execute([
                ':id_usuario' => $user->getIdUsuario(),
                ':nombre'     => $user->getNombre(),
                ':app'        => $user->getApp(),
                ':email'      => $user->getEmail(),
                ':password'   => $user->getPassword(),
                ':id_rol'     => $user->getIdRol()
            ]);

        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new \InvalidArgumentException("El correo ya está registrado");
            }

            throw new \Exception("Error al actualizar usuario");
        }
    }

    public function updatePassword(int $id, string $newPassword): bool{
        $stmt = $this->db->prepare(
            "UPDATE usuario
             SET password = :password
             WHERE id_usuario = :id"
        );

        return $stmt->execute([
            ':id' => $id,
            ':password' => $newPassword
        ]);
    }

    public function deleteUser(int $id): bool{
        $stmt = $this->db->prepare(
            "DELETE FROM usuario WHERE id_usuario = :id"
        );

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function getUsers(): ?array{
        $stmt = $this->db->prepare("SELECT
                                    u.id_usuario,
                                    u.nombre,
                                    u.app,
                                    u.email,
                                    u.password,
                                    u.id_rol,
                                    r.nombre AS nombreRol
                                     FROM usuario u
                                     LEFT JOIN rol r ON u.id_rol = r.id_rol;
                                     ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
