<?php
session_start();
require_once "conexion.php";

if($_SESSION['rol'] != "admin"){
exit();
}

$id = $_GET['id'];

$sql = "UPDATE usuarios SET rol='admin' WHERE id='$id'";

mysqli_query($conexion,$sql);

header("Location: ../presentation/dashboard.php");
?>