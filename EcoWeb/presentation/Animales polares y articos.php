<?php include "layout/header.php"; ?>
 <section class="ecoPage">
    <a href="ecosistemas.php" class="volver">⬅ Volver</a>
    <h3>Animales en peligro de Extincion en el Ecosistemas Polares Y Articos</h3>
    
    <p>Los ecosistemas polares incluyen el Ártico, la Antártida y la tundra, caracterizados por sus bajas
temperaturas extremas, hielo permanente o temporal, y suelos pobres en nutrientes. Aunque
parecen desolados, son el hogar de especies únicas que se han adaptado al frío extremo, pero
muchas están amenazadas por el cambio climático, la contaminación y la caza.</p>

<?php
echo '
<div style="display:flex; gap:50px; font-family:Arial, sans-serif;">

    <div>
        <h3>Ártico</h3>
        <ul>
            <li><strong>Oso polar</strong> – Pérdida de hielo marino por el calentamiento global; afecta su caza y reproducción.</li>
            <li><strong>Foca ártica</strong> – Amenazada por la caza y la reducción de hielo.</li>
            <li><strong>Zorro ártico</strong> – El aumento de temperaturas reduce su hábitat natural.</li>
        </ul>
    </div>

    <div>
        <h3>Antártida</h3>
        <ul>
            <li><strong>Pingüino emperador</strong> – Derretimiento de los hielos y cambios en la disponibilidad de alimento.</li>
            <li><strong>Krill antártico</strong> – Disminuye por la pesca industrial y el calentamiento de los océanos.</li>
            <li><strong>Foca de Weddell</strong> – Amenazada por la pérdida de hielo y la actividad humana.</li>
        </ul>
    </div>

    <div>
        <h3>Tundra</h3>
        <ul>
            <li><strong>Leopardo de las nieves</strong> – Caza furtiva y disminución de presas.</li>
            <li><strong>Búho nival</strong> – Reducción de presas y cambios en el ecosistema.</li>
            <li><strong>Liebre ártica</strong> – Cambios climáticos y depredadores invasores afectan su supervivencia.</li>
        </ul>
    </div>

</div>
';
?>