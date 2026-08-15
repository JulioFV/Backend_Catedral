<?php
namespace src\utils;

class ResponseHelper
{
    public static function json(array $response, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Respuesta exitosa (200)
     * Uso: ResponseHelper::success($data, 'Mensaje');
     */
    public static function success($data = [], string $message = 'Operación realizada correctamente'): void
    {
        self::json([
            'error' => false,
            'mensaje' => $message,
            'contenido' => $data
        ], 200);
    }

    /**
     * Recurso creado (201)
     * Uso: ResponseHelper::created($data, 'Mensaje');
     */
    public static function created($data = [], string $message = 'Registro creado correctamente'): void
    {
        self::json([
            'error' => false,
            'mensaje' => $message,
            'contenido' => $data
        ], 201);
    }

    /**
     * Error genérico
     * Uso: ResponseHelper::error('Mensaje', 500);
     */
    public static function error(string $message = 'Ocurrió un error', int $statusCode = 500, $data = []): void
    {
        self::json([
            'error' => true,
            'mensaje' => $message,
            'contenido' => $data
        ], $statusCode);
    }

    public static function badRequest(string $message = 'Solicitud incorrecta', $data = []): void
    {
        self::error($message, 400, $data);
    }

    public static function unauthorized(string $message = 'No autorizado', $data = []): void
    {
        self::error($message, 401, $data);
    }

    public static function forbidden(string $message = 'Acceso denegado', $data = []): void
    {
        self::error($message, 403, $data);
    }

    public static function notFound(string $message = 'Recurso no encontrado', $data = []): void
    {
        self::error($message, 404, $data);
    }

    public static function validationError(string $message = 'Error de validación', $data = []): void
    {
        self::error($message, 422, $data);
    }

    public static function serverError(string $message = 'Error interno del servidor', $data = []): void
    {
        self::error($message, 500, $data);
    }

    public static function noContent(): void
    {
        http_response_code(204);
        exit;
    }
}
?>
