<?php include("conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comentarios - EcoWeb</title>
    <link rel="stylesheet" href="../public/css/estilos.css">


</head>
<body>

<header>
    <h1>Comentarios EcoWeb</h1>
</header>

<nav>
  <nav>
    <a href="../index.html">Inicio</a>
    <a href="../pages/ecosistemas.html">Ecosistemas</a>
    <a href="../pages/contactos.html">Contactos</a>
</nav>


</nav>

<section>
    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Correo:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Comentario:</label><br>
        <textarea name="comentario" required></textarea><br><br>

        <button type="submit" name="guardar">Enviar</button>
    </form>

    <h2>Comentarios Guardados</h2>

    <?php
    if (isset($_POST['guardar'])) {
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $comentario = $_POST['comentario'];

        $sql = "INSERT INTO comentarios (nombre, correo, comentario)
                VALUES ('$nombre', '$correo', '$comentario')";

        $conn->query($sql);
        echo "<p>Comentario guardado correctamente ✅</p>";
    }

    $resultado = $conn->query("SELECT * FROM comentarios ORDER BY fecha DESC");

    while ($fila = $resultado->fetch_assoc()) {
        echo "<div style='background:#fff;padding:10px;margin:10px;border-radius:5px;'>
                <strong>{$fila['nombre']}</strong> ({$fila['correo']})<br>
                {$fila['comentario']}<br>
                <small>{$fila['fecha']}</small>
              </div>";
    }
    ?>
</section>

<footer>
    <p>EcoWeb © 2026</p>
</footer>

</body>
</html>
