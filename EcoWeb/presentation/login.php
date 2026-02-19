<?php
// Incluir seguridad Y conexión ANTES del header
require_once "../data/seguridad.php";
require_once "../data/conexion.php";
require_once "../data/usuarios_model.php";

// Iniciar sesión AQUÍ, antes de cualquier output
iniciarSesionSegura();

// AHORA incluir el header
include "layout/header.php";

$mensaje = "";

/* ================= LOGIN ================= */
if(isset($_POST['login'])){
    // Validar token CSRF
    if (!isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])) {
        $mensaje = "Token de seguridad inválido. Intenta de nuevo.";
    } else {
        $correo = sanitizarEntrada($_POST['correo']);
        $password = $_POST['password'];

        $usuario = loginUsuario($correo, $password);

        if($usuario){
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = escaparHTML($usuario['nombre']);
            $_SESSION['rol'] = $usuario['rol'];

            header("Location: index.php");
            exit();
        } else {
            $mensaje = "Credenciales incorrectas o demasiados intentos. Intenta después.";
        }
    }
}

/* ================= REGISTRO ================= */
if(isset($_POST['registro'])){
    // Validar token CSRF
    if (!isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])) {
        $mensaje = "Token de seguridad inválido. Intenta de nuevo.";
    } else {
        $nombre = sanitizarEntrada($_POST['nombre']);
        $correo = sanitizarEntrada($_POST['correo']);
        $password = $_POST['password'];
        $confirmar_password = $_POST['confirmar_password'] ?? '';

        // Validar que las contraseñas coincidan
        if ($password !== $confirmar_password) {
            $mensaje = "Las contraseñas no coinciden";
        } else {
            $resultado = registrarUsuario($nombre, $correo, $password);
            if ($resultado['exito']) {
                $mensaje = "Registro exitoso. Por favor, inicia sesión.";
            } else {
                $mensaje = $resultado['error'];
            }
        }
    }
}

/* ================= RECUPERAR ================= */
if(isset($_POST['recuperar'])){
    // Validar token CSRF
    if (!isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])) {
        $mensaje = "Token de seguridad inválido. Intenta de nuevo.";
    } else {
        $correo = sanitizarEntrada($_POST['correo']);
        $password = $_POST['password'];
        $confirmar_password = $_POST['confirmar_password'] ?? '';

        // Validar que las contraseñas coincidan
        if ($password !== $confirmar_password) {
            $mensaje = "Las contraseñas no coinciden";
        } else {
            // Validar email
            if (!validarEmail($correo)) {
                $mensaje = "Email inválido";
            } else {
                // Validar contraseña
                $validacion = validarPassword($password);
                if ($validacion !== true) {
                    $mensaje = $validacion;
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE usuarios SET password = ? WHERE correo = ?";
                    $stmt = conexion->prepare($sql);
                    
                    if ($stmt) {
                        $stmt->bind_param("ss", $passwordHash, $correo);
                        if ($stmt->execute() && $stmt->affected_rows > 0) {
                            $mensaje = "Contraseña actualizada. Por favor, inicia sesión.";
                        } else {
                            $mensaje = "Correo no encontrado.";
                        }
                    } else {
                        $mensaje = "Error en la base de datos";
                    }
                }
            }
        }
    }
}

// Generar token CSRF para formularios
$token_csrf = generarTokenCSRF();
?>

<section class="form-container">

<h2>Acceso EcoWeb</h2>

<?php if($mensaje != "") echo "<p style='color:red; padding: 10px; background: #ffe6e6; border-radius: 5px;'>" . escaparHTML($mensaje) . "</p>"; ?>

<!-- LOGIN (VISIBLE) -->
<form method="POST" id="loginForm" class="formulario activo">
    <input type="hidden" name="csrf_token" value="<?php echo escaparHTML($token_csrf); ?>">
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
    <input type="hidden" name="csrf_token" value="<?php echo escaparHTML($token_csrf); ?>">
    <input type="text" name="nombre" placeholder="Nombre (mín. 3 caracteres)" required>
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Contraseña (mín. 6 caracteres, con mayúscula y número)" required>
    <input type="password" name="confirmar_password" placeholder="Confirmar contraseña" required>
    <button type="submit" name="registro">Crear cuenta</button>
    <button type="button" onclick="mostrar('loginForm')">Volver</button>
</form>

<!-- RECUPERAR (OCULTO) -->
<form method="POST" id="recuperarForm" class="formulario">
    <h3>Recuperar Contraseña</h3>
    <input type="hidden" name="csrf_token" value="<?php echo escaparHTML($token_csrf); ?>">
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Nueva contraseña" required>
    <input type="password" name="confirmar_password" placeholder="Confirmar contraseña" required>
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
