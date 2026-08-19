<?php
namespace src\config;
//***
// Julio Cesar Florentino Vigueras 
// 2025-04-24
//Uso de patron sigleton para la conexion a la base de datos
// 
//  */

use PDO;
use PDOException;

class Database
{
    private static $connection = null;

    public static function getConnection(){
        if (self::$connection === null) {
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $dbname = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];
            $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

            try {
                self::$connection = new PDO($dsn, $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
    public static function beginTransaction(): bool{
        return self::getConnection()->beginTransaction();
    }
    public static function commit(): bool{
        return self::getConnection()->commit();
    }
    public static function rollBack(): bool{
        return self::getConnection()->rollBack();
    }
}
?>