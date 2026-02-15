<?php
include "layout/header.php";
require_once "../data/conexion.php";

$mensaje = "";

/* ================= LOGIN ================= */
if(isset($_POST['login'])){
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);

    if(!$stmt){
        die("Error SQL: " . $conexion->error);
    }

    $stmt->bind_param("s",$correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){
        $usuario = $resultado->fetch_assoc();

        if(password_verify($password, $usuario['password'])){
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            header("Location: index.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta";
        }
    } else {
        $mensaje = "Usuario no encontrado";
    }
}

/* ================= REGISTRO ================= */
if(isset($_POST['registro'])){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios(nombre,correo,password,rol) VALUES(?,?,?, 'usuario')";
    $stmt = $conexion->prepare($sql);

    if(!$stmt){
        die("Error SQL: " . $conexion->error);
    }

    $stmt->bind_param("sss",$nombre,$correo,$password);

    if($stmt->execute()){
        $mensaje = "Registro exitoso.";
    } else {
        $mensaje = "Error al registrarse.";
    }
}

/* ================= RECUPERAR ================= */
if(isset($_POST['recuperar'])){
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET password = ? WHERE correo = ?";
    $stmt = $conexion->prepare($sql);

    if(!$stmt){
        die("Error SQL: " . $conexion->error);
    }

    $stmt->bind_param("ss",$password,$correo);

    if($stmt->execute()){
        $mensaje = "Contraseña actualizada.";
    } else {
        $mensaje = "Correo no encontrado.";
    }
}
?>

<section class="form-container">

<h2>Acceso EcoWeb</h2>

<?php if($mensaje != "") echo "<p style='color:red;'>$mensaje</p>"; ?>

<!-- LOGIN (VISIBLE) -->
<form method="POST" id="loginForm" class="formulario activo">
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit" name="login">Ingresar</button>

    <div class="links">
        <button type="button" onclick="mostrar('registroForm')">Registrarse</button>
        <button type="button" onclick="mostrar('recuperarForm')">¿Olvidaste tu contraseña?</button>
    </div>
</form>

<!-- REGISTRO (OCULTO) -->
<form method="POST" id="registroForm" class="formulario">
    <h3>Registrarse</h3>
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit" name="registro">Crear cuenta</button>
    <button type="button" onclick="mostrar('loginForm')">Volver</button>
</form>

<!-- RECUPERAR (OCULTO) -->
<form method="POST" id="recuperarForm" class="formulario">
    <h3>Recuperar Contraseña</h3>
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Nueva contraseña" required>
    <button type="submit" name="recuperar">Actualizar</button>
    <button type="button" onclick="mostrar('loginForm')">Volver</button>
</form>

</section>

<script>
function mostrar(id){
    document.querySelectorAll('.formulario').forEach(form=>{
        form.classList.remove('activo');
    });
    document.getElementById(id).classList.add('activo');
}
</script>
