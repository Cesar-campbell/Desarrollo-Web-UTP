<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Número Aleatorio</title>
    <link rel="stylesheet" href="brave-style.css">
</head>
<body>

    <header>
        <h1>Brave PHP Lab</h1>
    </header>

    <div class="container">
        <h2>Generador de Números Aleatorios</h2>
        <p>Genera números aleatorios entre 1 y 9 hasta que salga un 8 o un 9.</p>
        <div class="resultado">
            <?php
            do {
                $aleatorio = mt_rand(1, 9);
                echo "Ha salido $aleatorio<br>";
            } while ($aleatorio < 8);
            ?>
        </div>
    </div>

    <footer>Paleta de colores inspirada en Brave Browser</footer>

</body>
</html>
