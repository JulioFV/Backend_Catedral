<?php
namespace src\routes;

use src\controller\ControllerItem;
use src\controller\ControllerLugar;
use src\controller\ControllerMaterial;
use src\controller\ControllerPrestamo;
use src\controller\ControllerUso;
use src\controller\ControllerRol;
use src\controller\ControllerUsuario;
use src\controller\ControllerGarantia;
use src\controller\ControllerEstado;
use src\controller\ControllerGeneral;

class RouteRegistrar
{
    public static function register(Router $router): void
    {
        // Usuarios
        $router->addRoute('POST', '/login',ControllerUsuario::class,'login');
        $router->addRoute('PUT', '/users/{id}', ControllerUsuario::class, 'updateUser');
        $router->addRoute('POST', '/updatepass', ControllerUsuario::class, 'updatePassword');
        $router->addRoute('POST', '/createuser', ControllerUsuario::class, 'createUser');
        $router->addRoute('GET', '/users', ControllerUsuario::class, 'readUsers');

        


        // Items
        $router->addRoute('GET', '/item', ControllerItem::class, 'readItem');
        $router->addRoute('POST', '/item', ControllerItem::class, 'createItem');
        $router->addRoute('PUT', '/item/{id}', ControllerItem::class, 'updateItem');
        $router->addRoute('PUT', '/items/{id}', ControllerItem::class,'inhabilitarItem');
        $router->addRoute('GET', '/item/{id}', ControllerItem::class, 'readItemByLocation');



        // Lugares
        $router->addRoute('GET', '/areas', ControllerLugar::class, 'getAll');
        $router->addRoute('POST', '/areas', ControllerLugar::class, 'create');
        $router->addRoute('PUT', '/areas/{id}', ControllerLugar::class, 'update');


        // MATERIALES
        $router->addRoute('GET', '/materiales', ControllerMaterial::class, 'getAllMateriales');
        $router->addRoute('POST', '/materiales', ControllerMaterial::class, 'createMaterial');
        //$router->addRoute('PUT', '/materiales/{id}', ControllerMaterial::class, 'update');
        //$router->addRoute('DELETE', '/materiales/{id}', ControllerMaterial::class, 'delete');

        //ESTADO
        $router->addRoute('GET', '/estado',ControllerEstado::class, 'getAllEstados');
        $router->addRoute('POST', '/estado',ControllerEstado::class, 'createEstado');
        //$router->addRoute('PUT', '/estado/{id}',ControllerEstado::class, 'getAllEstados');
        //$router->addRoute('DELETE', '/estado/{id}',ControllerEstado::class, 'getAllEstados');

        //GARANTIAS
        $router->addRoute('GET', '/garantia', ControllerGarantia::class, 'getAllGarantias');
        $router->addRoute('POST', '/garantia', ControllerGarantia::class, 'createGarantia');

        // PRESTAMOS
        $router->addRoute('GET', '/prestamos', ControllerPrestamo::class, 'getAllPrestamos');
        $router->addRoute('POST', '/prestamos', ControllerPrestamo::class, 'createPrestamo');
        $router->addRoute('PUT', '/devolverprestamo/{id}', ControllerPrestamo::class, 'devolverPrestamo');
        $router->addRoute('PUT', '/prestamos/{id}', ControllerPrestamo::class, 'updatePrestamo');
        $router->addRoute('DELETE', '/prestamos/{id}', ControllerPrestamo::class, 'deletePrestamo');

        // USOS
        $router->addRoute('GET', '/usos', ControllerUso::class, 'getAllUsos');
        $router->addRoute('POST', '/usos', ControllerUso::class, 'createUso');
        $router->addRoute('PUT', '/usos/{id}', ControllerUso::class, 'updateUso');
        $router->addRoute('DELETE', '/usos/{id}', ControllerUso::class, 'deleteUso');

        // ROLES
        $router->addRoute('GET', '/roles', ControllerRol::class, 'getAllRoles');
        $router->addRoute('POST', '/roles', ControllerRol::class, 'createRol');
        $router->addRoute('PUT', '/roles/{id}', ControllerRol::class, 'updateRol');
        //$router->addRoute('DELETE', '/roles/{id}', ControllerRol::class, 'delete');

        //GENERALES
        $router->addRoute('GET', '/general', ControllerGeneral::class, 'obtenerEstados');
    }
}