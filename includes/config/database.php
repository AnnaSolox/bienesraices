<?php

function conectarDB() : mysqli {
    $db = new mysqli($_ENV['MYSQL_DB_HOST'], $_ENV['MYSQL_ROOT_USER'], $_ENV['MYSQL_ROOT_PASSWORD'], $_ENV['MYSQL_DATABASE']);

    if (!$db) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "Error de depuración: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    return $db;
}
