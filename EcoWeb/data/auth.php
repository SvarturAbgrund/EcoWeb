<?php
session_start();
require_once "usuarios_model.php";

if (isset($_POST['login'])) {

    $usuario = loginUsuario($_POST['correo'], $_POST['password']);

    if ($usuario) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        header("Location: ../presentation/index.php");
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>
