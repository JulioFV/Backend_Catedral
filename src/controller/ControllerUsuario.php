<?php
namespace src\controller;

use src\service\ServiceUsuario;
use src\model\User;
use src\utils\ResponseHelper;

class ControllerUsuario
{
    private ServiceUsuario $serviceUsuario;

    public function __construct(ServiceUsuario $serviceUsuario)
    {
        $this->serviceUsuario = $serviceUsuario;
    }

    public function createUser(): void{
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            $user = new User();
            $user->setNombre($data['nombre'] ?? '');
            $user->setApp($data['app'] ?? '');
            $user->setEmail($data['email'] ?? '');
            $user->setPassword($data['password'] ?? '');
            $user->setIdRol($data['id_rol'] ?? 0);

            $this->serviceUsuario->createUser($user);

            ResponseHelper::json([
                'success' => true,
                'message' => 'Usuario registrado correctamente'
            ], 201);

        } catch (\InvalidArgumentException $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);

        } catch (\Exception $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function login(): void{
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            $user = $this->serviceUsuario->login($email, $password);

            if ($user === null) {
                ResponseHelper::json([
                    'success' => false,
                    'message' => 'Correo o contraseña incorrectos'
                ], 401);
            }

            ResponseHelper::json([
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function getUserById(int $id): void{
        try {
            $user = $this->serviceUsuario->getUserById($id);

            if ($user === null) {
                ResponseHelper::json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            ResponseHelper::json([
                'success' => true,
                'data' => $user
            ]);

        } catch (\Exception $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function updateUser(): void{
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            $user = new User();
            $user->setIdUsuario($data['id_usuario'] ?? 0);
            $user->setNombre($data['nombre'] ?? '');
            $user->setApp($data['app'] ?? '');
            $user->setEmail($data['email'] ?? '');
            $user->setPassword($data['password'] ?? '');
            $user->setIdRol($data['id_rol'] ?? 0);

            $this->serviceUsuario->updateUser($user);

            ResponseHelper::json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente'
            ]);

        } catch (\InvalidArgumentException $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);

        } catch (\Exception $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function updatePassword(): void{
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            $id = $data['id_usuario'] ?? 0;
            $password = $data['password'] ?? '';

            if($this->serviceUsuario->updatePassword($id, $password)){
                ResponseHelper::json([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente'
            ]);
            }else{
                ResponseHelper::json([
                'success' => false,
                'message' => 'No se pudo atualizar la contraseña'
            ]);
            }

        } catch (\InvalidArgumentException $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);

        } catch (\Exception $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function deleteUser(int $id): void{
        try {
            $this->serviceUsuario->deleteUser($id);

            ResponseHelper::json([
                'success' => true,
                'message' => 'Usuario eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }
    public function readUsers(): void{
        try{
            $user = $this->serviceUsuario->readUsers();
            ResponseHelper::json([
                'status' => 'success',
                'data' => $user
            ]);
        }catch(Exception $e){
            ResponseHelper::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getIdByEmail(): void{
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            if($data === null){
                ResponseHelper::json([
                    'success' =>false,
                    'message' =>'El body no puede ir vacío'
                ]);

            }
            if($data['correo'] === null){
                ResponseHelper::json([
                    'success' =>false,
                    'message' =>'El correo es necesario'
                ]);
            }
            $correo = $data['correo'];

            $ID = $this->serviceUsuario->obtenerID($correo);
            if($ID === null){
                ResponseHelper::json([
                'success' => false,
                'data' => "El usuario no existe"
            ]);
            }
            ResponseHelper::json([
                'success' => true,
                'data' => $ID
            ]);
            

        } catch (\Exception $e) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }
}
