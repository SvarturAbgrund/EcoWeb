<?php
// Inicializar seguridad antes del header
require_once "../data/seguridad.php";
require_once "../data/conexion.php";

// Iniciar sesión segura
iniciarSesionSegura();

// Incluir header
include "layout/header.php";
?>

<section>
    <h2>Bienvenido a EcoWeb</h2>
</section>
