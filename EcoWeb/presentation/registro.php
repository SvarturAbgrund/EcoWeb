<?php
require_once "../data/usuarios_model.php";
include "layout/header.php";

if (isset($_POST['registro'])) {
    registrarUsuario($_POST['nombre'], $_POST['correo'], $_POST['password']);
    header("Location: login.php");
    exit();
}
?>

<link rel="stylesheet" href="../public/css/estilos.css">


<section>
    <h2>Registro</h2>

    <form method="POST">
        <input type="text" name="nombre" required>
        <input type="email" name="correo" required>
        <input type="password" name="password" required>
        <button name="registro">Registrarse</button>
    </form>

    <a href="index.php">⬅ Volver</a>
</section>
