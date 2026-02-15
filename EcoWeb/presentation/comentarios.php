<?php
include "layout/header.php";
require_once "../data/conexion.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

/* AGREGAR */
if(isset($_POST['comentar'])){
    $comentario = $_POST['comentario'];
    $usuario_id = $_SESSION['id'];

    $sql = "INSERT INTO comentarios (usuario_id, comentario) VALUES (?,?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("is",$usuario_id,$comentario);
    $stmt->execute();
}

/* RESPONDER */
if(isset($_POST['responder'])){
    $respuesta = $_POST['respuesta'];
    $comentario_id = $_POST['comentario_id'];

    $sql = "UPDATE comentarios SET respuesta=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si",$respuesta,$comentario_id);
    $stmt->execute();
}

/* BORRAR SOLO ADMIN */
if(isset($_POST['borrar']) && $_SESSION['rol']=='admin'){
    $comentario_id = $_POST['comentario_id'];

    $sql = "DELETE FROM comentarios WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i",$comentario_id);
    $stmt->execute();
}

$sql = "SELECT c.*, u.nombre 
        FROM comentarios c
        JOIN usuarios u ON c.usuario_id = u.id
        ORDER BY c.id DESC";

$resultado = $conexion->query($sql);
?>

<section>
<h2>Comentarios</h2>

<form method="POST">
    <textarea name="comentario" placeholder="Escribe un comentario..." required></textarea>
    <button type="submit" name="comentar">Comentar</button>
</form>

<hr>

<?php while($row = $resultado->fetch_assoc()){ ?>

<div class="comentario">
    <strong><?php echo $row['nombre']; ?></strong>
    <p><?php echo $row['comentario']; ?></p>

    <?php if($row['respuesta']){ ?>
        <div class="respuesta">
            <strong>Respuesta:</strong>
            <p><?php echo $row['respuesta']; ?></p>
        </div>
    <?php } ?>

    <form method="POST">
        <input type="hidden" name="comentario_id" value="<?php echo $row['id']; ?>">
        <textarea name="respuesta" placeholder="Responder..."></textarea>
        <button type="submit" name="responder">Responder</button>
    </form>

    <?php if($_SESSION['rol']=='admin'){ ?>
        <form method="POST">
            <input type="hidden" name="comentario_id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="borrar" style="background:red;color:white;">
                Borrar
            </button>
        </form>
    <?php } ?>

</div>
<hr>

<?php } ?>
</section>
