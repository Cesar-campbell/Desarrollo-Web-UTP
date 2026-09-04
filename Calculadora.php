<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora BÁSICA PHP</title>
    <link rel="stylesheet" href="brave-style.css">
</head>
<body>

    <header>
        <h1>Calculadora</h1>
    </header>

    <div class="container">
    <h2>Calculadora Básica con Redondeo</h2>

    <form method="POST" action="">
        <input type="number" step="any" name="num1" placeholder="Número 1" required>

        <select name="operacion">
            <option value="suma">+</option>
            <option value="resta">-</option>
            <option value="multiplicacion">*</option>
            <option value="division">/</option>
        </select>

        <input type="number" step="any" name="num2" placeholder="Número 2" required>

        <button type="submit">Calcular</button>
    </form>

    <?php
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $operacion = $_POST['operacion'];
        $resultado = 0;

        if ($operacion === 'suma') {
            $resultado = $num1 + $num2;
        } elseif ($operacion === 'resta') {
            $resultado = $num1 - $num2;
        } elseif ($operacion === 'multiplicacion') {
            $resultado = $num1 * $num2;
        } elseif ($operacion === 'division') {
            if ($num2 != 0) {
                $resultado = $num1 / $num2;
            } else {
                $resultado = "Error: No se puede dividir entre cero";
            }
        }

        echo "<hr>";
        echo "<div class='resultado'>";
        echo "<h3>Resultado:</h3>";

        // Si el resultado es un número, lo redondeamos a 2 decimales
        if (is_numeric($resultado)) {
            echo "Resultado exacto: " . $resultado . "<br>";
            echo "<strong>Resultado redondeado (2 decimales): " . round($resultado, 2) . "</strong>";
        } else {
            echo $resultado;
        }
        echo "</div>";
    }
    ?>
    </div>

    <footer>Paleta de colores inspirada en Brave Browser</footer>

</body>
</html>