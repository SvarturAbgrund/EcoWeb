<?php
session_start();
require_once "conexion.php";

if(!isset($_SESSION['nombre'])){
    header("Location: ../presentation/login.php");
    exit();
}

$nombre = trim($_POST['nombre']);
$correo = trim($_POST['correo']);
$password = trim($_POST['password']);

if(empty($nombre) || empty($correo) || empty($password)){
    
    echo "<script>
        alert('Todos los campos son obligatorios');
        window.history.back();
    </script>";
    
    exit();
}

$nombreSesion = $_SESSION['nombre'];

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE usuarios 
        SET nombre='$nombre', correo='$correo', password='$passwordHash'
        WHERE nombre='$nombreSesion'";

mysqli_query($conexion,$sql);

$_SESSION['nombre'] = $nombre;

header("Location: ../presentation/perfil.php");
exit();
?>