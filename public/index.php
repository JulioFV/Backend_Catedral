<?php
require_once __DIR__ . '/../vendor/autoload.php';

use src\routes\Router;
use src\routes\RouteRegistrar;
use src\config\EnvLoader;

EnvLoader::load();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}
$router = new Router();



RouteRegistrar::register($router);

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);