<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<link rel="stylesheet" href="../public/css/estilos.css">

<header>
    <h1>EcoWeb</h1>
</header>

<nav>
    <a href="index.php">Inicio</a>
    <a href="ecosistemas.php">Ecosistemas</a>
    <a href="contactos.php">Contactos</a>
    <a href="comentarios.php">Comentarios</a>

    <?php if(isset($_SESSION['nombre'])) { ?>
        <a href="../data/logout.php">Cerrar sesión</a>
    <?php } else { ?>
        <a href="login.php">Login</a>
    <?php } ?>
</nav>

<?php if(isset($_SESSION['nombre'])) { ?>
    <div class="usuario-info">
        👤 <?php echo $_SESSION['nombre']; ?>
    </div>
<?php } ?>
