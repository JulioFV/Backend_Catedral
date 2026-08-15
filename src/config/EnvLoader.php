<?php
namespace src\config;

use Dotenv\Dotenv;

class EnvLoader
{
    public static function load()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }       
}
?>