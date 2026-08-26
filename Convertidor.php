<!DOCTYPE html>
<html>
<head>
    <title>Convertidor de Pulgadas a Centímetros</title>
</head>
<body>

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
        echo "<h3>Resultado:</h3>";
        echo $pulgadas . " pulgadas equivalen a " . $centimetros . " cm";
    }
    ?>

</body>
</html>