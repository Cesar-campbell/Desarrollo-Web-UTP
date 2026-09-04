<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Operaciones Matemáticas Básicas</title>
    <link rel="stylesheet" href="brave-style.css">
</head>
<body>

    <header>
        <h1>Operaciones</h1>
    </header>

    <div class="container">

    <h2>1) Suma</h2>
    <p>Para sumar dos números en PHP, simplemente use el operador +.</p>
    <div class="resultado"><?php
    $num1 = 4;
    $num2 = 7;
    $suma = $num1 + $num2;
    echo "La suma de $num1 y $num2 es: $suma // La suma de 4 y 7 es: 11";
    ?></div>

    <h2>2) Resta</h2>
    <p>La resta se realiza utilizando el operador -.</p>
    <div class="resultado"><?php
    $num1 = 10;
    $num2 = 3;
    $resta = $num1 - $num2;
    echo "La resta de $num1 y $num2 es: $resta // La resta de 10 y 3 es: 7";
    ?></div>

    <h2>3) Multiplicación</h2>
    <p>Para multiplicar dos números, use el operador *.</p>
    <div class="resultado"><?php
    $num1 = 5;
    $num2 = 6;
    $multiplicacion = $num1 * $num2;
    echo "La multiplicación de $num1 y $num2 es: $multiplicacion // La multiplicación de 5 y 6 es: 30";
    ?></div>

    <h2>4) División</h2>
    <p>La división se realiza utilizando el operador /.</p>
    <div class="resultado"><?php
    $num1 = 20;
    $num2 = 4;
    $division = $num1 / $num2;
    echo "La división de $num1 y $num2 es: $division // La división de 20 y 4 es: 5";
    ?></div>

    <h2>5) Módulo</h2>
    <p>El módulo (o residuo) se obtiene utilizando el operador %.</p>
    <div class="resultado"><?php
    $num1 = 15;
    $num2 = 4;
    $modulo = $num1 % $num2;
    echo "El módulo de $num1 y $num2 es: $modulo // El módulo de 15 y 4 es: 3";
    ?></div>

    <h2>6) Potenciación</h2>
    <p>La potenciación se realiza utilizando el operador **.</p>
    <div class="resultado"><?php
    $base = 2;
    $exponente = 3;
    $potencia = $base ** $exponente;
    echo "La potencia de $base elevado a $exponente es: $potencia // La potencia de 2 elevado a 3 es: 8";
    ?></div>

    <h2>Módulo según el signo del dividendo</h2>
    <p>El resultado del operador módulo % tiene el mismo signo que el dividendo — es decir, el resultado de $a % $b tendrá el mismo signo que $a. Por ejemplo:</p>
    <div class="resultado"><?php
    echo (5 % 3) . " // muestra 2<br>";
    echo (5 % -3) . " // muestra 2<br>";
    echo (-5 % 3) . " // muestra -2<br>";
    echo (-5 % -3) . " // muestra -2<br>";
    ?></div>

    <h2>Redondeo: round(), ceil() y floor()</h2>
    <p>Estas funciones se utilizan para redondear números a enteros. round() redondea al entero más cercano, ceil() redondea hacia arriba y floor() redondea hacia abajo.</p>
    <div class="resultado"><?php
    $numero = 4.6;
    $redondeado = round($numero);
    $redondeado_arriba = ceil($numero);
    $redondeado_abajo = floor($numero);

    echo "El número redondeado es: $redondeado // El número redondeado es: 5<br>";
    echo "El número redondeado hacia arriba es: $redondeado_arriba // El número redondeado hacia arriba es: 5<br>";
    echo "El número redondeado hacia abajo es: $redondeado_abajo // El número redondeado hacia abajo es: 4<br>";
    ?></div>

    <h2>Valor absoluto: abs()</h2>
    <p>La función abs() devuelve el valor absoluto de un número.</p>
    <div class="resultado"><?php
    $numero = -7;
    $valor_absoluto = abs($numero);
    echo "El valor absoluto de $numero es: $valor_absoluto // El valor absoluto de -7 es: 7";
    ?></div>

    </div>

    <footer>Paleta de colores inspirada en Brave Browser</footer>

</body>
</html>