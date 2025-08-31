<?php

$db_host = getenv('MYSQL_DB_HOST');
$db_user = getenv('MYSQL_ROOT_USER');
$db_pass = getenv('MYSQL_ROOT_PASSWORD');
$db_name = getenv('MYSQL_DATABASE');

function conectarDB() : mysqli {
    global $db_host, $db_user, $db_pass, $db_name;
    $db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$db) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "Error de depuración: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    return $db;
}
