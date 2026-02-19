<?php
// Incluir funciones de seguridad
require_once __DIR__ . '/seguridad.php';

// Iniciar sesión de forma segura
iniciarSesionSegura();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "ecoweb");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer charset UTF-8
$conexion->set_charset("utf8mb4");
?>
