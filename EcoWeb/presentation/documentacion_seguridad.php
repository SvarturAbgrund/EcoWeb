<?php
// Inicializar seguridad ANTES del header
require_once "../data/seguridad.php";
require_once "../data/conexion.php";

// Iniciar sesión segura
iniciarSesionSegura();

// Documento de Seguridad - Acceso restringido a admin
include "layout/header.php";

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentación de Seguridad - EcoWeb</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1, h2 { color: #2c5f2d; }
        .section { margin: 30px 0; }
        .vulnerability { 
            background: #ffe6e6; 
            padding: 15px; 
            border-left: 4px solid #d32f2f;
            margin: 10px 0;
            border-radius: 4px;
        }
        .control { 
            background: #e6f7ff; 
            padding: 15px; 
            border-left: 4px solid #1976d2;
            margin: 10px 0;
            border-radius: 4px;
        }
        .recommendation { 
            background: #fff3e0; 
            padding: 15px; 
            border-left: 4px solid #f57c00;
            margin: 10px 0;
            border-radius: 4px;
        }
        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2c5f2d;
            color: white;
        }
        .btn-print {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .btn-print:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">📄 Imprimir Documento</button>
    
    <div class="container">
        <h1>📋 Documentación de Seguridad - EcoWeb</h1>
        <p><strong>Proyecto Escolar:</strong> Página Web Segura con PHP y MySQL</p>
        <p><strong>Fecha:</strong> Febrero 2026</p>
        <hr>

        <!-- ====================================== -->
        <div class="section">
            <h2>1️⃣ Vulnerabilidades sin Medidas de Seguridad</h2>
            
            <h3>🔴 Inyección SQL (SQL Injection)</h3>
            <div class="vulnerability">
                <strong>¿Qué es?</strong> Insertar código SQL malicioso en campos de entrada.
                <br><br>
                <strong>Ejemplo sin protección:</strong>
                <code>SELECT * FROM usuarios WHERE correo = '" . $_POST['correo'] . "';</code>
                <br><br>
                <strong>Ataque:</strong> Usuario ingresa: <code>' OR '1'='1</code>
                <br>La consulta se vuelve: <code>SELECT * FROM usuarios WHERE correo = '' OR '1'='1';</code>
                <br><strong>Resultado:</strong> Devuelve todos los usuarios de la base de datos.
                <br><br>
                <strong>Impacto:</strong> ⚠️ Alta - Acceso no autorizado a datos, eliminación de datos, modificación de información.
            </div>

            <h3>🔴 Cross-Site Scripting (XSS)</h3>
            <div class="vulnerability">
                <strong>¿Qué es?</strong> Insertar código JavaScript malicioso que se ejecuta en el navegador.
                <br><br>
                <strong>Ejemplo sin protección:</strong>
                <code>&lt;?php echo $comentario; ?&gt;</code>
                <br><br>
                <strong>Ataque:</strong> Usuario ingresa en comentario: <code>&lt;script&gt;alert('Hackeado!')&lt;/script&gt;</code>
                <br><strong>Resultado:</strong> El script se ejecuta en el navegador de otros usuarios.
                <br><br>
                <strong>Impacto:</strong> ⚠️ Alta - Robo de cookies/sesiones, redirección a sitios maliciosos, phishing.
            </div>

            <h3>🔴 Cross-Site Request Forgery (CSRF)</h3>
            <div class="vulnerability">
                <strong>¿Qué es?</strong> Engañar al usuario para ejecutar acciones sin su consentimiento.
                <br><br>
                <strong>Ejemplo:</strong> Usuario logueado en EcoWeb. Un atacante lo engaña a visitar un sitio malicioso que envía un formulario oculto a EcoWeb (cambiar contraseña, borrar datos).
                <br><br>
                <strong>Impacto:</strong> ⚠️ Media-Alta - Modificación no autorizada de datos.
            </div>

            <h3>🔴 Falta de Validación de Entrada</h3>
            <div class="vulnerability">
                <strong>¿Qué es?</strong> Aceptar cualquier dato sin verificar si es válido.
                <br><br>
                <strong>Ejemplos:</strong>
                <ul>
                    <li>Email sin formato válido</li>
                    <li>Contraseña muy débil</li>
                    <li>Nombres con caracteres especiales peligrosos</li>
                    <li>Campos vacíos o demasiado largos</li>
                </ul>
                <strong>Impacto:</strong> ⚠️ Media - Datos inconsistentes, confusión, posibles errores.
            </div>

            <h3>🔴 Contraseñas Débiles o sin Hash</h3>
            <div class="vulnerability">
                <strong>¿Qué es?</strong> Guardar contraseñas en texto plano o con hash débil (MD5, SHA1).
                <br><br>
                <strong>Impacto:</strong> ⚠️ Crítica - Si alguien accede a la BD, obtiene todas las contraseñas.
            </div>

            <h3>🔴 Sesiones Inseguras</h3>
            <div class="vulnerability">
                <strong>¿Qué es?</strong> Cookies accesibles desde JavaScript, sin HTTPS, sin protección SameSite.
                <br><br>
                <strong>Impacto:</strong> ⚠️ Alta - Robo de sesión mediante XSS o ataques CSRF.
            </div>

            <h3>🔴 Mensajes de Error Informativos</h3>
            <div class="vulnerability">
                <strong>¿Qué es?</strong> Mostrar errores técnicos detallados que revelan estructura del sistema.
                <br><br>
                <strong>Ejemplo:</strong> "Error: MySQL 5.7 en tabla usuarios al conectarse al puerto 3306"
                <br><br>
                <strong>Impacto:</strong> ⚠️ Media - Facilita el reconocimiento del sistema para ataques.
            </div>

            <h3>🔴 Falta de Rate Limiting</h3>
            <div class="vulnerability">
                <strong>¿Qué es?</strong> No limitar intentos de login fallidos.
                <br><br>
                <strong>Ataque:</strong> Ataques de fuerza bruta (probar miles de combinaciones contraseña).
                <br><br>
                <strong>Impacto:</strong> ⚠️ Media - Compromiso de cuentas.
            </div>
        </div>

        <!-- ====================================== -->
        <div class="section">
            <h2>2️⃣ Controles de Seguridad Implementados</h2>

            <h3>✅ 1. Prevención de Inyección SQL</h3>
            <div class="control">
                <strong>Técnica:</strong> Consultas Preparadas (Prepared Statements)
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <pre><code>$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo=?");
$stmt->bind_param("s", $correo);
$stmt->execute();</code></pre>
                <br>
                <strong>¿Por qué funciona?</strong> El SQL se compila ANTES de insertar los datos. Los datos se agregan como parámetros seguros, no como parte del código SQL.
                <br><br>
                <strong>Archivo:</strong> <code>data/usuarios_model.php</code>, <code>presentation/comentarios.php</code>
            </div>

            <h3>✅ 2. Prevención de XSS</h3>
            <div class="control">
                <strong>Técnica:</strong> Escape de HTML con <code>htmlspecialchars()</code>
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <pre><code>function escaparHTML($datos) {
    return htmlspecialchars($datos, ENT_QUOTES, 'UTF-8');
}</code></pre>
                <br>
                <strong>Uso:</strong>
                <pre><code>&lt;?php echo escaparHTML($row['comentario']); ?&gt;</code></pre>
                <br>
                <strong>¿Por qué funciona?</strong> Convierte caracteres especiales (< > " ') en entidades HTML (&lt; &gt; &quot; &apos;), evitando que se ejecuten como código.
                <br><br>
                <strong>Archivo:</strong> <code>data/seguridad.php</code>, <code>presentation/comentarios.php</code>
            </div>

            <h3>✅ 3. Protección contra CSRF</h3>
            <div class="control">
                <strong>Técnica:</strong> Tokens CSRF únicos por sesión
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <pre><code>// Generar token
$token_csrf = generarTokenCSRF();

// En formulario
&lt;input type="hidden" name="csrf_token" value="&lt;?php echo $token_csrf; ?&gt;"&gt;

// Validar antes de procesar
if (!validarTokenCSRF($_POST['csrf_token'])) {
    die("CSRF inválido");
}</code></pre>
                <br>
                <strong>¿Por qué funciona?</strong> Un atacante externo no puede generar el token porque no tiene acceso a la sesión del usuario.
                <br><br>
                <strong>Archivo:</strong> <code>data/seguridad.php</code>, todos los formularios
            </div>

            <h3>✅ 4. Validación de Entrada</h3>
            <div class="control">
                <strong>Técnica:</strong> Validar formato y límites de datos
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <ul>
                    <li><code>validarEmail()</code> - Verifica formato válido</li>
                    <li><code>validarPassword()</code> - Requiere 6+ caracteres, mayúscula y número</li>
                    <li><code>validarNombre()</code> - 3-100 caracteres, solo letras</li>
                    <li><code>validarComentario()</code> - 5-2000 caracteres</li>
                </ul>
                <br>
                <strong>Archivo:</strong> <code>data/seguridad.php</code>
            </div>

            <h3>✅ 5. Sanitización de Entrada</h3>
            <div class="control">
                <strong>Técnica:</strong> Limpiar datos eliminando caracteres peligrosos
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <pre><code>function sanitizarEntrada($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
    return $dato;
}</code></pre>
                <br>
                <strong>Archivo:</strong> <code>data/seguridad.php</code>
            </div>

            <h3>✅ 6. Hash Seguro de Contraseñas</h3>
            <div class="control">
                <strong>Técnica:</strong> <code>password_hash()</code> con bcrypt
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <pre><code>// Guardar contraseña
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Verificar contraseña
if (password_verify($password, $usuario['password'])) {
    // Contraseña correcta
}</code></pre>
                <br>
                <strong>¿Por qué es seguro?</strong>
                <ul>
                    <li>Usar bcrypt que es lento (resistente a fuerza bruta)</li>
                    <li>Incluye salt automático</li>
                    <li>Incluso si la BD es comprometida, las contraseñas son irreversibles</li>
                </ul>
                <br>
                <strong>Archivo:</strong> <code>data/usuarios_model.php</code>
            </div>

            <h3>✅ 7. Sesiones Seguras</h3>
            <div class="control">
                <strong>Técnica:</strong> Configurar cookies de sesión seguras
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <pre><code>session_set_cookie_params([
    'httponly' => true,  // No accesible desde JavaScript
    'secure' => false,   // En producción sería true (HTTPS)
    'samesite' => 'Strict' // Previene CSRF
]);</code></pre>
                <br>
                <strong>Beneficios:</strong>
                <ul>
                    <li>HttpOnly previene robo de sesión por XSS</li>
                    <li>SameSite previene ataques CSRF</li>
                    <li>Secure (en producción) solo se envía por HTTPS</li>
                </ul>
                <br>
                <strong>Archivo:</strong> <code>data/seguridad.php</code>
            </div>

            <h3>✅ 8. Rate Limiting (Anti Fuerza Bruta)</h3>
            <div class="control">
                <strong>Técnica:</strong> Limitar intentos fallidos de login
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <pre><code>// Máximo 5 intentos en 5 minutos
if (!verificarRateLimiting('login_' . $correo)) {
    return false; // Demasiados intentos
}</code></pre>
                <br>
                <strong>Archivo:</strong> <code>data/seguridad.php</code> y <code>data/usuarios_model.php</code>
            </div>

            <h3>✅ 9. Charsets UTF-8</h3>
            <div class="control">
                <strong>Técnica:</strong> Especificar charset UTF-8 en conexión
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <code>$conexion->set_charset("utf8mb4");</code>
                <br><br>
                <strong>¿Por qué?</strong> Previene ataques de inyección cero-borde y asegura encoding correcto.
                <br><br>
                <strong>Archivo:</strong> <code>data/conexion.php</code>
            </div>

            <h3>✅ 10. Validación de Rol (Control de Acceso)</h3>
            <div class="control">
                <strong>Técnica:</strong> Verificar rol del usuario antes de operaciones sensibles
                <br><br>
                <strong>Implementación en EcoWeb:</strong>
                <pre><code>if ($_SESSION['rol'] !== 'admin') {
    die("No tienes permiso");
}</code></pre>
                <br>
                <strong>Archivo:</strong> <code>presentation/comentarios.php</code>
            </div>
        </div>

        <!-- ====================================== -->
        <div class="section">
            <h2>3️⃣ Recomendaciones Adicionales para Producción</h2>

            <h3>🔵 1. HTTPS Obligatorio</h3>
            <div class="recommendation">
                <strong>¿Por qué?</strong> Encripta toda comunicación entre navegador y servidor.
                <br><br>
                <strong>Implementación:</strong>
                <pre><code>// Redirigir HTTP a HTTPS
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}</code></pre>
            </div>

            <h3>🔵 2. Ocultar Errores en Producción</h3>
            <div class="recommendation">
                <strong>¿Por qué?</strong> Los mensajes de error detallados revelan la arquitectura del sistema.
                <br><br>
                <strong>php.ini para producción:</strong>
                <pre><code>display_errors = Off
log_errors = On
error_log = /var/log/php-errors.log</code></pre>
            </div>

            <h3>🔵 3. WAF (Web Application Firewall)</h3>
            <div class="recommendation">
                <strong>Ejemplos:</strong> CloudFlare, Sucuri, ModSecurity
                <br><br>
                <strong>Beneficios:</strong> Protección contra DDoS, bots maliciosos, ataques conocidos.
            </div>

            <h3>🔵 4. Monitoreo y Logging</h3>
            <div class="recommendation">
                <strong>¿Qué registrar?</strong>
                <ul>
                    <li>Logins fallidos</li>
                    <li>Intentos de acceso a áreas restringidas</li>
                    <li>Cambios en datos importantes</li>
                    <li>Errores de BD</li>
                </ul>
            </div>

            <h3>🔵 5. Actualizaciones Regulares</h3>
            <div class="recommendation">
                <strong>Mantener actualizado:</strong>
                <ul>
                    <li>PHP</li>
                    <li>MySQL/MariaDB</li>
                    <li>Librerías y dependencias</li>
                    <li>Sistema Operativo</li>
                </ul>
            </div>

            <h3>🔵 6. Backup Regular</h3>
            <div class="recommendation">
                <strong>¿Cada cuánto?</strong> Mínimo diario para protección contra ransomware.
            </div>

            <h3>🔵 7. Autenticación de Dos Factores (2FA)</h3>
            <div class="recommendation">
                <strong>¿Qué es?</strong> Además de contraseña, requerir un código temporal (SMS, app).
                <br><br>
                <strong>Librerías PHP:</strong> Google Authenticator, Authy
            </div>

            <h3>🔵 8. Content Security Policy (CSP)</h3>
            <div class="recommendation">
                <strong>¿Por qué?</strong> Previene carga de scripts no autorizados.
                <br><br>
                <strong>Implementación:</strong>
                <pre><code>header("Content-Security-Policy: default-src 'self'; script-src 'self'");</code></pre>
            </div>

            <h3>🔵 9. Limpieza de Datos Sensibles</h3>
            <div class="recommendation">
                <strong>¿Qué hacer?</strong>
                <ul>
                    <li>No loguear contraseñas</li>
                    <li>No guardar números de tarjeta</li>
                    <li>Eliminar datos después de cierto tiempo</li>
                </ul>
            </div>

            <h3>🔵 10. Auditoría de Seguridad Profesional</h3>
            <div class="recommendation">
                <strong>¿Qué es?</strong> Contratar a profesionales para pruebas de penetración.
                <br><br>
                <strong>Beneficio:</strong> Encontrar vulnerabilidades que no se ven a simple vista.
            </div>
        </div>

        <!-- ====================================== -->
        <div class="section">
            <h2>4️⃣ Tabla de Resumen de Controles</h2>
            <table>
                <tr>
                    <th>Vulnerabilidad</th>
                    <th>Riesgo</th>
                    <th>Control Implementado</th>
                    <th>Archivo</th>
                </tr>
                <tr>
                    <td>Inyección SQL</td>
                    <td>Crítica</td>
                    <td>Consultas Preparadas</td>
                    <td>data/usuarios_model.php</td>
                </tr>
                <tr>
                    <td>XSS</td>
                    <td>Alta</td>
                    <td>htmlspecialchars()</td>
                    <td>data/seguridad.php</td>
                </tr>
                <tr>
                    <td>CSRF</td>
                    <td>Media-Alta</td>
                    <td>Tokens CSRF</td>
                    <td>data/seguridad.php</td>
                </tr>
                <tr>
                    <td>Entrada Inválida</td>
                    <td>Media</td>
                    <td>Validación frontend y backend</td>
                    <td>data/seguridad.php</td>
                </tr>
                <tr>
                    <td>Contraseña débil</td>
                    <td>Alta</td>
                    <td>password_hash() + validación</td>
                    <td>data/usuarios_model.php</td>
                </tr>
                <tr>
                    <td>Robo de sesión</td>
                    <td>Alta</td>
                    <td>HttpOnly + SameSite cookies</td>
                    <td>data/seguridad.php</td>
                </tr>
                <tr>
                    <td>Fuerza bruta</td>
                    <td>Media</td>
                    <td>Rate Limiting</td>
                    <td>data/seguridad.php</td>
                </tr>
            </table>
        </div>

        <!-- ====================================== -->
        <div class="section">
            <h2>5️⃣ Referencias y Recursos</h2>
            <ul>
                <li><strong>OWASP Top 10:</strong> https://owasp.org/www-project-top-ten/</li>
                <li><strong>PHP Security:</strong> https://www.php.net/manual/es/security.php</li>
                <li><strong>CWE Top 25:</strong> https://cwe.mitre.org/top25/</li>
                <li><strong>NIST Cybersecurity:</strong> https://www.nist.gov/</li>
            </ul>
        </div>

        <hr>
        <p style="text-align: center; color: #666; margin-top: 40px;">
            <strong>Documento de Seguridad - EcoWeb Proyecto Escolar</strong><br>
            Generado: Febrero 2026<br>
            Solo accesible para Administradores
        </p>
    </div>
</body>
</html>
