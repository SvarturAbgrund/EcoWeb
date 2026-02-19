<?php
// Inicializar seguridad ANTES de cualquier output
require_once "../data/seguridad.php";
require_once "../data/conexion.php";

// Iniciar sesión segura antes del header
iniciarSesionSegura();

// AHORA incluir header
include "layout/header.php";

$mensaje = "";

/* PROCESAR FORMULARIO DE CONTACTO */
if(isset($_POST['enviar_contacto'])){
    // Validar token CSRF
    if (!isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])) {
        $mensaje = "Token de seguridad inválido.";
    } else {
        $nombre = sanitizarEntrada($_POST['nombre']);
        $correo = sanitizarEntrada($_POST['correo']);
        $asunto = sanitizarEntrada($_POST['asunto']);
        $mensaje_contenido = sanitizarEntrada($_POST['mensaje']);

        // Validar entrada
        $errores = [];
        
        if (strlen($nombre) < 3 || strlen($nombre) > 100) {
            $errores[] = "El nombre debe tener entre 3 y 100 caracteres";
        }
        
        if (!validarEmail($correo)) {
            $errores[] = "El email no es válido";
        }
        
        if (strlen($asunto) < 5 || strlen($asunto) > 200) {
            $errores[] = "El asunto debe tener entre 5 y 200 caracteres";
        }
        
        if (strlen($mensaje_contenido) < 10 || strlen($mensaje_contenido) > 5000) {
            $errores[] = "El mensaje debe tener entre 10 y 5000 caracteres";
        }

        if (!empty($errores)) {
            $mensaje = implode(". ", $errores);
        } else {
            // Guardar en base de datos (opcional - para guardar historial)
            $usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
            
            $sql = "INSERT INTO comentarios (usuario_id, nombre, correo, comentario) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            
            if ($stmt) {
                $tipo_mensaje = "[CONTACTO] " . $asunto;
                $stmt->bind_param("isss", $usuario_id, $nombre, $correo, $tipo_mensaje);
                $stmt->execute();
                
                // En un proyecto real, enviarías un email aquí con mail() o phpMailer
                // Para este proyecto escolar, solo confirmamos que se guardó
                $mensaje = "Mensaje enviado correctamente. Nos pondremos en contacto pronto.";
            } else {
                $mensaje = "Error al procesar tu solicitud. Intenta de nuevo.";
            }
        }
    }
}

// Generar token CSRF
$token_csrf = generarTokenCSRF();
?>
<link rel="stylesheet" href="../public/css/estilos.css">

<section>
    <h2>Contacto</h2>
    <p>Si tienes dudas o sugerencias sobre nuestro proyecto EcoWeb, completa el formulario a continuación:</p>

    <?php if(!empty($mensaje)) { ?>
        <p style="color: <?php echo strpos($mensaje, 'correctamente') !== false ? 'green' : 'red'; ?>; 
                  padding: 10px; background: <?php echo strpos($mensaje, 'correctamente') !== false ? '#e6ffe6' : '#ffe6e6'; ?>; 
                  border-radius: 5px;">
            <?php echo escaparHTML($mensaje); ?>
        </p>
    <?php } ?>

    <form method="POST" style="max-width: 600px; margin: 20px auto;">
        <input type="hidden" name="csrf_token" value="<?php echo escaparHTML($token_csrf); ?>">
        
        <div style="margin-bottom: 15px;">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Tu nombre completo" required 
                   minlength="3" maxlength="100">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="correo">Email:</label>
            <input type="email" id="correo" name="correo" placeholder="tu@email.com" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="asunto">Asunto:</label>
            <input type="text" id="asunto" name="asunto" placeholder="¿Cuál es tu consulta?" required 
                   minlength="5" maxlength="200">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" placeholder="Describe tu mensaje aquí (mínimo 10 caracteres)" 
                      required minlength="10" maxlength="5000" style="width: 100%; height: 150px;"></textarea>
        </div>

        <button type="submit" name="enviar_contacto">Enviar Mensaje</button>
    </form>

    <div style="margin-top: 30px; padding: 20px; background: #f0f0f0; border-radius: 5px;">
        <h3>Información de Contacto</h3>
        <p><strong>Email principal:</strong> contacto@ecoweb.com</p>
        <p><strong>Teléfono:</strong> +XX-XXX-XXX-XXXX</p>
        <p><strong>Dirección:</strong> Calle Principal 123, Ciudad</p>
    </div>
</section>
