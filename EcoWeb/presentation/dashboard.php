<?php
session_start();
require_once "../data/conexion.php";

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != "admin"){
    header("Location: index.php");
    exit();
}

$totalUsuarios = mysqli_fetch_assoc(mysqli_query($conexion,"SELECT COUNT(*) as total FROM usuarios"))['total'];
$totalComentarios = mysqli_fetch_assoc(mysqli_query($conexion,"SELECT COUNT(*) as total FROM comentarios"))['total'];
$totalAdmins = mysqli_fetch_assoc(mysqli_query($conexion,"SELECT COUNT(*) as total FROM usuarios WHERE rol='admin'"))['total'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard Admin</title>

<link rel="stylesheet" href="../public/css/estilos.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

.dashboard{
width:90%;
margin:auto;
margin-top:30px;
}

.cards{
display:flex;
gap:20px;
margin-bottom:40px;
}

.card{
flex:1;
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,0.2);
text-align:center;
}

.tabla{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,0.2);
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:10px;
border-bottom:1px solid #ddd;
text-align:center;
}

.boton{
padding:6px 12px;
background:#2c8f7a;
color:white;
text-decoration:none;
border-radius:5px;
}

.boton-rojo{
background:red;
}

</style>

</head>

<body>

<?php include "../presentation/layout/header.php"; ?>

<div class="dashboard">

<h2>Panel de Administrador</h2>

<div class="cards">

<div class="card">
<h3>Usuarios</h3>
<p><?php echo $totalUsuarios; ?></p>
</div>

<div class="card">
<h3>Comentarios</h3>
<p><?php echo $totalComentarios; ?></p>
</div>

<div class="card">
<h3>Administradores</h3>
<p><?php echo $totalAdmins; ?></p>
</div>

</div>

<canvas id="graficaSistema"></canvas>

<br><br>

<div class="tabla">

<h3>Usuarios registrados</h3>

<table>

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
<th>Acciones</th>
</tr>

<?php

$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conexion,$sql);

while($usuario = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $usuario['id']; ?></td>

<td><?php echo $usuario['nombre']; ?></td>

<td><?php echo $usuario['correo']; ?></td>

<td><?php echo $usuario['rol']; ?></td>

<td>

<a class="boton" href="../data/hacer_admin.php?id=<?php echo $usuario['id']; ?>">
Hacer Admin
</a>

<a class="boton boton-rojo" href="../data/eliminar_usuario.php?id=<?php echo $usuario['id']; ?>">
Eliminar
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<script>

const ctx = document.getElementById('graficaSistema');

new Chart(ctx, {
type: 'bar',
data: {
labels: ['Usuarios','Comentarios','Admins'],
datasets: [{
label: 'Estadísticas EcoWeb',
data: [<?php echo $totalUsuarios; ?>,<?php echo $totalComentarios; ?>,<?php echo $totalAdmins; ?>],
borderWidth: 1
}]
},
options: {
scales: {
y: {
beginAtZero: true
}
}
}
});

</script>

</body>
</html>