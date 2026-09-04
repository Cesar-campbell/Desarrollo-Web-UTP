<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Convertidor de Pulgadas a Centímetros</title>
    <link rel="stylesheet" href="brave-style.css">
</head>
<body>

    <header>
        <h1>Convertidor</h1>
    </header>

    <div class="container">
    <h2>Conversión de Pulgadas a Centímetros</h2>

    <form method="POST" action="">
        Pulgadas: <input type="number" step="any" name="pulgadas" required>
        <button type="submit">Convertir</button>
    </form>

    <?php
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $pulgadas = $_POST['pulgadas'];

        // 1 pulgada equivale a 2.54 centímetros
        $centimetros = $pulgadas * 2.54;

        echo "<hr>";
        echo "<div class='resultado'>";
        echo "<h3>Resultado:</h3>";
        echo $pulgadas . " pulgadas equivalen a " . $centimetros . " cm";
        echo "</div>";
    }
    ?>
    </div>

    <footer>Paleta de colores inspirada en Brave Browser</footer>

</body>
</html>