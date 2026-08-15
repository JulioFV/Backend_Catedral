<?php
require_once __DIR__ . '/../vendor/autoload.php';

use src\routes\Router;
use src\routes\RouteRegistrar;
use src\config\EnvLoader;

EnvLoader::load();

$router = new Router();

RouteRegistrar::register($router);

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);