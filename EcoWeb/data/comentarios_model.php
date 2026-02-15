<?php
require_once "conexion.php";

function obtenerComentarios() {
    global $conexion;
    return $conexion->query("SELECT * FROM comentarios ORDER BY fecha DESC");
}

function insertarComentario($usuario_id, $nombre, $comentario) {
    global $conexion;

    $stmt = $conexion->prepare(
        "INSERT INTO comentarios (usuario_id, nombre, comentario, fecha)
         VALUES (?, ?, ?, NOW())"
    );

    $stmt->bind_param("iss", $usuario_id, $nombre, $comentario);
    return $stmt->execute();
}
?>
