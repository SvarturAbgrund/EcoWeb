<?php
/**
 * Archivo: seguridad.php
 * Propósito: Centralizar funciones de seguridad
 * - Prevención de XSS (escapado de HTML)
 * - Tokens CSRF
 * - Validación de entrada
 */

// ====== 1. PREVENCIÓN DE XSS ======
/**
 * Escapa datos para mostrar en HTML de forma segura
 * Previene que scripts maliciosos se ejecuten
 */
function escaparHTML($datos) {
    return htmlspecialchars($datos, ENT_QUOTES, 'UTF-8');
}

// ====== 2. TOKENS CSRF ======
/**
 * Inicia la sesión de forma segura con cookies HttpOnly
 * DEBE SER LLAMADO ANTES DE CUALQUIER output o session_start()
 */
function iniciarSesionSegura() {
    // Si la sesión aún no está iniciada, configurar parámetros ANTES
    if (session_status() === PHP_SESSION_NONE) {
        // Configurar cookies de sesión de forma segura
        session_set_cookie_params([
            'httponly' => true,  // ✅ No se puede acceder desde JavaScript
            'secure' => false,   // En producción sería true (HTTPS)
            'samesite' => 'Strict' // ✅ Previene CSRF
        ]);
        session_start();
        
        // Marcar sesión como iniciada con seguridad
        $_SESSION['_secure_session'] = true;
    }
    // Si ya está iniciada, verificar headers para aplicar protección retroactivamente
    else if (!isset($_SESSION['_secure_session'])) {
        // Configurar headers para proteger la cookie existente
        // (no es ideal, pero es mejor que nada)
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}

/**
 * Genera un token CSRF y lo almacena en sesión
 */
function generarTokenCSRF() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Obtiene el token CSRF de la sesión
 */
function obtenerTokenCSRF() {
    return isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
}

/**
 * Valida que el token CSRF enviado sea válido
 */
function validarTokenCSRF($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    // Usar hash_equals para evitar timing attacks
    return hash_equals($_SESSION['csrf_token'], $token);
}

// ====== 3. VALIDACIÓN DE ENTRADA ======
/**
 * Valida que un email sea válido
 */
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Valida que una contraseña cumpla requisitos mínimos (proyecto escolar)
 * - Mínimo 6 caracteres
 * - Al menos 1 número
 * - Al menos 1 mayúscula
 */
function validarPassword($password) {
    if (strlen($password) < 6) {
        return "La contraseña debe tener al menos 6 caracteres";
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        return "La contraseña debe tener al menos 1 mayúscula";
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        return "La contraseña debe tener al menos 1 número";
    }
    
    return true;
}

/**
 * Valida que un nombre no esté vacío y sea razonable
 */
function validarNombre($nombre) {
    // Eliminar espacios extras
    $nombre = trim($nombre);
    
    if (strlen($nombre) < 3) {
        return "El nombre debe tener al menos 3 caracteres";
    }
    
    if (strlen($nombre) > 100) {
        return "El nombre no puede exceder 100 caracteres";
    }
    
    if (!preg_match('/^[a-zA-Z\s\á\é\í\ó\ú\Á\É\Í\Ó\Ú ]+$/u', $nombre)) {
        return "El nombre solo puede contener letras y espacios";
    }
    
    return true;
}

/**
 * Valida que un comentario sea válido
 */
function validarComentario($comentario) {
    $comentario = trim($comentario);
    
    if (strlen($comentario) < 5) {
        return "El comentario debe tener al menos 5 caracteres";
    }
    
    if (strlen($comentario) > 2000) {
        return "El comentario no puede exceder 2000 caracteres";
    }
    
    return true;
}

// ====== 4. SANITIZACIÓN ======
/**
 * Limpia entrada del usuario eliminando caracteres peligrosos
 */
function sanitizarEntrada($dato) {
    // Eliminar espacios en blanco al inicio y final
    $dato = trim($dato);
    
    // Eliminar barras invertidas
    $dato = stripslashes($dato);
    
    // Decriptar comillas especiales
    $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
    
    return $dato;
}

// ====== 5. RATE LIMITING SIMPLE (Anti Fuerza Bruta) ======
/**
 * Verifica si se ha excedido el límite de intentos fallidos
 * Para proteger contra ataques de fuerza bruta
 */
function verificarRateLimiting($clave_intento, $max_intentos = 5, $tiempo_espera = 300) {
    if (!isset($_SESSION['intentos'])) {
        $_SESSION['intentos'] = [];
    }
    
    $ahora = time();
    
    // Limpiar intentos antiguos
    if (isset($_SESSION['intentos'][$clave_intento])) {
        $_SESSION['intentos'][$clave_intento] = array_filter(
            $_SESSION['intentos'][$clave_intento],
            function($tiempo) use ($ahora, $tiempo_espera) {
                return ($ahora - $tiempo) < $tiempo_espera;
            }
        );
    }
    
    // Verificar si se excedió el límite
    if (!isset($_SESSION['intentos'][$clave_intento])) {
        $_SESSION['intentos'][$clave_intento] = [];
    }
    
    if (count($_SESSION['intentos'][$clave_intento]) >= $max_intentos) {
        return false; // Demasiados intentos
    }
    
    return true;
}

/**
 * Registra un intento fallido
 */
function registrarIntentoFallido($clave_intento) {
    if (!isset($_SESSION['intentos'])) {
        $_SESSION['intentos'] = [];
    }
    
    if (!isset($_SESSION['intentos'][$clave_intento])) {
        $_SESSION['intentos'][$clave_intento] = [];
    }
    
    $_SESSION['intentos'][$clave_intento][] = time();
}

/**
 * Reinicia los intentos fallidos (login exitoso)
 */
function limpiarIntentos($clave_intento) {
    if (isset($_SESSION['intentos'][$clave_intento])) {
        unset($_SESSION['intentos'][$clave_intento]);
    }
}

?>
