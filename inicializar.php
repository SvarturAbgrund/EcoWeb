<?php
/**
 * Script de Inicialización - Genera usuarios correctamente
 * Ejecuta ESTO SOLO UNA VEZ para crear los usuarios con hashes válidos
 */

require_once __DIR__ . '/EcoWeb/data/conexion.php';

// Verificar si ya existen usuarios
$resultado = $conexion->query("SELECT COUNT(*) as total FROM usuarios");
$row = $resultado->fetch_assoc();
$total_usuarios = $row['total'];

if ($total_usuarios > 0) {
    // Borrar usuarios y comentarios antiguos para empezar de nuevo
    $conexion->query("DELETE FROM comentarios");
    $conexion->query("DELETE FROM usuarios");
    echo "✓ Datos antiguos eliminados<br>";
}

// Crear usuarios con hashes válidos
$usuarios = [
    ['nombre' => 'Administrador Principal', 'email' => 'admin@ecoweb.com', 'password' => 'Admin123', 'rol' => 'admin'],
    ['nombre' => 'Admin Secundario', 'email' => 'admin2@ecoweb.com', 'password' => 'Admin456', 'rol' => 'admin'],
    ['nombre' => 'Juan Usuarios', 'email' => 'juan@ecoweb.com', 'password' => 'Usuario123', 'rol' => 'usuario'],
    ['nombre' => 'Maria Test', 'email' => 'maria@ecoweb.com', 'password' => 'Usuario456', 'rol' => 'usuario'],
    ['nombre' => 'Carlos Demo', 'email' => 'carlos@ecoweb.com', 'password' => 'Prueba789', 'rol' => 'usuario'],
    ['nombre' => 'Sofia Prueba', 'email' => 'sofia@ecoweb.com', 'password' => 'Demo2024', 'rol' => 'usuario'],
];

// Insertar usuarios
foreach ($usuarios as $usuario) {
    $passwordHash = password_hash($usuario['password'], PASSWORD_DEFAULT);
    
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo "❌ Error: " . $conexion->error . "<br>";
        exit;
    }
    
    $stmt->bind_param("ssss", $usuario['nombre'], $usuario['email'], $passwordHash, $usuario['rol']);
    
    if ($stmt->execute()) {
        echo "✓ Usuario creado: " . $usuario['email'] . " / " . $usuario['password'] . "<br>";
    } else {
        echo "❌ Error al crear: " . $usuario['email'] . " - " . $stmt->error . "<br>";
    }
    $stmt->close();
}

// Insertar comentarios de prueba
$comentarios_sql = "
INSERT INTO comentarios (usuario_id, nombre, correo, comentario, fecha, respuesta) VALUES
(3, 'Juan Usuarios', 'juan@ecoweb.com', 'Excelente página sobre ecosistemas, muy informativa', '2026-02-15 08:30:00', 'Gracias Juan, nos alegra te haya sido útil'),
(4, 'Maria Test', 'maria@ecoweb.com', 'Me encanta el enfoque educativo del proyecto', '2026-02-15 09:15:00', NULL),
(5, 'Carlos Demo', 'carlos@ecoweb.com', 'Muy bueno el contenido sobre conservación ambiental', '2026-02-15 10:45:00', 'Gracias por tu feedback Carlos'),
(6, 'Sofia Prueba', 'sofia@ecoweb.com', 'El diseño es muy limpio y fácil de navegar', '2026-02-15 11:20:00', NULL);
";

if ($conexion->multi_query($comentarios_sql)) {
    echo "✓ Comentarios de prueba creados<br>";
} else {
    echo "❌ Error en comentarios: " . $conexion->error . "<br>";
}

echo "<hr>";
echo "<h2>✅ ¡INICIALIZACIÓN COMPLETADA!</h2>";
echo "<p>Los usuarios han sido creados correctamente con hashes válidos.</p>";
echo "<p><a href='EcoWeb/presentation/'>Ir a la aplicación →</a></p>";

?>
