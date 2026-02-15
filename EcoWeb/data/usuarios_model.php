<?php
require_once "conexion.php";

function loginUsuario($correo, $password) {
    global $conexion;

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo=?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            return $usuario;
        }
    }

    return false;
}

function registrarUsuario($nombre, $correo, $password) {
    global $conexion;

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $rol = "usuario";

    $stmt = $conexion->prepare(
        "INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("ssss", $nombre, $correo, $passwordHash, $rol);
    return $stmt->execute();
}
?>
