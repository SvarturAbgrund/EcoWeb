<?php
session_start();
require_once "../data/conexion.php";

if($_SESSION['rol'] != "admin"){
    header("Location:index.php");
    exit();
}

$comentarios = mysqli_query($conexion,"SELECT * FROM comentarios");
?>

<h2>Comentarios</h2>

<table border="1">

<tr>
<th>ID</th>
<th>Usuario</th>
<th>Comentario</th>
<th>Acción</th>
</tr>

<?php while($c = mysqli_fetch_assoc($comentarios)){ ?>

<tr>

<td><?php echo $c['id']; ?></td>
<td><?php echo $c['usuario']; ?></td>
<td><?php echo $c['comentario']; ?></td>

<td>

<a href="../data/eliminar_comentario.php?id=<?php echo $c['id']; ?>">
Eliminar
</a>

</td>

</tr>

<?php } ?>

</table>