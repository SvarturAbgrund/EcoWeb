<?php
// Incluir funciones de seguridad
require_once '../data/seguridad.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<link rel="stylesheet" href="../public/css/estilos.css">


<header class="header-flotante">
    <div class="contenedor-header">
        <h1 class="titulo-flotante">🌍 EcoWeb</h1>
    </div>
</header>

<nav class="nav-flotante">
    <div class="contenedor-nav">

        <a href="index.php" class="nav-link">
            <span class="icono-nav">🏠</span>
            <span class="texto-nav">Inicio</span>
        </a>

        <a href="ecosistemas.php" class="nav-link">
            <span class="icono-nav">🌲</span>
            <span class="texto-nav">Ecosistemas</span>
        </a>

        <a href="contactos.php" class="nav-link">
            <span class="icono-nav">✉️</span>
            <span class="texto-nav">Contacto</span>
        </a>

        <a href="comentarios.php" class="nav-link">
            <span class="icono-nav">💬</span>
            <span class="texto-nav">Comentarios</span>
        </a>

        <?php if(!isset($_SESSION['nombre'])) { ?>

        <a href="login.php" class="nav-link">
            <span class="icono-nav">🔐</span>
            <span class="texto-nav">Login</span>
        </a>

        <?php } else { ?>

        <a href="../data/logout.php" class="nav-link">
            <span class="icono-nav">🚪</span>
            <span class="texto-nav">Cerrar sesión</span>
        </a>

        <?php } ?>

    </div>
</nav>

<?php if(isset($_SESSION['nombre'])) { ?>

<div class="usuario-info-burbuja">

<a href="<?php echo ($_SESSION['rol'] == 'admin') ? 'dashboard.php' : 'perfil.php'; ?>" class="burbuja-usuario">

<span class="icono-usuario">👤</span>

<span class="nombre-usuario">
<?php echo escaparHTML($_SESSION['nombre']); ?>
</span>

</a>

</div>

<?php } ?>