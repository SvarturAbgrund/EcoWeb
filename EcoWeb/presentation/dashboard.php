
<?php
/* =====================================================
   INICIO DE SESIÓN Y VALIDACIÓN DE ADMIN
===================================================== */

session_start();
require_once "../data/conexion.php";

/* Verificar que el usuario sea administrador */
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != "admin"){
    header("Location: index.php");
    exit();
}


/* =====================================================
   CONSULTAS PARA ESTADÍSTICAS
===================================================== */

$totalUsuarios = mysqli_fetch_assoc(
    mysqli_query($conexion,"SELECT COUNT(*) as total FROM usuarios")
)['total'];

$totalComentarios = mysqli_fetch_assoc(
    mysqli_query($conexion,"SELECT COUNT(*) as total FROM comentarios")
)['total'];

$totalAdmins = mysqli_fetch_assoc(
    mysqli_query($conexion,"SELECT COUNT(*) as total FROM usuarios WHERE rol='admin'")
)['total'];

?>

<!DOCTYPE html>
<html>

<head>

<title>Dashboard Administrador</title>

<!-- CSS general del sitio -->
<link rel="stylesheet" href="../public/css/estilos.css">

<!-- Librería para gráficas -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<style>

/* =====================================================
   CONTENEDOR PRINCIPAL DEL DASHBOARD
===================================================== */

.dashboard{
width:90%;
margin:auto;
margin-top:30px;
}


/* =====================================================
   TARJETAS DE ESTADÍSTICAS
===================================================== */

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


/* =====================================================
   CONTENEDOR DE GRÁFICAS
===================================================== */

.grafica-box{
background:white;
padding:25px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,0.2);
margin-bottom:40px;
text-align:center;
}

.grafica-box canvas{
max-width:100%;
}


/* =====================================================
   TABLA DE USUARIOS
===================================================== */

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


/* =====================================================
   BOTONES DE ACCIONES
===================================================== */

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

<!-- HEADER DEL SITIO -->
<?php include "../presentation/layout/header.php"; ?>


<div class="dashboard">

<h2>Panel de Administrador</h2>


<!-- =====================================================
     TARJETAS DE ESTADÍSTICAS
===================================================== -->

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


<!-- =====================================================
     GRÁFICA DEL SISTEMA
===================================================== -->

<div class="grafica-box">

<h3>Estadísticas EcoWeb</h3>

<canvas id="graficaSistema"></canvas>

</div>



<!-- =====================================================
     TABLA DE USUARIOS
===================================================== -->

<div class="tabla">

<h3>Usuarios registrados</h3>

<!-- BUSCADOR DE USUARUOS -->
<input type="text" id="buscarUsuario" placeholder="🔎 Buscar usuario..." onkeyup="buscarUsuarios()" style="
width:100%;
padding:10px;
margin-bottom:15px;
border-radius:6px;
border:1px solid #ccc;
">

<table id="tablaUsuarios">

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

<?php if($usuario['rol'] != 'admin'){ ?>

<a class="boton" href="../data/hacer_admin.php?id=<?php echo $usuario['id']; ?>">
Hacer Admin
</a>

<?php } ?>

<a class="boton boton-rojo" href="../data/eliminar_usuario.php?id=<?php echo $usuario['id']; ?>">
Eliminar
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>



<!-- =====================================================
     SCRIPT 1: GRÁFICA DEL SISTEMA (Chart.js)
     Muestra estadísticas de usuarios, comentarios y admins
===================================================== -->

<script>

const ctx = document.getElementById('graficaSistema');

new Chart(ctx, {

type: 'bar',

data: {

labels: ['Usuarios','Comentarios','Admins'],

datasets: [{

label: 'Estadísticas EcoWeb',

data: [
<?php echo $totalUsuarios; ?>,
<?php echo $totalComentarios; ?>,
<?php echo $totalAdmins; ?>
],

borderWidth: 1

}]

},

options: {

plugins:{
legend:{
labels:{
color:"black",
font:{
size:16
}
}
}
},

scales:{

x:{
ticks:{
color:"black",
font:{
size:14
}
}
},

y:{
beginAtZero:true,
ticks:{
color:"black",
font:{
size:14
}
}
}

}

}

});

</script>



<!-- =====================================================
     SCRIPT 2: BUSCADOR DE USUARIOS
     Filtra usuarios en tiempo real dentro de la tabla
===================================================== -->

<script>

function buscarUsuarios(){

// Obtener texto del buscador
let input = document.getElementById("buscarUsuario").value.toLowerCase();

// Obtener tabla
let tabla = document.getElementById("tablaUsuarios");

// Obtener filas de la tabla
let filas = tabla.getElementsByTagName("tr");


// Recorrer filas (se salta la primera que es el encabezado)
for(let i = 1; i < filas.length; i++){

let textoFila = filas[i].textContent.toLowerCase();

// Mostrar u ocultar fila según coincidencia
if(textoFila.indexOf(input) > -1){
filas[i].style.display = "";
}else{
filas[i].style.display = "none";
}

}

}

</script>



</body>
</html>

