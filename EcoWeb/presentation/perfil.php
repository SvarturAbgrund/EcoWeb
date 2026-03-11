<?php
session_start();
require_once "../data/conexion.php";
require_once "../data/seguridad.php";

if(!isset($_SESSION['nombre'])){
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Perfil de Usuario</title>

<link rel="stylesheet" href="../public/css/estilos.css">

<style>

.perfil-container{
width:80%;
margin:auto;
margin-top:40px;
}

.card{
background:white;
padding:25px;
margin-bottom:20px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,0.2);
}

input{
width:100%;
padding:10px;
margin:10px 0;
}

button{
padding:10px 20px;
background:#2c8f7a;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}

.centrar-boton{
text-align:center;
margin-top:20px;
}

</style>

</head>

<body>

<?php include '../presentation/layout/header.php'; ?>



<div class="perfil-container">

<?php if($rol == "usuario"){ ?>

<div class="card">

<h3>Editar perfil</h3>

<form action="../data/actualizar_perfil.php" method="POST">

<label>Nuevo nombre</label>
<input type="text" name="nombre" required>

<label>Nuevo correo</label>
<input type="email" name="correo" required>

<label>Nueva contraseña</label>
<input type="password" name="password" required>

<div class="centrar-boton">
    <button type="submit">Actualizar perfil</button>
</div>

</form>

</div>

<?php } ?>

<?php if($rol == "admin"){ ?>

<div class="card">

<h3>Gestión de Usuarios</h3>

<?php

$sql = "SELECT id,nombre,correo,rol FROM usuarios";
$result = mysqli_query($conexion,$sql);

while($usuario = mysqli_fetch_assoc($result)){

?>

<div style="border-bottom:1px solid #ddd;padding:10px;">

<strong><?php echo $usuario['nombre']; ?></strong>
<br>
<?php echo $usuario['correo']; ?>
<br>
Rol: <?php echo $usuario['rol']; ?>

<br><br>

<a href="../data/eliminar_usuario.php?id=<?php echo $usuario['id']; ?>">Eliminar</a>

|

<a href="../data/hacer_admin.php?id=<?php echo $usuario['id']; ?>">Dar admin</a>

</div>

<?php } ?>

</div>

<?php } ?>

</div>

</body>
</html>