<?php
require_once "conexion.php";
require_once "seguridad.php";

function obtenerComentarios() {
    global $conexion;
    return $conexion->query("SELECT c.*, u.nombre FROM comentarios c LEFT JOIN usuarios u ON c.usuario_id = u.id ORDER BY c.fecha DESC");
}

function insertarComentario($usuario_id, $comentario) {
    global $conexion;
    
    // Validar entrada
    $validacion = validarComentario($comentario);
    if ($validacion !== true) {
        return ['exito' => false, 'error' => $validacion];
    }
    
    // Sanitizar comentario
    $comentario = sanitizarEntrada($comentario);

    $stmt = $conexion->prepare(
        "INSERT INTO comentarios (usuario_id, comentario, fecha) VALUES (?, ?, NOW())"
    );
    
    if (!$stmt) {
        return ['exito' => false, 'error' => 'Error en la base de datos'];
    }

    $stmt->bind_param("is", $usuario_id, $comentario);
    
    if ($stmt->execute()) {
        return ['exito' => true, 'error' => ''];
    } else {
        return ['exito' => false, 'error' => 'Error al guardar el comentario'];
    }
}

function insertarRespuesta($comentario_id, $respuesta) {
    global $conexion;
    
    // Validar que sea admin - se verifica en el controlador
    // Validar entrada
    $validacion = validarComentario($respuesta);
    if ($validacion !== true) {
        return ['exito' => false, 'error' => $validacion];
    }
    
    // Sanitizar respuesta
    $respuesta = sanitizarEntrada($respuesta);

    $stmt = $conexion->prepare(
        "UPDATE comentarios SET respuesta = ? WHERE id = ?"
    );
    
    if (!$stmt) {
        return ['exito' => false, 'error' => 'Error en la base de datos'];
    }

    $stmt->bind_param("si", $respuesta, $comentario_id);
    
    if ($stmt->execute()) {
        return ['exito' => true, 'error' => ''];
    } else {
        return ['exito' => false, 'error' => 'Error al guardar la respuesta'];
    }
}

function eliminarComentario($comentario_id) {
    global $conexion;
    
    // Solo es llamado si es admin - validar en controlador

    $stmt = $conexion->prepare("DELETE FROM comentarios WHERE id = ?");
    
    if (!$stmt) {
        return ['exito' => false, 'error' => 'Error en la base de datos'];
    }

    $stmt->bind_param("i", $comentario_id);
    
    if ($stmt->execute()) {
        return ['exito' => true, 'error' => ''];
    } else {
        return ['exito' => false, 'error' => 'Error al eliminar el comentario'];
    }
}

?>
