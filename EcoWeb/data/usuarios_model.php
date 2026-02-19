<?php
require_once "conexion.php";
require_once "seguridad.php";

function loginUsuario($correo, $password) {
    global $conexion;
    
    // Validar entrada
    if (!validarEmail($correo)) {
        return false;
    }
    
    if (empty($password)) {
        return false;
    }
    
    // Verificar rate limiting (anti fuerza bruta)
    if (!verificarRateLimiting('login_' . $correo)) {
        return false; // Demasiados intentos
    }

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo=?");
    if (!$stmt) {
        return false;
    }
    
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            limpiarIntentos('login_' . $correo);
            return $usuario;
        } else {
            registrarIntentoFallido('login_' . $correo);
        }
    } else {
        registrarIntentoFallido('login_' . $correo);
    }

    return false;
}

function registrarUsuario($nombre, $correo, $password) {
    global $conexion;

    // Validar entrada
    $validacionNombre = validarNombre($nombre);
    if ($validacionNombre !== true) {
        return ['exito' => false, 'error' => $validacionNombre];
    }
    
    if (!validarEmail($correo)) {
        return ['exito' => false, 'error' => 'Email inválido'];
    }
    
    $validacionPassword = validarPassword($password);
    if ($validacionPassword !== true) {
        return ['exito' => false, 'error' => $validacionPassword];
    }
    
    // Verificar si el email ya existe
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        return ['exito' => false, 'error' => 'El email ya está registrado'];
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $rol = "usuario";
    $nombre = sanitizarEntrada($nombre);

    $stmt = $conexion->prepare(
        "INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)"
    );
    
    if (!$stmt) {
        return ['exito' => false, 'error' => 'Error en la base de datos'];
    }

    $stmt->bind_param("ssss", $nombre, $correo, $passwordHash, $rol);
    
    if ($stmt->execute()) {
        return ['exito' => true, 'error' => ''];
    } else {
        return ['exito' => false, 'error' => 'Error al registrarse'];
    }
}

?>

