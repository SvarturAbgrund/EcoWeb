<?php
include("conexion.php");

if (isset($_POST['login'])) {

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo='$correo'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            header("Location: ../index.html");
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
}
?>
