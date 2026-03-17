<?php
// Inicializar seguridad antes del header
require_once "../data/seguridad.php";
require_once "../data/conexion.php";

// Iniciar sesión segura
iniciarSesionSegura();

// Incluir header
include "layout/header.php";
?>

<section class="ecoPage">
    
     <a href="ecosistemas.php" class="volver">⬅ Volver</a>

<div class="contaminacion-box">

    <h3 class="titulo-conta">Problemas y Amenazas Globales</h3>

    <p>
    Los ecosistemas del planeta enfrentan múltiples amenazas provocadas
    principalmente por las actividades humanas. Estos problemas afectan
    a los ecosistemas terrestres, marinos y polares, poniendo en riesgo
    la biodiversidad y el equilibrio natural del planeta.
    </p>

    <h3 class="titulo-conta">Cambio Climático y Calentamiento Global</h3>

    <p>
    El cambio climático se debe al aumento de gases de efecto
    invernadero en la atmósfera, lo que provoca un incremento
    en la temperatura global.
    </p>

    <p><strong>Consecuencias:</strong></p>

    <ul class="eco-list">
        <li>Derretimiento de glaciares y polos.</li>
        <li>Aumento del nivel del mar.</li>
        <li>Sequías, incendios forestales y fenómenos climáticos extremos.</li>
        <li>Pérdida de hábitats naturales y especies.</li>
    </ul>

</div>

</section>