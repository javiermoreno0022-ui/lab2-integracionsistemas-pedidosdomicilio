<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\BaseDatos\Conexion;

$conexion = new Conexion();

$pdo = $conexion::obtener();

echo "Conexión a la base de datos exitosa.";