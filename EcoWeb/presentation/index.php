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
    <p>
        ¡Bienvenido a EcoWeb, un espacio dedicado a la protección y conservación de los ecosistemas
terrestres, marinos, polares y árticos! En este sitio encontrarás información, herramientas y
recursos para entender la importancia de nuestros entornos naturales y cómo nuestras
acciones impactan en ellos. Nuestro objetivo es fomentar la conciencia ambiental, promover
prácticas sostenibles y proteger la biodiversidad que hace posible la vida en nuestro planeta.
Únete a nosotros en esta misión de cuidar y preservar los ecosistemas, porque cada acción
cuenta y juntos podemos marcar la diferencia.</p>
</section>
