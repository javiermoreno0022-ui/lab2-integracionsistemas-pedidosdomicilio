<?php

namespace App\BaseDatos;

use PDO;
use PDOException;

class Conexion 
{ 
    public static function obtener(): PDO 
    { 
        $dsn = 'mysql:host=127.0.0.1;port=3306;dbname=pedidos_domicilio;charset=utf8mb4'; 
  
        try { 
            return new PDO($dsn, 'root', '', [ 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
            ]); 
        } catch (PDOException $e) { 
            die('Error de conexión: ' . $e->getMessage()); 
        } 
    } 
} 