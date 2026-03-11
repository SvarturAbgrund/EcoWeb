<?php
session_start();
require_once "../data/conexion.php";

if($_SESSION['rol'] != "admin"){
    header("Location:index.php");
    exit();
}

$usuarios = mysqli_query($conexion,"SELECT COUNT(*) as total FROM usuarios");
$comentarios = mysqli_query($conexion,"SELECT COUNT(*) as total FROM comentarios");

$totalUsuarios = mysqli_fetch_assoc($usuarios)['total'];
$totalComentarios = mysqli_fetch_assoc($comentarios)['total'];
?>

<!DOCTYPE html>
<html>

<head>

<title>Dashboard Admin</title>

<link rel="stylesheet" href="../public/css/dashboard.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<h1>Panel Administrador</h1>

<div class="cards">

<div class="card">
<h3>Usuarios</h3>
<p><?php echo $totalUsuarios; ?></p>
</div>

<div class="card">
<h3>Comentarios</h3>
<p><?php echo $totalComentarios; ?></p>
</div>

</div>

<canvas id="graficaUsuarios"></canvas>

<script>

const ctx = document.getElementById('graficaUsuarios');

new Chart(ctx, {

type: 'bar',

data: {

labels: ['Usuarios','Comentarios'],

datasets: [{
label: 'Datos del sistema',
data: [<?php echo $totalUsuarios ?>, <?php echo $totalComentarios ?>]
}]

}

});

</script>

<br>

<a href="usuarios.php">Administrar usuarios</a>

<br><br>

<a href="comentarios_admin.php">Administrar comentarios</a>

</body>

</html>