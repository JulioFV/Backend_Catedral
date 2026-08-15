<?php
namespace src\routes;

use src\config\Container;

class Router
{
    private array $routes = [];
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function addRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        // Ajusta según tu proyecto
        $base = '/ApiCatedral/public';
        if (strpos($uri, $base) === 0) {
            $uri = substr($uri, strlen($base));
        }

        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {

            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches);

                $controller = $this->container->make($route['controller']);

                call_user_func_array(
                    [$controller, $route['action']],
                    $matches
                );

                return;
            }
        }

        http_response_code(404);
        header('Content-Type: application/json');

        echo json_encode([
            'error' => true,
            'mensaje' => 'Ruta no encontrada',
            'contenido' => []
        ]);
    }
}