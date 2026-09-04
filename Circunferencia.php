<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Círculo Básico</title>
    <link rel="stylesheet" href="brave-style.css">
</head>
<body>

    <header>
        <h1>Circunferencia</h1>
    </header>

    <div class="container">
    <h2>Calculadora de Círculo</h2>

    <!-- Formulario para ingresar el radio -->
    <form method="POST" action="">
        Radio: <input type="number" step="any" name="radio" required>
        <button type="submit">Calcular</button>
    </form>

    <?php
    // Si se presionó el botón de enviar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $radio = $_POST['radio'];
        $pi = 3.1416;

        // Fórmulas básicas
        $area = $pi * $radio * $radio;
        $perimetro = 2 * $pi * $radio;

        // Mostrar resultados directamente en pantalla
        echo "<hr>";
        echo "<div class='resultado'>";
        echo "<h3>Resultados:</h3>";
        echo "El área es: " . $area . "<br>";
        echo "El perímetro es: " . $perimetro;
        echo "</div>";
    }
    ?>
    </div>

    <footer>Paleta de colores inspirada en Brave Browser</footer>

</body>
</html>