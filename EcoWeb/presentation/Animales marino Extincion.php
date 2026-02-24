<?php include "layout/header.php"; ?>

<section class="ecoPage">
    <a href="ecosistemas.php" class="volver">⬅ Volver</a>
    <h3>Animales en peligro de Extinción en Ecosistemas Marinos</h3>
    <p>Los ecosistemas marinos, que incluyen océanos, mares y arrecifes de coral, son el hogar de
una enorme variedad de especies. Sin embargo, muchas de ellas están en peligro de
extinción debido a la sobrepesca, la contaminación, la destrucción de hábitats y el cambio
climático. Proteger estos animales es crucial para mantener el equilibrio de los océanos y la
salud del planeta.</p>

<?php
echo '
<div style="display:flex; gap:50px; font-family:Arial, sans-serif;">
     
    <div>
    <h3>Océanos</h3>
    <ul>
        <li><strong>Tiburón blanco</strong> – Amenazado por la pesca y la caza por sus aletas.</li>
        <li><strong>Ballena azul</strong> – Cazada históricamente; su población sigue siendo vulnerable.</li>
        <li><strong>Tortuga laúd</strong> – Contaminación y captura accidental en redes de pesca.</li>
    </ul>

</div>

<div>

 <h3>Mares</h3>
        <ul>
            <li><strong>Delfín rosado amazónico</strong> – Pérdida de hábitat por contaminación y represas.</li>
            <li><strong>Foca monje del Mediterráneo</strong> – Caza y degradación de las costas.</li>
            <li><strong>Caballito de mar</strong> – Captura para acuarios y medicina tradicional.</li>
        </ul>
    </div>

    
</div>

<div>

 <h3>Arrecifes de Coral</h3>
        <ul>
            <li><strong>Tiburón coralino</strong> – Sobrepesca y destrucción de arrecifes.</li>
            <li><strong>Pez loro</strong> – Caza para alimentación y destrucción del coral.</li>
            <li><strong>Corales</strong> – Blanqueamiento por aumento de temperatura y contaminación.</li>
        </ul>
    </div>
    </div>

';
?>

  