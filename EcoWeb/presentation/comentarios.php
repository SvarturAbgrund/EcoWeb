<?php
// Inicializar seguridad ANTES de cualquier output
require_once "../data/seguridad.php";
require_once "../data/conexion.php";
require_once "../data/comentarios_model.php";

// Iniciar sesión segura antes del header
iniciarSesionSegura();

// AHORA incluir header
include "layout/header.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

$mensaje = "";

/* AGREGAR COMENTARIO */
if(isset($_POST['comentar'])){
    // Validar token CSRF
    if (!isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])) {
        $mensaje = "Token de seguridad inválido.";
    } else {
        $comentario = sanitizarEntrada($_POST['comentario']);
        $usuario_id = $_SESSION['id'];

        $resultado = insertarComentario($usuario_id, $comentario);
        if (!$resultado['exito']) {
            $mensaje = $resultado['error'];
        }
    }
}

/* RESPONDER */
if(isset($_POST['responder'])){
    // Validar token CSRF
    if (!isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])) {
        $mensaje = "Token de seguridad inválido.";
    } else if ($_SESSION['rol'] !== 'admin') {
        $mensaje = "Solo administradores pueden responder.";
    } else {
        $respuesta = sanitizarEntrada($_POST['respuesta']);
        $comentario_id = intval($_POST['comentario_id']);

        $resultado = insertarRespuesta($comentario_id, $respuesta);
        if (!$resultado['exito']) {
            $mensaje = $resultado['error'];
        }
    }
}

/* BORRAR SOLO ADMIN */
if(isset($_POST['borrar'])){
    // Validar token CSRF
    if (!isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])) {
        $mensaje = "Token de seguridad inválido.";
    } else if ($_SESSION['rol'] !== 'admin') {
        $mensaje = "Solo administradores pueden borrar.";
    } else {
        $comentario_id = intval($_POST['comentario_id']);
        
        $resultado = eliminarComentario($comentario_id);
        if (!$resultado['exito']) {
            $mensaje = $resultado['error'];
        }
    }
}

// Generar token CSRF
$token_csrf = generarTokenCSRF();

// Obtener comentarios
$resultado = obtenerComentarios();
?>

<section>
<h2>Comentarios</h2>

<?php if(!empty($mensaje)) { ?>
    <p style="color:red; padding: 10px; background: #ffe6e6; border-radius: 5px;">
        <?php echo escaparHTML($mensaje); ?>
    </p>
<?php } ?>

<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo escaparHTML($token_csrf); ?>">
    <textarea name="comentario" placeholder="Escribe un comentario (mín. 5 caracteres)..." required></textarea>
    <button type="submit" name="comentar">Comentar</button>
</form>

<hr>

<?php while($row = $resultado->fetch_assoc()){ ?>

<div class="comentario">
    <strong><?php echo escaparHTML($row['nombre'] ?? 'Anónimo'); ?></strong>
    <small><?php echo escaparHTML(date('d/m/Y H:i', strtotime($row['fecha']))); ?></small>
    <p><?php echo nl2br(escaparHTML($row['comentario'])); ?></p>

    <?php if(!empty($row['respuesta'])){ ?>
        <div class="respuesta">
            <strong>Respuesta del Admin:</strong>
            <p><?php echo nl2br(escaparHTML($row['respuesta'])); ?></p>
        </div>
    <?php } ?>

    <?php if($_SESSION['rol']=='admin'){ ?>
        <form method="POST" style="margin-top: 10px;">
            <input type="hidden" name="csrf_token" value="<?php echo escaparHTML($token_csrf); ?>">
            <input type="hidden" name="comentario_id" value="<?php echo escaparHTML($row['id']); ?>">
            <textarea name="respuesta" placeholder="Responder..." required></textarea>
            <button type="submit" name="responder">Responder</button>
        </form>

        <form method="POST" style="display: inline;">
            <input type="hidden" name="csrf_token" value="<?php echo escaparHTML($token_csrf); ?>">
            <input type="hidden" name="comentario_id" value="<?php echo escaparHTML($row['id']); ?>">
            <button type="submit" name="borrar" style="background:red;color:white;" 
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?');">
                Borrar
            </button>
        </form>
    <?php } ?>

</div>
<hr>

<?php } ?>
</section>
