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
        <h3 class="titulo-conta">Contaminación del Agua y los Suelos</h3>

        <p>
        La contaminación ocurre cuando sustancias químicas, plásticos y desechos
        industriales o domésticos llegan a ríos, mares y suelos.
        </p>

        <p><strong>Consecuencias:</strong></p>

        <ul class="eco-list">
            <li>Muerte de animales acuáticos y terrestres.</li>
            <li>Daños a la salud humana.</li>
            <li>Degradación del suelo y pérdida de fertilidad.</li>
            <li>Acumulación de microplásticos en los océanos.</li>
        </ul>
    </div>

</section>