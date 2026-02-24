<?php
// Inicializar seguridad antes del header
require_once "../data/seguridad.php";
require_once "../data/conexion.php";

// Iniciar sesión segura
iniciarSesionSegura();

// Incluir header
include "layout/header.php";
?>

<section class="ecosistemas-box">
    <h2>Ecosistemas</h2>

    <a class="btn" href="terrestre.php">Ecosistema Terrestre</a>
    <a class="btn" href="marino.php">Ecosistema Marino</a>
    <a class="btn" href="polar.php">Ecosistemas Polares y Árticos</a>
    <a class="btn" href="Animales terrestres Extincion.php">Animales en peligro de Extincion en el Ecosistemas terrestres</a>
    <a class="btn" href="Animales marino Extincion.php"> Animales en peligro de Extincion en el Ecosistemas Marinos</a>
    <a class="btn" href="Animales polares y articos.php">Animales en peligro de Extincion en el Ecosistemas Polares Y Articos</a>
    <a class="btn" href="DatosCuriosos.php">Datos Curiosos</a>
</section>
